@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Manage gallery: {{$product->product_name}}
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <input type="hidden" name="pro_id" class="pro_id" value="{{$product->product_id}}">
                <div class="position-center">

                    <form role="form" action="{{url('/save-gallery-product/'.$product->product_id)}}" name="galleryForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="gallery_image[]" accept="image/*" multiple id="gallery_image" >
                            <span id="error_gallery"></span>
                        </div>

                        <input type="submit" name="upload" class="btn btn-info add_image" value="upload" />
                    </form>
                </div>

                <form >
                    @csrf   
                    <div id="load-gallery">

                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection