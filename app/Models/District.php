<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'district_name',
        'district_type',
        'matp'
    ];

    protected $primaryKey = 'maqh';

    protected $table = 'tbl_district';
}