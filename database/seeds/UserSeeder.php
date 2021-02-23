<?php

use Illuminate\Database\Seeder;

use App\Models\Authentication\User;
use App\Models\Authentication\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
    	$role_admin = Role::where('name', 'admin')->first();
	    $role_sales  = Role::where('name', 'sales')->first();
    	// create user
    	$user = new User();
		$user->username   = 'admin';
		$user->name   = 'Admin';
		$user->password   = bcrypt('password');
		$user->email   = 'admin@gmail.com';
		$user->last_login = date('Y-m-d H:i:s');
    	$user->save();
    	$user->roles()->attach($role_admin);
    	// $user->roles()->attach($role_sales);

		$user = new User();
		$user->username   = 'sales';
		$user->name   = 'Sales';
		$user->password   = bcrypt('password');
		$user->email   = 'sales@gmail.com';
		$user->last_login = date('Y-m-d H:i:s');
    	$user->save();
    	$user->roles()->attach($role_sales);
    }
}

