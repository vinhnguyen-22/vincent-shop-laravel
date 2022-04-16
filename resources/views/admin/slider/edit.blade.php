@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Slider
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center row">
                    <form role="form" action="{{url('/update-slider/'.$edit_slider->slider_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" value="{{$edit_slider->slider_name}}" name="title" id="title" placeholder="Enter title slider">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{ $edit_slider->slider_slug }}" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea id="description-slider" class="form-control" name="desc" id="description">
                                {{$edit_slider->slider_desc}}
                            </textarea>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter image slider">
                        </div>
 
                        <div class="form-group col-lg-6">
                            <img src="{{url('public/uploads/slider/'.$edit_slider->slider_image)}}" width="100" height="100" alt="">
                        </div>
                        
                        <div class="col-lg-12">
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection