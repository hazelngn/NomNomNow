<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDietaryPrefItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'diet_pr_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ]);

        $this->forge->addKey(['id'], TRUE);
        $this->forge->addForeignKey('diet_pr_id', 'dietary_preferences', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('item_id', 'menu_items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dietary_pref_items');
    }

    public function down()
    {
        $this->forge->dropTable('dietary_pref_items');
    }
}
