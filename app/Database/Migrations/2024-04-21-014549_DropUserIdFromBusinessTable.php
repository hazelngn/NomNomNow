<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUserIdFromBusinessTable extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('businesses', 'businesses_user_id_foreign');
        $this->forge->dropColumn('businesses', 'user_id');
    }

    public function down()
    {
        //
    }
}
