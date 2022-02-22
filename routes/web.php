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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryProductController;
use App\Http\Controllers\MenuPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;

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

// Post
Route::get('/menu-post/{menu_post_slug}', [MenuPostController::class,'showMenuPostPage']);
Route::get('/post-detail/{post_slug}', [PostController::class,'showPostPage']);

// video
Route::get('/video-page', [VideoController::class,'showVideoPage']);
Route::post('/delete-video', [VideoController::class,'deleteVideo']);
Route::post('/show-modal-view-video', [VideoController::class,'showModalViewVideo']);

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
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/add-category-product', [CategoryProductController::class, 'addPageCategory']);
    Route::get('/edit-category-product/{cat_id}', [CategoryProductController::class, 'editCategory']);
    Route::get('/delete-category-product/{cat_id}', [CategoryProductController::class, 'deleteCategory']);

    Route::post('/save-category-product', [CategoryProductController::class, 'createCategory']);
    Route::post('/update-category-product/{cat_id}', [CategoryProductController::class, 'updateCategory']);

    Route::get('/inactive-category-product/{cat_id}', [CategoryProductController::class, 'activeCategory']);
    Route::get('/active-category-product/{cat_id}', [CategoryProductController::class, 'inactiveCategory']);
});

//brand product
Route::get('/all-brand-product', [BrandController::class, 'showAllBrand']);
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/add-brand-product', [BrandController::class, 'addPageBrand']);
    Route::get('/edit-brand-product/{brand_id}', [BrandController::class, 'editBrand']);
    Route::get('/delete-brand-product/{brand_id}', [BrandController::class, 'deleteBrand']);

    Route::post('/save-brand-product', [BrandController::class, 'createBrand']);
    Route::post('/update-brand-product/{brand_id}', [BrandController::class, 'updateBrand']);

    Route::get('/inactive-brand-product/{brand_id}', [BrandController::class, 'activeBrand']);
    Route::get('/active-brand-product/{brand_id}', [BrandController::class, 'inactiveBrand']);
});

//product
Route::get('/all-product', [ProductController::class, 'showAllProduct']);      
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/add-product', [ProductController::class, 'addPageProduct']);
    Route::get('/edit-product/{product_id}', [ProductController::class, 'editProduct']);
    Route::get('/delete-product/{product_id}', [ProductController::class, 'deleteProduct']);

    Route::post('/save-product', [ProductController::class, 'createProduct']);
    Route::post('/update-product/{product_id}', [ProductController::class, 'updateProduct']);

    Route::get('/inactive-product/{product_id}', [ProductController::class, 'activeProduct']);
    Route::get('/active-product/{product_id}', [ProductController::class, 'inactiveProduct']);    
});

//order
Route::get('/view-order/{order_code}', [OrderController::class, 'viewOrderDetails']);
Route::get('/manage-order', [OrderController::class, 'manageOrder']);
Route::get('/print-order/{order_code}', [OrderController::class, 'printOrder']);
Route::middleware(['auth.roles'])->group(function () {
    Route::post('/update-order-qty', [OrderController::class, 'updateOrderQty']);
    Route::post('/update-qty', [OrderController::class, 'updateQty']);
});

//Sendmail
Route::get('/send-mail', [MailController::class, 'sendMail']);

//coupon
Route::get('/all-coupon', [CouponController::class, 'showAllCoupon']);
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/insert-coupon', [CouponController::class, 'insertCouponPage']);
    Route::post('/save-coupon', [CouponController::class, 'saveCoupon']);
    Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'deleteCoupon']);
});

//Delivery
Route::get('/delivery', [DeliveryController::class,'insertDeliveryPage']);
Route::post('/select-delivery', [DeliveryController::class,'selectDelivery']);
Route::get('/select-feeship', [DeliveryController::class,'selectFeeShip']);// load feeship
Route::middleware(['auth.roles'])->group(function () {
    Route::post('/save-delivery', [DeliveryController::class,'saveDelivery']);
    Route::post('/update-feeship', [DeliveryController::class,'updateFeeShip']);
});

