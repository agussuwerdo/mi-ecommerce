<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('sales_item_model');
	}

	public function sales()
	{
		$sales_by_category = $this->sales_item_model->sales_by_category();
		$sales_by_product = $this->sales_item_model->sales_by_product();

		$cart_by_category_labels = array();
		$cart_by_category_data = array();
		$cart_by_category_color = array();
		foreach($sales_by_category->result_array() as $s_category)
		{
			$cart_by_category_labels[] = $s_category['category_name'];
			$cart_by_category_data[] = $s_category['quantity_total'];
			$cart_by_category_color[] = '#'.random_color();
		}
		$cart_by_category = array(
			'labels' => $cart_by_category_labels,
			'data' => $cart_by_category_data,
			'color' => $cart_by_category_color,
		);

		$cart_by_product_labels = array();
		$cart_by_product_data = array();
		$cart_by_product_color = array();
		foreach($sales_by_product->result_array() as $s_product)
		{
			$cart_by_product_labels[] = $s_product['f_name'];
			$cart_by_product_data[] = $s_product['quantity_total'];
			$cart_by_product_color[] = '#'.random_color();
		}
		$cart_by_product = array(
			'labels' => $cart_by_product_labels,
			'data' => $cart_by_product_data,
			'color' => $cart_by_product_color,
		);

		$data = array(
			'content' => 'dashboard/sales/main',
			'cart_by_category' => $cart_by_category,
			'cart_by_product' => $cart_by_product,
		);
		$this->bc->set_title('Sales dashboard');
		$this->bc->add('Dashboard',base_url('seller/dashboard'));
		$this->bc->add('Sales',base_url('seller/dashboard/sales'));
		$this->load->view(template_seller(),$data);
	}

	public function detail($slug='')
	{

	}
}
