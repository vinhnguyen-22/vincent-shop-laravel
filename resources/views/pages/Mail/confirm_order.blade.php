<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">

@import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
*{
  margin: 0;
  box-sizing: border-box;

}
body{
  background: #E0E0E0;
  font-family: 'Roboto', sans-serif;
  background-image: url('');
  background-repeat: repeat-y;
  background-size: 100%;
}
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: 1em;
  color: #666;
  line-height: 1.2em;
}

#invoiceholder{
  width:100%;
  padding-top: 50px;
}
#headerimage{
  z-index:-1;
  position:relative;
  height: 350px;
  overflow:hidden;
  background-attachment: fixed;
  background-size: 1920px 80%;
  background-position: 50% -90%;
}
#invoice{
  position: relative;
  top: -290px;
  margin: 0 auto;
  width: 700px;
  background: #FFF;
}

[id*='invoice-']{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
  padding: 30px;
}

#invoice-top{min-height: 120px;}
#invoice-mid{min-height: 120px;}
#invoice-bot{ min-height: 250px;}

.logo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  float:left;
  margin-left: 20px;
}
.title{
  float: right;
}
.title p{text-align: right;}
#project{margin-left: 52%;}
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  padding: 5px 0 5px 15px;
  border: 1px solid #EEE
}
.tabletitle{
  padding: 5px;
  background: #EEE;
}
.service{border: 1px solid #EEE;}
.item{width: 50%;}
.itemtext{font-size: .9em;}

#legalcopy{
  margin-top: 30px;
}
form{
  float:right;
  margin-top: 30px;
  text-align: right;
}


.effect2
{
  position: relative;
}
.effect2:before, .effect2:after
{
  z-index: -1;
  position: absolute;
  content: "";
  bottom: 15px;
  left: 10px;
  width: 50%;
  top: 80%;
  max-width:300px;
  background: #777;
  -webkit-box-shadow: 0 15px 10px #777;
  -moz-box-shadow: 0 15px 10px #777;
  box-shadow: 0 15px 10px #777;
  -webkit-transform: rotate(-3deg);
  -moz-transform: rotate(-3deg);
  -o-transform: rotate(-3deg);
  -ms-transform: rotate(-3deg);
  transform: rotate(-3deg);
}
.effect2:after
{
  -webkit-transform: rotate(3deg);
  -moz-transform: rotate(3deg);
  -o-transform: rotate(3deg);
  -ms-transform: rotate(3deg);
  transform: rotate(3deg);
  right: 10px;
  left: auto;
}



.legal{
  width:70%;
}
</style>
</head>
<body>
    <div id="invoiceholder">
        <div id="headerimage"></div>
            <div id="invoice" class="effect2">
                <div id="invoice-top">
                <div class="logo"></div>
                <div class="info">
                    <h2>Vincent Gaming</h2>
                    <p> vincentgaming@elaravel.dev.abc.com</br>
                    </p>
                </div><!--End Info-->
                <div class="title">
                    <h1>Xác nhận giao hàng đến từ shop VincentGaming:</h1>
                    <p>Đơn hàng đã được giao đi cho bên vẫn chuyển cám ơn bạn đã sử dụng dịch vụ</p>
                    <p>Hãy cho chúng tôi biết về cảm nhận khi sử dụng sản phẩm dưới phần comment</p>
                    <h1>Invoice: {{$code['order_code']}}</h1>
                    <p>Issued: {{$code['issued']}}</br>
                    </p>
                </div><!--End Title-->
                </div><!--End InvoiceTop-->
                
                <div id="invoice-mid">
                
                <div class="clientlogo"></div>
                <div class="info">
                    <h2>{{$shipping_array['shipping_name']}}</h2>
                    <p>{{$shipping_array['shipping_email']}}</p>
                    <p>{{$shipping_array['shipping_phone']}}</p>
                    <p>{{$shipping_array['shipping_address']}}</p>
                </div>

                <div id="project">
                    <h2>Notes</h2>
                    <p>{{$shipping_array['shipping_notes']}}</p>
                    @if ($shipping_array['shipping_method'] == 0)
                        <p>Payment in cash</p>
                    @elseif($shipping_array['shipping_method'] == 1)
                        <p>Payment in bank</p>
                    @endif
                </div>   

                </div><!--End Invoice Mid-->
                
                <div id="invoice-bot">
                
                <div id="table">
                    <table>
                        <tbody>
                            <tr>
                                <td>Customer</td>
                                <td>{{$shipping_array['customer_name']}}</td>
                            </tr>
                        </tbody>
                    </table>
                        
                    <table >
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Coupon Code</th>
                                <th>Total price</th>
                            </tr>             
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart_array as $key => $detail)
                            @php $total += $detail['product_price'] * $detail['product_qty']; @endphp
                            <tr >
                                <td>{{$detail['product_name']}}</td>
                                <td>{{$detail['product_qty']}}</td>
                                <td>${{number_format(($detail['product_price']),0,'.',',')}}</td>
                                <td>{{$code['coupon_code']}}</td>
                                <td>${{number_format(($detail['product_price'] * $detail['product_qty']),0,'.',',')}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="7" align="left">
                                    <ul style="list-style:none">
                                        <li >Sub Total: ${{number_format(($total),0,'.',',')}}</li>
                                        <li>Coupon: <span>
                                            @if($code['coupon_method'] == 1)
                                                Decrease ${{$code['coupon_rate']}}
                                                <span style="margin-left: 5px">
                                                    @php 
                                                    $total =  $total - $code['coupon_rate'];
                                                    @endphp
                                                    total coupon: {{number_format(($total),0,'.',',')}}
                                                </span>
                                            @elseif($code['coupon_method'] == 2)
                                                Decrease {{$code['coupon_rate']}}%
                                                <span style="margin-left: 5px">
                                                    @php
                                                    $total_coupon = ($total * $code['coupon_rate'])/100;
                                                    $total =  $total - $total_coupon;                                                    
                                                    @endphp
                                                    total coupon: {{number_format(($total_coupon),0,'.',',')}}
                                                </span>
                                            @endif
                                        </span></li>
                                        <li>Feeship: ${{number_format(($code['order_feeship']),0,'.',',')}}</li>
                                        @php $total += $code['order_feeship'] @endphp
                                        <li>Total: ${{number_format(($total),0,'.',',')}}</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--End Table-->
                <div>
                    <p style="color:cornflowerblue; text-align:center; font-size:15px">
                        Xem lại lịch sử đơn hàng đã đặt tại:
                        <a href="{{'/history-order'}}" style="color:coral">Lịch sử đơn hàng</a>
                    </p>
                </div>

                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="QRZ7QTM9XRPJ6">
                <input type="image" src="http://michaeltruong.ca/images/paypal.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                </form>
                <div id="legalcopy">
                    <p class="legal"><strong>Thank you for your business!</strong> </p>
                </div>
            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
    </div><!-- End Invoice Holder-->
</body>
</html>
