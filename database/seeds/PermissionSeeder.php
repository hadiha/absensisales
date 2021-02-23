<?php

use Illuminate\Database\Seeder;
use App\Models\Authentication\Role;
use App\Models\Authentication\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_admin = Role::where('name', 'admin')->first();
	    $role_user  = Role::where('name', 'sales')->first();
    	
    	// create permissions
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sys_permission_role')->truncate();
        DB::table('sys_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    	
    	$permissions = [
    		// ------------- DASHBOARD ---------------
    		[
				'name'         => 'dashboard',
				'display_name' => 'Dashboard',
				'action'       => ['view'],
    		],
    		// ------------- MASTER ---------------
    		// [
			// 	'name'         => 'master-pegawai',
			// 	'display_name' => 'Pegawai',
			// 	'action'       => ['view', 'add', 'edit', 'delete'],
			// ],
			[
				'name'         => 'master-area',
				'display_name' => 'Data Area',
				'action'       => ['view', 'add', 'edit', 'delete'],
			],
			[
				'name'         => 'master-sales',
				'display_name' => 'Data Sales Area',
				'action'       => ['view', 'add', 'edit', 'delete'],
			],
			[
				'name'         => 'master-barang',
				'display_name' => 'Data Barang',
				'action'       => ['view', 'add', 'edit', 'delete'],
			],
			[
				'name'         => 'audits',
				'display_name' => 'Audit Trail',
				'action'       => ['view', 'add', 'edit', 'delete'],
			],
			
			// ------------- MAIN ---------------
			[
				'name'         => 'main-monitoring',
				'display_name' => 'Monitoring',
				'action'       => ['view', 'add', 'edit', 'delete'],
			],
			[
				'name'         => 'main-absensi',
				'display_name' => 'Absensi',
				'action'       => ['view'],
			],
			[
				'name'         => 'main-rekap',
				'display_name' => 'Rekap',
				'action'       => ['view'],
			],
			[
				'name'         => 'main-barang',
				'display_name' => 'Laporan Barang',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
			
    		// ------------- Konfigurasi ---------------
    		[
				'name'         => 'konfigurasi-users',
				'display_name' => 'Manajemen Pengguna',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
    		[
				'name'         => 'konfigurasi-roles',
				'display_name' => 'Hak Akses',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
    	];

    	foreach ($permissions as $row) {
			if($row['name'] != 'audits' && $row['name'] != 'konfigurasi-users' && $row['name'] != 'konfigurasi-roles' && $row['name'] != 'main-absensi'){
				foreach ($row['action'] as $key => $val) {
					$tempt = [
						'name'         => $row['name'].'-'.$val,
						'display_name' => $row['display_name'].' '.ucfirst($val)
					];	
					$permss = Permission::firstOrCreate($tempt);
					
					$role_user->attachPermission($permss);
				}
			}
    		
			foreach ($row['action'] as $key => $val) {
    			$temp = [
					'name'         => $row['name'].'-'.$val,
					'display_name' => $row['display_name'].' '.ucfirst($val)
    			];	
    			$perms = Permission::firstOrCreate($temp);

    			$role_admin->attachPermission($perms);
    		}

    	}
    }
}
