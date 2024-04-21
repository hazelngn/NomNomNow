<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressToBusinessesTable extends Migration
{
    public function up()
    {
        $fields = [
            'address' => [
                'type' => 'TEXT',
                'after' => 'logo' 
            ]
        ];
        $this->forge->addColumn('businesses', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('businesses', 'address');
    }
}
