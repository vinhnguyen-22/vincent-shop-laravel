@extends('layout')
@section('content')
{{-- @php 
echo "<pre>";print_r($posts);echo "</pre>";
@endphp --}}
<style type="text/css">
.post ul Li {
    padding: 2p;
    font-size: 16p;
}
.post ul li a{
  color: #000;
}
.post ul li a:hover {
  color: FE980F;
}
.post ul li {
  list-style-type: decimal-leading-zero;
}
.summary h1 {
  font-size: 20px;
  color: brown;
}
</style>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
        <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    
    <h2 class="title text-center">{{$meta_title}}</h2>

    <div class="product-image-wrapper">
    @foreach($posts as $key => $post)
        <div class="single-products" style="padding:10px">
            <p>{!!$post->post_content!!}</p>
        </div>
    @endforeach
    </div>
@endsection