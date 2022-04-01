<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'rating_id', 'product_id', 'rating_num'
    ];
     
    protected $primaryKey = 'rating_id';
    protected $table = 'tbl_rating';
}