@extends('layout')
@section('content')


<div class="features_items">

    {{-- // SOCIAL PLUGIN FACEBOOK --}}
        <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    
    <!--features_items-->
    @foreach($cat_name as $key => $title)
    <h2 class="title text-center">{{ $title->category_name }}</h2>
    @endforeach 

    @foreach($pro_by_cat as $key => $pro)
    <a href="{{URL::to('/product-detail/'.$pro->product_slug)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" height="250"alt="">
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
    </a>
    @endforeach
</div>
@endsection 