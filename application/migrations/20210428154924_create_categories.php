<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_categories extends CI_Migration
{

	public function up()
	{

		## Create Table categories
		$this->dbforge->add_field(
			array(
				'category_code' => array('type' => 'varchar', 'constraint' => '30', 'key' => TRUE),
				'category_name' => array('type' => 'varchar', 'constraint' => '100', 'null' => TRUE),
				'created_at' => array('type' => 'datetime', 'null' => TRUE),
				'updated_at' => array('type' => 'datetime', 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("category_code", true);

		$this->dbforge->create_table("categories", TRUE);
		$this->db->query('ALTER TABLE  `categories` ENGINE = InnoDB');
		## Generate Table Data 
		$this->db->query("INSERT INTO `categories`(`category_code`, `category_name`, `created_at`, `updated_at`) VALUES ('aksesoris', 'Aksesoris', NULL, NULL);");
		$this->db->query("INSERT INTO `categories`(`category_code`, `category_name`, `created_at`, `updated_at`) VALUES ('celana', 'Celana', NULL, NULL);");
		$this->db->query("INSERT INTO `categories`(`category_code`, `category_name`, `created_at`, `updated_at`) VALUES ('pakaian', 'Pakaian', NULL, NULL);");
	}

	public function down()
	{
		### Drop table categories ##
		$this->dbforge->drop_table("categories", TRUE);
	}
}
