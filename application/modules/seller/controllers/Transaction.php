<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('sales_model');
		$this->load->model('sales_item_model');
	}

	public function sales()
	{
		$data = array(
			'content' => 'transaction/sales/main'
		);
		$this->bc->set_title('Transcation');
		$this->bc->add('Transcation', base_url('seller/transaction'));
		$this->bc->add('Sales', base_url('seller/transaction/sales'));
		$this->load->view(template_seller(), $data);
	}

	public function sales_page()
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
			tbl.invoice_number LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR user.name LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
		)"] = NULL;

		$this->sales_model->set_where($where);

		$list_count = $this->sales_model->count();
		$this->sales_model->set_limit($rowperpage);
		$this->sales_model->set_offset($start);
		$this->sales_model->set_order($order_multiple);
		$list_data  = $this->sales_model->find();

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

	public function confirm_transaction()
	{
		$invoice_number = $this->input->post('invoice_number');

		$data_update = array('status' => 1);
		$update_where = array('invoice_number' => $invoice_number);

		$this->sales_model->update($data_update, $update_where);
		$this->sales_item_model->update($data_update, $update_where);

		success('Order Processed');
	}
}
