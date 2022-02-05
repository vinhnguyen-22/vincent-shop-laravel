<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::truncate();
        Roles::create(['role_name' => 'admin']);
        Roles::create(['role_name' => 'author']);
        Roles::create(['role_name' => 'user']);
    }
}