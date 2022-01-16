<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function index(){
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','desc')->limit(4)->get();

        return view('pages.home')->with('brands',$brand_product)->with('cats',$cat_product)->with('all_product', $all_product);
    }

    public function search(Request $request){
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        $keywords = $request->search_box; 
        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->get();


        return view('pages.productDetail.search')->with('brands',$brand_product)->with('cats',$cat_product)->with("search_product", $search_product);
    }

}