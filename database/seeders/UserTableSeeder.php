<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('role_name','admin')->first();
        $authorRoles = Roles::where('role_name','author')->first();
        $userRoles = Roles::where('role_name','user')->first();
    
        $admin = Admin::create([
            'admin_name' => 'vincent',
            'admin_email' => 'vincent@gmail.com',
            'admin_phone' => '0999999998',
            'admin_password' => md5('123456'),
        ]);

        $author = Admin::create([
            'admin_name' => 'vinh',
            'admin_email' => 'vinh@gmail.com',
            'admin_phone' => '0998999998',
            'admin_password' => md5('123456'),
        ]);

        $user = Admin::create([
            'admin_name' => 'vinDev',
            'admin_email' => 'vinh.dev@gmail.com',
            'admin_phone' => '0999199998',
            'admin_password' => md5('123456'),
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        Admin::factory()->count(5)->create();
    }
}