<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Session;


class ProductController extends Controller
{
    public function addPageProduct(){
        return view('admin.product.create');
    } 
    
    public function showAllProduct(){
        $list_product = DB::table('tbl_product')->get();
        $manager_product = view('admin.product.list')->with('list_product',$list_product);
        return view('admin_layout')->with('admin.product.list',$manager_product);
    }
    
    public function createProduct(Request $request){
        $data = array();
        $data['product_name'] = $request->title;
        $data['product_status'] = $request->status;
        $data['product_desc'] = $request->desc;
        // $data['created_at'] = $request->time();
        // $data['updated_at'] = $request->time();

        DB::table('tbl_product')->insert($data);
        Session::put('message','Add product success');
        return Redirect::to('add-product-product'); 
    }   

    public function inactiveProduct ($product_id){
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 0]);
        Session::put ('message', 'Don\'t show product');
        return Redirect::to('all-product-product');
    }
    
    public function activeProduct ($product_id){
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 1]);
        Session::put ('message', 'show product');
        return Redirect::to('all-product-product');
    }
    
    public function editProduct($product_id){
        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.product.edit')->with('edit_product',$edit_product);
        return view('admin_layout')->with('admin.product.edit', $manager_product);
    }
    
    public function updateProduct(Request $request,$product_id){
        $data = array();
        $data['product_name'] = $request->title;
        $data['product_desc'] = $request->desc;
        // $data['created_at'] = $request->time();
        // $data['updated_at'] = $request->time();

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message','Update product success');
        return Redirect::to('all-product-product'); 
    }  
    
    public function deleteProduct($product_id){
        DB::table('tbl_product')->where( 'product_id',$product_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-product-product');
    }
}