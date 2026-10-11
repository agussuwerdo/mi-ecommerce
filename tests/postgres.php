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

check($db->trans_begin(), 'Cannot start test transaction');
try {
    $schema = 'mi_test_'.bin2hex(random_bytes(8));
    check($db->simple_query('CREATE SCHEMA '.$schema), 'Cannot create test schema');
    check($db->simple_query('SET LOCAL search_path TO '.$schema), 'Cannot select test schema');
    foreach (glob(APPPATH.'migrations/*.php') as $file) {
        require $file;
        $class = 'Migration_'.substr(basename($file, '.php'), 15);
        (new $class($db, $forge))->up();
        check($db->trans_status(), 'Migration failed: '.basename($file));
    }
    check($db->count_all('products') === 14, 'Product seeds missing');
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
    echo "PASS: all migrations, seeds, generated IDs, daily/monthly reports, joins, session storage and locks\n";
} finally {
    $db->trans_rollback();
    $db->close();
    echo "Test schema and data rolled back\n";
}
