<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $fillable = [
        'ward_name',
        'ward_type',
        'maqh'
    ];

    protected $primaryKey = 'xaid';

    protected $table = 'tbl_ward';
}