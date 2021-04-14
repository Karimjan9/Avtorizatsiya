<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/newuser', [App\Http\Controllers\RegisterController::class, 'saveuser'])->name('saveuser')->middleware(['admin','premium']);
Route::get('/u',[App\Http\Controllers\RegisterController::class, 'users'])->name('user')->middleware(['admin']);;
Route::get('/edituser/{id}',[App\Http\Controllers\RegisterController::class, 'edituser'])->middleware(['admin']);;
Route::post('/changeuser/{id}',[App\Http\Controllers\RegisterController::class, 'changeuser'])->middleware(['admin']);;
