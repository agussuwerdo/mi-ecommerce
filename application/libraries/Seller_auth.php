<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seller_auth
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
		$this->CI->db->where(array('email' => $username, 'user_type' => 1));
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

			$login_data['seller_user_id']		= $newdata['user_id'];
			$login_data['seller_email']			= $newdata['email'];
			$login_data['seller_enc_pass']		= $newdata['enc_pass'];
			$login_data['seller_name']			= $newdata['name'];
			$login_data['seller_user_type']		= $newdata['user_type'];
			$login_data['is_seller_authorized'] = true;

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
		$this->CI->session->unset_userdata('seller_user_id');
		$this->CI->session->unset_userdata('seller_email');
		$this->CI->session->unset_userdata('seller_enc_pass');
		$this->CI->session->unset_userdata('seller_name');
		$this->CI->session->unset_userdata('seller_user_type');
		$this->CI->session->unset_userdata('is_seller_authorized');
		return TRUE;
	}
}
