@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Product
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
                    <form role="form" action="{{url('/update-menu-post/'.$edit_menu_post->menu_post_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="name">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" value="{{$edit_menu_post->menu_post_name}}" name="name" id="name" placeholder="Enter name post">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{ $edit_menu_post->menu_post_slug }}" name="slug" id="slug" placeholder="Enter name category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea id="description-menu-post" class="form-control" name="desc" id="description">{{$edit_menu_post->menu_post_desc}}</textarea>
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