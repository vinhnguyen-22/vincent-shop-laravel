<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
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
    public function insertCouponPage(){
        return view('admin.coupon.create');
    }
    public function saveCoupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon();
     
        $coupon->coupon_name = $data['title'];
        $coupon->coupon_rate = $data['rate'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_method = $data[ 'method'];
        $coupon->save();                       
        
        session(['message'=>'Add coupon success']);
        return redirect('insert-coupon');   
    }
    public function showAllCoupon(){
        $this->AuthLogin();
        $list_coupon = Coupon::orderBy('coupon_id','DESC')->get();
        return view('admin.coupon.list')->with(compact('list_coupon'));
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