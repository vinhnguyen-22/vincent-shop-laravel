<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    {{-- //SEO --}}
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}">
    <meta name="author" content="">
    <title>{{$meta_title}}</title>
    <link rel="canonical" href="{{$url_canonical}}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="INDEX, FOLLOW"/>
     <link rel="shortcut icon" href="https://vanilla.futurecdn.net/pcgamer/392738/favicon.ico" size="16x16">    
    
    
    {{-- <meta property="og:image" content="{{$image_og}}" /> --}}
    <meta property="og:site_name" content="http://localhost:81/lavarel%208/shop-vincent/" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$url_canonical}}" />
    <meta property="og:type" content="website" />
     {{-- //SEO --}}
  
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lightslider.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/frontend/css/sweetalert.css')}}">
    <!-- price range -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{asset('public/frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('public/frontend/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('public/frontend/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('public/frontend/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('public/frontend/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="logo pull-left" >
                            <a href="{{url('/')}}" style="color: darkcyan"><img src="{{asset('public/uploads/info/'.$logo->info_img)}}" style="border-radius:50%; margin-right:10px" width="50" height="50"alt="" /><b>VINCENT GAMING</b></a>
                        </div>
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                    USA
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canada</a></li>
                                    <li><a href="#">UK</a></li>
                                </ul>
                            </div>
                            
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                    DOLLAR
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canadian Dollar</a></li>
                                    <li><a href="#">Pound</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <?php 
                                $customer_id = Session::get('customer_id');
                                $shipping_id = Session::get('shipping_id');
                                $customer_name = Session::get('customer_name');
                                
                                if($customer_id != null){ ?>
                                    <li><a href=""><i class="fa fa-user"></i> {{$customer_name}}</a></li>                                    
                                <?php }?>
                                
                                <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                                <li><a href="{{url('/show-contact')}}">Contact</a></li> 

                                <li><a href="
                                    @if($shipping_id == null)
                                    {{url('/checkout')}}
                                    @else
                                    {{url('/payment')}}
                                    @endif

                                    "><i class="fa fa-crosshairs"></i> Checkout</a></li>

                                <li><a href="{{url('/show-cart-page')}}"="{{url('/show-cart-page')}}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                <?php 
                                if($customer_id != null){ ?>
                                    <li><a href="{{url('/customer-logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>                                    
                                <?php } else{ ?>
                                    <li><a href="{{url('/login-checkout')}}"><i class="fa fa-lock"></i> Login</a></li>                                    
                                <?php }  ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->
    
        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{url('/home')}}" class="active">Home</a></li>
                               
                                <li class="dropdown"><a href="#">News<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach($catsPost as $key => $value)
                                        <li><a href="{{url('/menu-post/'.$value->menu_post_slug)}}">{{$value->menu_post_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li> 
                                <li><a href="{{url('/show-cart-page')}}">Cart</a></li>
                                <li><a href="{{url('/video-page')}}">Videos</a></li>
                                <li><a href="{{url('/show-contact')}}">Contact</a></li> 

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{url('/s')}}" autocomplete="off" method="post">
                            {{csrf_field()}}
                            <div class="search_box">
                                <input type="text" name="search_box" style="width:70%; resize:none;" placeholder="Search" id="search-box"/>
                                <input type="submit" style="margin-top:0px; width:20%; color:white" name="search_items" value="Search" class="btn btn-primary btn-sm">
                                <div id="keywords-box" >
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->
    
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @php $j = 0; @endphp
                            @foreach($slider as $key => $slide)
                            @php $j++; @endphp
                            <li data-target="#slider-carousel" data-slide-to="{{ $j - 1 }}" class="{{$j == 1 ? 'active': '' }}"></li>
                            @endforeach
                        </ol>
                        
                        <div class="carousel-inner">
                            @php $i = 0; @endphp
                            @foreach($slider as $key => $slide)
                            @php $i++; @endphp
                            <div class="item {{$i == 1 ? 'active': '' }}" >
                                <div class="col-sm-12" style="padding: 20px; background: url({{asset('public/uploads/slider/'.$slide->slider_image)}}); background-repeat: no-repeat; background-size:100%; background-position: center">
                                    <h1 style="color:white;"><span>Vincent</span>-Gaming</h1>
                                    <h2 style="color:white;">{{$slide->slider_name}}</h2>
                                    <p style="color:white;">{{$slide->slider_desc}} </p>
                                    <button type="button" class="btn btn-info get"><a style="color:white" href="/{{$slide->slider_slug}}">GO NOW</a></button>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section><!--/slider-->
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                            @foreach($cats as $key => $cat)
                                @if($cat->category_parentId == 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->category_slug}}">
                                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                    {{$cat->category_name}}
                                                </a>
                                            </h4>
                                        </div>

                                        <div id="{{$cat->category_slug}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul>
                                                    @foreach($cats as $key => $cat_sub)
                                                        @if($cat_sub->category_parentId == $cat->category_id)
                                                            <li><a href="{{url('category-product/'.$cat_sub->category_slug)}}"> {{$cat_sub->category_name}}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div><!--/category-products-->
                    
                        <div class="brands_products"><!--brands_products-->
                            <h2>Brands</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($brands as $key => $brand)
                                    <li><a href="{{url('brand-product/'.$brand->brand_slug)}}"> <span class="pull-right">(50)</span>{{$brand->brand_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!--/brands_products-->
                      
                        <div id="row_wishlist">
                            <h2>Wishlist</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    
    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <?php  for($i =1; $i < 4; $i++){ ?>
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{asset('public/frontend/images/iframe1.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="images/map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Service</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                                <li><a href="#">Change Location</a></li>
                                <li><a href="#">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Quock Shop</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">T-Shirt</a></li>
                                <li><a href="#">Mens</a></li>
                                <li><a href="#">Womens</a></li>
                                <li><a href="#">Gift Cards</a></li>
                                <li><a href="#">Shoes</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">Billing System</a></li>
                                <li><a href="#">Ticket System</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Company Information</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Store Location</a></li>
                                <li><a href="#">Affillate Program</a></li>
                                <li><a href="#">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Your email address" />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...</p>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>
        
    </footer><!--/Footer-->
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{asset('public/frontend/js/sweetalert.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontend/js/prettify.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
    <script type="text/javascript">
        //wishlist with localStorage
        function addWishlist(clicked_id) {
            var id = clicked_id;
            var url = document.getElementById("wishlist_producturl" + id).href;
            var name = document.getElementById("wishlist_productname" + id).value;

            var price = document.getElementById(
                "wishlist_productprice" + id
            ).value;
            var image = document.getElementById("wishlist_productimage" + id).src;

            var newItem = {
                url,
                id,
                name,
                price,
                image,
            };
            if (localStorage.getItem("data") == null) {
                localStorage.setItem("data", "[]");
            }
            var oldData = JSON.parse(localStorage.getItem("data"));
            //grep : Tìm các phần tử của một mảng thỏa mãn chức năng lọc. Các mảng ban đầu không bị ảnh hưởng.
            const matches = $.grep(oldData, function (obj) {
                // khi click vào sản phẩm thì sẽ có id và so sánh với id của oldData
               return obj.id == id;
            });

            if (matches.length) {
                alert("Item loved");
            } else {
                oldData.push(newItem);

                $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+newItem.image+'" width="100%"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><a href="'+newItem.url+'">Đặt hàng</a></div></div>');
            }
            localStorage.setItem("data", JSON.stringify(oldData));
        }

        function viewWishlist() {
            if (localStorage.getItem("data") != null);
            var data = JSON.parse(localStorage.getItem("data"));
            data.reverse();
            document.getElementById("row_wishlist").style.overflow = "scroll";
            document.getElementById("row_wishlist").style.height = "600px";
            for (i = 0; i < data.length; i++) {
                var url = data[i].url;
                var name = data[i].name;
                var price = data[i].price;
                var image = data[i].image;
                $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+image+'"width="100%"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+'</p><a href="'+url+'">Đặt hàng</a></div></div>');
            }
        }
        viewWishlist();
    </script>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat"
    attribution='setup_tool'
    page_id="113066507098247"
    theme color="#ff7e29"
    logged_in_greet ing="Hi bạn! Chào mừng bạn đến Shop"
    logged out_greeting="Hi bạn! Chào mừng bạn đến Shop"
    >
        
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "131939792730877");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=1542262152832776&autoLogAppEvents=1" nonce="xg4YUwcD"></script>
</body>
</html>