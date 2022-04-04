<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'info_contact',
        'info_map',
        'info_img',
        'info_fanpage',
    ];

    protected $primaryKey = 'info_id';

    protected $table = 'tbl_information';
}