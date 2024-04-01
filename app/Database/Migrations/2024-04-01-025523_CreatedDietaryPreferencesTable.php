<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDietaryPreferencesTable extends Migration
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
                'constraint' => 100,
                'unique' => TRUE,
            ]
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('dietary_preferences');

    }

    public function down()
    {
        //
        $this->forge->dropTable('dietary_preferences');
    }
}
