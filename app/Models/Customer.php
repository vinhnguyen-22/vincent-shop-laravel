<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
      public $timestamp = false;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_password',
        'customer_phone',
        'customer_vip',
    ];

    protected $primaryKey = 'customer_id';

    protected $table = 'tbl_customers';
}