<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\ShippingFee;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DeliveryController extends Controller
{
    public function insertDeliveryPage(Request $request){   
        $province = Province::orderBy('matp','ASC')->get();
        $district = District::orderBy('maqh','ASC')->get();
        $ward = Ward::orderBy('xaid','ASC')->get();
        return view('admin.shippingfee.create')->with(compact('district','ward','province'));
    }   

    public function selectDelivery(Request $request){
        $data = $request->all();
        if($data['action']){
            if($data['action'] == 'province'){
                $select_district = District::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                echo '<option value="">--choose--</option>';
                foreach($select_district as $key => $district){
                    echo '<option value="'.$district->maqh.'">'.$district->district_name.'</option>';
                }
            }else{
                $select_ward = Ward::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                echo '<option value="">--choose--</option>';
                foreach($select_ward as $key => $ward){
                    echo '<option value="'.$ward->xaid.'">'.$ward->ward_name.'</option>';
                }
            }
        }
    }

    public function saveDelivery(Request $request){
        $data = $request->all();
        $fee_ship = new ShippingFee;
        $fee_ship->fee_matp = $data['province'];
        $fee_ship->fee_maqh = $data['district'];
        $fee_ship->fee_xaid = $data['ward'];
        $fee_ship->fee_shippingfee = $data['feeShip'];
        $fee_ship->save();
    }
}