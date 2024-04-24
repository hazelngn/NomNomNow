<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterImageToTextColumn extends Migration
{
    public function up()
    {
        $fields = array(
            'item_img' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
        );
        $this->forge->modifyColumn('menu_items', $fields);

        $fields = array(
            'logo' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ]
        );
        $this->forge->modifyColumn('businesses', $fields);
    }

    public function down()
    {
        //
    }
}
