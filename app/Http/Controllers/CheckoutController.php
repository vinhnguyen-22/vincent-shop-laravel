<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Province;
use App\Models\Shipping;
use App\Models\Slider;
use App\Models\Ward;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Rules\Captcha;
use Illuminate\Support\Facades\Auth;

session_start();
class CheckoutController extends Controller
{
    public function CustomerLogin(){
        $customer_id = Session::get('customer_id');

        if(!$customer_id){
            return Redirect::to('/login-checkout')->send();
        }else{
            return Redirect::to('/');
        }
    }
    
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function loginCheckout(Request $request){        
        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $meta_desc = 'Checkout page, order';
        $meta_keywords ='checkout, order'; 
        $meta_title = 'Your order';
        $url_canonical = $request->url();
        
        return view('pages.checkout.login')->with(compact('logo','catsPost','cats','brands','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
    
    public function login(Request $request){
        $customer_email = $request-> customer_email;
        $customer_password = md5($request-> customer_password);
        $result = DB::table('tbl_customers')->where('customer_email',$customer_email)->where('customer_password',$customer_password)->first();
        if($result){
            Session::put('customer_name', $result->customer_name);
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        }else{
            // Session::put('message','Password or email incorrect');
            return Redirect::to('/login-checkout');
        }
        
    }

    public function logout(){
        $this->CustomerLogin();
        Session::flush();
        $customer_id = Session::get('customer_id');
        if($customer_id != null){
            Session::put('customer_name',null);
            Session::put('customer_id',null);
        }
        return  Redirect::to('/login-checkout');
    }
        
    public function customerRegister(Request $request){
        $data = $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_password' => 'required',
            'customer_phone' => 'required',
            'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $customer_id = DB::table('tbl_customers')->insertGetId($data);
        
        if($customer_id){
            Session::put('customer_name', $request->customer_name);
            Session::put('customer_id', $customer_id);
            return Redirect::to('/checkout');
        }else{
            Session::put('message','Password or email incorrect');
            return Redirect::to('/login-checkout');
        }        
    }
    // END LOGIN SIGNUP
    
    public function checkoutPage (Request $request){        
        $this->CustomerLogin();
        $cats = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $meta_desc = 'Checkout page, order';
        $meta_keywords ='checkout, order'; 
        $meta_title = 'Your order';
        $url_canonical = $request->url();

        $province = Province::orderBy('matp','ASC')->get();
        $district = District::orderBy('maqh','ASC')->get();
        $ward = Ward::orderBy('xaid','ASC')->get();

        if(!session()->get('cart')){
            return redirect('/show-cart-page')->with('message', 'Please buy something before checkout');
        }else{
            return view('pages.checkout.show')->with(compact('logo','catsPost','cats','brands','meta_desc','meta_keywords','meta_title','url_canonical','province','district','ward','slider'));
        }
    }
    
    public function confirmOrder(Request $request){
        $this->CustomerLogin();
        $data = $request->all();
        $shipping = new Shipping;
        $shipping->shipping_name = $data['shipping_name']; 
        $shipping->customer_id = session()->get('customer_id'); 
        $shipping->shipping_address = $data['shipping_address']; 
        $shipping->shipping_phone = $data['shipping_phone']; 
        $shipping->shipping_email = $data['shipping_email']; 
        $shipping->shipping_notes = $data['shipping_notes']; 
        $shipping->shipping_method = $data['shipping_method'];     
        $shipping->save();    

        $shipping_id = $shipping->shipping_id;
        $checkout_code =  substr(md5(microtime()),rand(0,26), 5);

        $order = new Order;
        $order->customer_id = session()->get('customer_id'); 
        $order->shipping_id = $shipping_id; 
        $order->order_status = 1; 
        $order->order_code = $checkout_code;
        $order->order_total = $data['order_total'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();
        
        if(session()->get('cart')){
            foreach(session()->get('cart') as $key => $cart){
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->order_coupon = $data['order_coupon'];
                $order_details->order_feeship = $data['order_fee'];
                $order_details->save();
            }    
        }
        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('fee');
    }
}