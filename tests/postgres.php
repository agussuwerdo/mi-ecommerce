<?php
// Run with PHP CLI. Integration changes are confined to a new schema and rolled back.
error_reporting(E_ALL & ~E_DEPRECATED);
define('BASEPATH', dirname(__DIR__).'/system/');
define('APPPATH', dirname(__DIR__).'/application/');
define('ENVIRONMENT', 'production');
function log_message($level, $message) {}
function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
function &get_instance() { return $GLOBALS['test_ci']; }
function check($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
}
function database_config() {
    require APPPATH.'config/database.php';
    return $db['default'];
}

$names = array('DATABASE_URL_UNPOOLED', 'POSTGRES_URL_NON_POOLING', 'DATABASE_URL', 'POSTGRES_URL', 'DB_CONNECTION');
$saved = array();
foreach ($names as $name) { $saved[$name] = getenv($name); putenv($name); }
try {
    check(database_config()['dbdriver'] === 'mysqli', 'MySQL fallback failed');
    $direct = 'postgresql://test:p%40ss@direct.example/testdb?sslmode=require&channel_binding=require';
    foreach (array('DATABASE_URL', 'POSTGRES_URL', 'POSTGRES_URL_NON_POOLING', 'DATABASE_URL_UNPOOLED') as $name) {
        putenv($name.'='.$direct);
        $config = database_config();
        check($config['dbdriver'] === 'postgre' && $config['dsn'] === $direct, 'URL/TLS options were not preserved');
        check($config['password'] === 'p@ss' && !$config['pconnect'] && !$config['db_debug'], 'Unsafe connection options');
        putenv($name);
    }
    putenv('DATABASE_URL=postgresql://test:pass@ep-test-pooler.example/testdb?sslmode=require');
    try { database_config(); throw new LogicException('Pooler should be rejected'); }
    catch (RuntimeException $e) { check(strpos($e->getMessage(), 'session-level locks') !== FALSE, 'Unexpected pooler error'); }
    putenv('DATABASE_URL_UNPOOLED='.$direct);
    check(database_config()['dsn'] === $direct, 'Direct URL must take precedence');
    echo "PASS: configuration, URL precedence, encoded credentials, TLS, pooler rejection\n";
} finally {
    foreach ($saved as $name => $value) { putenv($value === FALSE ? $name : $name.'='.$value); }
}

if (!getenv('DATABASE_URL_UNPOOLED')) {
    echo "SKIP: set DATABASE_URL_UNPOOLED for live PostgreSQL integration checks\n";
    exit(0);
}
check(extension_loaded('pgsql'), 'Enable the PHP pgsql extension');
require BASEPATH.'database/DB.php';
$config = database_config();
$db = DB($config, TRUE);
check((bool) $db->conn_id, 'PostgreSQL connection failed');
$GLOBALS['test_ci'] = (object) array('db' => $db);
require BASEPATH.'database/DB_forge.php';
require BASEPATH.'database/drivers/postgre/postgre_forge.php';
$forge = new CI_DB_postgre_forge($db);
// Supply migration dependencies without invoking the application router.
class CI_Migration {
    public $db;
    public $dbforge;
    public function __construct($db, $forge) { $this->db = $db; $this->dbforge = $forge; }
}
require BASEPATH.'core/Model.php';
require APPPATH.'core/MY_Model.php';
require APPPATH.'models/Sales_model.php';
require APPPATH.'models/Sales_item_model.php';
require APPPATH.'models/Product_model.php';
require APPPATH.'libraries/Seller_auth.php';
require APPPATH.'models/Category_model.php';

class TestControllerResponse extends RuntimeException {
    public $successful;
    public function __construct($message, $successful) { parent::__construct($message); $this->successful = $successful; }
}
function success($message = '') { throw new TestControllerResponse($message, TRUE); }
function error($message = '') { throw new TestControllerResponse($message, FALSE); }
require APPPATH.'helpers/general_helper.php';
class MY_Controller {
    public $db;
    public $product_model;
    public $category_model;
    public $input;
    public $load;
}
require APPPATH.'modules/seller/controllers/Master.php';
class TestMaster extends Master {
    public function __construct() {}
}
class TestProductInput {
    public $data;
    public function post($name) { return isset($this->data[$name]) ? $this->data[$name] : NULL; }
}
class TestProductView {
    public $data;
    public function view($name, $data) { $this->data = $data; }
}

// Exercise the real authentication query using an in-memory session sink.
class TestSellerAuth extends Seller_auth {
    public function __construct() { $this->CI = get_instance(); }
}
class TestLoginSession {
    public $data = array();
    public function set_userdata($data) { $this->data = $data; }
}

