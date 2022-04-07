<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'category_name',
        'category_slug',
        'category_keywords',
        'category_desc',
        'category_status',
        'category_parentId',
        'category_order',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'category_id';

    protected $table = 'tbl_category_product';
}