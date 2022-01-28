<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;

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
////////////////////////////
//FRONTEND
///////////////////////////

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::post('/s', [HomeController::class, 'search']);

// route category product
Route::get('/category-product/{cat_slug}', [CategoryProductController::class, 'showCategoryPage']);
// route brand product
Route::get('/brand-product/{brand_slug}', [BrandController::class, 'showBrandPage']);
// product page
Route::get('/product-detail/{product_slug}', [ProductController::class, 'showProductDetailPage']);

// Cart
// Route::post('/save-cart', [CartController::class, 'saveCart']);
// Route::get('/show-cart', [CartController::class, 'showCart']);
// Route::get('/delete-to-cart/{rowId}', [CartController::class, 'deleteToCart']);
// Route::post('/update-cart-qty', [CartController::class, 'updateQtyCart']);

//Checkout
Route::get('/login-checkout', [CheckoutController::class, 'loginCheckout']);
Route::post('/customer-signup', [CheckoutController::class, 'customerRegister']);
Route::post('/customer-login', [CheckoutController::class, 'login']);
Route::get('/customer-logout', [CheckoutController::class, 'logout']);

Route::get('/checkout', [CheckoutController::class, 'checkoutPage']);
Route::post('/order-place', [CheckoutController::class, 'orderPlace']);

Route::post('/confirm-order', [CheckoutController::class, 'confirmOrder']);

//CART WITH AJAX
Route::post('/add-cart-ajax', [CartController::class, 'addCartAjax']);
Route::get('/show-cart-page', [CartController::class, 'showCartAjax']);
Route::post('/update-cart', [CartController::class, 'updateCart']);
Route::get('/delete-item/{session_id}', [CartController::class, 'deleteItem']);
Route::get('/delete-all-item', [CartController::class, 'deleteAllItem']);

//coupon
Route::post('/check-coupon', [CartController::class, 'checkCoupon']);
Route::get('/delete-all-coupon', [CartController::class, 'deleteAllCoupon']);

// Delivery
Route::post('/select-delivery-fe', [DeliveryController::class,'selectDeliveryFE']);
Route::post('/calculate-fee', [DeliveryController::class,'calculateFee']);
Route::get('/delete-fee', [DeliveryController::class,'deleteFee']);


////////////////////////////
//FRONTEND
///////////////////////////



/////////////////////////
//BACKEND
/////////////////////////
//admin
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
Route::get('/view-order/{order_code}', [OrderController::class, 'viewOrderDetails']);
Route::get('/manage-order', [OrderController::class, 'manageOrder']);
Route::get('/print-order/{order_code}', [OrderController::class, 'printOrder']);

//Sendmail
Route::get('/send-mail', [MailController::class, 'sendMail']);

//coupon
Route::get('/insert-coupon', [CouponController::class, 'insertCouponPage']);
Route::post('/save-coupon', [CouponController::class, 'saveCoupon']);
Route::get('/all-coupon', [CouponController::class, 'showAllCoupon']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'deleteCoupon']);

//Delivery
Route::get('/delivery', [DeliveryController::class,'insertDeliveryPage']);
Route::post('/select-delivery', [DeliveryController::class,'selectDelivery']);
Route::post('/save-delivery', [DeliveryController::class,'saveDelivery']);
Route::get('/select-feeship', [DeliveryController::class,'selectFeeShip']);// load feeship
Route::post('/update-feeship', [DeliveryController::class,'updateFeeShip']);


//slider
Route::get('/manage-slider', [SliderController::class,'manageSliderPage']);
Route::get('/insert-slider', [SliderController::class,'insertSliderPage']);
Route::post('/save-slider', [SliderController::class,'createSlider']);

Route::get('/inactive-slider/{slider_id}', [SliderController::class, 'activeSlider']);
Route::get('/active-slider/{slider_id}', [SliderController::class, 'inactiveSlider']);

Route::get('/edit-slider/{slider_id}', [SliderController::class, 'editSlider']);
Route::post('/update-slider/{slider_id}', [SliderController::class, 'updateSlider']);
Route::get('/delete-slider/{slider_id}', [SliderController::class, 'deleteSlider']);

/////////////////////////
//BACKEND
/////////////////////////


/////////////////////////
//LOGIN WITH SOCIAL MEDIA
/////////////////////////
Route::get('/login-facebook', [AdminController::class, 'loginFacebook']);
Route::get('/admin/callback', [AdminController::class, 'callbackFacebook']);

Route::get('/login-google', [AdminController::class, 'loginGoogle']);
Route::get('/google/callback', [AdminController::class, 'callbackGoogle']);
/////////////////////////
//LOGIN WITH SOCIAL MEDIA
/////////////////////////