<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration extends CI_Controller
{

	/**
	 * Function to migrate database.
	 *
	 * @return mixed
	 * 
	 * call via URL : localhost/mi-ecommerce/migration
	 * call via CLI : php index.php migration
	 */
	public function index()
	{
		$this->load->library('migration');
		$migrate = $this->migration->latest();
		if ($migrate === FALSE) {
			error($this->migration->error_string());
		} else {
			success('Migration success');
		}
	}
}
