<?php
class Custom404 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
		$this->bc->set_title('Page Not Found');
		$this->load->view(template_customer(),array('content'=>'templates/404'));
	}
}
