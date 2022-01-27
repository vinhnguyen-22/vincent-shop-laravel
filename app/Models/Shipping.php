<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_email',
        'shipping_name',
        'shipping_address',
        'shipping_phone',
        'shipping_notes',
        'shipping_method',
    ];

    protected $primaryKey = 'shipping_id';

    protected $table = 'tbl_shipping';
}