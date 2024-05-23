<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItauController;
use Illuminate\Http\Request;

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
    return view('welcome');
});

Route::post('/itau/export/html', [ItauController::class, 'generateBoletoHtml']);
Route::post('/itau/export/pdf', [ItauController::class, 'generateBoletoPdf']);