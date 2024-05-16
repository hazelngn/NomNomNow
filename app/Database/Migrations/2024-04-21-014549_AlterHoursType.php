<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterHoursType extends Migration
{
    public function up()
    {
        $fields = [
            'weekday_hours' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'address' 
            ],
            'weekend_hours' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'weekday_hours' 
            ]
        ];

        $this->forge->modifyColumn('businesses', $fields);
    }

    public function down()
    {
        //
    }
}
