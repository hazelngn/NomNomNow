<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWeekendHoursToBusinessesTable extends Migration
{
    public function up()
    {
        $fields = [
            'weekend_hours' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'after' => 'weekday_hours' 
            ]
        ];
        $this->forge->addColumn('businesses', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('businesses', 'weekend_hours');
    }
}
