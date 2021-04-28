<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_auth
{
	var $CI = null;

	function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');
	}

	function do_login($login = NULL)
	{
		$result = array();
		$result['focus'] = '';
		$result['error'] 	= '';

		if (!isset($login))
			$result['status'] 	= 0;

		if (count($login) != 2) {
			$result['status'] = 0;
			$result['error'] = 'Incorrect parameter';
		}
		$username = $login['email'];
		$password = $login['pass'];

		$enc_pass = md5($password);

		$this->CI->db->from('users');
		$this->CI->db->where(array('email' => $username, 'user_type' => 2));
		$query = $this->CI->db->get();
		if ($query->num_rows() == 1) {
			$newdata = $query->row_array();
			$login_data = array();
			if (strtolower($newdata['enc_pass']) !== strtolower($enc_pass)) {
				// Password tidak sesuai
				$result['status'] = 0;
				$result['error'] = 'Invalid Email or Password';
				$result['focus'] = 'pass';
				return $result;
			}

			$login_data['customer_user_id']			= $newdata['user_id'];
			$login_data['customer_email']			= $newdata['email'];
			$login_data['customer_enc_pass']		= $newdata['enc_pass'];
			$login_data['customer_name']			= $newdata['name'];
			$login_data['customer_user_type']		= $newdata['user_type'];
			$login_data['customer_adress']			= $newdata['adress'];
			$login_data['is_customer_authorized'] = true;

			$this->CI->session->set_userdata($login_data);

			$result['status'] = 1;
		} else {
			// No existing user.
			$result['status'] = 0;
			$result['focus'] = 'email';
			$result['error'] = 'User Not Found';
		}
		return $result;
	}

	function do_logout()
	{
		$this->CI->session->unset_userdata('customer_user_id');
		$this->CI->session->unset_userdata('customer_email');
		$this->CI->session->unset_userdata('customer_enc_pass');
		$this->CI->session->unset_userdata('customer_name');
		$this->CI->session->unset_userdata('customer_user_type');
		$this->CI->session->unset_userdata('customer_adress');
		$this->CI->session->unset_userdata('is_customer_authorized');
		return TRUE;
	}
}
