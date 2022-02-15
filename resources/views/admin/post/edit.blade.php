@extends('admin_layout')
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
                    <form role="form" action="{{URL::to('/update-post/'.$edit_post->post_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" value="{{$edit_post->post_title}}" name="title" id="title" placeholder="Enter title post">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{ $edit_post->post_slug }}" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" value="{{$edit_post->post_author}}" name="author" id="author" placeholder="Enter author post">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea id="description-post" class="form-control" name="desc" id="description">
                                {{$edit_post->post_desc}}
                            </textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea id="content-post" class="form-control" name="content" id="content">
                                {{$edit_post->post_content}}
                            </textarea>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea style="resize:none" id="keywords-post" class="form-control" name="keywords" required>
                                {{$edit_post->post_keywords}}
                            </textarea>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="">Menu</label>
                            <select class="form-control input-sm m-bot15" name="menuPost" required>
                                @foreach($menu_post as $key => $value)
                                <option value="{{$value->menu_post_id}}" {{$value->menu_post_id == $edit_post->menu_post_id ? 'selected' : ''}}>{{$value->menu_post_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="thumbnail">Image</label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail" placeholder="Enter image post">
                        </div>
                        <div class="form-group col-lg-6">
                            <img src="{{URL::to('public/uploads/post/'.$edit_post->post_thumbnail)}}" width="100" height="100" alt="">
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