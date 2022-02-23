<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\MenuPost;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
class CategoryProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPageCategory(){
        $this->AuthLogin();
        $category = CategoryProduct::where('category_parentId',0)->orderBy('category_id','DESC')->get();
        return view('admin.category.create')->with('category',$category);
    } 
    
    public function showAllCategory(){
        $this->AuthLogin();
        $list_category = CategoryProduct::orderBy('category_id','DESC')->get();
        $manager_category_product = view('admin.category.list')->with('list_category',$list_category);
        return view('admin_layout')->with('admin.category.list',$manager_category_product);
    }
    
    public function createCategory(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $category = new CategoryProduct();
        $category->category_name = $data['title'];
        $category->category_status = $data['status'];
        $category->category_desc = $data['desc'];
        $category->category_slug = $data['slug'];
        $category->category_keywords = $data['keywords'];
        $category->category_parentId = $data['parent'];
        $category->created_at = Carbon::now()->toDateTimeString();
        $category->updated_at = Carbon::now()->toDateTimeString();
        $category->save();

        session(['message'=>'Add category success']);
        return Redirect::to('add-category-product'); 
    }   

    public function inactiveCategory ($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->category_status = 0;
        $category->save();
        session(['message'=> 'Don\'t show category']);
        return Redirect::to('all-category-product');
    }
    
    public function activeCategory ($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->category_status = 1;
        $category->save();
        session(['message'=> 'show category']);
        return Redirect::to('all-category-product');
    }
    
    public function editCategory($cat_id){
        $this->AuthLogin();
        $edit_category = CategoryProduct::find($cat_id);
        $category = CategoryProduct::where('category_id','<>',$cat_id)->orderBy('category_id','DESC')->get();
        return view('admin.category.edit')->with(compact('edit_category','category'));
    }
    
    public function updateCategory(Request $request,$cat_id){
        $this->AuthLogin();
    
        $data = $request->all();
        $category = CategoryProduct::find($cat_id);
        $category->category_name = $data['title'];
        $category->category_desc = $data['desc'];
        $category->category_slug = $data['slug'];
        $category->category_keywords = $data['keywords'];
        $category->category_parentId = $data['parent'];
        $category->updated_at = Carbon::now()->toDateTimeString();
        $category->save();

        session(['message'=>'Update category success']);
        return Redirect::to('all-category-product'); 
    }  
    
    public function deleteCategory($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->delete();
        session(['message'=> 'Delete success']);
        return Redirect::to('all-category-product');
    }

    // end function admin page
    
    public function showCategoryPage($cat_slug, Request $request){
        $cats = CategoryProduct::orderBy('category_id','DESC')->where('category_status','1' )->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $pro_by_cat = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_category_product.category_slug',$cat_slug)->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        
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
        $cat_name = DB::table('tbl_category_product')->select('category_name')->where('tbl_category_product.category_slug',$cat_slug)->limit(1)->get(); 

        return view('pages.category.show')->with(compact('catsPost','cats','brands','pro_by_cat','cat_name','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    } 
}