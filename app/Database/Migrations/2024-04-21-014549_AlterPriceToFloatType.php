<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPriceToFloatType extends Migration
{
    public function up()
    {
        $fields = array(
            'price' => [
                'type' => 'FLOAT',
                'default' => 0.00,
            ],
        );
        $this->forge->modifyColumn('menu_items', $fields);
    }

    public function down()
    {
        //
    }
}
