<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'password' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'staff', 'owner'],
            ],
            'usertype' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
        $this->forge->dropTable('users');
    }
}
