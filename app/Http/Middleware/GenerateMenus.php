<?php

namespace App\Http\Middleware;
use App\Models\Master\Auditor;
use App\Models\Audit\DataAudit;

use Closure;
use Menu;

class GenerateMenus
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        Menu::make('mainMenu', function ($menu) {
            $menu->add('Dashboard', 'home')
                 ->data('icon', 'dashboard')
                 ->data('perms', 'dashboard')
                 ->active('home');

            $menu->add('Kehadiran')
                 ->data('icon', 'calendar check outline')
                 ->active('kehadiran/*');
            $menu->kehadiran->add('Monitoring', 'kehadiran/monitoring/')
               //   ->data('perms', 'master-pegawai')
                 ->active('kehadiran/monitoring/*');
            $menu->kehadiran->add('Rekap', 'kehadiran/rekap/')
               // ->data('perms', 'master-area')
               ->active('kehadiran/rekap/*');


            $menu->add('Barang', 'barang')
                 ->data('icon', 'tags')
               //   ->data('perms', 'barang')
                 ->active('barang');

            /* Data Master */
            $menu->add('Data Master')
                 ->data('icon', 'database')
                 ->active('master/*');
          //   $menu->dataMaster->add('Data User Aplikasi', 'master/karyawan/')
          //      //   ->data('perms', 'master-karyawan')
          //        ->active('master/karyawan/*');
            $menu->dataMaster->add('Data Area', 'master/area/')
               // ->data('perms', 'master-area')
               ->active('master/area/*');
            $menu->dataMaster->add('Data Sales Area', 'master/sales-area/')
               // ->data('perms', 'master-area')
               ->active('master/sales-area/*');
            $menu->dataMaster->add('Data Barang', 'master/barang/')
               // ->data('perms', 'master-barang')
               ->active('master/barang/*');       
          

                 
            /* Konfigurasi */
            $menu->add('Konfigurasi')
                 ->data('icon', 'settings')
                 ->active('konfigurasi/*');
            $menu->konfigurasi->add('Manajemen Pengguna', 'konfigurasi/users/')
                 ->data('perms', 'konfigurasi-users')
                 ->active('konfigurasi/users/*');
            $menu->konfigurasi->add('Hak Akses', 'konfigurasi/roles/')
                 ->data('perms', 'konfigurasi-roles')
                 ->active('konfigurasi/roles/*');

            $menu->add('Audit Trail', 'audit')
                 ->data('icon', 'history')
               //   ->data('perms', 'barang')
                 ->active('audit');
        });

        return $next($request);
    }
}
