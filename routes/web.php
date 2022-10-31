<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/products', ProductController::class);
Route::get('/getProductsAjax', [ProductController::class, 'getProductsAjax'])->name('products.ajax');

Route::get('/getDetailsAjax/{product}', [ProductController::class, 'getDetailsAjax'])->name('details.ajax');
Route::get('/getAjaxPriceHistory', [ProductPriceController::class, 'getAjaxPriceHistory'])->name('priceHistory.ajax');
Route::get('/bestDeal', [ProductPriceController::class, 'index'])->name('products.bestDeal');



Route::get('/update_products/23398e43ab2ee0412f775adb8b52988a', [ProductController::class, 'cronJobUpdateProducts']);
