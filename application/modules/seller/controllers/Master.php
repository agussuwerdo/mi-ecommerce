<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('sub_category_model');
	}

	public function product()
	{
		$data = array(
			'content' => 'master/product/main'
		);
		$this->bc->set_title('Master Product');
		$this->bc->add('master data', base_url('seller/master'));
		$this->bc->add('Product', base_url('seller/master/product'));
		$this->load->view(template_seller(), $data);
	}

	public function product_page()
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
			tbl.sku LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR tbl.name LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR tbl.description LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
		)"] = NULL;

		$this->product_model->set_where($where);

		$list_count = $this->product_model->count();
		$this->product_model->set_limit($rowperpage);
		$this->product_model->set_offset($start);
		$this->product_model->set_order($order_multiple);
		$list_data  = $this->product_model->find();

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

	public function product_input($enc_id = '')
	{
		$list_category = $this->category_model->find();
		$rowdata = $this->product_model->find_one(array('item_id' => decode($enc_id)));
		$data = array(
			'content' => 'master/product/input',
			'rowdata' => $rowdata,
			'list_category' => $list_category
		);
		$this->load->view($data['content'], $data);
	}

	public function save_product()
	{
		$this->db->trans_start();
		$data = array();
		$data['item_id'] = decode($this->input->post('item_id')) ?: 0;
		$data['sku'] = $this->input->post('sku');
		$data['name'] = $this->input->post('name');
		$data['description'] = $this->input->post('description');
		$data['price'] = floatval(preg_replace('/[^\d.]/', '', $this->input->post('price')));
		$data['discount'] = floatval(preg_replace('/[^\d.]/', '', $this->input->post('discount')));
		$data['stock'] = floatval(preg_replace('/[^\d.]/', '', $this->input->post('stock')));
		$data['weight'] = floatval(preg_replace('/[^\d.]/', '', $this->input->post('weight')));
		$data['f_category_code'] = $this->input->post('f_category_code');
		$data['f_sub_category_code'] = $this->input->post('f_sub_category_code');

		if (!$data['sku'])
			error('sku is empty');
		if (!$data['name'])
			error('name is empty');
		if (!$data['description'])
			error('description is empty');
		if (!$data['price'])
			error('price is empty');
		if (!$data['f_category_code'])
			error('category is empty');

		$data['slug'] = slugify($data['name']);

		$get_existing = $this->product_model->find_one(array('item_id' => $data['item_id']));

		// check if product exists
		$action = '';
		if ($get_existing['item_id']) {
			// check existing sku
			$where_sku_exists = array();
			$where_sku_exists['item_id != ' . $this->db->protect_identifiers($data['item_id'])] = null;
			$where_sku_exists['sku = ' . $this->db->protect_identifiers($data['sku'])] = null;
			$get_existing_sku = $this->product_model->find_one($where_sku_exists);

			if ($get_existing_sku['item_id'])
				error('SKU already used by [' . $get_existing_sku['name'] . ']');
			// update data
			$action = 'Update';
			$date['update_time'] = date('Y-m-d H:i:s');
			$this->product_model->update($data, $data['item_id']);
		} else {
			// check existing sku
			$where_sku_exists = array();
			$where_sku_exists['sku = ' . $this->db->protect_identifiers($data['sku'])] = null;
			$get_existing_sku = $this->product_model->find_one($where_sku_exists);
			if ($get_existing_sku['item_id'])
				error('SKU already used by [' . $get_existing_sku['name'] . ']');
			/// insert data
			$action = 'Insert';
			$date['create_time'] = date('Y-m-d H:i:s');
			$this->product_model->insert($data);
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			$error = $this->db->error();
			error($error);
		} else {
			$this->db->trans_commit();
			success("$action Data Success");
		}
	}

	public function delete_product()
	{
		$item_id = decode($this->input->post('item_id'));
		$this->product_model->delete($item_id);
		success("Delete Data Success");
	}

	public function category()
	{
		$data = array(
			'content' => 'master/category/main'
		);
		$this->bc->set_title('Master Category');
		$this->bc->add('master data', base_url('seller/master'));
		$this->bc->add('Category', base_url('seller/master/category'));
		$this->load->view(template_seller(), $data);
	}

	public function category_page()
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
			tbl.category_code LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR tbl.category_name LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
		)"] = NULL;

		$this->category_model->set_where($where);

		$list_count = $this->category_model->count();
		$this->category_model->set_limit($rowperpage);
		$this->category_model->set_offset($start);
		$this->category_model->set_order($order_multiple);
		$list_data  = $this->category_model->find();

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

	public function category_input($enc_id = '')
	{
		$rowdata = $this->category_model->find_one(array('category_code'=>decode($enc_id)));
		$data = array(
			'content' => 'master/category/input',
			'rowdata' => $rowdata
		);
		$this->load->view($data['content'], $data);
	}

	public function save_category()
	{
		$this->db->trans_start();
		$data = array();
		$data['category_name'] = $this->input->post('category_name');
		$new_category_code = slugify($data['category_name']);
		$data['category_code'] = $this->input->post('category_code') ?: $new_category_code;

		if (!$data['category_name'])
			error('Category Name is empty');

		$get_existing = $this->category_model->find_one($data['category_code']);
		// check if data exists
		$action = '';
		if ($get_existing['category_code']) {
			if ($data['category_code'] != $new_category_code) {
				// update related tables
				$this->product_model->update(array('f_category_code' => $new_category_code), array('f_category_code' => $data['category_code']));
				$this->sub_category_model->update(array('f_category_code' => $new_category_code), array('f_category_code' => $data['category_code']));
			}
			// update data
			$action = 'Update';
			$date['update_time'] = date('Y-m-d H:i:s');
			$this->category_model->update(array('category_code' => $new_category_code, 'category_name' => $data['category_name']), $data['category_code']);
		} else {
			/// insert data
			$action = 'Insert';
			$date['create_time'] = date('Y-m-d H:i:s');
			$this->category_model->insert($data);
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			$error = $this->db->error();
			error($error);
		} else {
			$this->db->trans_commit();
			success("$action Data Success");
		}
	}

	public function delete_category()
	{
		$category_code = decode($this->input->post('category_code'));
		// validate whether the category already used by another tables
		$count_product = $this->product_model->count(array('f_category_code' => $category_code));
		if ($count_product != 0)
			error("Category already used by $count_product products");
		$count_sub_cat = $this->sub_category_model->count(array('f_category_code' => $category_code));
		if ($count_sub_cat != 0)
			error("Category already used by $count_sub_cat sub categories");
		$this->category_model->delete($category_code);
		success("Delete Data Success");
	}

	public function get_sub_category()
	{
		$category_code = $this->input->get('category_code');
		$this->sub_category_model->set_where(array('f_category_code' => $category_code));
		$list_sub_cat = $this->sub_category_model->find();
		$res_data = array();
		foreach ($list_sub_cat->result_array() as $row) {
			$ok = array();
			$ok['id'] = $row['sub_category_code'];
			$ok['text'] = $row['sub_category_name'];
			$res_data[] = $ok;
		}
		$this->result['data'] = $res_data;
		success();
	}

	public function sub_category()
	{
		$data = array(
			'content' => 'master/sub_category/main'
		);
		$this->bc->set_title('Master Sub Category');
		$this->bc->add('master data', base_url('seller/master'));
		$this->bc->add('Sub Category', base_url('seller/master/sub_category'));
		$this->load->view(template_seller(), $data);
	}

	public function sub_category_page()
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
			tbl.f_category_code LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR tbl.f_category_code LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
			OR tbl.sub_category_name LIKE '%" . $this->db->escape_like_str($searchValue) . "%' ESCAPE '!'
		)"] = NULL;

		$this->sub_category_model->set_where($where);

		$list_count = $this->sub_category_model->count();
		$this->sub_category_model->set_limit($rowperpage);
		$this->sub_category_model->set_offset($start);
		$this->sub_category_model->set_order($order_multiple);
		$list_data  = $this->sub_category_model->find();

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

	public function sub_category_input($enc_id = '', $enc_sub_id = '')
	{
		$rowdata = $this->sub_category_model->find_one(array('f_category_code' => decode($enc_id), 'sub_category_code' => decode($enc_sub_id)));
		$list_category = $this->category_model->find();
		$data = array(
			'content' => 'master/sub_category/input',
			'list_category' => $list_category,
			'rowdata' => $rowdata
		);
		$this->load->view($data['content'], $data);
	}

	public function save_sub_category()
	{
		$this->db->trans_start();

		$data = array();
		$data['f_category_code'] = $this->input->post('f_category_code');
		$data['sub_category_code'] = $this->input->post('sub_category_code');
		$data['sub_category_name'] = $this->input->post('sub_category_name');

		if (!$data['f_category_code'])
			error('Category Code is empty');

		if (!$data['sub_category_name'])
			error('Sub Category Name is empty');

		$new_sub_category_code = slugify($data['sub_category_name']);
		$data['sub_category_code'] = $this->input->post('sub_category_code') ?: $new_sub_category_code;

		$get_existing = $this->sub_category_model->find_one(array('f_category_code' => $data['f_category_code'], 'sub_category_code' => $data['sub_category_code']));
		// check if data exists
		$action = '';
		if ($get_existing['sub_category_code']) {
			if ($data['sub_category_code'] != $new_sub_category_code) {
				// update related tables
				$this->product_model->update(
					array(
						'f_sub_category_code' => $new_sub_category_code
					),
					array(
						'f_category_code' => $data['f_category_code'],
						'f_sub_category_code' => $data['sub_category_code']
					)
				);
			}
			// update data
			$action = 'Update';
			$date['update_time'] = date('Y-m-d H:i:s');
			$this->sub_category_model->update(
				array(
					'sub_category_code' => $new_sub_category_code,
					'sub_category_name' => $data['sub_category_name']
				),
				array(
					'f_category_code' => $data['f_category_code'],
					'sub_category_code' => $data['sub_category_code']
				)
			);
		} else {
			/// insert data
			$action = 'Insert';
			$date['create_time'] = date('Y-m-d H:i:s');
			$this->sub_category_model->insert($data);
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			$error = $this->db->error();
			error($error);
		} else {
			$this->db->trans_commit();
			success("$action Data Success");
		}
	}

	public function delete_sub_category()
	{
		$category_code = decode($this->input->post('category_code'));
		$sub_category_code = decode($this->input->post('sub_category_code'));
		// validate whether the sub category already used by another tables
		$count_product = $this->product_model->count(array('f_category_code' => $category_code, 'f_sub_category_code' => $sub_category_code));
		if ($count_product != 0)
			error("Sub Category already used by $count_product products");
		$this->sub_category_model->delete(array('f_category_code' => $category_code, 'sub_category_code' => $sub_category_code));
		success("Delete Data Success");
	}
}
