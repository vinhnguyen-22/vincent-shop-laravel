<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Video;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
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

    // start statistic by revenue
    public function filterByDate(Request $request){ 
        $this->AuthLogin();
        $data = $request->all();

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $chart_data= array();

        $result = Statistic::whereBetween('order_date',[$from_date, $to_date])->orderBy('order_date','ASC')->get();
        foreach($result as $key => $val){
            $chart_data[]= array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }
    
    public function daysOrder(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $result = Statistic::whereBetween('order_date',[Carbon::now()->subDay(15)->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
        $chart_data= array();
        foreach($result as $key => $val){
            $chart_data[]= array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }
    
    public function filterByTime(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $time = $data['time'];
        switch ($time) {
            case '7days':
                $result = Statistic::whereBetween('order_date',[Carbon::now()->subDay(7)->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
                break;
            case 'thisMonth':
                $result = Statistic::whereBetween('order_date',[Carbon::now()->startOfMonth()->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
                break;
            case 'lastMonth':
                $result = Statistic::whereBetween('order_date',[Carbon::now()->subMonth()->startOfMonth()->toDateString(),Carbon::now()->subMonth()->endOfMonth()->toDateString()])->orderBy('order_date','ASC')->get();
                break;
            case 'thisYear':
                $result = Statistic::whereBetween('order_date',[Carbon::now()->subDay(365)->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
                break;
            default:
                $result = Statistic::whereBetween('order_date',[Carbon::now()->subDay(30)->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
                break;
        }
        $chart_data= array();
        foreach($result as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    // end statistic by revenue
    
    // start statistic item
    public function statisticItem(Request $request){
        //total
        $data = $request->all();
        $product = Product::all()->count();
        $post = Post::all()->count();
        $order = Order::all()->count();
        $video = Video::all()->count();
        $customer = Customer::all()->count();       
        
        $donut_data = array(
            'product' => $product,
            'post' => $post,
            'order' => $order ,
            'video' => $video ,
            'customer' => $customer,
        );
       
        echo $data = json_encode($donut_data);
    }
    // end statistic item

}