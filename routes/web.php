<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'konfigurasi', 'namespace' => 'Konfigurasi'], function(){
        Route::post('users/grid', 'UsersController@grid');
        Route::resource('users', 'UsersController');
       
        Route::put('roles/{id}/grant', 'RolesController@grant');
        Route::post('roles/grid', 'RolesController@grid');
        Route::resource('roles', 'RolesController');

        Route::post('profile/foto', 'SettingController@setFoto');
        Route::resource('profile', 'SettingController');
    });
    
    Route::group(['prefix' => 'master', 'namespace' => 'Master'], function(){
        Route::post('area/grid', 'AreaController@grid');
        Route::resource('area', 'AreaController');

        Route::post('sales-area/grid', 'SalesAreaController@grid');
        Route::resource('sales-area', 'SalesAreaController');

        Route::post('barang/grid', 'BarangController@grid');
        Route::resource('barang', 'BarangController');

        Route::post('karyawan/grid', 'KaryawanController@grid');
        Route::resource('karyawan', 'KaryawanController');
	});

    Route::get('kehadiran/monitoring/add/{id}', 'Main\MonitoringController@add');
    Route::get('kehadiran/monitoring/add-store', 'Main\MonitoringController@addStore');
    Route::post('kehadiran/monitoring/grid', 'Main\MonitoringController@grid');
    Route::resource('kehadiran/monitoring', 'Main\MonitoringController');
    
    Route::post('barang/file-upload', 'Main\LaporanController@fileUpload')->name('barang.file-upload');
    Route::post('barang/unlink', 'Main\LaporanController@unlink')->name('barang.unlink');
    Route::post('barang/grid', 'Main\LaporanController@grid');
    Route::resource('barang', 'Main\LaporanController');
    
    Route::post('kehadiran/rekap/grid', 'Main\RekapController@grid');
    Route::resource('kehadiran/rekap', 'Main\RekapController');

    Route::post('home/get-data', 'DashboardController@getData')->name('home.getData');
    Route::get('/home', 'DashboardController@index')->name('home');
    
    
});

// Route::get('/home', 'HomeController@index')->name('home');
