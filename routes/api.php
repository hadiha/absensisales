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
Route::get('/user', 'AuthController@user');

Route::middleware(['auth:api'])->group(function () {
    Route::get('refresh-token', 'AuthController@refresh');
    Route::post('/logout', 'AuthController@logout');
    
    Route::resource('/absensi', 'API\AbsensiController')->only(['index', 'show', 'store']);
    Route::resource('/laporan', 'API\LaporanController')->only(['index', 'show', 'store']);

    Route::resource('/master/user', 'API\UserController')->only(['index']);
    Route::resource('/master/barang', 'API\BarangController')->only(['index']);

});