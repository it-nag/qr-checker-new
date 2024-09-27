<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;

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
    return view('production-qr');
});

Route::controller(ScanController::class)->prefix("scan")->group(function () {
    Route::get('/', 'index')->name('scan');
    Route::get('/scan-item', 'scanItem')->name('scan-item');
    Route::get('/getdataqr', 'getdataqr')->name('getdataqr');
    Route::get('/getdataqr_sb', 'getdataqr_sb')->name('getdataqr_sb');
    Route::get('/getdataqr_gambar', 'getdataqr_gambar')->name('getdataqr_gambar');
});
