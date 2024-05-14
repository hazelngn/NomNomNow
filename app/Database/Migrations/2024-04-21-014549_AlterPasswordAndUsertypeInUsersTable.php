<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPasswordAndUsertypeInUsersTable extends Migration
{
    public function up()
    {
        $fields = array(
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'usertype' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'staff', 'owner'],
            ],
        );
        $this->forge->modifyColumn('users', $fields);
    }

    public function down()
    {
        //
    }
}
