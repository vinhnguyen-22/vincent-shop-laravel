<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function saveCart(Request $request){
        $data = array();
        $product_id =
         $request->productId_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')-> where('product_id', $product_id)->first();

        $data['id'] = $product_info->product_id;
        $data['name'] = $product_info->product_name;
        $data['qty'] = $quantity;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;

        // Cart::destroy();
        Cart::add($data);
        Cart::setGlobalTax(10);
        
        return Redirect::to('/show-cart');
    }

    public function showCart(){        
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        return view('pages.cart.show')->with('cats',$cat_product)->with('brands', $brand_product);
    }
    
    public function deleteToCart($rowId){        
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    
    public function updateQtyCart(Request $request){        
        $rowId = $request->rowId_cart;
        $qty = $request->cart_qty;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }
}