
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
            {!! session()->get('message')!!}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {!!session()->get('error')!!}
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
        
        <div style="margin-top:20px">
            <a class="btn btn-default checkout" href="
            <?php 
                $shipping_id = Session::get('shipping_id');
                ?>
            @if($shipping_id == null)
            {{URL::to('/checkout')}}
            @else
            {{URL::to('/payment')}}
            @endif
            ">Check Out</a>
        </div>    
    </div>
</section> <!--/#cart_items-->


@endsection 