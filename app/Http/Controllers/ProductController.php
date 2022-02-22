<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Imports\ProductImport;
use App\Exports\ProductExport;
use App\Models\GalleryProduct;
use App\Models\MenuPost;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id(); 
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPageProduct(){
        $this->AuthLogin();
        
        $cat_product = CategoryProduct::orderBy('category_id','DESC')->get();
        $brand_product = Brand::orderBy('brand_id','DESC')->get();
        return view('admin.product.create')->with(compact('cat_product', 'brand_product'));
    } 
    
    public function showAllProduct(){
        $this->AuthLogin();
        
        $list_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->orderby('tbl_product.product_id','desc')->paginate(5);
        
        return view('admin.product.list',['list_product' => $list_product]);
    }
    
    public function createProduct(Request $request){
        $this->AuthLogin();
        
        $data = $request->except('_token');
        $product = new Product();
        $product->category_id = $data['category'];
        $product->brand_id = $data['brand'];
        $product->product_name = $data['title'];
        $product->product_status = $data['status'];
        $product->product_desc = $data['desc'];
        $product->product_content = $data['content'];
        $product->product_price = $data['price'];
        $product->product_quantity = $data['quantity'];
        $product->product_slug = $data['slug'];
        $product->product_keywords = $data['keywords'];
        $product->created_at = Carbon::now()->toDateTimeString();
        $product->updated_at = Carbon::now()->toDateTimeString();

        $get_image = $request->file('image');
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move($path,$new_image);

            File::copy($path.$new_image,$path_gallery.$new_image);
            $product->product_image = $new_image;            
        }
        $product->save();
        $product_id = $product->product_id;
        $gallery = new GalleryProduct();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $product_id;
        $gallery->save();
        
        session(['message'=>'Add product success']);
        return Redirect::to('all-product'); 
    }   

    public function inactiveProduct ($product_id){
        $this->AuthLogin();
        $product = Product::find($product_id);
        $product->product_status = 0;
        $product->save();
        session(['message'=>'Don\'t show product']);
        return Redirect::to('all-product');
    }
    
    public function activeProduct ($product_id){
        $this->AuthLogin();
        $product = Product::find($product_id);
        $product->product_status = 1;
        $product->save();
        session(['message'=>'show product']);
        return Redirect::to('all-product');
    }
    
    public function editProduct($product_id){
        $this->AuthLogin();
        
        $cat_product = CategoryProduct::orderBy('category_id','DESC')->get();
        $brand_product = Brand::orderBy('brand_id','DESC')->get();

        $edit_product = Product::find($product_id);
        $manager_product = view('admin.product.edit')->with(compact('edit_product','brand_product','cat_product'));
        return view('admin_layout')->with('admin.product.edit', $manager_product);
    }
    
    public function updateProduct(Request $request,$product_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $product = Product::find($product_id);
        $product->category_id = $data['category'];
        $product->brand_id = $data['brand'];
        $product->product_name = $data['title'];
        $product->product_desc = $data['desc'];
        $product->product_content = $data['content'];
        $product->product_price = $data['price'];
        $product->product_quantity = $data['quantity'];
        $product->product_slug = $data['slug'];
        $product->product_keywords = $data['keywords'];
        $product->updated_at = Carbon::now()->toDateTimeString();

        $get_image = $request->file('image');
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            if($product->product_image){
                unlink($path.$product->product_image);
                unlink($path_gallery.$product->product_image);
            }
            $product->product_image = $new_image;            
            $gallery = GalleryProduct::where('product_id',$product_id)->first();
            $gallery->gallery_image = $new_image;
            $gallery->save();
        }
        $product->save();
        session(['message'=>'Update product success']);
        return Redirect::to('all-product'); 
    }  
    
    public function deleteProduct($product_id){
        $this->AuthLogin();
        $product = Product::find($product_id);
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        if($product->product_image){
            unlink($path.$product->product_image);
            unlink($path_gallery.$product->product_image);
        }
        $product->delete();
        session(['message' => 'Delete product success']);
        return Redirect::to('all-product');
    }

    public function exportCSV (){
      return Excel::download(new ProductExport , 'product.xlsx');
    }

    public function importCSV (Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ProductImport, $path);
        return back();        
    }

    //end function admin
    
    public function showProductDetailPage($product_slug, Request $request){  
        $cats = CategoryProduct::orderBy('category_id','DESC')->where('category_status','1')->get();      
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
      
        $product_details = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id','=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=', 'tbl_product.brand_id')
        ->where('tbl_product.product_slug', $product_slug)->limit(1)->get();
           
        $meta_desc = '';
        $meta_keywords =''; 
        $meta_title = '';
        $url_canonical = $request->url();
    
        // SEO
        foreach($product_details as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->product_keywords;
            $meta_title = $value->product_name;
            $url_canonical = $request->url(); 
        }
        // SEO

        //gallery
        $gallery = GalleryProduct::where('product_id',$product_id)->get();

        $related_products = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id','=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=', 'tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_slug',[$product_slug])->get();
        
        return view('pages.productDetail.show')->with(compact('gallery','catsPost','cats','brands','slider','product_details','related_products','meta_desc','meta_keywords','meta_title','url_canonical'));
    }
}