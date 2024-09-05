<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends MY_Model
{
	protected $table = 'sales';
	protected $primaryKey = 'invoice_number';
	function __construct()
	{
		parent::__construct();
		$this->set_select('tbl.*,user.name');
	}

	function _join()
	{
		$this->db->join('users user', 'tbl.f_customer_id = user.user_id', 'left');
	}

	function count_report_daily()
	{
		$this->db->select('sum( quantity_total ) AS quantity_total', false);
		$this->db->select('sum( retail_sales_total ) AS retail_sales_total', false);
		$this->db->select('sales_date', false);

		$this->db->group_by('sales_date');
		$compiled_select = $this->db->get_compiled_select($this->table_name() . ' t1');

		$this->db->reset_query();

		$this->db->select('count(*) as num_rows', false);

		if ($this->where) {
			if (!$this->autoQuotes) {
				$this->db->where($this->where, NULL, false);
			} else {
				$this->db->where($this->where);
			}
		}

		$query = $this->db->get('(' . $compiled_select . ') tbl');

		$row = $query->row_array();
		return $row['num_rows'];
	}

	function list_report_daily()
	{
		$this->db->select('sum( quantity_total ) AS quantity_total', false);
		$this->db->select('sum( retail_sales_total ) AS retail_sales_total', false);
		$this->db->select('sales_date', false);

		$this->db->group_by('sales_date');
		$compiled_select = $this->db->get_compiled_select($this->table_name() . ' t1');

		$this->db->reset_query();

		if ($this->where) {
			if (!$this->autoQuotes) {
				$this->db->where($this->where, NULL, false);
			} else {
				$this->db->where($this->where);
			}
		}

		if ($this->orderBy)
			foreach ($this->orderBy as $key => $value) {
				$this->db->order_by($key, $value);
			}

		if (!$this->limit and !$this->offset)
			$query = $this->db->get('(' . $compiled_select . ') tbl');
		else
			$query = $this->db->get('(' . $compiled_select . ') tbl', $this->limit, $this->offset);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			$query->free_result();
			return $query;
		}
	}

	function count_report_monthly()
	{
		$this->db->select('sum( quantity_total ) AS quantity_total', false);
		$this->db->select('sum( retail_sales_total ) AS retail_sales_total', false);
		$this->db->select('MONTHNAME( sales_date ) AS month_name', false);
		$this->db->select('YEAR( sales_date ) AS year_name', false);

		$this->db->group_by(array('year_name','month_name'));
		$compiled_select = $this->db->get_compiled_select($this->table_name() . ' t1');

		$this->db->reset_query();

		// Select count of rows from the compiled subquery
		$this->db->select('count(*) as num_rows', false);

		if ($this->where) {
			if (!$this->autoQuotes) {
				$this->db->where($this->where, NULL, false);
			} else {
				$this->db->where($this->where);
			}
		}

		$query = $this->db->get('(' . $compiled_select . ') tbl');

		$row = $query->row_array();
		return $row['num_rows'];
	}

	function list_report_monthly()
	{
		$this->db->select('sum( quantity_total ) AS quantity_total', false);
		$this->db->select('sum( retail_sales_total ) AS retail_sales_total', false);
		$this->db->select('MONTHNAME( sales_date ) AS month_name', false);
		$this->db->select('YEAR( sales_date ) AS year_name', false);

		$this->db->group_by(array('year_name','month_name'));
		$compiled_select = $this->db->get_compiled_select($this->table_name() . ' t1');

		$this->db->reset_query();

		if ($this->where) {
			if (!$this->autoQuotes) {
				$this->db->where($this->where, NULL, false);
			} else {
				$this->db->where($this->where);
			}
		}

		if ($this->orderBy)
			foreach ($this->orderBy as $key => $value) {
				$this->db->order_by($key, $value);
			}

		if (!$this->limit and !$this->offset)
			$query = $this->db->get('(' . $compiled_select . ') tbl');
		else
			$query = $this->db->get('(' . $compiled_select . ') tbl', $this->limit, $this->offset);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			$query->free_result();
			return $query;
		}
	}
}
