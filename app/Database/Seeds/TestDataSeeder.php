<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $categories_sample = [
            'Entrees' => 'images/menu/entrees.png',
            'Sides' => 'images/menu/sides.png',
            'Main Dishes' => 'images/menu/maindish.png',
            'Desserts' => 'images/menu/dessert.png',
            'Alcoholic Beverages' => 'images/menu/alcoholicBV.png',
            'Coffee & Tea' => 'images/menu/coffee&tea.png',
            'Soft Drinks' => 'images/menu/softdrink.png',
            
        ];

        $categories = [];
        $cate_ids = [];

        foreach ($categories_sample as $name => $url) {
            $categories[] = [
                'name' => $name,
                'iconUrl' => $url
            ];
        }

        $dietary_prefs = [
            [
                'name' => 'Dairy Free'
            ],
            [
                'name' => 'Gluten Free'
            ],
            [
                'name' => 'Vegan'
            ],
            [
                'name' => 'Vegetarian'
            ],
            [
                'name' => 'Nut Free'
            ],

        ];

        $user = [
            'username' => 'hazel',
            'password' => 'thisistest',
            'usertype' => 'owner',
            'email' => 'hazeltest@gmail.com',
            'name' => 'hazel',
            'phone' => '0123456789'
        ];

        $this->db->table('categories')->insertBatch($categories);
        $this->db->table('dietary_preferences')->insertBatch($dietary_prefs);
        $this->db->table('users')->insert($user);
        $id = $this->db->insertID();
        $business = [
            'user_id' => $id,
            'name' => 'hazel zone',
            'table_num' => 20,
            'description' => 'A traditional coffee shop.',
        ];
        $this->db->table('businesses')->insert($business);
    }
}
