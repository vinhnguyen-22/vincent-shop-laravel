<!DOCTYPE html>
<head>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@include("admin.partial.style")
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
    @include('admin.partial.header')
    @include('admin.partial.sidebar')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @yield('admin_content')
        </section>
    </section>
    <!-- footer -->
    @include('admin.partial.footer')
    <!-- / footer -->
    <!--main content end-->
</section>
@include('admin.partial.javascript')
@yield('scripts')
</body>
</html>
