<?php

/**
 * Global helper function.
 * 
 * @author		agussuwerdo
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Function to show error message then exit.
 *
 * @param String $msg Result error message
 * @param String $error_code Result Status Code
 * @param String $error_header Result header
 * 
 * @return json error result
 * 
 */
if (!function_exists('error')) {
	function error($err, $error_code = '202', $error_header = 'error')
	{
		$_this = &get_Instance();
		$_this->result['status_code']			= 0;
		$_this->result['message']				= $err;
		if (!headers_sent()) {
			header('Content-Type: application/json');
			header("HTTP/1.1 " . $error_code . " " . $error_header);
		}
		echo json_encode($_this->result);
		exit;
	}
}

/**
 * Function to show success message.
 *
 * @param String $msg Result Success message
 * @param String $success_code Result Status Code
 * @param String $success_header Result header
 * 
 * @return json Success result
 * 
 */
if (!function_exists('success')) {
	function success($msg = '', $success_code = '200', $success_header = 'OK')
	{
		$_this = &get_Instance();
		$_this->result['status_code']			= 1;
		$_this->result['message']				= $msg;
		if (!headers_sent()) {
			header('Content-Type: application/json');
			header("HTTP/1.1 " . $success_code . " " . $success_header);
		}
		echo json_encode($_this->result);
	}
}

/**
 * Global helper for customer template.
 * 
 * @return String default customer template
 * 
 */
if (!function_exists('template_customer')) {
	function template_customer()
	{
		return 'templates/customer/main';
	}
}

/**
 * Global helper for seller template.
 * 
 * @return String default seller template
 * 
 */
if (!function_exists('template_seller')) {
	function template_seller()
	{
		return 'templates/seller/main';
	}
}

/**
 * Global helper for empty image.
 * 
 * @return String default empty image
 * 
 */
if (!function_exists('empty_image')) {
	function empty_image()
	{
		return base_url('assets/front/img/empty-img.png');
	}
}

/**
 * Global helper for logo image.
 * 
 * @return String default logo image
 * 
 */
if (!function_exists('logo_image')) {
	function logo_image()
	{
		return base_url('assets/front/img/mi-ecommerce-logo-clear.png');
	}
}

/**
 * Global helper for checking is customer logged in.
 * 
 * @return Boolean login state
 * 
 */
