<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'email' => [
                'type' => 'TEXT',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type' => 'CHAR',
                'constraint' => 10,
            ]
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('customers');
    }

    public function down()
    {
        //
        $this->forge->dropTable('customers');
    }
}
