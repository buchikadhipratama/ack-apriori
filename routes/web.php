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

// Route::get('/home', function () {
//     return view('dashboard.home')->name('home');
// });

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/produk', [App\Http\Controllers\ProductController::class, 'product'])->name('/produk');
Route::get('/transaksi', [App\Http\Controllers\ProductController::class, 'transaction'])->name('/transaksi');
Route::get('/kasir', [App\Http\Controllers\SaleController::class, 'index'])->name('/kasir');
