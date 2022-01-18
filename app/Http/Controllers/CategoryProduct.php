<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Session;
class categoryProduct extends Controller
{
    public function AuthLogin(){    
        $admin_id = Session::get('admin_id');

        if(!$admin_id){
            return Redirect::to('admin')->send();
        }else{
            return Redirect::to('dashboard');
        }
    }

    public function addPageCategory(){
        $this->AuthLogin();
        return view('admin.category.create');
    } 
    
    public function showAllCategory(){
        $this->AuthLogin();
        $list_category = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.category.list')->with('list_category',$list_category);
        return view('admin_layout')->with('admin.category.list',$manager_category_product);
    }
    
    public function createCategory(Request $request){
        $this->AuthLogin();
    
        $data = array();
        $data['category_name'] = $request->title;
        $data['category_status'] = $request->status;
        $data['category_desc'] = $request->desc;
        $data['category_keywords'] = $request->keywords;
        $data['category_slug'] = $request->slug;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Add category success');
        return Redirect::to('add-category-product'); 
    }   

    public function inactiveCategory ($cat_id){
        $this->AuthLogin();
    
        DB::table('tbl_category_product')->where('category_id',$cat_id)->update(['category_status' => 0]);
        Session::put ('message', 'Don\'t show category');
        return Redirect::to('all-category-product');
    }
    
    public function activeCategory ($cat_id){
        $this->AuthLogin();
    
        DB::table('tbl_category_product')->where('category_id',$cat_id)->update(['category_status' => 1]);
        Session::put ('message', 'show category');
        return Redirect::to('all-category-product');
    }
    
    public function editCategory($cat_id){
        $this->AuthLogin();
    
        $edit_category = DB::table('tbl_category_product')->where('category_id',$cat_id)->get();
        $manager_category_product = view('admin.category.edit')->with('edit_category',$edit_category);
        return view('admin_layout')->with('admin.category.edit', $manager_category_product);
    }
    
    public function updateCategory(Request $request,$cat_id){
        $this->AuthLogin();
    
        $data = array();
        $data['category_name'] = $request->title;
        $data['category_desc'] = $request->desc;
        $data['category_slug'] = $request->slug;
        $data['category_keywords'] = $request->keywords;
        $data['updated_at'] = Carbon::now()->toDateTimeString();


        DB::table('tbl_category_product')->where('category_id', $cat_id)->update($data);
        Session::put('message','Update category success');
        return Redirect::to('all-category-product'); 
    }  
    
    public function deleteCategory($cat_id){
        $this->AuthLogin();
    
        DB::table('tbl_category_product')->where( 'category_id',$cat_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    // end function admin page
    
    public function showCategoryPage($cat_id, Request $request){
        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $pro_by_cat = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',$cat_id)->get();
        
        $meta_desc = '';
        $meta_keywords =''; 
        $meta_title = '';
        $url_canonical = $request->url();
        // SEO
        foreach ($pro_by_cat as $key => $val){
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->category_keywords;
            $meta_title = $val->category_name;
            $url_canonical = $request->url(); 
        }
        // SEO
        $cat_name = DB::table('tbl_category_product')->select('category_name')->where('tbl_category_product.category_id',$cat_id)->limit(1)->get(); 

        return view('pages.category.show')->with(compact('cats','brands','pro_by_cat','cat_name','meta_desc','meta_keywords','meta_title','url_canonical'));
    } 
}