@extends('layout')
@section('content')


<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    @foreach($all_product as $key => $allpro)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <form >

                        <input type="hidden" value="{{$allpro->product_id}}" class="cart_product_id_{{$allpro->product_id}}">
                        <input type="hidden" value="{{$allpro->product_name}}" class="cart_product_name_{{$allpro->product_id}}">
                        <input type="hidden" value="{{$allpro->product_image}}" class="cart_product_image_{{$allpro->product_id}}">
                        <input type="hidden" value="{{$allpro->product_price}}" class="cart_product_price_{{$allpro->product_id}}">
                        <input type="hidden" value="1" class="cart_product_qty_{{$allpro->product_id}}">

                        <div class="productinfo text-center">
                            <a href="{{URL::to('/product-detail/'.$allpro->product_slug)}}">
                                <img src="{{URL::to('public/uploads/product/'.$allpro->product_image)}}" height="250"alt="">
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
<!--features_items-->
{{-- 
<div class="category-tab">
    <!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tshirt" data-toggle="tab">T-Shirt</a></li>
            <li><a href="#blazers" data-toggle="tab">Blazers</a></li>
            <li><a href="#sunglass" data-toggle="tab">Sunglass</a></li>
            <li><a href="#kids" data-toggle="tab">Kids</a></li>
            <li><a href="#poloshirt" data-toggle="tab">Polo shirt</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tshirt">
            <?php  for($i =1; $i < 5; $i++){ ?>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="tab-pane fade" id="blazers">
            <?php  for($i =1; $i < 5; $i++){ ?>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="tab-pane fade" id="sunglass">
            <?php  for($i =1; $i < 5; $i++){ ?>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="tab-pane fade" id="kids">
            <?php  for($i =1; $i < 5; $i++){ ?>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="tab-pane fade" id="poloshirt">
            <?php  for($i =1; $i < 5; $i++){ ?>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!--/category-tab-->

<div class="recommended_items">
    <!--recommended_items-->
    <h2 class="title text-center">recommended items</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <?php  for($i =1; $i < 4; $i++){ ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add
                                    to cart</a>
                            </div>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="item">
                <?php  for($i =1; $i < 4; $i++){ ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add
                                    to cart</a>
                            </div>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div> --}}
<!--/recommended_items-->
@endsection 