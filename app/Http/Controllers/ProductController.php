<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Session;


class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');

        if(!$admin_id){
            return Redirect::to('admin')->send();
        }else{
            return Redirect::to('dashboard');
        }
    }

    public function addPageProduct(){
        $this->AuthLogin();
        
        $cat_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();
        return view('admin.product.create')->with('cat_product', $cat_product)->with('brand_product', $brand_product);
    } 
    
    public function showAllProduct(){
        $this->AuthLogin();
        
        $list_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->orderby('tbl_product.product_id','desc')->get();
        $manager_product = view('admin.product.list')->with('list_product',$list_product);
        return view('admin_layout')->with('admin.product.list',$manager_product);
    }
    
    public function createProduct(Request $request){
        $this->AuthLogin();
        
        $data = array();
        $data['category_id'] = $request->category;
        $data['brand_id'] = $request->brand;
        $data['product_name'] = $request->title;
        $data['product_price'] = $request->price;
        $data['product_desc'] = $request->desc;
        $data['product_content'] = $request->content;
        $data['product_status'] = $request->status;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Add product success');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        
        DB::table('tbl_product')->insert($data);
        Session::put('message','Add product success');
        return Redirect::to('all-product'); 
    }   

    public function inactiveProduct ($product_id){
        $this->AuthLogin();
        
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 0]);
        Session::put ('message', 'Don\'t show product');
        return Redirect::to('all-product');
    }
    
    public function activeProduct ($product_id){
        $this->AuthLogin();
        
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 1]);
        Session::put ('message', 'show product');
        return Redirect::to('all-product');
    }
    
    public function editProduct($product_id){
        $this->AuthLogin();
        
        $cat_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.product.edit')->with('edit_product',$edit_product)->with('cat_product',$cat_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.product.edit', $manager_product);
    }
    
    public function updateProduct(Request $request,$product_id){
        $this->AuthLogin();
        
        $data = array();
        $data['category_id'] = $request->category;
        $data['brand_id'] = $request->brand;
        $data['product_name'] = $request->title;
        $data['product_price'] = $request->price;
        $data['product_desc'] = $request->desc;
        $data['product_content'] = $request->content;
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        
        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Update product success');
            return Redirect::to('all-product');
        }
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message','Update product success');
        return Redirect::to('all-product'); 
    }  
    
    public function deleteProduct($product_id){
        $this->AuthLogin();
        
        DB::table('tbl_product')->where( 'product_id',$product_id)->delete();
        Session::put('message', 'Delete product success');
        return Redirect::to('all-product');
    }

    //end function admin
    
    public function showProductDetailPage($product_id){
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $product_details = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id','=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=', 'tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->limit(1)->get();
   
        foreach($product_details as $key => $value){
            $category_id = $value->category_id;
        }

        $related_products = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id','=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=', 'tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();
        
        return view('pages.productDetail.show')->with('cats',$cat_product)->with('brands', $brand_product)->with('product_details', $product_details)->with('related_products', $related_products);
    } 


}