<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenusTable extends Migration
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
            'business_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'start_date' => [
                'type' => 'DATE',
            ]
            ,
            'end_date' => [
                'type' => 'DATE',
                'null' => TRUE,
            ],
            'last_edited' => [
                'type' => 'DATE',
            ],
            'last_edited_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ]
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('last_edited_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menus');
    }

    public function down()
    {
        $this->forge->dropTable('menus');
    }
}
