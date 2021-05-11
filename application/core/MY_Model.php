<?php

/**
 * Custom ORM model.
 * Design for : mySQL & postgreSQL
 */
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	protected $table = '';
	protected $schema = '';
	protected $primaryKey = '';
	protected $limit = 0;
	protected $offset = 0;
	protected $where = null;
	protected $orderBy = null;
	protected $groupBy = null;
	protected $selectFields = null;
	protected $autoQuotes = true;

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * setter to set join active records
	 * @return Void
	 */
	function _join()
	{
	}

	/**
	 * getter to retreive table name
	 * @return Void
	 */
	function table_name()
	{
		return ($this->schema != '') ? $this->schema . '.' . $this->table : $this->table;
	}

	/**
	 * getter to retreive primary key
	 * @return Void
	 */
	function single_primary()
	{
		if (is_array($this->primaryKey))
			return $this->primaryKey[0];
		else
			return $this->primaryKey;
	}

	/**
	 * setter to set select active records
	 * @return Void
	 */
	public function set_select($select)
	{
		$this->selectFields = $select;
	}

	/**
	 * setter to set offset active records
	 * @return Void
	 */
	public function set_limit($limit = 0)
	{
		if ($limit > 0)
			$this->limit = $limit;
	}

	/**
	 * setter to remove limit active records
	 * @return Void
	 */
	public function unset_limit()
	{
		$this->limit = null;
	}

	/**
	 * setter to set offset active records
	 * @return Void
	 */
	public function set_offset($offset = 0)
	{
		if ($offset > 0)
			$this->offset = $offset;
	}

	/**
	 * setter to remove offset active records
	 * @return Void
	 */
	public function unset_offset()
	{
		$this->offset = null;
	}

	/**
	 * setter to set where active records
	 * @return Void
	 */
	public function set_where($where = array())
	{
		if ($where)
			$this->where = $where;
	}

	/**
	 * setter to remove where active records
	 * @return Void
	 */
	public function unset_where()
	{
		$this->where = null;
	}

	/**
	 * setter to set order by active records
	 * @return Void
	 */
	public function set_order($order = array())
	{
		if ($order)
			$this->orderBy = $order;
	}

	/**
	 * setter to remove order by active records
	 * @return Void
	 */
	public function unset_order()
	{
		$this->orderBy = null;
	}

	/**
	 * setter to set active records group
	 * @return Void
	 */
	public function set_group($group = array())
	{
		if ($group)
			$this->groupBy = $group;
	}

	/**
	 * setter to remove active records group
	 * @return Void
	 */
	public function unset_group()
	{
		$this->groupBy = null;
	}

	/**
	 * Function to find count data from tables based on active records query
	 * @return Integer count data
	 */
	function count($where = null)
	{
		$count_where = $where ?: $this->where;

		if ($count_where)
			if (is_array($count_where)) {
				foreach ($count_where as $key => $value) {
					$this->db->where($key, $value);
				}
			} else {
				$this->db->where($this->single_primary(), $count_where ?: '0');
			}

		$this->_join();

		$query = $this->db->get($this->table_name() . ' tbl');
		
		return $query->num_rows();
	}

	/**
	 * Function to find single data from tables based on active records query
	 * @return Array single row data
	 */
	function find_one($where='')
	{
		$find_where = $where ?: $this->where;

		$data = array();
		if ($find_where)
			if (is_array($find_where)) {
				foreach ($find_where as $key => $value) {
					$this->db->where($key, $value);
				}
			} else {
				$this->db->where($this->single_primary(), $find_where ?: 'null');
			}

		$this->db->select('tbl.*');
		if (is_array($this->orderBy)) {
			foreach ($this->orderBy as $key => $value) {
				$this->db->order_by($key, $value);
			}
		} else {
			$this->db->order_by($this->single_primary());
		}
		$query = $this->db->get($this->table_name() . ' tbl', 1, 0);

		if ($query->num_rows() == 1) {
			$data = $query->row_array();
			$query->free_result();
		} else {
			$data = $this->default_fields();
		}
		return $data;
	}

	/**
	 * Function to find list data from tables based on active records query
	 * @return Array result list data
	 */
	function find()
	{
		if ($this->selectFields != null)
			$this->db->select($this->selectFields);
		if ($this->where) {
			if (!$this->autoQuotes) {
				$this->db->where($this->where, NULL, false);
			} else {
				$this->db->where($this->where);
			}
		}

		if (is_array($this->orderBy)) {
			foreach ($this->orderBy as $key => $value) {
				$this->db->order_by($key, $value);
			}
		} else {
			$this->db->order_by($this->orderBy);
		}
		if ($this->groupBy) {
			foreach ($this->groupBy as $key => $value) {
				$this->db->group_by($value);
			}
		}

		$this->_join();

		if (!$this->limit and !$this->offset)
			$query = $this->db->get($this->table_name() . ' tbl');
		else
			$query = $this->db->get($this->table_name() . ' tbl', $this->limit, $this->offset);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			$query->free_result();
			return $query;
		}
	}

	/**
	 * Extends insert function
	 * @return Mixed insert result
	 */
	public function insert($data = null)
	{
		return $this->db->insert($this->table_name(), $data);
	}

	/**
	 * Extends insert_batch function
	 * @return Mixed insert_batch result
	 */
	public function insert_batch($data = null)
	{
		return $this->db->insert_batch($this->table_name(), $data); 
	}

	/**
	 * Extends Delete function
	 * @return Mixed delete result
	 */
	public function delete($where = NULL, $table = FALSE)
	{
		$table = (FALSE !== $table) ? $table : $this->table_name();

		if (is_array($where)) {
			$this->db->where($where);
		} else {
			$this->db->where($this->single_primary(), $where);
		}

		return $this->db->delete($table);
	}

	/**
	 * Extends update function
	 * @return Mixed update result
	 */
	function update($data, $where = null)
	{
		$update_where = $where ?: $this->where;
		if (!$update_where)
			$this->log_message('update condition not set..!');

		if (is_array($update_where)) {
			$this->db->where($update_where);
		} else {
			$this->db->where($this->single_primary(), $update_where);
		}
		$update = $this->db->update($this->table_name(), $data);
		return $update;
	}

	/**
	 * Create log message and exit
	 * @return String log message
	 */
	function log_message($msg, $level = 'error')
	{
		log_message($level, $msg);
		echo $msg;
		exit;
	}

	/**
	 * Get list fields from table
	 * @return Array list fields
	 */
	function default_fields()
	{
		$template = array();
		$fields = $this->db->list_fields($this->table);

		foreach ($fields as $field) {
			$field_data = (isset($field_data[0])) ? $field_data[0] : false;

			$template[$field] = (isset($field_data['Default'])) ? $field_data['Default'] : '';
		}
		return $template;
	}

	/**
	 * Generate auto number {only for single pk field}
	 * @return string auto number
	 */
	function gen_auto_number($prefix = '', $autonumber_length = 5)
	{
		$prefix_length		= strlen($prefix);
		$transnumber_length = $autonumber_length + $prefix_length;

		$this->db->select('RIGHT(tbl.' . $this->db->protect_identifiers($this->single_primary()) . ',' . $autonumber_length . ') ' . $this->db->protect_identifiers($this->db->protect_identifiers($this->single_primary())) . '', false);
		$this->db->order_by('tbl.' . $this->db->protect_identifiers($this->single_primary()) . '', 'DESC');
		$this->db->group_by('tbl.' . $this->db->protect_identifiers($this->single_primary()) . '');

		$this->db->where('LEFT(tbl.' . $this->db->protect_identifiers($this->single_primary()) . ',' . $prefix_length . ') = ' . $this->db->escape($prefix) . ' AND CHAR_LENGTH(tbl.' . $this->db->protect_identifiers($this->single_primary()) . ') = ' . $transnumber_length . '');

		$query = $this->db->get($this->table_name() . ' tbl', '1', '0');

		$no_last =  $query->row_array();
		$no_next = 1;
		if ($no_last) {
			$no_next = $no_last[$this->single_primary()] + 1;
		}

		$no = $prefix . sprintf('%0' . $autonumber_length . 's', $no_next);

		$query->free_result();

		return $no;
	}

}
