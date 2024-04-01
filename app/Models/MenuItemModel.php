<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table = 'menu_items'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'menu_id', 'name', 'description', 'ingredients', 'notes', 'item_img', 'price']; 
    protected $returnType = 'array'; 
    protected $useTimestamps = false;
}
