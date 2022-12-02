<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductAnaliseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\WebScrapperController;
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

Route::resource('/products', ProductController::class)->only(['index', 'show']);

Route::group(['prefix'=>'getProductsAjax', 'as'=>'products.ajax.'], function(){
    Route::get('/', [ProductController::class, 'getProductsAjax'])->name('all');
    Route::get('/{product}', [ProductController::class, 'getProductAjax'])->name('one');
    
});

Route::group(['prefix'=>'discount', 'as'=>'discount.'], function(){
    Route::get('/', [ProductAnaliseController::class, 'index'])->name('index');
    Route::get('/bestDeal', [ProductAnaliseController::class, 'bestDealProductsAjax'])->name('biggest');
});

Route::get('/update_products/23398e43ab2ee0412f775adb8b52988a', [WebScrapperController::class, 'index']);
