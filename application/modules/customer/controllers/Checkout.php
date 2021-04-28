<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->check_customer_login();
		$this->load->library('cart');
		$this->load->model('product_model');
	}

	public function index()
	{
		$data = array(
			'content' => 'checkout/adress',
			'carts' => cart_data()
		);
		$this->bc->set_title('Checkout - Adress');
		$this->bc->add('Checkout - Adress', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function submit()
	{
		switch ($this->input->get('step')) {
			case 1:
				redirect(site_url('checkout/delivery'));
				break;
			case 2:
				redirect(site_url('checkout/payment'));
				break;
			case 3:
				redirect(site_url('checkout/review'));
				break;
			default:
				redirect(site_url('checkout'));
		}
	}

	public function delivery()
	{
		$data = array(
			'content' => 'checkout/delivery',
			'carts' => cart_data()
		);
		$this->bc->set_title('Checkout - Delivery Method');
		$this->bc->add('Checkout - Delivery Method', site_url());
		$this->load->view(template_customer(), $data);
	}
	public function payment()
	{
		$data = array(
			'content' => 'checkout/payment',
			'carts' => cart_data()
		);
		$this->bc->set_title('Checkout - Payment Method');
		$this->bc->add('Checkout - Payment Method', site_url());
		$this->load->view(template_customer(), $data);
	}
	public function review()
	{
		$data = array(
			'content' => 'checkout/review',
			'carts' => cart_data()
		);
		$this->bc->set_title('Checkout - Order Review');
		$this->bc->add('Checkout - Order Review', site_url());
		$this->load->view(template_customer(), $data);
	}
}
