<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

route::group([
    'prefix' => 'api/product'
],function(){
    Route::get('/', [ProductController::class, 'index'])->name('Product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('Product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('Product.store');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('Product.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('Product.update');
    Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('Product.delete');
});

route::group([
    'prefix' => 'api/category'
],function(){
    Route::get('/', [CategoryController::class, 'index'])->name('Category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('Category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('Category.store');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('Category.edit');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->name('Category.update');
    Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('Category.delete');
});

route::group([
    'prefix' => 'api/brand'
],function(){
    Route::get('/', [BrandController::class, 'index'])->name('Brand.index');
    Route::get('/create', [BrandController::class, 'create'])->name('Brand.create');
    Route::post('/store', [BrandController::class, 'store'])->name('Brand.store');
    Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('Brand.edit');
    Route::put('/update/{brand}', [BrandController::class, 'update'])->name('Brand.update');
    Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('Brand.delete');
});

