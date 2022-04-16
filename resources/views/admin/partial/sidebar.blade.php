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