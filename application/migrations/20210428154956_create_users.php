<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_users extends CI_Migration
{

	public function up()
	{

		## Create Table users
		$this->dbforge->add_field(
			array(
				'user_id' => array('type' => 'int', 'key' => TRUE, 'auto_increment' => TRUE),
				'email' => array('type' => 'varchar', 'constraint' => '100', 'null' => TRUE),
				'enc_pass' => array('type' => 'text', 'constraint' => '65535', 'null' => TRUE),
				'name' => array('type' => 'varchar', 'constraint' => '255', 'null' => TRUE),
				'user_type' => array('type' => 'int', 'null' => TRUE, 'comment' => '1 = seller, 2 = customer'),
				'created_at' => array('type' => 'datetime', 'null' => TRUE), // Set to NULL by default
				'updated_at' => array('type' => 'datetime', 'null' => TRUE), // Set to NULL by default
				'adress' => array('type' => 'text', 'constraint' => '65535', 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("user_id", true);

		$this->dbforge->create_table("users", TRUE);
		$this->db->query('ALTER TABLE  `users` ENGINE = InnoDB');
		## Generate Table Data 
		$this->db->query("INSERT INTO `users`(`user_id`, `email`, `enc_pass`, `name`, `user_type`, `created_at`, `updated_at`, `adress`) VALUES (1, 'admin@mi.com', '21232f297a57a5a743894a0e4a801fc3', 'administrator', 1, NULL, NULL, NULL);");
	}

	public function down()
	{
		### Drop table users ##
		$this->dbforge->drop_table("users", TRUE);
	}
}
