<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_wish_list_products extends CI_Migration
{

	public function up()
	{
		
		## Create Table wish_list_products
		$this->dbforge->add_field(
			array(
				'f_user_id' => array('type' => 'int', 'key' => TRUE),
				'f_item_id' => array('type' => 'int', 'key' => TRUE),
				'created_at' => array('type' => 'datetime', 'null' => TRUE),
				'updated_at' => array('type' => 'datetime', 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("f_user_id", true);
		$this->dbforge->add_key("f_item_id", true);

		$this->dbforge->create_table("wish_list_products", TRUE);
		$this->db->query('ALTER TABLE  `wish_list_products` ENGINE = InnoDB');
	}

	public function down()
	{
		### Drop table wish_list_products ##
		$this->dbforge->drop_table("wish_list_products", TRUE);
	}
}
