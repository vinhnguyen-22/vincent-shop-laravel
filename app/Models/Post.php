<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_post_id',
        'post_title',
        'post_slug',
        'post_keywords',
        'post_desc',
        'post_content',
        'post_status',
        'post_thumbnail',
        'post_author',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'post_id';

    protected $table = 'tbl_post';

     public function menuPost(){
        return $this->belongsTo(MenuPost::class);
    }
}