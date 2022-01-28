<!DOCTYPE html>
<head>
<title>Order Detail</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body{
        font-family: 'DejaVu Sans';
    }
</style>
</head>
<body>
<div class="table-agile-info ">
    <div class="panel panel-default">
        <h2 class="panel-heading">
            Information customer
        </h2>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" border="1" cellspacing="0">
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
        <h2 class="panel-heading">
            Information Shipping
        </h2>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light"  border="1" cellspacing="0">
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
        <h2 class="panel-heading">
            Order Details
        </h2>
     
        <div class="row w3-res-tb">
            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th style="padding:10px">Product</th>
                    <th style="padding:10px">Quantity</th>
                    <th style="padding:10px">Unit</th>
                    <th style="padding:10px">Coupon Code</th>
                    <th style="padding:10px">Total price</th>
                </tr>             
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order_details as $key => $detail)
                @php $total += $detail->product_price * $detail->product_sales_quantity ; @endphp
                <tr>
                    <td  style="padding:10px" >{{$detail->product_name}}</td>
                    <td  style="padding:10px" align="center">{{$detail->product_sales_quantity}}</td>
                    <td  style="padding:10px" align="center">${{number_format(($detail->product_price),0,',','.')}}</td>
                    <td  style="padding:10px" align="center">{{$detail->order_coupon}}</td>
                    <td  style="padding:10px" align="center">${{number_format(($detail->product_price * $detail->product_sales_quantity),0,',','.')}}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="padding:20px" colspan="7" align="left">
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
            </tbody>
        </table>
    </div>
</div>
</body>
</html>