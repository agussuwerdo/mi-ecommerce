<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_sessions_table extends CI_Migration {

    public function up()
    {
        // Define the ci_sessions table structure
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => FALSE
            ),
            'timestamp' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => FALSE,
                'default' => 0
            ),
            'data' => array(
                'type' => 'BLOB',
                'null' => FALSE
            )
        ));

        // Add primary key on id
        $this->dbforge->add_key('id', TRUE);
        
        // Add index on timestamp to improve query performance
        $this->dbforge->add_key('timestamp');

        // Create the ci_sessions table
        $this->dbforge->create_table('ci_sessions', TRUE);

        // Set the storage engine to InnoDB for performance
        $this->db->query('ALTER TABLE `ci_sessions` ENGINE = InnoDB');
    }

    public function down()
    {
        // Drop the ci_sessions table if it exists
        $this->dbforge->drop_table('ci_sessions', TRUE);
    }
}
