@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info ">
    <div class="panel panel-default">
        <div class="panel-heading">
            Information customer
        </div>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$customer->customer_name}}</td>
                    <td>{{$customer->customer_phone}}</td>
                    <td>{{$customer->customer_email}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Information Shipping
        </div>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Notes</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$shipping->shipping_name}}</td>
                    <td>{{$shipping->shipping_email}}</td>
                    <td>{{$shipping->shipping_address}}</td>
                    <td>{{$shipping->shipping_phone}}</td>
                    <td>{{$shipping->shipping_notes}}</td>
                    @if ($shipping->shipping_method == 0)
                        <td>By cash</td>
                    @elseif($shipping->shipping_method == 1)
                        <td>Bank</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
</div>
    

<br><br>

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Order Details
        </div>
     
        <div class="row w3-res-tb">
            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Coupon Code</th>
                    <th>Total price</th>
                </tr>             
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order_details as $key => $detail)
                @php $total += $detail->product_price * $detail->product_sales_quantity ; @endphp
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{$detail->product_name}}</td>
                    <td>{{$detail->product_sales_quantity}}</td>
                    <td>${{number_format(($detail->product_price),0,',','.')}}</td>
                    <td>{{$detail->order_coupon}}</td>
                    <td>${{number_format(($detail->product_price * $detail->product_sales_quantity),0,',','.')}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" align="left">
                        <ul style="list-style:none">
                            <li >Sub Total: ${{number_format(($total),0,',','.')}}</li>
                            <li>Coupon: <span>
                                @if($coupon_method == 1)
                                    Decrease ${{$coupon_rate}}
                                    <span style="margin-left: 5px">
                                        @php 
                                        $total =  $total - $coupon_rate;
                                        @endphp
                                        total coupon: {{number_format(($total),0,',','.')}}
                                    </span>
                                @elseif($coupon_method == 2)
                                    Decrease {{$coupon_rate}}%
                                    <span style="margin-left: 5px">
                                        @php
                                        $total_coupon = ($total * $coupon_rate)/100;
                                        $total =  $total - $total_coupon;                                                    
                                        @endphp
                                        total coupon: {{number_format(($total_coupon),0,',','.')}}
                                    </span>
                                @endif
                            </span></li>
                            <li>Tax: 10%</li>
                            <li>Feeship: ${{number_format(($order_fee),0,',','.')}}</li>
                            <li>Total: ${{number_format(($order->order_total),0,',','.')}}</li>
                        </ul>
                    </td>
                </tr>
                <tr colspan="6" align="right">
                    <td>
                        <a target="_blank" class="btn btn-info" href="{{url('/print-order/'.$order->order_code)}}">Print</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        
    </div>
</div>
@endsection