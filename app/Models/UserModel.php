<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'usertype', 'email', 'name', 'phone', 'business_id']; 
    protected $returnType = 'array'; 
    protected $useTimestamps = false;
}
