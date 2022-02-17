<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
  
    protected $fillable = [
        'product_id',
        'gallery_name',
        'gallery_image',
    ];

    protected $primaryKey = 'gallery_id';

    protected $table = 'tbl_gallery_product';
}