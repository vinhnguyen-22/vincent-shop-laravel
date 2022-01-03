<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;



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
//Frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

//Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'showDashboard']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);

//category product
Route::get('/all-category-product', [CategoryProduct::class, 'showAllCategory']);
Route::get('/add-category-product', [CategoryProduct::class, 'addPageCategory']);
Route::get('/edit-category-product/{cat_id}', [CategoryProduct::class, 'editCategory']);
Route::get('/delete-category-product/{cat_id}', [CategoryProduct::class, 'deleteCategory']);

Route::post('/save-category-product', [CategoryProduct::class, 'createCategory']);
Route::post('/update-category-product/{cat_id}', [CategoryProduct::class, 'updateCategory']);

Route::get('/inactive-category-product/{cat_id}', [CategoryProduct::class, 'activeCategory']);
Route::get('/active-category-product/{cat_id}', [CategoryProduct::class, 'inactiveCategory']);

//brand product
Route::get('/all-brand-product', [BrandProduct::class, 'showAllBrand']);
Route::get('/add-brand-product', [BrandProduct::class, 'addPageBrand']);
Route::get('/edit-brand-product/{brand_id}', [BrandProduct::class, 'editBrand']);
Route::get('/delete-brand-product/{brand_id}', [BrandProduct::class, 'deleteBrand']);

Route::post('/save-brand-product', [BrandProduct::class, 'createBrand']);
Route::post('/update-brand-product/{brand_id}', [BrandProduct::class, 'updateBrand']);

Route::get('/inactive-brand-product/{brand_id}', [BrandProduct::class, 'activeBrand']);
Route::get('/active-brand-product/{brand_id}', [BrandProduct::class, 'inactiveBrand']);

//product
Route::get('/all-product', [ProductController::class, 'showAllProduct']);
Route::get('/add-product', [ProductController::class, 'addPageProduct']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'editProduct']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'deleteProduct']);

Route::post('/save-product', [ProductController::class, 'createProduct']);
Route::post('/update-product/{product_id}', [ProductController::class, 'updateProduct']);

Route::get('/inactive-product/{product_id}', [ProductController::class, 'activeProduct']);
Route::get('/active-product/{product_id}', [ProductController::class, 'inactiveProduct']);