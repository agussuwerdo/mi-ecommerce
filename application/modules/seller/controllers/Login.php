<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
	}

	public function index()
	{
		$data = array(
			'content' => 'login/main'
		);
		$this->load->view($data['content'], $data);
	}

	public function authorize()
	{
		$this->load->library('seller_auth');
		$this->result['url'] = 'seller';
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
		$return = $this->seller_auth->do_login($data);
		if (isset($return['focus']))
			$this->result['focus']		 = $return['focus'];
		if (!$return['status']) {
			error($return['error']);
		}
		if (isset($return['default_menu_url'])) {
			$this->result['url'] = $return['default_menu_url']?:'seller';
		}
		success('Login Success');
	}

	function deauthorize()
	{
		$this->load->library('seller_auth');
		$this->seller_auth->do_logout();
		redirect(site_url('seller'));
	}
}
