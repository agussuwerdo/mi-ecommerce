<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends MY_Model
{
	protected $table = 'categories';
	protected $primaryKey = 'category_code';
	function __construct()
	{
		parent::__construct();
	}
}
