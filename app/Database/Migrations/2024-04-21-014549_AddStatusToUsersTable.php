<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'BOOL',
                'after' => 'phone' 
            ]
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('users', 'status');
    }
}
