@extends('layout')
@section('custom_styles')
<style type-"text/css">
   ul.nav.nav-pills.nav-justified li {
       text-align: center;
       font-size: 13px;
   }
   .btn_wishlist{
       border: none;
       background: #ffff;
       color: #83AFA8;
   }
   ul.nav.nav-pills.nav-justified i {
       color: #B3AFA8;
   }
    .btn_wishlist span:hover {
    color: #FE980F;
    }
    .btn_wishlist:focus {
    border: none;
    outline: none;
    }
</style>
@endsection
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
                            <input type="hidden" value="{{$allpro->product_name}}" id="wishlist_productname{{$allpro->product_id}}" class="cart_product_name_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_image}}" class="cart_product_image_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_price}}" id="wishlist_productprice{{$allpro->product_id}}" class="cart_product_price_{{$allpro->product_id}}">
                            <input type="hidden" value="{{$allpro->product_quantity}}" class="cart_product_stock_{{$allpro->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$allpro->product_id}}">

                            <div class="productinfo text-center">
                                <a id="wishlist_producturl{{$allpro->product_id}}" href="{{url('/product-detail/'.$allpro->product_slug)}}">
                                    <img id="wishlist_productimage{{$allpro->product_id}}" src="{{url('public/uploads/product/'.$allpro->product_image)}}" height="250" alt="">
                                    <h2>${{number_format($allpro->product_price)}}</h2>
                                    <p>{{$allpro->product_name}}</p>
                                </a>
                                <button data-id_product="{{$allpro->product_id}}" class="btn btn-primary add-to-cart" type="button" style="color: white" name="add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                                <button data-product_id="{{$allpro->product_id}}" type="button" class="btn btn-primary quick-view" data-toggle="modal" data-target="#quickViewModal" style="margin-bottom: 25px">
                                    Quick view
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                                <i class="fa fa-heart"></i>
                                <button class="btn_wishlist" id="{{$allpro->product_id}}" onclick="addWishlist(this.id);">Add to wishlist</button>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-plus-square"></i>Add to compare</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{$all_product->links()}}


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
@endsection 

@section('scripts')
    <script>
        function addToCart(id) {
        var cart_product_id = $(".cart_product_id_" + id).val();
        var cart_product_name = $(".cart_product_name_" + id).val();
        var cart_product_image = $(".cart_product_image_" + id).val();
        var cart_product_price = $(".cart_product_price_" + id).val();
        var cart_product_qty = $(".cart_product_qty_" + id).val();
        var cart_product_stock = $(".cart_product_stock_" + id).val();
        var _token = $('input[name="_token"]').val();
        if (parseInt(cart_product_stock) > parseInt(cart_product_qty)) {
            $.ajax({
                url: "/lavarel%208/shop-vincent/add-cart-ajax",
                method: "POST",
                data: {
                    cart_product_id: cart_product_id,
                    cart_product_name: cart_product_name,
                    cart_product_image: cart_product_image,
                    cart_product_price: cart_product_price,
                    cart_product_qty: cart_product_qty,
                    cart_product_stock: cart_product_stock,
                    _token: _token,
                },
                success: function () {
                    swal(
                        {
                            title: "???? th??m s???n ph???m v??o gi??? h??ng",
                            text: "B???n c?? th??? mua h??ng ti???p ho???c t???i gi??? h??ng ????? ti???n h??nh thanh to??n",
                            showCancelButton: true,
                            cancelButtonText: "Xem ti???p",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "??i ?????n gi??? h??ng",
                            closeOnConfirm: false,
                        },
                        function () {
                            window.location.href =
                                "/lavarel%208/shop-vincent/show-cart-page";
                        }
                    );
                },
            });
        } else {
            alert(
                "Please buy lower than quantity in stock " + cart_product_stock
            );
        }
    }
    </script>
@endsection