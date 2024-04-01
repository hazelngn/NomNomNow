<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessesTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'table_num' => [
                'type' => 'INT',
                'unsigned' => TRUE,
            ], 
            'description' => [
                'type' => 'TEXT',
            ],
            'logo' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ]
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('businesses');
    }

    public function down()
    {
        $this->forge->dropTable('businesses');
    }
}
