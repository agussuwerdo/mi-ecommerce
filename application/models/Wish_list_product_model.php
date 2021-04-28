<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wish_list_product_model extends MY_Model
{
	protected $table = 'wish_list_products';
	protected $primaryKey = array('f_user_id','f_item_id');
	function __construct()
	{
		parent::__construct();
	}
}
