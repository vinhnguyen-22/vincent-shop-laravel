@extends('layout')
@section('content')
{{-- @php 
echo "<pre>";print_r($posts);echo "</pre>";
@endphp --}}
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
    {{-- // SOCIAL PLUGIN FACEBOOK --}}
    

<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    <div class="row">
        @foreach($videos as $key => $video)
            <div class="col-sm-4" style="max-height:470px">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <form >
                            <div class="productinfo text-center">
                                <a href="{{url('/video-detail/'.$video->video_slug)}}">
                                    <img src="{{url('public/uploads/video/'.$video->video_image)}}" height="250" alt="">
                                    {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/v9_K_6VQMDg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                                    <p>{{$video->video_title}}</p>
                                </a>{{-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a> --}}
                                 <button type="button" data-video_id="{{$video->video_id}}" class="btn btn-primary btn-sm view-video" data-toggle="modal" data-target="#viewVideoModal">
                                    Watch
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            {{-- <li><a href="#"><i class="fa fa-plus-square"></i>Xem</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{$videos->links()}}
<div class="modal fade bd-example-modal-lg" id="viewVideoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding:0px" id="">
            </div>
            <div class="modal-video-view">
            </div>
        </div>
    </div>
</div>
@endsection
