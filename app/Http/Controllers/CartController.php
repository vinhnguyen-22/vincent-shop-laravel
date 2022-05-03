<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
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
                'product_stock' => $data['cart_product_stock'],
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
                'product_stock' => $data['cart_product_stock'],
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
        return view('pages.cart.cartAjax')->with(compact('meta_desc','meta_keywords','meta_title','url_canonical'));
    }

    public function updateCart(Request $request){
        $data = $request->all();
        $cart = session()->get('cart');
        if($cart==true){
            $message = '';
            
            foreach($data['cart_qty'] as $key=> $qty){
                foreach($cart as $session => $val){
                    if($val['session_id'] == $key && $qty < $cart[$session]['product_stock']){
                        $cart[$session]['product_qty'] = $qty;
                        $message .= '<p style="color:darkcyan">Update quantity: '.$cart[$session]['product_name']. ' success</p>';
                    }elseif($val['session_id'] == $key && $qty > $cart[$session]['product_stock']){
                        $message .= '<p style="color:coral">Update quantity: '.$cart[$session]['product_name']. ' failed</p>';
                    }
                }
            }

            session(['cart'=>$cart]);
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with('error', 'Update item failed');
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
        $now = Carbon::now()->format('Y-m-d');
        $coupon =Coupon::where('coupon_code', $data['coupon'])->where('coupon_status',1)->where('coupon_expired','>=',$now)->first();
        if($coupon){
            if(session()->get('customer_id')){
                $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status',1)->where('coupon_used','NOT LIKE','%'.session()->get('customer_id').'%')->first();
                if(!$coupon) {
                    return redirect()->back()->with('error','Coupon used');
                }
            }
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
        }else{
            return redirect()->back()->with('error','Coupon expired');
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