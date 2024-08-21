<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    OrderController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dat-ve', function () {
    return view('dat-ve');
});

Route::get('/cho-thanh-toan', function () {
    return view('cho-thanh-toan');
});
