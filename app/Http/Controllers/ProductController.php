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
use App\Models\Information;
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
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->orderby('tbl_product.product_id','desc')->get();
        
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
        $product->product_tags = $data['tag'];
        $product->product_desc = $data['desc'];
        $product->product_content = $data['content'];
        $product->product_price = filter_var($data['price'], FILTER_SANITIZE_NUMBER_INT);
        $product->product_cost = filter_var($data['cost'],FILTER_SANITIZE_NUMBER_INT);
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
        return redirect('all-product'); 
    }   

    public function inactiveProduct ($product_id){
        $this->AuthLogin();
        $product = Product::find($product_id);
        $product->product_status = 0;
        $product->save();
        session(['message'=>'Don\'t show product']);
        return redirect('all-product');
    }
    
    public function activeProduct ($product_id){
        $this->AuthLogin();
        $product = Product::find($product_id);
        $product->product_status = 1;
        $product->save();
        session(['message'=>'show product']);
        return redirect('all-product');
    }
    
    public function editProduct($product_id){
        $this->AuthLogin();
        
        $cat_product = CategoryProduct::orderBy('category_id','DESC')->get();
        $brand_product = Brand::orderBy('brand_id','DESC')->get();

        $edit_product = Product::find($product_id);
        $manager_product = view('admin.product.edit')->with(compact('edit_product','brand_product','cat_product'));
        return view('admin.admin_layout')->with('admin.product.edit', $manager_product);
    }
    
    public function updateProduct(Request $request,$product_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $product = Product::find($product_id);
        $product->category_id = $data['category'];
        $product->brand_id = $data['brand'];
        $product->product_tags = $data['tag'];
        $product->product_name = $data['title'];
        $product->product_desc = $data['desc'];
        $product->product_content = $data['content'];
        $product->product_price = filter_var($data['price'], FILTER_SANITIZE_NUMBER_INT);
        $product->product_cost = filter_var($data['cost'],FILTER_SANITIZE_NUMBER_INT);
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
        return redirect('all-product'); 
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
        return redirect('all-product');
    }

    public function exportCSV (){
      return Excel::download(new ProductExport , 'product.xlsx');
    }

    public function importCSV (Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ProductImport, $path);
        return back();        
    }

    public function ckeditorImage(Request $request){
        if($request->hasFile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName,PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            
            $request->file('upload')->move('public/uploads/ckeditor',$fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/uploads/ckeditor/'.$fileName);
            $msg = 'Tải ảnh thành công';
            $response ="<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header("Content-type: text/html; charset=utf-8");
            echo $response;
        }
    }

    public function fileBrowser(){
        $paths = glob(public_path('uploads/ckeditor/*'));
        $fileNames = array();
        foreach ($paths as $path){
            array_push($fileNames,basename($path));
        }
        $data = array(
            'fileNames' => $fileNames
        );
        return view('admin.images.file_browser')->with($data);
    }

    //end function admin
    
    public function showProductDetailPage($product_slug, Request $request){  
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();      
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

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

        $product = Product::Where('product_slug', $product_slug)->first();
        $product->product_views += 1;
        $product->save();
        //gallery
        $gallery = GalleryProduct::where('product_id',$product_id)->get();

        $related_products = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id','=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=', 'tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_slug',[$product_slug])->get();
        
        return view('pages.productDetail.show')->with(compact('logo','gallery','catsPost','cats','brands','slider','product_details','related_products','meta_desc','meta_keywords','meta_title','url_canonical'));
    }

    public function tag(Request $request, $product_tag){
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();      
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $tag = str_replace('-'," ",$product_tag);

        $pro_tag = Product::where('product_status','1')
        ->where('product_name','LIKE','%'.$tag.'%')
        ->orWhere('product_slug','LIKE','%'.$tag.'%')
        ->orWhere('product_tags','LIKE','%'.$tag.'%')
        ->paginate(5);
           
        $meta_desc = 'tag:'.$product_tag;
        $meta_keywords ='tags tìm kiếm:'.$product_tag; 
        $meta_title = 'Tags: '.$product_tag;
        $url_canonical = $request->url();
    
        return view('pages.productDetail.tag')->with(compact('logo','catsPost','cats','brands','slider','meta_desc','meta_keywords','meta_title','url_canonical','product_tag','pro_tag'));
    }

    public function quickView(Request $request){
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $gallery = GalleryProduct::where('product_id', $product_id)->get();
        $output['product_gallery'] = '';
        foreach ($gallery as $key => $val){
            $output['product_gallery'] .=  '<p><img width="100%" src="public/uploads/gallery/'.$val->gallery_image.'"></p>';
        }

        $output['product_title'] = $product->product_name;
        $output ['product_id'] = $product->product_id;
        $output ['product_desc']= $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_slug'] = url('/product-detail/'.$product->product_slug);
        $output['product_price'] = number_format ($product->product_price,0,',','.').'$';
        $output['product_image'] =  '<p><img width="100%" src="public/uploads/product/'.$product->product_image.'"></p>';

        
        $output['product_inputValue'] =  '
        <input type="number" value="1" min="1" class="cart_product_qty_'.$product->product_id.'">
        <input type="hidden" value="'.$product->product_id.'" class="cart_product_id_'.$product->product_id.'">
        <input type="hidden" value="'.$product->product_name.'" class="cart_product_name_'.$product->product_id.'">
        <input type="hidden" value="'.$product->product_image.'" class="cart_product_image_'.$product->product_id.'">
        <input type="hidden" value="'.$product->product_price.'" class="cart_product_price_'.$product->product_id.'">
        <input type="hidden" value="'.$product->product_quantity.'" class="cart_product_stock_'.$product->product_id.'">
        <button data-id_product="'.$product->product_id.'" class="btn btn-primary add-to-cart-quickView" type="button" style="color: white" name="add-to-cart">Add to cart</button>
        
        ';
        echo json_encode ($output);
    }
}