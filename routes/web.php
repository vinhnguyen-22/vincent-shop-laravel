<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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
Route::post('/s', [HomeController::class, 'search']);

// route category product
Route::get('/category-product/{cat_id}', [CategoryProductController::class, 'showCategoryPage']);
// route brand product
Route::get('/brand-product/{cat_id}', [BrandController::class, 'showBrandPage']);
// product page
Route::get('/product-detail/{product_id}', [ProductController::class, 'showProductDetailPage']);

// Cart
Route::post('/save-cart', [CartController::class, 'saveCart']);
Route::get('/show-cart', [CartController::class, 'showCart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'deleteToCart']);
Route::post('/update-cart-qty', [CartController::class, 'updateQtyCart']);

//Checkout
Route::get('/login-checkout', [CheckoutController::class, 'loginCheckout']);
Route::post('/customer-signup', [CheckoutController::class, 'customerSignup']);
Route::post('/customer-login', [CheckoutController::class, 'login']);
Route::get('/customer-logout', [CheckoutController::class, 'logout']);

Route::get('/checkout', [CheckoutController::class, 'checkoutPage']);
Route::get('/payment', [CheckoutController::class, 'paymentPage']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'saveCheckoutCustomer']);
Route::post('/order-place', [CheckoutController::class, 'orderPlace']);




//Backend

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'showDashboard']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);

//category product
Route::get('/all-category-product', [CategoryProductController::class, 'showAllCategory']);
Route::get('/add-category-product', [CategoryProductController::class, 'addPageCategory']);
Route::get('/edit-category-product/{cat_id}', [CategoryProductController::class, 'editCategory']);
Route::get('/delete-category-product/{cat_id}', [CategoryProductController::class, 'deleteCategory']);

Route::post('/save-category-product', [CategoryProductController::class, 'createCategory']);
Route::post('/update-category-product/{cat_id}', [CategoryProductController::class, 'updateCategory']);

Route::get('/inactive-category-product/{cat_id}', [CategoryProductController::class, 'activeCategory']);
Route::get('/active-category-product/{cat_id}', [CategoryProductController::class, 'inactiveCategory']);

//brand product
Route::get('/all-brand-product', [BrandController::class, 'showAllBrand']);
Route::get('/add-brand-product', [BrandController::class, 'addPageBrand']);
Route::get('/edit-brand-product/{brand_id}', [BrandController::class, 'editBrand']);
Route::get('/delete-brand-product/{brand_id}', [BrandController::class, 'deleteBrand']);

Route::post('/save-brand-product', [BrandController::class, 'createBrand']);
Route::post('/update-brand-product/{brand_id}', [BrandController::class, 'updateBrand']);

Route::get('/inactive-brand-product/{brand_id}', [BrandController::class, 'activeBrand']);
Route::get('/active-brand-product/{brand_id}', [BrandController::class, 'inactiveBrand']);

//product
Route::get('/all-product', [ProductController::class, 'showAllProduct']);
Route::get('/add-product', [ProductController::class, 'addPageProduct']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'editProduct']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'deleteProduct']);

Route::post('/save-product', [ProductController::class, 'createProduct']);
Route::post('/update-product/{product_id}', [ProductController::class, 'updateProduct']);

Route::get('/inactive-product/{product_id}', [ProductController::class, 'activeProduct']);
Route::get('/active-product/{product_id}', [ProductController::class, 'inactiveProduct']);

//order
Route::get('/manage-order', [CheckoutController::class, 'manageOrder']);
Route::get('/view-order/{order_id}', [CheckoutController::class, 'viewOrder']);