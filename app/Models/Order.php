<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'shipping_id',
        'order_total',
        'order_status',
        'order_code',
        'created_at'
    ];

    protected $primaryKey = 'order_id';

    protected $table = 'tbl_order';
}