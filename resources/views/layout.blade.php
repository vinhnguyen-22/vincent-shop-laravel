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
    <link rel="shortcut icon" href="{{asset("")}}" size="16x16">    

    
    {{-- <meta property="og:image" content="{{$image_og}}" /> --}}
    <meta property="og:site_name" content="http://localhost:81/lavarel%208/shop-vincent/" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$url_canonical}}" />
    <meta property="og:type" content="website" />
     {{-- //SEO --}}
    
    @include('pages.partial.style')
    @yield('custom_styles')
    <style type="text/css">
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background-color: #ebebeb;
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        border-radius: 10px;
        background: #6d6d6d; 
    }
    </style>

</head><!--/head-->

<body>
    @include('pages.partial.header')
    <section id="slider"><!--slider-->
        <div class="container">
            <div class=" carousel">
                <div id="slider-carousel" class=" slide" data-ride="carousel">
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
                            <div class="" style="padding: 20px; background: url({{asset('public/uploads/slider/'.$slide->slider_image)}}); background-repeat: no-repeat; background-size:100%; background-position: center">
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
    </section><!--/slider-->
    
    <section>
        <div class="container">
            <div class="row">
                @include('pages.partial.sidebar') 
                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include('pages.partial.footer')
    @include('pages.partial.javascript')

    @yield('scripts')
   </body>
</html>