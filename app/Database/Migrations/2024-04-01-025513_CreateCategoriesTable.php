<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'iconUrl' => [
                'type' => 'TEXT',
            ]
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('categories');

    }

    public function down()
    {
        //
        $this->forge->dropTable('categories');
    }
}
