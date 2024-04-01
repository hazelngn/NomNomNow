<?php

namespace App\Models;

use CodeIgniter\Model;

class DietaryPreferencesModel extends Model
{
    protected $table = 'dietary_preferences'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['name']; 
    protected $returnType = 'array'; 
}
