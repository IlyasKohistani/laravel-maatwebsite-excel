<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('product/{product_id}/available-packages', [DashboardController::class, 'availablePackages'])->name('product.available_pakcages');
Route::get('shop-details/{shop_id}', [DashboardController::class, 'shopAllProductPackages'])->name('shop.details');
Route::post('shop/package', [DashboardController::class, 'store'])->name('shop.package.store');


//exports
Route::get('export', [ExportController::class, 'export'])->name('export.all');
Route::get('export/shop-details/{shop_id}', [ExportController::class, 'shopDetails'])->name('export.shop_details');

//imports
Route::get('import', [ImportController::class, 'index'])->name('import.index');
Route::post('import', [ImportController::class, 'import'])->name('import.upload');