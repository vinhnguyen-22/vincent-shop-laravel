<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function index(Request $request){

        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO
        
        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','desc')->limit(4)->get();

        return view('pages.home')->with(compact('brands','cats','all_product','meta_desc','meta_keywords','meta_title','url_canonical'));
    }

    public function search(Request $request){
        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO

        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        $keywords = $request->search_box; 
        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->get();


        return view('pages.productDetail.search')->with(compact('brands','cats','meta_desc','meta_keywords','meta_title','url_canonical','search_product'));
    }

}