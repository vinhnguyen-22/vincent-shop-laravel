<!DOCTYPE html>
<head>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> --}}
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" />
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/main.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->

<!-- dataTables -->
<link rel="stylesheet" href="{{asset('public/backend/css/responsive.dataTables.min.css')}}" type="text/css"/>
{{-- taginput --}}
<link rel="stylesheet" href="{{asset('public/backend/css/boostrap-tagsinput.css')}}" type="text/css"/>

<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}" type="text/css"/>
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="{{url('/dashboard')}}" class="logo">
        Admin
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>


<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle">
                
                <img alt="" src="{{asset('public/backend/images/2.png')}}">
               
               <?php
                $admin_name = Session::get('admin_name');
                if(Auth::user()){
                    $admin_name = Auth::user()->admin_name;
                }elseif(session()->get('login_normal')){
                    $admin_name = Session::get('admin_name');
                }
               
                if($admin_name){ ?>
                    <span class="username"><?php echo $admin_name; ?></span>                   
                <?php } ?>
               
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{url('/logout-auth')}}"><i class="fa fa-key"></i>Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{url('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @impersonate
                <li>
                    <a class="btn btn-sm btn-danger" href="{{url('/destroy-impersonate')}}">
                        Destroy Impersonate
                    </a>
                </li>
                @endimpersonate
                
                @hasrole(['admin','author'])
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>User</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{url('/insert-user')}}">Add User</a></li>
                            <li><a href="{{url('/manage-user')}}">Manage User</a></li>
                        </ul>
                    </li>
                @endhasrole
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Information</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
                        <li><a href="{{url('/insert-info')}}">Add Information</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-info')}}">List Information</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub">
                    @hasrole(['admin','author'])
                        <li><a href="{{url('/insert-slider')}}">Add Slider</a></li>
                    @endhasrole
                        <li><a href="{{url('/manage-slider')}}">Manage Slider</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Order</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('/manage-order')}}">Manage Order</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Shipping Fee</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('/delivery')}}">Manage shipping</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Coupon</span>
                    </a>
                    <ul class="sub">
                    @hasrole(['admin','author'])
                        <li><a href="{{url('/insert-coupon')}}">Add Coupon</a></li>
                    @endhasrole
                        <li><a href="{{url('/all-coupon')}}">List Coupon</a></li>
                    </ul>
                </li>
               
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
						<li><a href="{{url('/add-category-product')}}">Add</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-category-product')}}">View All</a></li>
                    </ul>
                </li>
				
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Brand</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
                        <li><a href="{{url('/add-brand-product')}}">Add</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-brand-product')}}">View All</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
						<li><a href="{{url('/add-product')}}">Add</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-product')}}">View All</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Video</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
						<li><a href="{{url('/manage-video')}}">Manage</a></li>
                        @endhasrole
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Menu Post</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
						<li><a href="{{url('/add-menu-post')}}">Add</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-menu-post')}}">View All</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Post</span>
                    </a>
                    <ul class="sub">
                        @hasrole(['admin','author'])
						<li><a href="{{url('/add-post')}}">Add</a></li>
                        @endhasrole
                        <li><a href="{{url('/all-post')}}">View All</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Comment</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('/all-comment')}}">Manage comment</a></li>
                    </ul>
                </li>
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @yield('admin_content')
        </section>
    <!-- footer -->
            <div class="footer">
                <div class="wthree-copyright">
                <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
                </div>
            </div>
    <!-- / footer -->
    </section>
    <!--main content end-->
</section>

<script type="text/javascript" src="{{asset('public/backend/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    // upload ckeditor
    CKEDITOR.replace('description-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
    CKEDITOR.replace('content-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });

    CKEDITOR.replace('description-post');
    CKEDITOR.replace('content-post');

    CKEDITOR.replace('information-contact');    
</script>


<!-- morris JavaScript -->	
{{-- <script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
</script> --}}
<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
<script type="text/javascript">
        //order category
    $("#category_order").sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            var page_id_array = new Array();
            var _token = $('input[name="_token"]').val();

            $("#category_order tr").each(function () {
                page_id_array.push($(this).attr("id"));
            });

            $.ajax({
                url: "/lavarel%208/shop-vincent/arrange-category",
                method: "post",
                data: {
                    page_id_array,
                    _token,
                },
                success: function (data) {
                    alert(data);
                },
            });
        },
    })
</script>

</body>
</html>
