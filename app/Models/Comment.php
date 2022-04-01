<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'comment_content',
        'comment_name',
        'comment_date',
        'comment_approval',
        'comment_parent',
        'comment_product_id',
    ];

    protected $primaryKey = 'comment_id';

    protected $table = 'tbl_comment';

     public function product(){
        return $this->belongsTo('App\Models\Product','comment_product_id');
    }
}