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
                <div class="col-md-4">
                    <div class="logo pull-left" >
                        <a href="{{url('/')}}" style="color: darkcyan"><img src="{{asset('public/uploads/info/'.$logo->info_img)}}" style="border-radius:50%; margin-right:10px" width="50" height="50"alt="" /><b>VINCENT GAMING</b></a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <?php 
                            $customer_id = Session::get('customer_id');
                            $shipping_id = Session::get('shipping_id');
                            $customer_name = Session::get('customer_name');
                            $customer_avatar = Session::get('customer_avatar');
                            
                            if($customer_id != null){ ?>
                                <li><a href="">
                                    @if($customer_avatar)
                                        <img src="{{$customer_avatar}}" style="width:30px; border-radius:50%" alt="">
                                    @else
                                        <i class="fa fa-user"></i> 
                                    @endif
                                    {{$customer_name}}</a></li>                                    
                            <?php }?>
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
                                <li><a href="{{url('/history-order')}}"><i class="fa fa-history"></i>Order history</a></li>
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
                            <div id="keywords-box" ></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->