<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', 'AuthController@login');
Route::post('/refresh', 'AuthController@refresh');
Route::get('/user', 'AuthController@user');

Route::middleware(['auth:api'])->group(function () {
    Route::get('refresh-token', 'AuthController@refresh');
    Route::post('/logout', 'AuthController@logout');
    
    Route::post('/home', 'API\DashboardController@index');
    
    Route::get('/absensi/notif', 'API\AbsensiController@getNotif');
    Route::get('/absensi/all-notif', 'API\AbsensiController@getAllNotif');
    Route::post('/absensi/out', 'API\AbsensiController@out');
    Route::post('/absensi/pengajuan', 'API\AbsensiController@storePengajuan');
    Route::resource('/absensi', 'API\AbsensiController');
    Route::resource('/laporan', 'API\LaporanController');
    Route::resource('/documentasi', 'API\DocumentasiController');

    Route::resource('/master/user', 'API\UserController')->only(['index']);
    Route::resource('/master/barang', 'API\BarangController')->only(['index']);
    Route::resource('/master/area', 'API\AreaController')->only(['index']);

});