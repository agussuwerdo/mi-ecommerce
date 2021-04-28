<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sub_category_model extends MY_Model
{
	protected $table = 'sub_categories';
	protected $primaryKey = array('f_category_code', 'sub_category_code');
	function __construct()
	{
		parent::__construct();
		$this->set_select('tbl.*,cat.category_name');
	}

	function _join()
	{
		$this->db->join('categories cat', 'tbl.f_category_code = cat.category_code', 'left');
	}
}
