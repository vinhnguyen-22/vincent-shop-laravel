<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;

class OrderController extends Controller
{
    public function AuthLogin(){
        if(session()->get('login_normal')){
            $admin_id = session()->get('admin_id');
        }else{
            $admin_id = session()->get('admin_id');
        }
        if($admin_id){
            return redirect('dashboard');
        }else{
            return redirect('admin')->send();
        }
    }

    public function manageOrder(){
        $this->AuthLogin();
        $all_order = Order::orderby('created_at','DESC')->get();
        return view('admin.order.manage')->with(compact('all_order'));
    }
    
    public function viewOrderDetails($order_code){
        $this->AuthLogin();        
        $order = Order::where('order_code', $order_code)->first();
        
        $customer_id = $order->customer_id;
        $shipping_id = $order->shipping_id;
        
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $customer = Customer::where('customer_id',$customer_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();

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
        return view('admin.order.viewOrder')->with(compact('customer','shipping','order','order_details','coupon_method','coupon_rate'));
    }
    public function printOrder(){
        
    }
}