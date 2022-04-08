@extends('layout')
@section('content')
<style>
    .demo {
    width:420px;
}
ul {
    list-style: none outside none;
    padding-left: 0;
    margin-bottom:0;
}
li {
    display: block;
    float: left;
    margin-right: 6px;
    cursor:pointer;
}
img {
    display: block;
    height: auto;
    max-width: 100%;
}
</style>
@foreach ($product_details as $key => $pro_detail)
<div class="product-details"><!--product-details-->

    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    <div class="col-sm-5">
        <div class="lSSlideWrapper usingCss" style="transition-timing-function: ease; transition-duration: 500ms;">
            <ul id="lightSlider">
                @foreach($gallery as $key => $gal)
                <li data-thumb="{{asset('/public/uploads/gallery/'.$gal->gallery_image)}}">
                    <img src="{{asset('/public/uploads/gallery/'.$gal->gallery_image)}}" alt="{{$gal->gallery_name}}" />
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$pro_detail->product_name}}</h2>
            <img src="images/product-details/rating.png" alt="" />
            
            <form action="{{url('/save-cart')}}" method="post">
                {{ csrf_field() }} 
                <span>
                    <span>USD {{number_format($pro_detail->product_price)}}</span>
                    <label>Quantity:</label>
                    <input type="number" value="1" min="1" class="cart_product_qty_{{$pro_detail->product_id}}">
                    <form >
                        <input type="hidden" value="{{$pro_detail->product_id}}" class="cart_product_id_{{$pro_detail->product_id}}">
                        <input type="hidden" value="{{$pro_detail->product_name}}" class="cart_product_name_{{$pro_detail->product_id}}">
                        <input type="hidden" value="{{$pro_detail->product_image}}" class="cart_product_image_{{$pro_detail->product_id}}">
                        <input type="hidden" value="{{$pro_detail->product_price}}" class="cart_product_price_{{$pro_detail->product_id}}">
                        <input type="hidden" value="{{$pro_detail->product_quantity}}" class="cart_product_stock_{{$pro_detail->product_id}}">
                       
                        <button data-id_product="{{$pro_detail->product_id}}" class="btn btn-primary add-to-cart" type="button" style="color: white" name="add-to-cart">Add to cart</button>
                    </form>
                </span>
            </form>
            
            <p><b>Availability:</b> {{$pro_detail->product_quantity}} In Stock</p>
            <p><b>Condition:</b> New</p>
            <p><b>Brand:</b> {{$pro_detail->brand_name}}</p>
            <p><b>Category:</b> {{$pro_detail->category_name}}</p>
            
            <div style="" class="fb-share-button" data-href="http://localhost:81/lavarel%208/shop-vincent/" data-layout="button_count" data-size="small">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
            </div>
            
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
            <style type="text/css">
                a.tags-style{
                    margin:3px 2px;
                    border:1px solid #ccc;

                    height: auto;
                    background:#428bac;
                    color:#fff;
                    padding:5px;
                }
                a.tags-style:hover{
                    background:black;
                }
            </style>

            <fieldset>
                <legend>Tags</legend> 
                <p><i class="fa fa-tag">
                    @php 
                    $tags = $pro_detail->product_tags;
                    $tags = explode(",",$tags);
                    @endphp    

                    @foreach($tags as $tag)
                        <a href="{{url('/tags/'.Str::slug($tag, '-'))}}" class="tags-style">{{$tag}}</a>
                    @endforeach
                </i></p>
            </fieldset>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->
@endforeach
<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li><a href="#details" data-toggle="tab">Details</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Description</a></li>
            <li  class="active"><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade " id="details" >
           <p>{!!$pro_detail->product_content!!}</p>
        </div>
        
        <div class="tab-pane fade" id="companyprofile" >
            <p>{!!$pro_detail->product_desc!!}</p>
        </div>
        
        <div class="tab-pane fade active in"  id="reviews" >
            <div class="col-sm-12">
                <style type="text/css">
                    .style-comment {
                        border: 1px solid #ddd;
                        border-radius:10px;
                        background: #F0F0E9;
                    }
                </style>
                <form >
                    @csrf
                    <input type="hidden"  name="comment_product_id" class="comment_product_id" value="{{$pro_detail->product_id}}" id="">

                    <div id="comment-show">
                       
    
                    </div>
                </form>
                <p><b>Write Your Review</b></p>
                <form>
                    @csrf
                    <input type="text" class="form-control comment_name" placeholder="Your Name" style="margin-bottom:5px" />
                    <label for="">Content: </label>
                    <textarea name="" class="form-control comment_content"></textarea>
                    
                    <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                    <ul class="list-rating" title="average rating">
                        {{-- @for($count = 1; $count <=5; $count++) 

                            @php
                            if($count <= $rating){
                                $color = 'color:#ffcc00';
                            }else{
                                $color = 'color:#ccc';
                            }
                            @endphp
                            
                            <li title="star_rating" id="{{$pro_detail->product_id}}-{{$count}}"
                                data-index="{{$count}}"
                                data-product_id="{{$pro_detail->product_id}}"
                                data-rating="{{$rating}}" class="rating" style="cursor: pointer;
                                {{$color}}; font-size:30px; 
                                ">
                            &#9733;    
                            </li>
                        @endfor --}}
                    </ul>
                    
                    <button data-id_product="{{$pro_detail->product_id}}" type="button" class="btn btn-default pull-right send-comment">
                        Send
                    </button>
                </form>
            </div>
            <div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="20"></div>
        </div>
        
    </div>
</div><!--/category-tab-->

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">recommended items</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">	
                @foreach ($related_products as $key => $related_pro)
                <a href="{{url('/product-detail/'.$related_pro->product_slug)}}">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{url('public/uploads/product/'.$related_pro->product_image)}}" width="50" height="250"alt="" />
                                    <h2>${{number_format($related_pro->product_price)}}</h2>
                                    <p>{{$related_pro->product_name}}</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>             
                @endforeach
            </div>
           
        </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>			
    </div>
</div><!--/recommended_items-->
@endsection