function is_customer_authorized()
{
	$this_ = &get_instance();
	$this_->load->library('session');
	$session = $this_->session->userdata('is_customer_authorized');
	if ($session != '') {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Global helper for checking is seller logged in.
 * 
 * @return Boolean login state
 * 
 */
function is_seller_authorized()
{
	$this_ = &get_instance();
	$this_->load->library('session');
	$session = $this_->session->userdata('is_seller_authorized');
	if ($session != '') {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Global helper for set active menu css class.
 * 
 * @return String active menu state
 * 
 */
function get_menu_active($selected_menu, $parent = false)
{
	$this_ = &get_instance();
	$selected_menu = strtolower($selected_menu);
	$seg_parent = $this_->uri->segment(2);
	if ($parent)
		return ($seg_parent === $selected_menu);
	else {
		$seg_menu = $this_->uri->segment(3);
		$explodeMenu = explode("/", $selected_menu);
		$countExplodeMenu = count($explodeMenu);
		$last_selected_parent = strtolower($explodeMenu[$countExplodeMenu - 2]);
		$last_selected_menu = strtolower($explodeMenu[$countExplodeMenu - 1]);
		return (($seg_parent === $last_selected_parent) && ($seg_menu === $last_selected_menu));
	}
}

/**
 * Function to generate product slug.
 * 
 * @return String slug product name
 * 
 */
if (!function_exists('slugify')) {
	function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('/[^A-Za-z0-9-]+/', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
}

/**
 * Base46 encode function
 * 
 * @return String encoded string
 * 
 */
function encode($str)
{
	return base64_encode($str);
}

/**
 * Base46 decode function
 * 
 * @return String decoded string
 * 
 */
function decode($str)
{
	return base64_decode($str);
}

/**
 * Function to generate pagination buttons
 * 
 * @return String Pagination
 * 
 */
function paginate_links($total_rows, $offset, $row_per_page, $link_number = 3, $page_url = '')
{
	$CI = &get_Instance();
	$CI->load->library('pagination');
	// $config['first_link'] = true;
	// $config['last_link'] = true;
	$config['full_tag_open'] = '<ul class="pagination float-right">';
	$config['full_tag_close'] = '</ul>';
	$config['first_tag_open'] = '<li class="page-item">';
	$config['first_tag_close'] = '</li>';
	$config['prev_link'] = '&laquo';
	$config['prev_tag_open'] = '<li class="page-item prev">';
	$config['prev_tag_close'] = '</li>';
	$config['next_link'] = '&raquo';
	$config['next_tag_open'] = '<li class="page-item">';
	$config['next_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li class="page-item">';
	$config['last_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li class="page-item">';
	$config['num_tag_close'] = '</li>';
	$config['attributes'] = array('class' => 'page-link');

	$config['cur_page'] = $offset;
	$config['page_query_string'] = TRUE;
	$config['base_url'] = site_url() . $page_url;
	$config['total_rows'] = $total_rows;
	$config['per_page'] = $row_per_page;
	$config['reuse_query_string'] = true;
	$config['num_links'] = $link_number;
	$CI->pagination->initialize($config);

	return $CI->pagination->create_links();
}

/**
 * Function to return ceil number
 * 
 * @return Int ceiling number
 * 
 */
if (!function_exists('ceiling')) {
	function ceiling($number, $significance = 1)
	{
		return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
	}
}

/**
 * Function to get category list
 * 
 * @return Array list category
 * 
 */
if (!function_exists('category_list')) {
	function category_list()
	{
		$CI = &get_Instance();
		$CI->load->model('sub_category_model');
		$CI->sub_category_model->set_order(array('f_category_code' => 'asc', 'sub_category_code' => 'asc'));
		$sub_category = $CI->sub_category_model->find();
		$fmt_category = array();
		$tmp_category_code = '';
		$tmp_category_name = '';
		$key_category = -1;
		$key_sub_category = -1;
		foreach ($sub_category->result_array() as $sub) {
			if ($tmp_category_code != $sub['f_category_code']) {
				$key_category++;
				$key_sub_category = -1;
				$tmp_category_code = $sub['f_category_code'];
				$tmp_category_name = $sub['category_name'];
			}
			$key_sub_category++;
			$fmt_category[$key_category]['category_code'] = $tmp_category_code;
			$fmt_category[$key_category]['category_name'] = $tmp_category_name;
			$fmt_category[$key_category]['sub_category'][$key_sub_category] = $sub;
		}
		return $fmt_category;
	}
}

/**
 * Function to get cart list
 * 
 * @return Array list cart
 * 
 */
function cart_data()
{
	$CI = &get_instance();
	$CI->load->library('cart');
	$carts = $CI->cart->contents();
	$total_items = 0;
	$total_quantity = 0;
	$total_original_price = 0;
	$total_price = 0;
	$total_shipping = 10000;
	$total_discount = 0;
	$total_weight = 0;
	$new_carts = array();
	foreach ($carts as $rowid => $cart) {
		$get_product = $CI->product_model->find_one($cart['id']);
		$cart['qty_stock'] = (int)$get_product['stock'] ?: 0;
		$total_items++;
		$total_quantity = $total_quantity + $cart['qty'];
		$total_original_price = $total_original_price + ($cart['options']['original_price'] * $cart['qty']);
		$total_price =  $total_price + ($cart['price'] * $cart['qty']);
		$total_discount = $total_discount + ($cart['options']['discount'] * $cart['qty']);
		$total_weight = $total_weight + ($cart['options']['weight'] * $cart['qty']);
		$new_carts['carts'][$rowid] = $cart;
	}
	$new_carts['total_items'] 			= $total_items;
	$new_carts['total_quantity'] 		= $total_quantity;
	$new_carts['total_original_price'] 	= $total_original_price;
	$new_carts['total_price']		 	= $total_price;
	$new_carts['total_shipping']		= $total_shipping;
	$new_carts['total_retail_sales']	= $total_price + $total_shipping;
	$new_carts['total_discount']	 	= $total_discount;
	$new_carts['total_weight']	 		= $total_weight;
	return $new_carts;
}

/**
 * Function to get order count for customer
 * 
 * @return mixed order
 * 
 */
function order_count_cust()
{
	$CI = &get_Instance();
	$CI->load->model('sales_model');
	$CI->sales_model->set_where(array('f_customer_id' => $CI->session->userdata('customer_user_id')));
	$count =  $CI->sales_model->count();

	return $count;
}

/**
 * Function to get order count for seller
 * 
 * @return mixed order
 * 
 */
function order_count_seller()
{
	$CI = &get_Instance();
	$CI->load->model('sales_model');
	$CI->sales_model->set_where(array('status' => 0));
	$count =  $CI->sales_model->count();

	return $count;
}

/**
 * Function to return 404 page to end user
 * 
 * @return view 404
 * 
 */
function return_404()
{
	$CI = &get_instance();
	$CI->output->set_status_header('404');
	$CI->bc->set_title('Page Not Found');
	$CI->load->view(template_customer(), array('content' => 'templates/404'));
}
/**
 * Function to generate random color part
 * 
 * @return String color part
 * 
 */
function random_color_part()
{
	return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

/**
 * Function to generate random color
 * 
 * @return String color
 * 
 */
function random_color()
{
	return random_color_part() . random_color_part() . random_color_part();
}
