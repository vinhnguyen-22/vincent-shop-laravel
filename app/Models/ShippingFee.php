<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    use HasFactory;
    public $timestamp = false;
    
    protected $fillable = [
        'fee_matp',
        'fee_maqh',
        'fee_xaid',
        'fee_shippongfee',
    ];

    protected $primaryKey = 'fee_id';

    protected $table = 'tbl_shippingfee';

}