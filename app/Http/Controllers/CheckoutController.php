<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
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
use Illuminate\Support\Facades\Mail;

session_start();
class CheckoutController extends Controller
{
    public function CustomerLogin(){
        $customer_id = Session::get('customer_id');

        if(!$customer_id){
            return redirect('/login-checkout')->send();
        }else{
            return redirect('/');
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
        $meta_desc = 'Checkout page, order';
        $meta_keywords ='checkout, order'; 
        $meta_title = 'Your order';
        $url_canonical = $request->url();
        
        return view('pages.checkout.login')->with(compact('meta_desc','meta_keywords','meta_title','url_canonical'));
    }
    
    public function login(Request $request){
        $customer_email = $request-> customer_email;
        $customer_password = md5($request-> customer_password);
        $result = DB::table('tbl_customers')->where('customer_email',$customer_email)->where('customer_password',$customer_password)->first();
        if($result){
            Session::put('customer_name', $result->customer_name);
            Session::put('customer_id', $result->customer_id);
            return redirect('/checkout');
        }else{
            // Session::put('message','Password or email incorrect');
            return redirect('/login-checkout');
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
        return  redirect('/login-checkout');
    }
        
    public function customerRegister(Request $request){
        $data = $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_password' => 'required',
            'customer_phone' => 'required',
            // 'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
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
            return redirect('/checkout');
        }else{
            Session::put('message','Password or email incorrect');
            return redirect('/login-checkout');
        }        
    }
    // END LOGIN SIGNUP
    
    public function checkoutPage (Request $request){        
        $this->CustomerLogin();
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
            return view('pages.checkout.show')->with(compact('province','district','ward', 'meta_desc','meta_keywords','meta_title','url_canonical'));
        }
    }
    
    public function confirmOrder(Request $request){
        $this->CustomerLogin();
        $data = $request->all();
        // get coupon
        $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
        if($coupon){
            $coupon->coupon_time -= 1;
            $coupon->coupon_used = $coupon->coupon_used.','.session()->get('customer_id');
            $coupon->save();
        }
        // get fee_shipping
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

        // send email
        $now = Carbon::now()->format('d-m-Y H:i:s');
        $title_mail = 'Xác nhận đơn hàng đến từ VincentGaming ngày '.$now;
        $customer = Customer::find(session()->get('customer_id'));
        $data['email'][] = $customer->customer_email;

        if(session()->get('cart') == true){
            foreach(session()->get('cart') as $key => $val){
                $cart_array[] = array(
                    'product_name' => $val['product_name'],
                    'product_price' => $val['product_price'],
                    'product_qty' => $val['product_qty'],
                );
            }
        }

        $shipping_array = array(
            'customer_name' => $customer->customer_name, 
            'shipping_name' => $data['shipping_name'], 
            'shipping_address' => $data['shipping_address'], 
            'shipping_phone' => $data['shipping_phone'], 
            'shipping_email' => $data['shipping_email'], 
            'shipping_notes' => $data['shipping_notes'], 
            'shipping_method' => $data['shipping_method']  
        );
        if($coupon->coupon_code){
            $code = array(
                'coupon_code' => $coupon->coupon_code,
                'coupon_method' => $coupon->coupon_method,
                'coupon_rate' => $coupon->coupon_rate,
                'order_feeship' =>  $data['order_fee'],
                'order_code' => $order->order_code,
                'issued' => $now
            );
        }else{
            $code = array(
                'coupon_code' => 'Không có',
                'order_code' => $checkout_code,
                'issued' => $now
            );
        }
        
        Mail::send('pages.Mail.invoice',[
            'cart_array' => $cart_array,
            'shipping_array' => $shipping_array,
            'code' => $code], function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('fee');
    }

    //Order history

    public function orderHistoryPage(Request $request){
        $this->CustomerLogin();
        $meta_desc = 'History page, order';
        $meta_keywords ='history, order'; 
        $meta_title = 'Your order';
        $url_canonical = $request->url();
        
        $all_order = Order::where('customer_id',session()->get('customer_id'))->orderby('order_id','DESC')->paginate(20);
        return view('pages.history.history_order')->with(compact('all_order', 'meta_desc','meta_keywords','meta_title','url_canonical'));
    }

    public function ViewOrderHistoryPage(Request $request,$order_code){
        $this->CustomerLogin();
 
        $meta_desc = 'History page, order';
        $meta_keywords ='history, order'; 
        $meta_title = 'Your order';
        $url_canonical = $request->url();
        
        $order = Order::where('order_code', $order_code)->first();
        
        $customer_id = $order->customer_id;
        $shipping_id = $order->shipping_id;
        
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $customer = Customer::where('customer_id',$customer_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        $order_fee = OrderDetails::where('order_code', $order_code)->pluck('order_feeship')->first();
        
        $order_coupon = "Empty";

        foreach($order_details as $key => $value){
            $order_coupon = $value->order_coupon;
        }    
        if($order_coupon != "Empty"){
            $coupon = Coupon::where('coupon_code',$order_coupon)->first();
            $coupon_method = $coupon->coupon_method;
            $coupon_rate = $coupon->coupon_rate;
        }else{
            $coupon_method = 2;
            $coupon_rate = 0;
        }
        return view('pages.history.history_detail')->with(compact('customer','shipping','order','order_details','coupon_method','coupon_rate','order_fee','meta_desc','meta_keywords','meta_title','url_canonical'));
    }
}