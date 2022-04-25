<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_time',
        'coupon_rate',
        'coupon_method',
        'coupon_condition',
        'coupon_expired',
        'coupon_start',
        'coupon_status',
        'coupon_used'
    ];

    protected $primaryKey = 'coupon_id';

    protected $table = 'tbl_coupon';
}