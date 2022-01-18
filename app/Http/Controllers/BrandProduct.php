<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Session;

class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');

        if(!$admin_id){
            return Redirect::to('admin')->send();
        }else{
            return Redirect::to('dashboard');
        }
    }

    public function addPageBrand(){
        $this->AuthLogin();
        return view('admin.brand.create');
    } 
    
    public function showAllBrand(){
        $this->AuthLogin();
        $list_brand = DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.brand.list')->with('list_brand',$list_brand);
        return view('admin_layout')->with('admin.brand.list',$manager_brand_product);
    }
    
    public function createBrand(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['brand_name'] = $request->title;
        $data['brand_status'] = $request->status;
        $data['brand_desc'] = $request->desc;
        $data['brand_slug'] = $request->slug;
        $data['brand_keywords'] = $request->keywords;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Add brand success');
        return Redirect::to('add-brand-product'); 
    }   

    public function inactiveBrand ($brand_id){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status' => 0]);
        Session::put ('message', 'Don\'t show brand');
        return Redirect::to('all-brand-product');
    }
    
    public function activeBrand ($brand_id){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status' => 1]);
        Session::put ('message', 'show brand');
        return Redirect::to('all-brand-product');
    }
    
    public function editBrand($brand_id){
        $this->AuthLogin();
        $edit_brand = DB::table('tbl_brand')->where('brand_id',$brand_id)->get();
        $manager_brand_product = view('admin.brand.edit')->with('edit_brand',$edit_brand);
        return view('admin_layout')->with('admin.brand.edit', $manager_brand_product);
    }
    
    public function updateBrand(Request $request,$brand_id){
        $data = array();
        $data['brand_name'] = $request->title;
        $data['brand_desc'] = $request->desc;
        $data['brand_slug'] = $request->slug;
        $data['brand_keywords'] = $request->keywords;
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        DB::table('tbl_brand')->where('brand_id', $brand_id)->update($data);
        Session::put('message','Update brand success');
        return Redirect::to('all-brand-product'); 
    }  
    
    public function deleteBrand($brand_id){
        DB::table('tbl_brand')->where( 'brand_id',$brand_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    
    // end function admin
    
    public function showBrandPage($brand_id, Request $request){
        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        $pro_by_brand = DB::table('tbl_product')->join('tbl_brand', 'tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->get();
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get(); 
        
        $meta_desc = '';
        $meta_keywords =''; 
        $meta_title = '';
        $url_canonical = $request->url();
        
        // SEO
        foreach ($pro_by_brand as $key => $val){
            $meta_desc = $val->brand_desc;
            $meta_keywords = $val->brand_keywords;
            $meta_title = $val->brand_name;
            $url_canonical = $request->url(); 
        }
        // SEO

        return view('pages.brand.show')->with(compact('cats','brands','pro_by_brand','brand_name','meta_desc','meta_keywords','meta_title','url_canonical'));
    } 
}