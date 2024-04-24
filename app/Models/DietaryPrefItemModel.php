<?php

namespace App\Models;

use CodeIgniter\Model;

class DietaryPrefItemModel extends Model
{
    protected $table = 'dietary_pref_items'; 
    protected $allowedFields = ['diet_pr_id', 'item_id']; 
    protected $returnType = 'array'; 
}
