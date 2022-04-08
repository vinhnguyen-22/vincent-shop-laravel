<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Product;
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
        
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','desc')->paginate(6);
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $logo = Information::select('info_img')->first();
        $cat_tab = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->where('category_parentId','<>',0)->get();
        return view('pages.home')->with(compact('cat_tab','logo','catsPost','brands','cats','all_product','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }

    public function search(Request $request){
        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO

        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $keywords = $request->search_box; 
        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->paginate(5);

        return view('pages.productDetail.search')->with(compact('logo','catsPost','brands','cats','meta_desc','meta_keywords','meta_title','url_canonical','search_product','slider'));
    }

    public function searchAjax(Request $request){
        $data = $request->all();
        if($data["keywords"]){
            $search_product = Product::where('product_name', 'like', '%'.$data["keywords"].'%')->get();

            $output = '<ul class="dropdown-menu" style="display: block; position:relative;" >';
            foreach($search_product as $key => $val){
                $output .= '<li class="li-search-ajax">
                <a href="#">'. $val->product_name.'</a>
                </li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}