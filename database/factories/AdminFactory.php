<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'admin_name' => $this->faker->name(),
            'admin_email' => $this->faker->unique()->safeEmail(),
            'admin_phone' => '0123456789',
            'admin_password' => 'e10adc3949ba59abbe56e057f20f883e', // password
        ];
    }
    
    public function configure(){
        return $this->afterMaking(function (Admin $admin) {
            //
        })->afterCreating(function (Admin $admin) {
            $roles = Roles::where('role_name','user')->get();
            $admin->roles()->sync($roles->pluck('role_id')->toArray());
        });
    }
}