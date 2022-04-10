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
    <div class="row" style="margin-bottom: 10px; border:1px solid darkcyan">
        
        <div class="col-md-4">
            <label for="amount">Order by: </label>
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">-- none --</option>
                    <option value="{{Request::url()}}?sort_by=asc">Price ascending</option>
                    <option value="{{Request::url()}}?sort_by=desc">Price descending</option>
                    <option value="{{Request::url()}}?sort_by=az"> A-Z </option>
                    <option value="{{Request::url()}}?sort_by=za"> Z-A </option>
                </select>
            </form>
        </div>

        <div class="col-md-4" >  
            <form >
                @csrf
                <p >
                    <label for="amount">Price range:</label>
                    <input type="hidden" name="" id="min" value="{{$min}}">
                    <input type="hidden" name="" id="max" value="{{$max}}">
                    
                    <input type="hidden" name="min_price" id="min_price" value="{{$min}}" >
                    <input type="hidden" name="max_price" id="max_price" value="{{$max}}">
                    
                    <input type="text" id="amount" readonly style="width:50%;border:0; color:#f6931f; font-weight:bold;">
                    <input type="submit" name="filter_price" style="margin-top:5px; border-radius:10px" value="filter" class="btn btn-sm btn-primary">
                    <div id="slider-range"></div>
                </p>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($pro_by_cat as $key => $allpro)
            <div class="col-sm-4" style="max-height:470px">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <form >
                            <input type="hidden" value="{{$allpro->product_id}}" class="cart_product_id_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_name}}" class="cart_product_name_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_image}}" class="cart_product_image_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_price}}" class="cart_product_price_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_quantity}}" class="cart_product_stock_{{$allpro->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$allpro->product_id}}">

                            <div class="productinfo text-center">
                                <a href="{{url('/product-detail/'.$allpro->product_slug)}}">
                                    <img src="{{url('public/uploads/product/'.$allpro->product_image)}}" height="250" alt="">
                                    <h2>${{number_format($allpro->product_price)}}</h2>
                                    <p>{{$allpro->product_name}}</p>
                                </a>
                                {{-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a> --}}
                                <button data-id_product="{{$allpro->product_id}}" class="btn btn-primary add-to-cart" type="button" style="color: white" name="add-to-cart">Add to cart</button>
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
</div>
@endsection 