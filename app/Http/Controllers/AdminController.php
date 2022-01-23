<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Social;
use Illuminate\Http\Request;
use Socialite;
use App\Rules\Captcha;
use Validator;
session_start();
class AdminController extends Controller
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

    public function index(){
        return view('admin_login');
    }

    public function showDashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

       $admin_email = $data['admin_email'];
       $admin_password = md5($data['admin_password']);

       $admin = Admin::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
       if($admin){
            session(['admin_name'=> $admin->admin_name]);
            session(['admin_id'=> $admin->admin_id]);
            session(['login_normal'=>true]);
            return redirect('/dashboard');
        }else{
            session(['message'=>'Password or email incorrect']);
            return redirect('/admin');
        }
    }

    public function logout(){
        $this->AuthLogin();
        session(['admin_name'=>null]);
        session(['admin_id'=>null]);
        session(['login_normal'=>false]);
        return redirect('/admin');
    }

    //LOGIN WITH FACEBOOK
    public function loginFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
            
        if($account){
            //login in Admin  
            $account_name = Admin::where('admin_id',$account->user)->first();
            session(['admin_name'=>$account_name->admin_name]);
            session(['admin_id'=>$account_name->admin_id]);
            session(['login_normal'=>true]);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $admin_login = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Admin::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Admin::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_phone' => '',
                    'admin_password' => '',
                    'admin_status' => 1
                ]);
            }
            $admin_login->login()->associate($orang);
            $admin_login->save();

            $account_name = Admin::where('admin_id',$admin_login->user)->first();
            session(['admin_name'=>$admin_login->admin_name]);
            session(['admin_id'=>$admin_login->admin_id]);
            session(['login_normal'=>true]);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }
    }
    
    //LOGIN WITH GOOGLE
    public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function callbackGoogle(){
        $users = Socialite::driver('google')->stateless()->user(); 
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google');
        
    
        if($authUser){
            $account_name = Admin::where('admin_id',$authUser->user)->first();
            session(['admin_name'=>$account_name->admin_name]);
            session(['admin_id'=>$account_name->admin_id]);
            session(['login_normal'=>true]);
        }else{
            $account_name = Admin::where('admin_id',$authUser->user)->first();
            session(['admin_name'=>$account_name->admin_name]);
            session(['admin_id'=>$account_name->admin_id]);
            session(['login_normal'=>true]);
        }

        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');  
    }
    
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $admin_new = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $orang = Admin::where('admin_email',$users->email)->first();

            if(!$orang){
                $orang = Admin::create([
                    'admin_name' => $users->name,
                    'admin_email' => $users->email,
                    'admin_password' => '',

                    'admin_phone' => '',
                    'admin_status' => 1
                ]);
            }
            $admin_new->login()->associate($orang);
            $admin_new->save();
            return $admin_new;
        }        
    }
}