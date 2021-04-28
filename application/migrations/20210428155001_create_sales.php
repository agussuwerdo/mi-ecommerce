<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_sales extends CI_Migration
{

	public function up()
	{

		## Create Table sales
		$this->dbforge->add_field(
			array(
				'invoice_number' => array('type' => 'varchar', 'constraint' => '15', 'key' => TRUE),
				'f_customer_id' => array('type' => 'int'),
				'sales_date' => array('type' => 'date', 'null' => TRUE, 'comment' => 'tanggal transaksi'),
				'product_count' => array('type' => 'int', 'null' => TRUE, 'comment' => 'jumlah product'),
				'quantity_total' => array('type' => 'double', 'null' => TRUE, 'comment' => 'total quantity'),
				'price_total' => array('type' => 'double', 'null' => TRUE),
				'discount_total' => array('type' => 'double', 'null' => TRUE),
				'shipping_cost' => array('type' => 'double', 'null' => TRUE),
				'weight_total' => array('type' => 'double', 'null' => TRUE),
				'retail_sales_total' => array('type' => 'double', 'null' => TRUE),
				'customer_address_name' => array('type' => 'varchar', 'constraint' => '30', 'null' => TRUE),
				'customer_address' => array('type' => 'varchar', 'constraint' => '100', 'null' => TRUE),
				'status' => array('type' => 'int', 'null' => TRUE, 'comment' => '0 = created, 1 = confirmed'),
				'created_at' => array('type' => 'datetime', 'null' => TRUE),
				'updated_at' => array('type' => 'datetime', 'null' => TRUE)
			)
		);
		$this->dbforge->add_key("invoice_number", true);

		$this->dbforge->create_table("sales", TRUE);
		$this->db->query('ALTER TABLE  `sales` ENGINE = InnoDB');
	}

	public function down()
	{
		### Drop table sales ##
		$this->dbforge->drop_table("sales", TRUE);
	}
}
