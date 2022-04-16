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