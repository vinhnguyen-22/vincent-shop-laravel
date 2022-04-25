<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function sendMail(){
       $to_name = 'Vincent DEV';
       $from_email = 'vincentazure.dev@gmail.com';
       $to_email = 'vinhnguyenad22@gmail.com'; 

       $data = array("name"=>"Mail từ khách hàng","body"=>"mail gửi về vấn đề hàng hóa");

        Mail::send('pages.Mail.sendMail', $data, function ($message) use ($to_name,$to_email,$from_email) {
            $message->from($from_email, $to_name);
            $message->to($from_email)->subject('Quên mật khẩu Admin GamingStore.com');//send this mai1 with subject
        });
        return redirect('/')->with('message','');
    }

    public function sendCoupon($coupon_name,$coupon_rate,$coupon_code,$coupon_time,$coupon_method,$coupon_expired,$coupon_start){
        $customer = Customer::where('customer_vip','!=',1)->get();
        $now = Carbon::now()->format('d-m-Y H:i:s');
        $title_mail = "Coupon code for ".$now;
        $data = [];
        
        foreach($customer as $cus){
            $data['email'][] =$cus->customer_email; 
        }
        $coupon = array(
            'coupon_name' => $coupon_name,
            'coupon_rate' => $coupon_rate,
            'coupon_code' => $coupon_code,
            'coupon_time' => $coupon_time,
            'coupon_method' => $coupon_method,
            'coupon_expired' => $coupon_expired,
            'coupon_start' => $coupon_start,
        );

        Mail::send('pages.Mail.send_coupon',['coupon' => $coupon], function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
        return redirect()->back()->with('message', 'Send mail successfully');
    }

    public function sendCouponVip($coupon_name,$coupon_rate,$coupon_code,$coupon_time,$coupon_method,$coupon_expired,$coupon_start){
        $customer_vip = Customer::where('customer_vip',1)->get();
        $now = Carbon::now()->format('d-m-Y H:i:s');
        $title_mail = "Coupon code for ".$now;
        $data = [];
        
        foreach($customer_vip as $vip){
            $data['email'][] =$vip->customer_email; 
        }

        $coupon = array(
            'coupon_name' => $coupon_name,
            'coupon_rate' => $coupon_rate,
            'coupon_code' => $coupon_code,
            'coupon_time' => $coupon_time,
            'coupon_method' => $coupon_method,
            'coupon_expired' => $coupon_expired,
            'coupon_start' => $coupon_start,
        );

        Mail::send('pages.Mail.send_coupon_vip',['coupon' => $coupon], function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
        return redirect()->back()->with('message', 'Send mail successfully');
    }
    public function mailExample(){
        return view('pages.Mail.send_coupon');
    }
}