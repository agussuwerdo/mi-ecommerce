<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	function __construct()
	{
		parent::__construct();
	}
}
