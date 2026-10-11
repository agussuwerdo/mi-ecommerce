<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_sales_items extends CI_Migration
{

	public function up()
	{
		
		## Create Table sales_items
		$this->dbforge->add_field(
			array(
				'invoice_number' => array('type' => 'varchar', 'constraint' => '15', 'key' => TRUE),
				'recnum' => array('type' => 'int', 'key' => TRUE),
				'f_customer_id' => array('type' => 'int', 'null' => TRUE),
				'sales_date' => array('type' => ($this->db->dbdriver === 'postgre' ? 'timestamp' : 'datetime'), 'null' => TRUE),
				'f_item_id' => array('type' => 'int', 'null' => TRUE),
				'f_sku' => array('type' => 'varchar', 'constraint' => '50', 'null' => TRUE),
				'f_name' => array('type' => 'varchar', 'constraint' => '100', 'null' => TRUE),
				'quantity' => array('type' => 'double precision', 'null' => TRUE),
				'price' => array('type' => 'double precision', 'null' => TRUE),
				'discount' => array('type' => 'double precision', 'null' => TRUE),
				'retail_sales' => array('type' => 'double precision', 'null' => TRUE),
				'status' => array('type' => 'int', 'null' => TRUE),
				'weight' => array('type' => 'double precision', 'null' => TRUE),
				'created_at' => array('type' => ($this->db->dbdriver === 'postgre' ? 'timestamp' : 'datetime'), 'null' => TRUE),
				'updated_at' => array('type' => ($this->db->dbdriver === 'postgre' ? 'timestamp' : 'datetime'), 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("invoice_number", true);
		$this->dbforge->add_key("recnum", true);

		$this->dbforge->create_table("sales_items", TRUE);
		if ($this->db->dbdriver === 'mysqli') {
			$this->db->query('ALTER TABLE  `sales_items` ENGINE = InnoDB');
		}
	}

	public function down()
	{
		### Drop table sales_items ##
		$this->dbforge->drop_table("sales_items", TRUE);
	}
}
