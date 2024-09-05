<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('sub_category_model');
		$this->load->model('wish_list_product_model');
	}

	public function index()
	{
		$this->paginate();
	}

	public function paginate()
	{
		$this->bc->set_title('List Product');
		$this->bc->add('List Product', base_url('customer/product'));

		$limit = 8;
		$per_page = $this->input->get('per_page') ? (ceiling($this->input->get('per_page'), $limit)) : 0;
		$search_value = strtolower($this->input->get('q') ?? '');
		$category = strtolower($this->input->get('cat') ?? '');
		$sub_category = strtolower($this->input->get('subcat') ?? '');

		$where = array();

		if ($category)
			if ($category != 'all') {
				$where['lower(f_category_code)'] = $category;
				$get_category = $this->category_model->find_one($category);
				$this->bc->add($get_category['category_name'], base_url('product?cat=' . $get_category['category_code']));
			}

		if ($sub_category)
			if ($sub_category != 'all') {
				$where['lower(f_sub_category_code)'] = $sub_category;
				$get_sub_category = $this->sub_category_model->find_one(array('f_category_code' => $category, 'sub_category_code' => $sub_category));
				$this->bc->add($get_sub_category['sub_category_name'], base_url('product?cat=' . $category . '&subcat=' . $get_sub_category['sub_category_code']));
			}

		if ($search_value) {
			$where["(
				lower(tbl.sku) LIKE '%" . $this->db->escape_like_str($search_value) . "%' ESCAPE '!'
				OR lower(tbl.slug) LIKE '%" . $this->db->escape_like_str($search_value) . "%' ESCAPE '!'
				OR lower(tbl.name) LIKE '%" . $this->db->escape_like_str($search_value) . "%' ESCAPE '!'
				OR lower(tbl.description) LIKE '%" . $this->db->escape_like_str($search_value) . "%' ESCAPE '!'
				OR lower(tbl.f_category_code) LIKE '%" . $this->db->escape_like_str($search_value) . "%' ESCAPE '!'
			)"] = NULL;
		}

		$order = array(
			'name' => 'asc'
		);

		$this->product_model->set_where($where);
		$list_count = $this->product_model->count();
		$this->product_model->set_limit($limit);
		$this->product_model->set_offset($per_page);
		$this->product_model->set_order($order);
		$list_data  = $this->product_model->find();

		$data = array(
			'content' => 'product/paginate',
			'paging' => paginate_links($list_count, $per_page, $limit, 3, 'product'),
			'products' => $list_data,
		);
		$this->load->view(template_customer(), $data);
	}

	public function detail($slug = '')
	{
		$user_id = 0;

		if (is_customer_authorized())
			$user_id = $this->session->userdata('customer_user_id');
		$product = $this->product_model->find_one(array('slug' => $slug));

		if (!$product['item_id'])
			return_404();

		$this->product_model->set_select('DISTINCT(item_id),name,price,discount,slug');
		$this->product_model->set_order('rand()');
		$this->product_model->set_limit(3);
		$random_product = $this->product_model->find();

		$in_wish = $this->wish_list_product_model->find_one(array('f_user_id' => $user_id, 'f_item_id' => $product['item_id']));
		$product['in_wish'] = $in_wish['f_item_id'];

		$data = array(
			'content' => 'product/detail',
			'category_list' => category_list(),
			'product' => $product,
			'random_product' => $random_product
		);
		$get_category = $this->category_model->find_one($product['f_category_code']);
		$get_sub_category = $this->sub_category_model->find_one(array('f_category_code' => $product['f_category_code'], 'sub_category_code' => $product['f_sub_category_code']));
		$this->bc->set_title($product['name']);
		$this->bc->add($get_category['category_name'], base_url('product?cat=' . $get_category['category_code']));
		$this->bc->add($get_sub_category['sub_category_name'], base_url('product?subcat=' . $get_sub_category['sub_category_code']));
		$this->bc->add($product['name'], site_url());
		$this->load->view(template_customer(), $data);
	}

	public function in_wish()
	{
		$this->result['noauth'] = 0;
		$item_id = $this->input->get('id');
		if (!is_customer_authorized()) {
			$this->result['noauth'] = 1;
			error('Noauth');
		}
		$user_id = $this->session->userdata('customer_user_id');
		if (!$user_id) {
			$this->result['noauth'] = 1;
			error('Noauth');
		}
		$exs_product = $this->product_model->find_one($item_id);
		if ($exs_product['item_id']) {
			$exs_wish = $this->wish_list_product_model->find_one(array('f_user_id' => $user_id, 'f_item_id' => $item_id));
			$wish_type = 0;
			if (!$exs_wish['f_user_id']) {
				$wish_type = 1;
				$data_wish = array();
				$data_wish['f_item_id'] = $item_id;
				$data_wish['f_user_id'] = $user_id;
				$data_wish['created_at'] = date("Y-m-d H:i:s");
				$this->wish_list_product_model->insert($data_wish);
			} else {
				$this->wish_list_product_model->delete(array('f_user_id' => $user_id, 'f_item_id' => $item_id));
			}

			$this->result['type'] = $wish_type;
		}
		success();
	}
}
