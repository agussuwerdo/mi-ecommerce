<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_sub_categories extends CI_Migration
{

	public function up()
	{
		## Create Table sub_categories
		$this->dbforge->add_field(
			array(
				'f_category_code' => array('type' => 'varchar', 'constraint' => '30', 'key' => TRUE),
				'sub_category_code' => array('type' => 'varchar', 'constraint' => '30', 'key' => TRUE),
				'sub_category_name' => array('type' => 'varchar', 'constraint' => '100', 'null' => TRUE),
				'created_at' => array('type' => 'datetime', 'null' => TRUE),
				'updated_at' => array('type' => 'datetime', 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("f_category_code", true);
		$this->dbforge->add_key("sub_category_code", true);

		$this->dbforge->create_table("sub_categories", TRUE);
		$this->db->query('ALTER TABLE  `sub_categories` ENGINE = InnoDB');
		## Generate Table Data 
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('aksesoris', 'dasi', 'Dasi', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('aksesoris', 'kaos-kaki', 'Kaos Kaki', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('aksesoris', 'masker', 'Masker', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('celana', 'celana-jeans', 'Celana Jeans', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('pakaian', 'blazer', 'Blazer', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('pakaian', 'kaos-pria', 'Kaos Pria', NULL, NULL);");
		$this->db->query("INSERT INTO `sub_categories`(`f_category_code`, `sub_category_code`, `sub_category_name`, `created_at`, `updated_at`) VALUES ('pakaian', 'pakaian-olahraga', 'Pakaian Olahraga', NULL, NULL);");
	}

	public function down()
	{
		### Drop table sub_categories ##
		$this->dbforge->drop_table("sub_categories", TRUE);
	}
}
