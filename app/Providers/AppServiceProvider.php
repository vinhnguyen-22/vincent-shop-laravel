<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
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

        view()->composer('*', function($view){
            $app_product = Product::all()->count();
            $app_post = Post::all()->count();
            $app_order = Order::all()->count();
            $app_video = Video::all()->count();
            $app_customer = Customer::all()->count();
            $view->with(compact(
                'app_product',
                'app_post',
                'app_order',
                'app_video',
                'app_customer'
            ));
        });
        Paginator::useBootstrap();
    }
}