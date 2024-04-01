<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'TEXT',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'ingredients' => [
                'type' => 'TEXT',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'item_img' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'price' => [
                'type' => 'INT',
                'default' => 0,
            ],
        ]);
            
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_id', 'menus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_items');
    }

    public function down()
    {
        $this->forge->dropTable('menu_items');
    }
}
