<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;

class AuthController extends Controller
{
    public function logoutAuth(){
        Auth::logout();
        session(['login_normal'=>0]);
        return view('admin.auth.login')->with('message','Logout success');
    }

    public function loginAuth(Request $request){
        $this->validate($request,[
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'g-recaptcha-response' => new Captcha(), 	//dòng kiểm tra Captch
        ]);
        if(Auth::attempt(['admin_email'=> $request->email,'admin_password'=> $request->password])){
            return redirect('/dashboard');
        }else{
            return redirect('/login-auth')->with('message','Incorrect email or password');
        }
    }

    public function showLoginAuth(){
        return view('admin.auth.login');
    }

    public function validation($request){
        return $this->validate($request,[
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'g-recaptcha-response' => new Captcha(), 	//dòng kiểm tra Captch
        ]);
    }

    public function registerAuth(Request $request){
        $this->validation($request);
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['name'];
        $admin->admin_email = $data['email'];
        $admin->admin_phone = $data['phone'];
        $admin->admin_password = md5($data['password']);
        $admin->save();
        return redirect('/register-auth')->with('message', 'Sign up success');
    }

    public function showRegisterAuth(){
        return view('admin.auth.register');
    }
}