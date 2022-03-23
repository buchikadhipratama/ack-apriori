<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/produk', [ProductController::class, 'product'])->name('/produk');
Route::get('/produk/hapus/{id}', [ProductController::class, 'delete']);
Route::get('/product/detail/{id}', [ProductController::class, 'edit']);
Route::post('product/edit', [ProductController::class, 'editProduct']);

Route::get('/transaksi', [ProductController::class, 'transaction'])->name('/transaksi');
Route::get('/kasir', [SaleController::class, 'index'])->name('/kasir');
