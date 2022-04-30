<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Social;
use App\Models\SocialCustomer;
use App\Models\Video;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Rules\Captcha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
session_start();
class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = null;
        if(session()->get('login_normal')){
            $admin_id = session()->get('admin_id');
        }elseif(Auth::id()){
            $admin_id = Auth::id();
        }
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('admin')->send();
        }
    }

    public function index(){
        return view('admin.admin_login');
    }

    public function showDashboard(Request $request){
        $this->AuthLogin();
        //get IP address
        $user_ip_address = $request->ip();
        $start_last_month = Carbon::now()->subMonth()->startOfMonth()->toDateString ();
        $end_of_last_month = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $start_this_month = Carbon::now()->startOfMonth()->toDateString ();
        $oneyears = Carbon::now()->subdays(365)->toDateString();
        $now = Carbon::now()->toDateString();
        
        //total last month
        $visitor_of_lastmonth = Visitor::whereBetween('date_visit',[$start_last_month,$end_of_last_month])->get();
        $visitor_lastmonth_count = $visitor_of_lastmonth->count();

        //total this month
        $visitor_of_thismonth = Visitor::whereBetween('date_visit',[$start_this_month,$now])->get();
        $visitor_thismonth_count = $visitor_of_thismonth->count();
        
        //total in one year
        $visitor_of_year = Visitor::whereBetween('date_visit',[$oneyears,$now])->get();
        $visitor_year_count = $visitor_of_year->count();

        //current online
        $visitor_current = Visitor::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitor_current->count();
        
        //check ip trùng nhỏ hơn 1
        if($visitor_count < 1){
            $visitor = new Visitor();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visit = $now;
            $visitor->save();
        }

        $visitor = Visitor::all();
        $visitor_total = $visitor->count();

        $product_views = Product::orderBy('product_views','DESC')->take(20)->get();
        $post_views = Post::orderBy('post_views','DESC')->take(20)->get();
        
        return view('admin.dashboard', compact(
            'visitor_total',
            'visitor_count',
            'visitor_thismonth_count',
            'visitor_lastmonth_count',
            'visitor_year_count',
            'product_views',
            'post_views'
        ));
    }

    public function dashboard(Request $request){
        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
        ]);

        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);

        $admin = Admin::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if($admin){
           $login_count = $admin->count();
            if($login_count > 0){    
                session(['admin_name'=> $admin->admin_name]);
                session(['admin_id'=> $admin->admin_id]);
                session(['login_normal'=>true]);
                return redirect('/dashboard');
            }
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
                'provider_user_email' => $users->email,
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

    //LOGIN GOOGLE CLIENT
    public function loginCustomerGoogle(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }

    public function callbackCustomerGoogle(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        $users = Socialite::driver('google')->stateless()->user(); 
        $authUser = $this->findOrCreateCustomer($users,'google');
        if($authUser){
            $account = Customer::where('customer_id',$authUser->user)->first();
            session(['customer_name'=>$account->customer_name]);
            session(['customer_id'=>$account->customer_id]);
            session(['customer_avatar'=>$account->customer_avatar]);
        }elseif(isset($customer_new)){
            $account = Customer::where('customer_id',$authUser->user)->first();
            session(['customer_name'=>$account->customer_name]);
            session(['customer_id'=>$account->customer_id]);
            session(['customer_avatar'=>$account->customer_avatar]);
        }

        return redirect('/login-checkout')->with('message', 'Đăng nhập thành công');
    }

     public function findOrCreateCustomer($users,$provider){
        $authUser = SocialCustomer::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
             $customer_new = new SocialCustomer([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);

            $orang = Customer::where('customer_email',$users->email)->first();

            if(!$orang){
                $orang = Customer::create([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_avatar' => $users->avatar,
                    'customer_password' => '',
                    'customer_phone' => ''
                ]);
            }
            $customer_new->customer()->associate($orang);
            $customer_new->save();
            return $customer_new;
        }        
    }

    //LOGIN FACEBOOK CLIENT
    public function loginCustomerFacebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackCustomerFacebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        $provider = Socialite::driver('facebook')->user();
        $account = SocialCustomer::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
            
        if($account != null) {
            //login in Admin  
            $account_name = Customer::where('customer_id',$account->user)->first();
            session(['customer_name'=>$account_name->customer_name]);
            session(['customer_id'=>$account_name->customer_id]);
            return redirect('/login-checkout')->with('message', 'Đăng nhập Customer thành công');
        }else{

            $customer_login = new SocialCustomer([
                'provider_user_id' => $provider->getId(),
                'provider_user_email' => $provider->getEmail() ?? '',
                'provider' => 'facebook'
            ]);

            $orang = Customer::where('customer_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Customer::create([
                    'customer_name' => $provider->getName(),
                    'customer_email' => $provider->getEmail() ?? '',
                    'customer_avatar' => '',
                    'customer_phone' => '',
                    'customer_password' => '',
                ]);
            }
            $customer_login->customer()->associate($orang);
            $customer_login->save();

            $account_name = Customer::where('customer_id',$customer_login->user)->first();
            session(['customer_name'=>$customer_login->customer_name]);
            session(['customer_id'=>$customer_login->customer_id]);
            return redirect('/login-checkout')->with('message', 'Đăng nhập Customer thành công');
        }
    }
}