<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_time',
        'coupon_rate',
        'coupon_method',
        'coupon_condition',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'coupon_id';

    protected $table = 'tbl_coupon';
}