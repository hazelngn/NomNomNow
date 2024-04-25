<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'payment_type', 'table_num', 'status', 'total', 'order_at']; 
    protected $returnType = 'array'; 
    protected $useTimestamps = false;
}
