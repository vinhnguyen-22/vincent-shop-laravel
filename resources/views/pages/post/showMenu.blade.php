@extends('layout')
@section('content')


<div class="features_items">

   {{-- @php 
    echo "<pre>";
    print_r($posts) ;
    echo "</pre>";
    @endphp --}}

    {{-- // SOCIAL PLUGIN FACEBOOK --}}
        <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    
    <h2 class="title text-center">List Post</h2>

    <div class="product-image-wrapper">
    @foreach($posts as $key => $post)
        <div class="single-products" style="padding:10px">
            <div class="text-left">
                <img src="{{asset('public/uploads/post/'.$post->post_thumbnail)}}" style="float:left; width: 20%; heigh: 20%; margin-right:20px" alt="">
                <h4 style="padding:5px">{{$post->post_title}}</h4>
                <p>{!!$post->post_desc!!}</p>
            </div>
            
            <div class="text-right" >
                <a href="{{url('/post-detail/'.$post->post_slug)}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" style="margin-right:10px" ></i>view</a>
            </div>
        </div>
    @endforeach

    </div>
</div>
@endsection 