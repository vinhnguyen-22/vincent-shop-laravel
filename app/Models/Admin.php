<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable 
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = [
        'admin_email',
        'admin_password',
        'admin_name',
        'admin_phone'
    ];
    protected $primaryKey ='admin_id';
    protected $table = 'tbl_admin';

    public function roles(){
        return $this->belongsToMany('App\Roles');
    }

    // public function hasAnyRoles ($roles){
    //     if(is_array($roles)){
    //         foreach($roles as $role)
    //     }
    // }

    public function getAuthPassword(){
        return $this->admin_password;
    }
}