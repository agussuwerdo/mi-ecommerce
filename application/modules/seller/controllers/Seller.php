<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array();
		$this->load->view(template_seller(),$data);
	}

	public function detail($slug='')
	{

	}
}
