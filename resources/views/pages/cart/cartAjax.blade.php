
@extends('layout')
@section('content')

<section id="cart_items">
    <div class="">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
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
                                <td class="cart_delete">
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
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        @php
                            echo '<pre>';
                            print_r(session()->get('coupon'));
                            echo '</pre>';
                        @endphp
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
                                        total coupon: {{number_format(($cou['coupon_rate']),0,',','.')}}
                                    </span>
                                @elseif($cou['coupon_method'] == 2)
                                    Decrease {{$cou['coupon_rate']}}%
                                    <span style="margin-left: 5px">
                                        @php 
                                        $total_coupon = ($total*$cou['coupon_rate'])/100;
                                        $total =  $total - $total_coupon;
                                        @endphp
                                        total coupon: {{number_format(($total_coupon),0,',','.')}}
                                    </span>
                                @endif
                            @endforeach
                        </span></li>
                        @endif
                        <li>Eco Tax <span>${{number_format((0.1 * $total),0,',','.')}}</span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span>${{number_format((1.1 * $total),0,',','.')}}</span></li>
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
                   
                    <?php 
                    $shipping_id = Session::get('shipping_id');
                    ?>
                    {{-- <div style="margin-top:20px">
                        <a class="btn btn-default checkout" href="
                        @if($shipping_id == null)
                        {{URL::to('/checkout')}}
                        @else
                        {{URL::to('/payment')}}
                        @endif
                        ">Check Out</a>
                    </div>     --}}
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

@endsection 