<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
class OrderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function manageOrder(){
        $this->AuthLogin();
        $all_order = Order::orderby('created_at','DESC')->paginate(5);
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
        return view('admin.order.viewOrder')->with(compact('customer','shipping','order','order_details','coupon_method','coupon_rate','order_fee'));
    }

    public function printOrder($order_code){
        $this->AuthLogin();        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->printOrderConvert($order_code));
        return $pdf->stream();
    }
    
    public function printOrderConvert($order_code){
        $this->AuthLogin();        
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
        return view('admin.order.orderPDF')->with(compact('customer','shipping','order','order_details','coupon_method','coupon_rate','order_fee'));
    }

    public function updateOrderQty(Request $request){
        $this->AuthLogin();        
        $data = $request->all();
        $order = Order::find($data['orderId']);
        $order->order_status = $data['orderStatus'];
        $order->save();
         
        if($order->order_status == 2){
            foreach($data['orderProductId'] as $key => $product_id){
                $product = Product::find($product_id); 
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                foreach($data['quantity'] as $key2 => $qty){
                    if($key ==  $key2){
                        $product->product_quantity  = $product_quantity - $qty;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();
                    }
                }
            }
        }elseif($order->order_status != 2 && $order->order_status != 1 && $order->order_status != 3 ){
            foreach ($data['orderProductId'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                foreach ($data['quantity'] as $key2 => $qty) {
                    if($key == $key2){
                        $product_remain = $product_quantity + $qty;
                        $product->product_quantity = $product_remain;
                        $product->product_sold = $product_sold - $qty;
                        $product->save();
                    }
                }
            }
        }
    }
    
    public function updateQty(Request $request){
        $this->AuthLogin();        
        $data = $request->all();
        $order_details = OrderDetails::where('product_id',$data['orderProductId'])->where('order_code',$data['orderCode'])->first();

        $order_details->product_sales_quantity = $data['orderQty'];
        $order_details->save();         
    }
}