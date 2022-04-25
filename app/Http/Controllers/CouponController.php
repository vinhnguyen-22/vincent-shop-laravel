<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }
    
    public function insertCouponPage(){
        return view('admin.coupon.create');
    }
    public function saveCoupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon();
        $exp = strtotime($data['expired']);
        $coupon->coupon_name = $data['title'];
        $coupon->coupon_rate = $data['rate'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_method = $data['method'];
        $coupon->coupon_expired = date("Y-m-d",strtotime($data['expired']));
        $coupon->coupon_start = date("Y-m-d",strtotime($data['start']));
        $coupon->save();                       
        
        session(['message'=>'Add coupon success']);
        return redirect('insert-coupon');   
    }
    public function showAllCoupon(){
        $this->AuthLogin();
        $today = Carbon::now()->format('Y-m-d');
        $list_coupon = Coupon::orderBy('coupon_id','DESC')->paginate(5);
        return view('admin.coupon.list')->with(compact('list_coupon','today'));
    }
    
    public function deleteCoupon($coupon_id){
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        session(['message'=> 'Delete success']);
        return redirect('all-coupon');
    }

    //END FUNCTION BACKEND
}   