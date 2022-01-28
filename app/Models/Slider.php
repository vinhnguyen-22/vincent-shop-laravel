<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'slider_name',
        'slider_slug',
        'slider_image',
        'slider_desc',
        'slider_status',
    ];

    protected $primaryKey = 'slider_id';

    protected $table = 'tbl_slider';
}