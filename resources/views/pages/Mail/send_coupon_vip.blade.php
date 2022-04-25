<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Code example</title> 

    <style type="text/css">
        body {
            font-family:Arial, Helvetica, sans-serif;
        }
        .coupon {
            border:5px dotted cornflowerblue;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }
        .container {
            padding:2px 16px;
            background-color: #f1f1f1
        }

        .promo {
            background-color: #ccc;
            padding:3px;
        }
        .expire {
            color: coral;
        }
        p.code{
            text-align: center;
            font-size:20px;
        }
        p.expire{
            text-align: center;
        }
        h2.note{
            text-align: center;
            font-size:large;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="coupon">
        <div class="container">
            <h3>Mã khuyến mãi dành cho khách hàng từ shop:<a href="https://vincentgaming.dev/lavarel%208/shop-vincent/" type="_blank">Vincent Gaming</a></h3>
        </div>

        <div class="container" style="background-color:white">
            <h2 class="note"><b><i>Giảm 
                @if($coupon['coupon_method'] == 2)
                    {{$coupon['coupon_rate']}}%
                @else
                    ${{number_format($coupon['coupon_rate'],0,',','.')}}
                @endif
             cho tổng đơn hàng</i></b></h2>
            <p>Qúy khách đã từng mua hàng tại shop 
                <a href="https://vincentgaming.dev/lavarel%208/shop-vincent/" target="_blank" style="color:coral">
                    VincentGaming
                </a>
            </p>
            Nếu qúy khách đã có tài khoản xin vui lòng <a href="https://vincentgaming.dev/lavarel%208/shop-vincent/" target="_blank">Đăng nhập</a>
            vào tài khoản để mua hàng và nhập mã code phía dưới để được giảm giá mua hàng, xin cảm ơn quý khách. Chúc quý khách thật nhiều sức khỏe trong cuộc sống
        </div>
        <div class="container">
            <p class="code">Sử dụng code sau <span class="promo">{{$coupon['coupon_code']}}</span>
            Với chỉ {{$coupon['coupon_time']}} mã giảm giá, nhanh tay kẻo hết
            </p>
            <p class="expire">Ngày bắt đầu: {{$coupon['coupon_start']}} / Ngày hết hạn: {{$coupon['coupon_expired']}}</p>
        </div>
    </div>
</body>
</html>
