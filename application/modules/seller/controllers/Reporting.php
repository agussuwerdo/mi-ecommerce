<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reporting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Sales_model');
	}

	public function daily()
	{
		$data = array(
			'content' => 'reporting/daily/main'
		);
		$this->bc->set_title('Reporting Sales Daily');
		$this->bc->add('Reporting', base_url('seller/reporting'));
		$this->bc->add('Daily', base_url('seller/reporting/daily'));
		$this->load->view(template_seller(),$data);
	}

	public function sales_daily_page()
	{
		$draw = $this->input->post('draw') ?: 0;
		$start = $this->input->post('start');
		$rowperpage  = $this->input->post('length') ?: 0;
		$search = $this->input->post('search');
		$searchValue = $search['value'];
		$column_orders = $this->input->post('order');
		$column_list = $this->input->post('columns');
		$order_multiple = array();

		foreach ($column_orders as $col_order) {
			$col_index = $col_order['column'];
			$col_name = $column_list[$col_index]['data'];
			$order_dir = $col_order['dir'];
			$order_multiple[$col_name] = $order_dir;
		}

		$where = array();

		$this->Sales_model->set_where($where);

		$list_count = $this->Sales_model->count_report_daily();
		$this->Sales_model->set_limit($rowperpage);
		$this->Sales_model->set_offset($start);
		$this->Sales_model->set_order($order_multiple);
		$list_data  = $this->Sales_model->list_report_daily();

		$response = array(
			"post" => $this->input->post(),
			"draw" => intval($draw),
			"iTotalRecords" => $list_count,
			"iTotalDisplayRecords" => $list_count,
			"aaData" => $list_data->result_array()
		);

		header('Content-type: application/json');
		echo json_encode($response);
	}

	public function monthly()
	{
		$data = array(
			'content' => 'reporting/monthly/main'
		);
		$this->bc->set_title('Reporting Sales Monthly');
		$this->bc->add('Reporting', base_url('seller/reporting'));
		$this->bc->add('Monthly', base_url('seller/reporting/monthly'));
		$this->load->view(template_seller(),$data);
	}

	public function sales_monthly_page()
	{
		$draw = $this->input->post('draw') ?: 0;
		$start = $this->input->post('start');
		$rowperpage  = $this->input->post('length') ?: 0;
		$search = $this->input->post('search');
		$searchValue = $search['value'];
		$column_orders = $this->input->post('order');
		$column_list = $this->input->post('columns');
		$order_multiple = array();

		foreach ($column_orders as $col_order) {
			$col_index = $col_order['column'];
			$col_name = $column_list[$col_index]['data'];
			$order_dir = $col_order['dir'];
			$order_multiple[$col_name] = $order_dir;
		}

		$where = array();

		$where["(
			tbl.month_name LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
		)"] = NULL;

		$this->Sales_model->set_where($where);

		$list_count = $this->Sales_model->count_report_monthly();
		$this->Sales_model->set_limit($rowperpage);
		$this->Sales_model->set_offset($start);
		$this->Sales_model->set_order($order_multiple);
		$list_data  = $this->Sales_model->list_report_monthly();

		$response = array(
			"post" => $this->input->post(),
			"draw" => intval($draw),
			"iTotalRecords" => $list_count,
			"iTotalDisplayRecords" => $list_count,
			"aaData" => $list_data->result_array()
		);

		header('Content-type: application/json');
		echo json_encode($response);
	}

}
