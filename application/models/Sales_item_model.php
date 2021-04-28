<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_item_model extends MY_Model
{
	protected $table = 'sales_items';
	protected $primaryKey = array('invoice_number', 'recnum');
	function __construct()
	{
		parent::__construct();
		$this->set_select('tbl.*,prd.slug');
	}

	function _join()
	{
		$this->db->join('products prd', 'tbl.f_item_id = prd.item_id', 'left');
	}

	function sales_by_category()
	{
		$qry = 'SELECT
			SUM( quantity ) AS quantity_total,
			cat.category_name 
		FROM
			sales_items tbl
			LEFT JOIN products prd ON tbl.f_item_id = prd.item_id
			LEFT JOIN categories cat ON prd.f_category_code = cat.category_code 
		GROUP BY
			category_name  
		ORDER BY quantity_total DESC';

		$query = $this->db->query($qry);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			$query->free_result();
			return $query;
		}
	}

	function sales_by_product()
	{
		$qry = 'SELECT
			SUM( quantity ) AS quantity_total,
			f_name 
		FROM
			sales_items 
		GROUP BY
			f_name 
		ORDER BY
			quantity_total DESC';

		$query = $this->db->query($qry);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			$query->free_result();
			return $query;
		}
	}
}
