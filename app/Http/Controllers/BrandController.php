<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class BrandController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPageBrand(){
        $this->AuthLogin();
        return view('admin.brand.create');
    } 
    
    public function showAllBrand(){
        $this->AuthLogin();
        $list_brand = Brand::orderBy('brand_id','DESC')->paginate(5);
        $manager_brand_product = view('admin.brand.list')->with('list_brand',$list_brand);
        return view('admin.admin_layout')->with('admin.brand.list',$manager_brand_product);
    }
    
    public function createBrand(Request $request){
        $this->AuthLogin();
        
        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['title'];
        $brand->brand_status = $data['status'];
        $brand->brand_desc = $data['desc'];
        $brand->brand_slug = $data['slug'];
        $brand->brand_keywords = $data['keywords'];
        $brand->created_at = Carbon::now()->toDateTimeString();
        $brand->updated_at = Carbon::now()->toDateTimeString();
        $brand->save();

        session(['message' => 'Add brand success']);
        return redirect('add-brand-product'); 
    }   

    public function inactiveBrand ($brand_id){
        $this->AuthLogin();
        $brand = Brand::find($brand_id);
        $brand->brand_status = 0;
        $brand->save();
        session(['message' => 'Don\'t show brand']);
        return redirect('all-brand-product');
    }
    
    public function activeBrand ($brand_id){
        $this->AuthLogin();
        $brand = Brand::find($brand_id);
        $brand->brand_status = 1;
        $brand->save();
        session(['message' => 'Show brand']);
        return redirect('all-brand-product');
    }
    
    public function editBrand($brand_id){
        $this->AuthLogin();
        $edit_brand = Brand::find($brand_id);
        $manager_brand_product = view('admin.brand.edit')->with('edit_brand',$edit_brand);
        return view('admin.admin_layout')->with('admin.brand.edit', $manager_brand_product);
    }
    
    public function updateBrand(Request $request,$brand_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $brand = Brand::find($brand_id);
        $brand->brand_name = $data['title'];
        $brand->brand_desc = $data['desc'];
        $brand->brand_slug = $data['slug'];
        $brand->brand_keywords = $data['keywords'];
        $brand->updated_at = Carbon::now()->toDateTimeString();
        $brand->save();

        session(['message' =>'Update brand success']);
        return redirect('all-brand-product'); 
    }  
    
    public function deleteBrand($brand_id){
        $this->AuthLogin();

        $brand = Brand::find($brand_id);
        $brand->delete();
        session(['message' => 'Delete success']);
        return redirect('all-brand-product');
    }
    
    // end function admin
    
    public function showBrandPage($brand_slug, Request $request){
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();      
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();
      
        $pro_by_brand = DB::table('tbl_product')->join('tbl_brand', 'tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_brand.brand_slug',$brand_slug)->get();
      
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_slug',$brand_slug)->limit(1)->get(); 
        
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

        return view('pages.brand.show')->with(compact('logo','catsPost','cats','brands','pro_by_brand','brand_name','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    } 
}