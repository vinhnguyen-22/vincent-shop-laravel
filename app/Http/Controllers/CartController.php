<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Slider;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
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

    public function showCart(Request $request){
        // SEO
        $meta_desc = 'Cart shopping';
        $meta_keywords ='buy online, e-commerce'; 
        $meta_title = 'Your cart';
        $url_canonical = $request->url(); 
        // SEO

        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
    
        return view('pages.cart.show')->with(compact('cats','brands','meta_desc','meta_keywords','meta_title','url_canonical'));
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

    //AJAX request
    public function addCartAjax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = session()->get('cart');
        if($cart==true){
            $is_available = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                session(['cart'=>$cart]);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            session(['cart'=>$cart]);
        }
        session()->save();
    }  
    
    public function showCartAjax(Request $request){
        // SEO
        $meta_desc = 'Cart shopping';
        $meta_keywords ='buy online, e-commerce'; 
        $meta_title = 'Your cart';
        $url_canonical = $request->url(); 
        // SEO

        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
    
        return view('pages.cart.cartAjax')->with(compact('cats','brands','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }

    public function updateCart(Request $request){
        $data = $request->all();
        $cart = session()->get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key=>$qty){
                foreach($cart as $session => $val){
                    if($val['session_id'] == $key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            session(['cart'=>$cart]);
            return redirect()->back()->with('message', 'Update item success');
        }else{
            return redirect()->back()->with('message', 'Update item failed');
        }
        session()->save();
    }  

    public function deleteItem($session_id){
        $cart = session()->get('cart');
        if($cart == true){
            foreach($cart as $key => $val){
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            session(['cart'=>$cart]);
            return redirect()->back()->with('message', 'Delete item success');
        }else{
            return redirect()->back()->with('message', 'Delete item failed');
        }
    }  

    public function deleteAllItem(){
        $cart = session()->get('cart');
        if($cart == true){
            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('fee');
            return redirect()->back()->with('message', 'Delete item success');
        }else{
            return redirect()->back()->with('message', 'Delete item failed');
        }
    }
    
    public function checkCoupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = session()->get('coupon');
                
                if($coupon_session){
                    $is_available = false;
                    if(!$is_available){
                        $cou[]= array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_method' => $coupon->coupon_method,
                            'coupon_rate' => $coupon->coupon_rate,
                        );
                        session(['coupon' => $cou]);
                    }
                }else{
                    $cou[]= array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_method' => $coupon->coupon_method,
                        'coupon_rate' => $coupon->coupon_rate,
                    );
                    session(['coupon' => $cou]);
                }
                
                session()->save();
                return redirect()->back()->with('message','Add coupon success');
            }
        }else{
            return redirect()->back()->with('error','Coupon code incorrect');
        }             
    }
    
    public function deleteAllCoupon(){
        $cart = session()->get('cart');
        if($cart == true){
            session()->forget('coupon');
            return redirect()->back()->with('message', 'Delete coupon success');
        }else{
            return redirect()->back()->with('message', 'Delete coupon failed');
        }
    }
}