@extends('layout')
@section('content')


<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    <div class="row">
        @foreach($all_product as $key => $allpro)
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
                                <button data-product_id="{{$allpro->product_id}}" type="button" class="btn btn-primary quick-view" data-toggle="modal" data-target="#quickViewModal" style="margin-bottom: 25px">
                                    Quick view
                                </button>
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


    <div class="category-tab">
        <form >
        @csrf
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    @php 
                        $i = 0;
                    @endphp
                    @foreach ($cat_tab as $key => $val)
                        @php
                            $i++;
                        @endphp
                        <li class="tabs_pro {{$i == 1 ? 'active':''}}" data-id="{{$val->category_id}}"><a href="#blazers" data-toggle="tab">{{$val->category_name}}</a></li>
                    @endforeach

                </ul>
            </div>
            <div id="tabs_product">

            </div>
        </form>
    </div><!--/category-tab-->
</div>


<!-- Modal -->
<div class="modal fade " style="" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 1200px; max-height: 350px;" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="quickViewModalLabel">
                <strong>
                    <span id="product_quickView_title"></span>
                </strong>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-details" style="padding:0px">
                <div class="col-sm-5">
                    <div class="lSSlideWrapper usingCss" style="transition-timing-function: ease; transition-duration: 500ms;">
                        <ul id="lightSlider">
                        
                        </ul>
                        <span id="product_quickView_image"></span>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="product-information" style="padding-top:0px">
                        <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                        <img src="images/product-details/rating.png" alt="" />
                        
                        <form action="{{url('/save-cart')}}" method="post">
                            {{ csrf_field() }} 
                            <span>
                                <span id="product_quickView_price"></span>
                                <label>Quantity:</label>
                                <form >
                                    <div id="product_quickView_inputValue">
                                    
                                    </div>
                                </form>
                            </span>
                        </form>
                        <h5><strong>Description: </strong></h5>
                        <hr>
                        <div style="max-height:200px">
                            <span id="product_quickView_desc"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary" type="button" style="color: white" name="add-to-cart">
                <a id="goToProductPage" style="color: white">
                    Go to product page
                </a>
            </button>
        </div>
    </div>
  </div>
</div>

{{$all_product->links()}}

@endsection 