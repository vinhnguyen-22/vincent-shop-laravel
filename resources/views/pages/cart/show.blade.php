@extends('layout')
@section('content')

<section id="cart_items">
    <div class="">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
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
                            <a href=""><img src="{{url('public/uploads/product/'.$cart_content->options->image)}}" width="100" height="100"alt=""></a>
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
                                <form action="{{url('/update-cart-qty')}}" method="post">
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
                            <a class="cart_quantity_delete" href="{{url('/delete-to-cart/'.$cart_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ucrane</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                            
                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Dillih</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                        
                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Sub Total <span>${{Cart::priceTotal()}}</span></li>
                        <li>Eco Tax <span>${{
                        Cart::tax()}}</span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span>${{Cart::total()}}</span></li>
                        
                    </ul>
                        {{-- <a class="btn btn-default update" href="">Update</a> --}}
                        <?php 
                        $shipping_id = Session::get('shipping_id');
                        ?>
                        <a class="btn btn-default check_out" href="
                        @if($shipping_id == null)
                        {{url('/checkout')}}
                        @else
                        {{url('/payment')}}
                        @endif
                        ">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->


@endsection 