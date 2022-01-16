<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cart;
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
        $admin_id = Session::get('admin_id');

        if(!$admin_id){
            return Redirect::to('admin')->send();
        }else{
            return Redirect::to('dashboard');
        }
    }

    public function loginCheckout(){        
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.login')->with('cats',$cat_product)->with('brands', $brand_product);
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
        
    public function customerSignup(Request $request){
        
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
    
    public function checkoutPage (){        
        $this->CustomerLogin();
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        return view('pages.checkout.show')->with('cats',$cat_product)->with('brands', $brand_product);
    }
    
    public function saveCheckoutCustomer(Request $request){
        $data = array();
        
        $data['customer_id'] =  Session::get('customer_id');;
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        return Redirect('/payment'); 
    }

    public function paymentPage(){
        $this->CustomerLogin();
        $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        return view('pages.checkout.payment')->with('cats',$cat_product)->with('brands', $brand_product);
    }

    public function orderPlace(Request $request){
        //insert payment method
        $this->CustomerLogin();
        $data = array();
        
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 0;
    
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order payment
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 0;
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        
        //insert order details payment
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] =$v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }

        if($data['payment_method'] == 1){
            echo 'Bank';
        }elseif($data['payment_method'] == 2){
            Cart::destroy();

            $cat_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

            return view('pages.checkout.handCash')->with('cats',$cat_product)->with('brands', $brand_product);
        } else {
            echo 'Paypal';
        }
    }

    //Backend functionality
    
    public function manageOrder (){
        $this->AuthLogin();
        
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();

        $manager_order = view('admin.order.manage')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.order.manage',$manager_order);
    }

    public function viewOrder($order_id){
        $this->AuthLogin();
        
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*')
        ->where('tbl_order.order_id', $order_id)
        ->first();      
          
        $detail_by_orderId = DB::table('tbl_order')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order_details.*')
        ->where('tbl_order.order_id', $order_id)
        ->get();  
      
        // echo '<pre>';
        // print_r($detail_by_orderId);
        // echo '</pre>';

        $order_details = view('admin.order.viewOrder')->with('order_by_id',$order_by_id)->with('detail_by_orderId',$detail_by_orderId);
        return view('admin_layout')->with('admin.order.viewOrder',$order_details);
    }
}