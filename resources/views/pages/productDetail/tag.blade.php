@extends('layout')
@section('content')

<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Tag {{$product_tag}}</h2>
    <div class="row">
        @foreach($pro_tag as $key => $pro)
            <div class="col-sm-4" style="max-height:470px">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <form >
                            <input type="hidden" value="{{$pro->product_id}}" class="cart_product_id_{{$pro->product_id}}">
                            <input type="hidden" value="{{$pro->product_name}}" class="cart_product_name_{{$pro->product_id}}">
                            <input type="hidden" value="{{$pro->product_image}}" class="cart_product_image_{{$pro->product_id}}">
                            <input type="hidden" value="{{$pro->product_price}}" class="cart_product_price_{{$pro->product_id}}">
                            <input type="hidden" value="{{$pro->product_quantity}}" class="cart_product_stock_{{$pro->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$pro->product_id}}">

                            <div class="productinfo text-center">
                                <a href="{{URL::to('/product-detail/'.$pro->product_slug)}}">
                                    <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" height="250" alt="">
                                    <h2>${{number_format($pro->product_price)}}</h2>
                                    <p>{{$pro->product_name}}</p>
                                </a>
                                {{-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a> --}}
                                <button data-id_product="{{$pro->product_id}}" class="btn btn-primary add-to-cart" type="button" style="color: white" name="add-to-cart">Add to cart</button>
                            </div>
                        </form>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{$pro_tag->links()}}
</div>
@endsection