check($db->trans_begin(), 'Cannot start test transaction');
try {
    $schema = 'mi_test_'.bin2hex(random_bytes(8));
    check($db->simple_query('CREATE SCHEMA '.$schema), 'Cannot create test schema');
    check($db->simple_query('SET LOCAL search_path TO '.$schema), 'Cannot select test schema');
    $db->schema = $schema;
    foreach (glob(APPPATH.'migrations/*.php') as $file) {
        require $file;
        $class = 'Migration_'.substr(basename($file, '.php'), 15);
        (new $class($db, $forge))->up();
        check($db->trans_status(), 'Migration failed: '.basename($file));
    }
    check($db->count_all('products') === 14, 'Product seeds missing');
    $products = new Product_model();
    $products->set_select('item_id,name,price,discount,slug');
    $products->set_order(array('item_id' => 'RANDOM'));
    $products->set_limit(3);
    $recommendations = $products->find()->result_array();
    check(count($recommendations) === 3, 'Product/cart recommendations failed');
    check(count(array_unique(array_column($recommendations, 'item_id'))) === 3, 'Recommendations must be unique');

    $master = new TestMaster();
    $master->db = $db;
    $master->product_model = new Product_model();
    $master->category_model = new Category_model();
    $master->input = new TestProductInput();
    $master->load = new TestProductView();
    $master->product_input();
    check($master->load->data['rowdata']['item_id'] === '', 'New-product form should use empty defaults');
    $master->product_input(encode('19'));
    check((int) $master->load->data['rowdata']['item_id'] === 19, 'Padded Base64 edit ID should load the product');
    $master->input->data = array('item_id' => '', 'sku' => "TEST'SKU", 'name' => 'Controller test',
        'description' => 'Test product', 'price' => '1000', 'discount' => '0', 'stock' => '2', 'weight' => '100',
        'f_category_code' => 'pakaian', 'f_sub_category_code' => 'kaos-pria');
    try { $master->save_product(); throw new RuntimeException('Missing save response'); }
    catch (TestControllerResponse $response) { check($response->successful, $response->getMessage()); }
    $created = $master->product_model->find_one(array('sku' => "TEST'SKU"));
    check((int) $created['item_id'] > 25 && !empty($created['created_at']), 'New product should receive a generated ID and timestamp');
    $master->input->data['item_id'] = encode($created['item_id']);
    $master->input->data['name'] = 'Updated controller test';
    try { $master->save_product(); throw new RuntimeException('Missing update response'); }
    catch (TestControllerResponse $response) { check($response->successful, $response->getMessage()); }
    $updated = $master->product_model->find_one(array('item_id' => $created['item_id']));
    check($updated['name'] === 'Updated controller test' && !empty($updated['updated_at']), 'Product update failed');
    $master->input->data['item_id'] = '';
    try { $master->save_product(); throw new RuntimeException('Duplicate SKU accepted'); }
    catch (TestControllerResponse $response) {
        check(!$response->successful && strpos($response->getMessage(), 'SKU already used') !== FALSE, 'Duplicate SKU should be rejected');
        $db->trans_rollback(); // Balance the rejected controller request's nested transaction.
    }

    $GLOBALS['test_ci']->session = new TestLoginSession();
    $auth = new TestSellerAuth();
    check($auth->do_login(array('email' => 'admin@mi.com', 'pass' => 'wrong-password'))['status'] === 0, 'Incorrect password accepted');
    $chosen_password = bin2hex(random_bytes(16));
    check($db->where('user_id', 1)->update('users', array('enc_pass' => md5($chosen_password))), 'Cannot set test seller password');
    check($auth->do_login(array('email' => 'admin@mi.com', 'pass' => $chosen_password))['status'] === 1, 'Seller login with chosen password failed');
    check($GLOBALS['test_ci']->session->data['is_seller_authorized'] === TRUE, 'Seller authorization not recorded');
    check($db->insert('products', array('name' => 'Postgres test')), 'Product insert failed');
    check($db->insert_id() > 25, 'Product sequence did not advance past seed IDs');
    check($db->insert('users', array('email' => 'test@example.invalid')), 'User insert failed');
    check($db->insert_id() > 1, 'User sequence did not advance past seed IDs');
    check($db->insert('sales', array('invoice_number' => 'TEST-001', 'f_customer_id' => 1,
        'sales_date' => '2026-10-11', 'quantity_total' => 2, 'retail_sales_total' => 100)), 'Sale insert failed');
    $sales = new Sales_model();
    check((int) $sales->count_report_daily() === 1, 'Daily count failed');
    check($sales->list_report_daily()->num_rows() === 1, 'Daily report failed');
    check((int) $sales->count_report_monthly() === 1, 'Monthly count failed');
    $month = $sales->list_report_monthly()->row_array();
    check($month['month_name'] === 'October' && (int) $month['year_name'] === 2026, 'Monthly date functions failed');
    $sales->_join();
    check($db->get('sales tbl')->num_rows() === 1, 'Customer join failed');
    $items = new Sales_item_model();
    check($items->sales_by_category()->num_rows() === 0, 'Category aggregation failed');
    check($items->sales_by_product()->num_rows() === 0, 'Product aggregation failed');

    require BASEPATH.'libraries/Session/Session_driver.php';
    require BASEPATH.'libraries/Session/CI_Session_driver_interface.php';
    require BASEPATH.'libraries/Session/drivers/Session_database_driver.php';
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    $params = array('save_path' => 'ci_sessions', 'match_ip' => FALSE);
    $session = new CI_Session_database_driver($params);
    check($session->open('ci_sessions', 'test'), 'Session open failed');
    check($session->read('integration-test') === '', 'New session should be empty');
    check($session->write('integration-test', 'cart|s:4:"test";'), 'Session write failed');
    check($session->read('integration-test') === 'cart|s:4:"test";', 'Session round trip failed');
    check($session->close(), 'Session unlock failed');
    echo "PASS: migrations, seeds, recommendations, product create/edit/save, SKU validation, seller authentication, generated IDs, reports, joins, sessions and locks\n";
} finally {
    $db->trans_rollback();
    $db->close();
    echo "Test schema and data rolled back\n";
}
