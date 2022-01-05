@extends('layout')
@section('content')


<div class="features_items">
    <!--features_items-->
    @foreach($brand_name as $key => $title)
    <h2 class="title text-center">{{ $title->brand_name }}</h2>
    @endforeach

    @foreach($pro_by_brand as $key => $pro)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" width="100" height="250"alt="">
                    <h2>${{number_format($pro->product_price)}}</h2>
                    <p>{{$pro->product_name}}</p>
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
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
@endsection 