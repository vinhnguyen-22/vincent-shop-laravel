<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    //
    public function filterByDate(Request $request){ 
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
        $data = $request->all();
        $result = Statistic::whereBetween('order_date',[Carbon::now()->subDay(30)->toDateString(),Carbon::now()->toDateString()])->orderBy('order_date','ASC')->get();
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
}