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
        'fee_shippingfee',
    ];

    protected $primaryKey = 'fee_id';

    protected $table = 'tbl_shippingfee';
    
    public function province(){
        return $this->belongsTo('App\Models\Province','fee_matp');
    }
    
    public function district(){
        return $this->belongsTo('App\Models\District','fee_maqh');
    }
    
    public function ward(){
        return $this->belongsTo('App\Models\Ward','fee_xaid');
    }
}