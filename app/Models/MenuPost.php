<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPost extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'menu_post_name',
        'menu_post_slug',
        'menu_post_desc',
        'menu_post_status',
    ];

    protected $primaryKey = 'menu_post_id';

    protected $table = 'tbl_menu_post';
}