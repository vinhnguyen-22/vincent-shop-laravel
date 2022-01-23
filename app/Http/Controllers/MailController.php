<?php

namespace App\Http\Controllers;

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
}