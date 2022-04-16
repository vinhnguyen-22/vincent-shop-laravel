<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'ip_address','date_visit'
    ];
    protected $primaryKey = "visitor_id";
    protected $table = 'tbl_visitor';
}