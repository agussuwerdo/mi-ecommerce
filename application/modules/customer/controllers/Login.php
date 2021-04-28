<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->load->model('user_model');
	}

	public function login_cust()
	{
		if (is_customer_authorized())
			redirect(base_url());
		$data = array(
			'content' => 'login/main'
		);
		$this->bc->set_title('Login Customer');
		$this->bc->add('Login', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function register_cust()
	{
		$data = array(
			'content' => 'login/register'
		);
		$this->bc->set_title('Register Customer');
		$this->bc->add('Register', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function forgot_cust()
	{
		$data = array(
			'content' => 'login/forgot'
		);
		$this->bc->set_title('Forgot Password');
		$this->bc->add('Forgot', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function authorize()
	{
		$this->load->library('customer_auth');
		$this->result['url'] = '';
		$this->result['focus'] = 'email';
		$data['email'] = $this->input->post('email');
		$data['pass'] = $this->input->post('pass');

		if (!$data['email']) {
			error('Email cannot be empty');
		}
		if (!$data['pass']) {
			$this->result['focus'] = 'pass';
			error('Password cannot be empty');
		}
		$return = $this->customer_auth->do_login($data);
		if (isset($return['focus']))
			$this->result['focus']		 = $return['focus'];
		if (!$return['status']) {
			error($return['error']);
		}
		if (isset($return['default_menu_url'])) {
			$this->result['url'] = $return['default_menu_url'] ?: '';
		}
		success('Login Success');
	}

	function deauthorize()
	{
		$this->load->library('customer_auth');
		$this->customer_auth->do_logout();
		redirect(site_url());
	}

	function register()
	{
		$data_user = array();
		$data_user['name']		= $this->input->post('name');
		$data_user['email']		= $this->input->post('email');
		$data_user['adress']	= $this->input->post('adress');
		$password				= $this->input->post('pass');

		$where_email = array(
			'email = ' . $this->db->escape($data_user['email']) => null
		);
		$check_existing_email = $this->user_model->find_one($where_email);
		if ($check_existing_email['email']) {
			$this->result['em'] = $check_existing_email;
			$this->result['focus'] = 'email_adress';
			error('Email adress already registered');
		}

		$data_user['user_type']	= 2;
		$data_user['enc_pass'] 	= md5($password);

		$this->user_model->insert($data_user);

		$this->result['url'] = base_url();
		success('Registration success, please login with your account credentials');
	}
}
