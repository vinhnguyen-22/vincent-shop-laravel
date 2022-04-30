<!DOCTYPE html>
<head>
<title>Admin login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
{{-- <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> --}}
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/main.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css')}}"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
</head>
<body>
<div class="log-w3">
<div class="w3layouts-main">
	<h2>Register Now</h2>
    <?php 
    $message = Session::get('message');
    if($message){
        echo '<div class="text-alert">'.$message.'</div>';
        Session::put('message',null);
    }
    ?>
    <form action="{{url('/register')}}" method="post">
        @csrf
        @foreach($errors->all() as $val)
            <li>
                {{$val}} <br>
            </li>
        @endforeach
        <input type="text" class="ggg" value="{{old('name')}}" name="name" placeholder="FULL NAME" >
        <input type="text" class="ggg" value="{{old('email')}}" name="email" placeholder="E-MAIL" >
        <input type="tel" class="ggg" value="{{old('phone')}}" name="phone" placeholder="PHONE" >
        <input type="password" class="ggg" name="password" placeholder="PASSWORD" >
        <input type="password" class="ggg" name="confirm_password" placeholder="CONFIRM PASSWORD" >
        <div class="g-recaptcha" style="margin: 60px auto 0px auto;" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
        <div class="clearfix"></div>

        <input type="submit" value="Register" name="register">
        
        <br/>
    </form>
    <a href="{{url('/login-facebook')}}" class="">Login Facebook |</a>
    <a href="{{url('/login-google')}}" class="">Login Google |</a>
    <a href="{{url('/login-auth')}}" class="">Login Auth |</a>
    <a href="{{url('/register-auth')}}" class="">Register Auth</a>    
</div>
</div>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
</body>
</html>
