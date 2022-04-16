@extends('admin.admin_layout')
@section('admin_content')
 <?php
    $message = Session::get('message');
    if($message){
    echo '<h3 class="text-alert text-alert-warning">' .$message. '</h3>';
        Session::put('message' , null);    
    }
?>
<div class="container-fluid" style="background-color:#fff">
    <style type="text/css">
        p.title-chart{
            text-align: center;
            font-size:20px;
            font-weight:bold;
        }
    </style>    
    <div class="row">
        <p class="title-chart">Statistic By Revenues</p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>From day: <input type="text" id="from-date" class="form-control"></p>
                <br>
                <input type="button" value="Result" id="btn-filter" class="btn btn-primary btn-sm">
            </div>

            <div class="col-md-2">
                <p>To day: <input type="text" id="to-date" class="form-control"></p>
            </div>

            <div class="col-md-2">
                <p>
                    Filter by
                    <select name="" class="form-control filter_by" id="">
                        <option value="">-- Choose --</option>
                        <option value="7days">The past 7 days</option>
                        <option value="thisMonth">This month</option>
                        <option value="lastMonth">Last month</option>
                        <option value="thisYear">This year</option>
                    </select>
                </p>
            </div>
        </form>

        <div class="col-md-12">
            <div id="revenue-charts" style="height: 250px;"></div>
        </div>
    </div>

    <div class="row">
        <style type="text/css">
            table.table.table-bordered.table-dark{
                background: #32383e
            }
            table.table.table-bordered.table-dark tr th{
                color:#fff;
            }
        </style>
        <p class="title-chart">Statistical access</p>
        <table class="table table-bordered table-dark m-2">
            <thead>
                <tr>
                    <th>Online</th>
                    <th>Total in last month</th>
                    <th>Total in this month</th>
                    <th>Total in this year</th>
                    <th>Total access</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$visitor_count}}</td>
                    <td>{{$visitor_lastmonth_count}}</td>
                    <td>{{$visitor_thismonth_count}}</td>
                    <td>{{$visitor_year_count}}</td>
                    <td>{{$visitor_total}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-md-4 col-xs-12">
            <p class="title-chart">Statistic total item in website</p>

            <form autocomplete="off">
                @csrf
                <div id="donut-quantity-item" style="height: 250px;"></div>
            </form>
        </div>
        
        <div class="col-md-8">
            <p class="title-chart">Statistic total product and post</p>

            <div class="col-md-4 col-xs-12">
                <ol>
                @foreach($product_views as $key => $value)
                    <li><a href="{{url('/product-detail/'.$value->product_slug)}}" target="_blank">{{$value->product_name}} | <span style="color:coral">({{$value->product_views}})</span></a></li>
                @endforeach
                </ol>
            </div>

            <div class="col-md-4 col-xs-12">
                <ol>
                @foreach($post_views as $key => $value)
                    <li><a href="{{url('/post-detail/'.$value->post_slug)}}" target="_blank">{{$value->post_title}} | <span style="color:coral">({{$value->post_views}})</span></a></li>
                @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection 