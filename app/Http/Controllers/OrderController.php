<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        
        //order date
        $order_date =  explode(" ",$order->created_at)[0];
        $statistic = Statistic::where('order_date',$order_date)->get();
        if($statistic){
            $statistic_count = $statistic->count();
        }else{
            $statistic_count = 0; 
        }
        
        $total_order = 0;
        $sales = 0;
        $profit = 0;
        $quantity = 0;

        if($order->order_status == 2){
         
            foreach($data['orderProductId'] as $key => $product_id){
                $product = Product::find($product_id); 
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                $product_price = $product->product_price;
                $product_cost = $product->product_cost;
                $now = Carbon::now()->toDateString();

                foreach($data['quantity'] as $key2 => $qty){
                    if($key ==  $key2){
                        $product->product_quantity  = $product_quantity - $qty;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();

                        //update doanh thu 
                        $quantity += $qty;
                        $total_order += 1;
                        $sales += $product_price * $qty;
                        $profit =  $sales - ($product_cost * $qty);
                    }
                }
            }
            
            // send email
            $now = Carbon::now()->format('d-m-Y H:i:s');
            $title_mail = 'Xác nhận đơn hàng đến từ VincentGaming ngày '.$now;
            $customer = Customer::where('customer_id', $order->customer_id)->first();
            $data['email'][] = $customer->customer_email;

            foreach($data['orderProductId'] as $key => $val){
                $product_mail = Product::find($val);
                foreach($data['quantity'] as $key2 => $qty){
                    $cart_array[] = array(
                        'product_name' => $product_mail['product_name'],
                        'product_price' => $product_mail['product_price'],
                        'product_qty' => $qty,
                    );
                }
            }
            
            $details = OrderDetails::where('order_code',$order->order_code)->first();
            $fee_ship = $details->order_feeship;
            $coupon_code = $details->order_coupon;
            $shipping = Shipping::where('shipping_id',$order->shipping_id)->first();
            $coupon = Coupon::where('coupon_code',$coupon_code)->first();
            
            $shipping_array = array(
                'customer_name' => $customer->customer_name, 
                'shipping_name' => $shipping->shipping_name, 
                'shipping_address' => $shipping->shipping_address, 
                'shipping_phone' => $shipping->shipping_phone, 
                'shipping_email' => $shipping->shipping_email, 
                'shipping_notes' => $shipping->shipping_notes, 
                'shipping_method' => $shipping->shipping_method, 
            );

            if($coupon_code){
                $code = array(
                    'coupon_code' => $coupon_code,
                    'coupon_method' => $coupon->coupon_method,
                    'coupon_rate' => $coupon->coupon_rate,
                    'order_feeship' =>  $fee_ship,
                    'order_code' => $order->order_code,
                    'issued' => $now
                );
            }else{
                $code = array(
                    'coupon_code' => 'Không có',
                    'order_code' => $order->order_code,
                    'issued' => $now
                );
            }
            
            Mail::send('pages.Mail.confirm_order',[
                'cart_array' => $cart_array,
                'shipping_array' => $shipping_array,
                'code' => $code], function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'],$title_mail);
            });

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

        if($statistic_count > 0){
            $statistic_update = Statistic::where("order_date",$order_date)->first();
            $statistic_update->sales += $sales;
            $statistic_update->profit += $profit;
            $statistic_update->quantity += $quantity;
            $statistic_update->total_order += $total_order;
            $statistic_update->save();
        }else{
            $statistic = new Statistic();
            $statistic->order_date = $order_date;
            $statistic->sales = $sales;
            $statistic->profit = $profit;
            $statistic->quantity = $quantity;
            $statistic->total_order = $total_order;
            $statistic->save();
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