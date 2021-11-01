<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
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

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('product/{product_id}/available-packages', [DashboardController::class, 'availablePackages'])->name('product.available_pakcages');
Route::get('shop-details/{shop_id}', [DashboardController::class, 'shopAllProductPackages'])->name('shop.details');
Route::post('shop/package', [DashboardController::class, 'store'])->name('shop.package.store');


//imports and exports
Route::get('export/products-sample', [ExportController::class, 'productsSample'])->name('export.product_sample');
Route::get('export/shop-details/{shop_id}', [ExportController::class, 'shopDetails'])->name('export.shop_details');
Route::get('export/shop-details', [ExportController::class, 'allShopDetails'])->name('export.shop_details.all');
