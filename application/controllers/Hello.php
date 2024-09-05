<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hello extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		echo phpinfo();
	}

	public function env()
	{
		print_r($_ENV);
	}

	public function env_get($envvar)
	{
		echo getenv($envvar);
	}

	public function db()
	{
		$this->load->database();
		echo "connected";
	}

	public function product()
	{
		$this->load->database();
		$query = $this->db->get('products');
		print_r($query->result_array());
		echo "connected";
	}

	public function eloquent()
	{
		$this->load->library('eloquent');

		$this->load->model('Product');

		$product = Product::all(); // Fetch all users from 'users' table
		echo 'Eloquent is loaded and running.';
	}

	public function list()
	{
		echo base_url('product');
	}
}
