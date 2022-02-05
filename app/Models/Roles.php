<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'role_name',
    ];

    protected $primaryKey = 'role_id';

    protected $table = 'tbl_roles';
    
    public function admin(){
        return $this->belongsToMany('App\Admin');
    }
}