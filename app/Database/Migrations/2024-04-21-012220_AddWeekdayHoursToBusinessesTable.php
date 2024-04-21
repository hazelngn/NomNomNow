<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWeekdayHoursToBusinessesTable extends Migration
{
    public function up()
    {
        $fields = [
            'weekday_hours' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'after' => 'address' 
            ]
        ];
        $this->forge->addColumn('businesses', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('businesses', 'weekday_hours');
    }
}
