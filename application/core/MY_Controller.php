<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    // loading breadcrumb library for customer page
    if ($this->is_customer_page()) {
      $this->load->database();
      $this->load->library('breadcrumb', null, 'bc');
      $this->bc->add('Home', base_url());
    } else {
      if (!is_seller_authorized())
        redirect('/seller/login');
      $this->load->database();
      $this->load->library('breadcrumb_seller', null, 'bc');
      $this->bc->add('Home', base_url('seller'));
    }
  }

  function is_customer_page()
  {
    $segment_path = strtolower($this->uri->segment(1) ?? '');
    return ($segment_path == 'seller') ? false : true;
  }

  function check_customer_login()
  {
    if (!is_customer_authorized()) {
      if ($this->get_accept_header() == 'application/json')
        error('Session expired, please reload the page', '440');
      $this->load->library('user_agent');
      // if ($this->agent->is_referral()) {
      // 	echo $this->agent->referrer();
      // 	die;
      // }

      $this->session->set_userdata('redirect_url', $this->agent->referrer());
      $this->session->set_flashdata('error', 'You have to login first!');
      echo $this->load->view(template_customer(), array('content' => 'login/main'), TRUE);
      die();
    }
  }

  function get_accept_header()
  {
    $CI = &get_Instance();
    $accept_request = $CI->input->get_request_header('accept', TRUE);
    $arr = explode(",", $accept_request, 2);
    $first = $arr[0];
    return strtolower($first);
  }
}
