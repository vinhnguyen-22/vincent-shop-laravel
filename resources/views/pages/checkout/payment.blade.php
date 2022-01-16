@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Checkout cart</li>
            </ol>
        </div>
        
        <div class="review-payment">
            <h2>Review &amp; Cart</h2>
        </div>
        
        <div class="table-responsive cart_info">
            <?php 
                $content = Cart::content();    
            ?>
            
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $key => $cart_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$cart_content->options->image)}}" width="100" height="100"alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart_content->name}}</a></h4>
                            <p>{{$cart_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>${{number_format($cart_content->price)}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-qty')}}" method="post">
                                    {{csrf_field()}}
                                    {{-- <a class="cart_quantity_up" href=""> + </a> --}}
                                    <input class="cart_quantity_input" type="text" name="cart_qty" value="{{$cart_content->qty}}" autocomplete="off" size="2">
                                    {{-- <a class="cart_quantity_down" href=""> - </a> --}}
                                    <input type="hidden" name="rowId_cart" value="{{$cart_content->rowId}}">
                                    <input type="submit" value="update" name="update_qty" class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">${{number_format($cart_content->price * $cart_content->qty)}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$cart_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <h4 style="margin:40px;font-size:20px">Choose payment</h4>
        <form action="{{URL::to('/order-place')}}" method="post">
                {{csrf_field()}}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> By Cash</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3 " type="checkbox"> Paypal</label>
                </span>
                <input type="submit" value="Order" name="send_order_place" class="btn btn-primary btn-sm">
            </div>
        </form>
        
    </div>
</section>
@endsection