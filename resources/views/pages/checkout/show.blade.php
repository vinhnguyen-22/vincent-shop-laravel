@extends('layout')
@section('content')
<section id="cart_items">
    <div class="">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Checkout</li>
            </ol>
        </div>
      
        <div class="shopper-informations">
            <div class="row"> 
                <div class="col-sm-12 clearfix">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message')}}
                        </div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-danger">
                            {{session()->get('error')}}
                        </div>
                    @endif
                    <div class="table-responsive cart_info">
                        <form action="{{url('/update-cart')}}" method="POST">
                            {{csrf_field()}}
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="cart_menu">
                                        <td class="image">Image</td>
                                        <td class="description">Name</td>
                                        <td  d class="price">Unit price</td>
                                        <td class="quantity">Quatity</td>
                                        <td class="total">Price</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                        // echo '<pre>'; print_r(Session::get('cart')); echo '</pre>';
                                    @endphp
                                    @if(Session::get('cart'))
                                        @foreach(Session::get('cart') as $key => $cart)
                                            @php
                                                $subtotal = $cart['product_price']*$cart['product_qty'];
                                                $total+=$subtotal;  
                                            @endphp

                                        <tr>
                                            <td class="cart_product" style="width:200px">
                                                <img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
                                            </td>
                                            <td class="cart_description">
                                                <h4><a href=""></a></h4>
                                                <p>{{$cart['product_name']}}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>${{number_format($cart['product_price'],0,',','.')}}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">                            
                                                    <input class="cart_quantity" style="width:30%" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >
                                                </div>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    ${{number_format($subtotal,0,',','.')}}
                                                </p>
                                            </td>
                                            <td class="cart_delete" style="width:50px">
                                                <a class="cart_quantity_delete" href="{{url('/delete-item/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <button class="btn btn-default btn-sm">
                                                    <a href="{{url('/delete-all-item')}}" name="delete_all" >Delete All</a>
                                                </button>
                                            </td>
                                            <td>
                                                <input type="submit" value="Update cart" name="update_qty" class="btn btn-default btn-sm checkout">
                                            </td>
                                        </tr>
                                    @else
                                        <td colspan="5" style="text-align:center">
                                            @php
                                                echo "Go shopping now"
                                            @endphp
                                        </td>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>	

                <div class="col-md-12 clearfix">
                    <div class="bill-to">
                        <p>Fill in shipping information</p>
                        <div class="form-one">
                            <form method="POST">
                                @csrf
                                <input type="text"  name="shipping_email" class="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Full name *">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Address *">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone">
                                <textarea name="shipping_notes" class="shipping_notes" placeholder="Notes about your order, Special Notes for Delivery" rows="5"></textarea>
                                <div class="review-payment">
                                    <h2>Review &amp; Payment</h2>
                                    <select id="payment_select" class="form-control input-sm m-bot15 optionSelect payment_select" name="payment_select">
                                        <option value="0">By cash</option>
                                        <option value="1">Direct Bank Transfer</option>
                                        <option value="2">Paypal</option>
                                    </select>
                                </div>

                                
                                @if(session()->get('fee'))
                                <input type="hidden" name="order_fee" class="order_fee" value="{{session()->get('fee')}}">
                                @else
                                <input type="hidden" name="order_fee" class="order_fee" value="10">
                                @endif

                                
                                @if(session()->get('coupon'))
                                    @foreach(session()->get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                    @endforeach
                                @else
                                <input type="hidden" name="order_coupon" class="order_coupon" value="Empty" >
                                @endif

                                <input type="button" value="Confirm Order" name="send_order" class="btn btn-primary btn-sm send_order">
                                <div id="paypal-button"></div>
                            </form>
                        </div>
                        
                        <div class="form-two">
                            <form >
                                @csrf
                                <div class="form-group">
                                    <label for="">Province</label>
                                    <select id="province" class="form-control input-sm m-bot15 optionSelect province" name="province">
                                        <option value="0">--choose--</option>
                                        @foreach($province as $key => $val)
                                        <option value="{{$val->matp}}">{{$val->province_name}}</option>
                                        @endforeach;
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="">District</label>
                                    <select id="district" class="form-control input-sm m-bot15 optionSelect district" name="district">
                                        <option value="0">--choose--</option>
                                        @foreach($district as $key => $val)
                                        <option value="{{$val->maqh}}">{{$val->district_name}}</option>
                                        @endforeach;
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Ward</label>
                                    <select id="ward" class="form-control input-sm m-bot15 ward" name="ward">
                                        <option value="0">--choose--</option>
                                        @foreach($ward as $key => $val)
                                        <option value="{{$val->xaid}}">{{$val->ward_name}}</option>
                                        @endforeach;
                                    </select>
                                </div>
                                <input type="button" value="Calculate Shipping Fee" name="calculate_shipping_fee" class="btn btn-primary btn-sm calculate_shipping_fee">
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="total_area">
                                    <ul>
                                        <li>Sub Total <span>${{number_format($total,0,',','.')}}</span></li>
                                        @if(session()->get('coupon'))
                                        <li>Coupon: <span>
                                            @foreach(session()->get('coupon') as $key => $cou)
                                                @if($cou['coupon_method'] == 1)
                                                    Decrease ${{$cou['coupon_rate']}}
                                                    <span style="margin-left: 5px">
                                                        @php 
                                                        $total =  $total - $cou['coupon_rate'];
                                                        @endphp
                                                        total coupon: {{number_format(($total),0,',','.')}}
                                                    </span>
                                                @elseif($cou['coupon_method'] == 2)
                                                    Decrease {{$cou['coupon_rate']}}%
                                                    <span style="margin-left: 5px">
                                                        @php
                                                        $total_coupon = ($total * $cou['coupon_rate'])/100;
                                                        $total =  $total - $total_coupon;                                                    
                                                       @endphp
                                                        total coupon: {{number_format(($total_coupon),0,',','.')}}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </span></li>
                                        @endif
                                        <li>Eco Tax <span>${{number_format((0.1 * $total),0,',','.')}}</span></li>
                                        @php
                                            $total = 1.1 * $total; 
                                        @endphp
                                        @if(session()->get('fee'))
                                        @php
                                            $total =  $total + session()->get('fee');
                                        @endphp
                                        <li>
                                            <a class="cart_quantity_delete" href="{{url('/delete-fee')}}"><i class="fa fa-times"></i></a>
                                            Shipping Cost <span>{{number_format(session()->get('fee'),0,',','.')}}</span>
                                        </li>
                                        @endif
                                        <input type="hidden" class="order_total" name="order_total" value="{{$total}}" id="order_total">
                                        <li>Total <span >${{number_format(($total),0,',','.')}}</span></li>
                                        @if(session()->get('cart'))
                                        <br>
                                        <form method="POST" action="{{url('/check-coupon')}}">
                                            {{csrf_field()}}
                                                <input type="text" class="form-control" placeholder="Enter coupon" name="coupon" id=""> <br>
                                            @if(session()->get('coupon'))
                                                <button class="btn btn-default btn-md">
                                                    <a href="{{url('/delete-all-coupon')}}" name="delete_all" >Delete all coupon</a>
                                                </button>
                                            @endif
                                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Confirm Coupon">
                                        </form>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection

@section('scripts')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    //papal payment
    var total = document.getElementById('order_total').value;
  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox:  'AY6sDShCSG15m9x0z23XTbElwux-ukCxPk0tJ8mymah-vPAqr_CTCGP2_Am12uC2TSEFZMWv1DFoSGa4' ,
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'large',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
                total: `${total}`,
                currency: 'USD'
            }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
        window.alert('Thank you for your purchase!');
      });
    }
  }, '#paypal-button');

</script>
@endsection