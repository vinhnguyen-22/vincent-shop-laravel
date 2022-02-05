<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesUser extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'role_id',
    ];

    protected $primaryKey = 'admin_roles_id';

    protected $table = 'tbl_admin_roles';
}