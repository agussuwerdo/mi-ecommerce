<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->check_customer_login();
		$this->load->model('user_model');
		$this->load->model('sales_model');
		$this->load->model('product_model');
		$this->load->model('sales_item_model');
	}

	public function index()
	{
		$where_order = array();
		$user_id = $this->session->userdata('customer_user_id');
		$where_order['f_customer_id'] = $user_id;
		$this->sales_model->set_where($where_order);
		$order_list = $this->sales_model->find();

		$where_wish = array();
		$where_wish["item_id in (select f_item_id from wish_list_products where f_user_id = $user_id)"] = null;
		$this->product_model->set_where($where_wish);
		$wish_list = $this->product_model->find();

		$data = array(
			'content' => 'profile/main',
			'order_list' => $order_list,
			'wish_list' => $wish_list
		);
		$this->bc->set_title('Customer Page');
		$this->bc->add('Customer Page', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function update_password()
	{
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');
		$new_password_confirm = $this->input->post('new_password_confirm');
		$user_id = $this->session->userdata('customer_user_id');

		$user = $this->user_model->find_one($user_id);

		if ($user['enc_pass'] != md5($old_password)) {
			$this->result['focus'] = 'old_password';
			error('Old Password is invalid');
		}

		if ($user['enc_pass'] == md5($new_password)) {
			$this->result['focus'] = 'new_password';
			error('New password cannot be same with old password');
		}

		if ($new_password != $new_password_confirm)
			error('Please enter same confirmation password');

		$data_update = array('enc_pass' => md5($new_password));
		$update_where = array('user_id' => $user_id);
		$this->user_model->update($data_update, $update_where);

		success('Your password has been updated');
	}

	public function update_user()
	{
		$user_name = $this->input->post('user_name');
		$user_adress = $this->input->post('user_adress');
		$user_id = $this->session->userdata('customer_user_id');

		$data_update = array('name' => $user_name, 'adress' => $user_adress, 'updated_at' => date('Y-m-d H:i:s'));
		$update_where = array('user_id' => $user_id);
		$this->user_model->update($data_update, $update_where);

		$this->session->set_userdata('customer_name', $user_name);
		$this->session->set_userdata('customer_adress', $user_adress);

		success('Your personal profile has been updated');
	}
}
