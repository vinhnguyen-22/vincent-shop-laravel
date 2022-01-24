<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'province_name',
        'province_type'
    ];

    protected $primaryKey = 'matp';

    protected $table = 'tbl_province';
}