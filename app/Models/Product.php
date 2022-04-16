<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'category_id',
        'brand_id',
        'product_name',
        'product_slug',
        'product_tags',
        'product_keywords',
        'product_desc',
        'product_content',
        'product_price',
        'product_cost',
        'product_views',
        'product_image',
        'product_status',
        'product_quantity',
        'product_sold',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'product_id';

    protected $table = 'tbl_product';

    public function category(){
        return $this->belongsTo('App\Models\CategoryProduct', 'category_id');
    }
}