//slider
Route::get('/manage-slider', [SliderController::class,'manageSliderPage']);
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/insert-slider', [SliderController::class,'insertSliderPage']);
    Route::post('/save-slider', [SliderController::class,'createSlider']);

    Route::get('/inactive-slider/{slider_id}', [SliderController::class, 'activeSlider']);
    Route::get('/active-slider/{slider_id}', [SliderController::class, 'inactiveSlider']);

    Route::get('/edit-slider/{slider_id}', [SliderController::class, 'editSlider']);
    Route::post('/update-slider/{slider_id}', [SliderController::class, 'updateSlider']);
    Route::get('/delete-slider/{slider_id}', [SliderController::class, 'deleteSlider']);
});

//excel
Route::post('/export-csv', [ProductController::class, 'exportCSV']);
Route::middleware(['auth.roles'])->group(function () {
    Route::post('/import-csv', [ProductController::class, 'importCSV']);
});

//Auth roles
Route::get('/register-auth', [AuthController::class, 'showRegisterAuth']);
Route::post('/register', [AuthController::class, 'registerAuth']);
Route::get('/login-auth', [AuthController::class, 'showLoginAuth']);
Route::post('/login', [AuthController::class, 'loginAuth']);
Route::get('/logout-auth', [AuthController::class, 'logoutAuth']);

//User
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/insert-user', [UserController::class, 'insertUserPage']);
    Route::post('/save-user', [UserController::class, 'saveUser']);
    Route::get('/manage-user', [UserController::class, 'manageUser']);
    Route::post('/assign-roles', [UserController::class, 'assignRoles']);
    Route::get('/delete-user/{admin_id}', [UserController::class, 'deleteUser']); 
    Route::get('/impersonate/{admin_id}', [UserController::class, 'impersonate']); 
});
Route::get('/destroy-impersonate', [UserController::class, 'destroyImpersonate']);
 
//menuPost
Route::get('/all-menu-post', [MenuPostController::class, 'showAllMenuPost']);      
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/add-menu-post', [MenuPostController::class, 'addPageMenuPost']);
    Route::get('/edit-menu-post/{menu_post_id}', [MenuPostController::class, 'editMenuPost']);
    Route::get('/delete-menu-post/{menu_post_id}', [MenuPostController::class, 'deleteMenuPost']);

    Route::post('/save-menu-post', [MenuPostController::class, 'createMenuPost']);
    Route::post('/update-menu-post/{menu_post_id}', [MenuPostController::class, 'updateMenuPost']);

    Route::get('/inactive-menu-post/{menu_post_id}', [MenuPostController::class, 'activeMenuPost']);
    Route::get('/active-menu-post/{menu_post_id}', [MenuPostController::class, 'inactiveMenuPost']);    
});

//post
Route::get('/all-post', [PostController::class, 'showAllPost']);      
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/add-post', [PostController::class, 'addPagePost']);
    Route::get('/edit-post/{post_id}', [PostController::class, 'editPost']);
    Route::get('/delete-post/{post_id}', [PostController::class, 'deletePost']);

    Route::post('/save-post', [PostController::class, 'createPost']);
    Route::post('/update-post/{post_id}', [PostController::class, 'updatePost']);

    Route::get('/inactive-post/{post_id}', [PostController::class, 'activePost']);
    Route::get('/active-post/{post_id}', [PostController::class, 'inactivePost']);    
});

//gallery
Route::get('/manage-gallery-product/{product_id}', [GalleryProductController::class, 'showManageGalleryPage']);      
Route::post('/show-gallery-img', [GalleryProductController::class,'showImgGallery']);
Route::middleware(['auth.roles'])->group(function () {
    Route::post('/save-gallery-product/{product_id}', [GalleryProductController::class,'saveGalleryProduct']);
    Route::post('/update-name-gallery', [GalleryProductController::class,'updateNameGallery']);
    Route::post('/update-gallery', [GalleryProductController::class,'updateGallery']);
    Route::post('/delete-gallery', [GalleryProductController::class,'deleteGallery']);
});

//video
Route::middleware(['auth.roles'])->group(function () {
    Route::get('/manage-video', [VideoController::class, 'showManageVideoPage']);      
    Route::post('/show-video', [VideoController::class,'showVideo']);
    Route::post('/show-modal-video', [VideoController::class,'showModalVideo']);
    Route::post('/save-video', [VideoController::class,'saveVideo']);
    Route::post('/update-img-video', [VideoController::class,'updateImgVideo']);
    Route::post('/update-video', [VideoController::class,'updateVideo']);
    Route::post('/delete-video', [VideoController::class,'deleteVideo']);
});

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