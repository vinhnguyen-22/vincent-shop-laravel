<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_keywords',
        'brand_desc',
        'brand_status',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'brand_id';

    protected $table = 'tbl_brand';

    // public function product(){
    //     return $this->belongsTo('App\Product','brand_id');
    // }
}