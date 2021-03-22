<?php

use Illuminate\Database\Seeder;
use App\Models\Authentication\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_employee = new Role();
	    $role_employee->name = 'admin';
	    $role_employee->display_name = 'Administrator';
	    $role_employee->description = 'Administrator';
	    $role_employee->save();

	    $role_employee = new Role();
	    $role_employee->name = 'sales';
	    $role_employee->display_name = 'Sales';
	    $role_employee->description = 'Sales';
	    $role_employee->save();

		$role_employee = new Role();
	    $role_employee->name = 'TL';
	    $role_employee->display_name = 'Team Leader';
	    $role_employee->description = 'Team Leader';
	    $role_employee->save();

    }
}
