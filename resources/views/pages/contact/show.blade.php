@extends('layout')
@section('content')
<div class="features_items">
    <h2 class="title text-center">Contact Us</h2>
    
    <div class="row">
        @foreach($informations as $key => $info)
        <div class="col-md-12">

            <p>{!!$info->info_contact!!}</p>
            <p>{!!$info->info_fanpage!!}</p>
        </div>
        <div class="col-md-12">
           {!!$info->info_map!!}
        </div>
        @endforeach
    </div>
@endsection