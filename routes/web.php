<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\FundController::class, 'index'])->name('welcome')->middleware('guest');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home/favorites', [App\Http\Controllers\HomeController::class, 'favorites'])->name('favorites')->middleware('auth');
Route::post('/home/favorites/{id}', [App\Http\Controllers\HomeController::class, 'addToFavorites'])->name('addToFavorites')->middleware('auth');
Route::delete('/home/remove/{id}', [App\Http\Controllers\HomeController::class, 'remove'])->name('remove')->middleware('auth');
Route::get('/home/downloadPdf/{id}', [App\Http\Controllers\HomeController::class, 'downloadPdf'])->name('downloadPdf')->middleware('auth');
Route::get('/home/downloadXlsx/{id}', [App\Http\Controllers\HomeController::class, 'downloadXlsx'])->name('downloadXlsx')->middleware('auth');
Route::get('/home/downloadXml/{id}', [App\Http\Controllers\HomeController::class, 'downloadXml'])->name('downloadXml')->middleware('auth');

