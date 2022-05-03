<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('pages/*', function($view){
            $app_product = Product::all()->count();
            $app_post = Post::all()->count();
            $app_order = Order::all()->count();
            $app_video = Video::all()->count();
            $app_customer = Customer::all()->count();

            $logo = Information::select('info_img')->first();
            $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();
            $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
            $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
            $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();

            $view->with(compact(
                'app_product',
                'app_post',
                'app_order',
                'app_video',
                'app_customer',

                'logo',
                'cats',
                'brands',
                'slider',
                'catsPost',
            ));
        });
        Paginator::useBootstrap();
    }
}