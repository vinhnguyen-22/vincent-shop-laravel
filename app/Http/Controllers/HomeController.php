<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request){

        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO
        
        $cats = CategoryProduct::orderBy('category_id','DESC')->where('category_status','1')->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','desc')->limit(10)->get();

        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();

        return view('pages.home')->with(compact('brands','cats','all_product','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }

    public function search(Request $request){
        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO

        $cats = CategoryProduct::orderBy('category_id','DESC')->where('category_status','1')->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
       
        $keywords = $request->search_box; 
        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->get();


        return view('pages.productDetail.search')->with(compact('brands','cats','meta_desc','meta_keywords','meta_title','url_canonical','search_product','slider'));
    }
}