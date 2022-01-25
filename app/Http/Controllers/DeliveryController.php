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
        return view('admin.shippingfee.manageShippingFee')->with(compact('district','ward','province'));
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

    public function selectFeeShip(){
        $fee_ship = ShippingFee::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '
        <div class="table-responsive">
            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>Province</th>
                        <th>District</th>
                        <th>Ward</th>
                        <th>Shipping Fee</th>
                    </tr>
                </thread>
                
                <tbody>';
                foreach ($fee_ship as $key => $fee) {
                    $output .='
                    <tr>
                        <td>'.$fee->province->province_name.'</td>
                        <td>'.$fee->district->district_name.'</td>
                        <td>'.$fee->ward->ward_name.'</td>
                        <td contenteditable class="feeShipEdit" data-fee_ship_id="'.$fee->fee_id.'">'.number_format($fee->fee_shippingfee,0,',','.').'</td>
                    </tr>
                    ';
                }
                
        $output .= '
                </tbody>
            </table>
        </div>';
        echo $output;
    }

    public function updateFeeShip(Request $request){
        $data = $request->all();
        $fee_ship = ShippingFee::find($data['feeId']);
        $fee_ship->fee_shippingfee = rtrim($data['feeValue'],'.');
        $fee_ship->save();
    }
    //END BACKEND FUNCTIONS
    public function selectDeliveryFE(Request $request){
        $this->selectDelivery($request);
    }

    public function calculateFee(Request $request){
        $data = $request->all();
        if($data['province']){
            $fee_ship = ShippingFee::where('fee_matp', $data['province'])->where('fee_maqh' , $data['district'])->where('fee_xaid',$data['ward'])->get();
            foreach($fee_ship as $key => $fee){
                session(['fee'=>$fee->fee_shippingfee]);
                session()->save();
            }
        }
    }

    public function deleteFee(){
        session()->forget('fee');
        return redirect()->back()->with('message', 'Delete fee success');
    }
}