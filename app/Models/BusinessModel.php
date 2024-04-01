<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table = 'businesses'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'name', 'table_num', 'description', 'logo']; 
    protected $returnType = 'array'; 
    protected $useTimestamps = false;
}
