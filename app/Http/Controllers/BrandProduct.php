<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class BrandProduct extends Controller
{
    public function addPageBrand(){
        return view('admin.brand.create');
    } 
    
    public function showAllBrand(){
        $list_brand = DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.brand.list')->with('list_brand',$list_brand);
        return view('admin_layout')->with('admin.brand.list',$manager_brand_product);
    }
    
    public function createBrand(Request $request){
        $data = array();
        $data['brand_name'] = $request->title;
        $data['brand_status'] = $request->status;
        $data['brand_desc'] = $request->desc;
        // $data['created_at'] = $request->time();
        // $data['updated_at'] = $request->time();

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Add brand success');
        return Redirect::to('add-brand-product'); 
    }   

    public function inactiveBrand ($brand_id){
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status' => 0]);
        Session::put ('message', 'Don\'t show brand');
        return Redirect::to('all-brand-product');
    }
    
    public function activeBrand ($brand_id){
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status' => 1]);
        Session::put ('message', 'show brand');
        return Redirect::to('all-brand-product');
    }
    
    public function editBrand($brand_id){
        $edit_brand = DB::table('tbl_brand')->where('brand_id',$brand_id)->get();
        $manager_brand_product = view('admin.brand.edit')->with('edit_brand',$edit_brand);
        return view('admin_layout')->with('admin.brand.edit', $manager_brand_product);
    }
    
    public function updateBrand(Request $request,$brand_id){
        $data = array();
        $data['brand_name'] = $request->title;
        $data['brand_desc'] = $request->desc;
        // $data['created_at'] = $request->time();
        // $data['updated_at'] = $request->time();

        DB::table('tbl_brand')->where('brand_id', $brand_id)->update($data);
        Session::put('message','Update brand success');
        return Redirect::to('all-brand-product'); 
    }  
    
    public function deleteBrand($brand_id){
        DB::table('tbl_brand')->where( 'brand_id',$brand_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
}