<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('product_model');
		$this->load->model('sales_model');
		$this->load->model('sales_item_model');
	}

	public function save_cart()
	{
		$order_item_id = $this->input->post('order_item_id');
		$quantity = floatval(preg_replace('/[^\d.]/', '', $this->input->post('order_quantity')));

		if (!$order_item_id)
			error('Error item not selected');
		if (!$quantity)
			error('Quantity cannot be empty');

		$get_product = $this->product_model->find_one($order_item_id);
		if ($get_product['item_id'] == '')
			error('Invalid product');

		// check product availability
		if ($quantity > $get_product['stock'])
			error('Stock not available');

		$retail_sale_amount = $get_product['price'] - $get_product['discount'];
		// save to cart
		$cart = array(
			'id'      => $order_item_id,
			'qty'     => $quantity,
			'price'   => $retail_sale_amount,
			'name'    => $get_product['name'],
			'options' => array(
				'product_link' => base_url('product/' . $get_product['slug']),
				'weight' => (int)$get_product['weight'],
				'original_price' => (int)$get_product['price'],
				'discount' => $get_product['discount']
			)
		);

		$this->cart->product_name_rules = '[:print:]';

		$action_text = 'Add product to cart';
		$insert_new = TRUE;
		$my_cart = $this->cart->contents();

		foreach ($my_cart as $item) {

			// check product id in session, if exist update the quantity
			if ($item['id'] == $order_item_id) {

				$data_update = array(
					'rowid' => $item['rowid'], 'qty'    => $quantity,
				);
				$this->cart->update($data_update);

				// set $insert_new value to False
				$insert_new = FALSE;
				$action_text = 'Update product in cart';
			}
		}
		// if $insert_new value is true, insert the item as new item in the cart
		if ($insert_new) {
			$this->cart->insert($cart);
		}
		$count_item = $this->cart->total_items();
		if (empty($count_item)) {
			error('Failed to add item to cart');
		}
		success(" $action_text success");
	}

	public function cart()
	{
		$this->product_model->set_select('DISTINCT(item_id),name,price,discount,slug');
		$this->product_model->set_order('rand()');
		$this->product_model->set_limit(3);
		$random_product = $this->product_model->find();

		$data = array(
			'content' => 'order/main',
			'random_product' => $random_product
		);
		$this->bc->set_title('Shopping Cart');
		$this->bc->add('Shopping Cart', site_url());
		$this->load->view(template_customer(), $data);
	}

	public function cart_contents()
	{
		$data = array(
			'content' => 'order/cart',
			'carts' => cart_data()
		);
		$this->load->view($data['content'], $data);
	}

	public function update_cart()
	{
		$cart_contents = $this->input->post();

		foreach ($cart_contents as $rowid => $cart) {
			$id = isset($cart['id']) ? $cart['id'] : '';
			$qty = isset($cart['qty']) ? $cart['qty'] : 0;
			$get_product = $this->product_model->find_one(array('item_id' => $id));
			$quantity_stock = $get_product['stock'] ?: 0;
			if ($qty > $quantity_stock)
				error('Product ' . $get_product['name'] . ' Stock not available, failed to update cart');
		}

		foreach ($cart_contents as $cart) {
			$this->cart->update($cart);
		}

		success('Cart updated');
	}

	public function get_cart()
	{
		$this->result['carts'] = cart_data();
		success('ok');
	}

	public function get_cart_count()
	{
		$this->result['carts'] = cart_data();
		success('ok');
	}

	public function submit_order()
	{
		if (!is_customer_authorized())
			error('You have to login first', '440');
		$customer_id = $this->session->userdata('customer_user_id');
		$customer_name = $this->session->userdata('customer_name');
		$customer_adress = $this->session->userdata('customer_adress');

		$cart_data = cart_data();
		if ($cart_data['total_items'] < 1)
			error('Your cart still empty');

		$this->db->trans_begin();
		$temp_sales = array();
		$temp_sales_detail = array();

		try {
			$transaction_prefix = 'IN' . date('ymdG');
			$invoice_number = $this->sales_model->gen_auto_number($transaction_prefix);

			$temp_sales['invoice_number']		 = $invoice_number;
			$temp_sales['f_customer_id']		 = $customer_id;
			$temp_sales['sales_date']			 = date('Ymd');
			$temp_sales['created_at']			 = date('Y-m-d H:i:s');
			$temp_sales['product_count']		 = $cart_data['total_items'];
			$temp_sales['quantity_total']		 = $cart_data['total_quantity'];
			$temp_sales['price_total']			 = $cart_data['total_original_price'];
			$temp_sales['discount_total']		 = $cart_data['total_discount'];
			$temp_sales['shipping_cost']		 = $cart_data['total_shipping'];
			$temp_sales['weight_total']			 = $cart_data['total_weight'];
			$temp_sales['retail_sales_total']	 = $cart_data['total_retail_sales'];
			$temp_sales['customer_address_name'] = $customer_name;
			$temp_sales['customer_address']		 = $customer_adress;
			$temp_sales['status']				 = 0;

			$recnum = 1;
			foreach ($cart_data['carts'] as $rowid => $cart) {
				$temp_sales_ = array();

				$get_product = $this->product_model->find_one($cart['id']);
				$temp_sales_['invoice_number']	= $invoice_number;
				$temp_sales_['recnum']			= $recnum++;
				$temp_sales_['f_customer_id']	= $customer_id;
				$temp_sales_['sales_date']		= date('Ymd');
				$temp_sales_['created_at']		= date('Y-m-d H:i:s');
				$temp_sales_['f_item_id']		= $cart['id'];
				$temp_sales_['f_sku']			= $get_product['sku'];
				$temp_sales_['f_name']			= $get_product['name'];
				$temp_sales_['quantity']		= $cart['qty'];
				$temp_sales_['price']			= $cart['options']['original_price'];
				$temp_sales_['discount']		= $cart['options']['discount'];
				$temp_sales_['retail_sales']	= $cart['subtotal'];
				$temp_sales_['status']			= 0;
				$temp_sales_['weight']			= $cart['options']['weight'];
				$temp_sales_detail[] = $temp_sales_;
				// update stock
				$data_stock = array();
				$data_stock['stock'] = $get_product['stock'] - $cart['qty'];
				$where_stock = array();
				$where_stock['item_id'] = $cart['id'];
				$this->product_model->update($data_stock, $where_stock);
			}
			$this->sales_model->insert($temp_sales);
			$this->sales_item_model->insert_batch($temp_sales_detail);
		} catch (\Throwable $th) {
			error($th);
		}
		if (($this->db->trans_status() === false) || ($this->db->error()['code'])) {
			$this->db->trans_rollback();
			$error = $this->db->error();
			error($error);
		} else {
			$this->db->trans_commit();
			$this->cart->destroy();
			success('Order Successfully Placed');
		}
	}
	
	public function sales_detail($invoice_number)
	{
		$sales_row = $this->sales_model->find_one($invoice_number);
		$this->sales_item_model->set_where(array('invoice_number' => $invoice_number));
		$sales_detail_list = $this->sales_item_model->find();
		$data = array(
			'content' => 'profile/sales_detail',
			'invoice_number' => $invoice_number,
			'sales_row' => $sales_row,
			'sales_detail_list' => $sales_detail_list
		);
		$this->load->view($data['content'], $data);
	}
}
