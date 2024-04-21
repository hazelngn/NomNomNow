<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['business_id', 'name', 'start_date', 'end_date', 'last_edited', 'last_edited_by']; 
    protected $returnType = 'array'; 
    protected $useTimestamps = false;
}
