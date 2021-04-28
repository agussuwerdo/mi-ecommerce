<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model
{
	protected $table = 'products';
	protected $primaryKey = 'item_id';
	function __construct()
	{
		parent::__construct();
	}
}
