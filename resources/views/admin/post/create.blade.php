@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Post
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
                    <form role="form" id="postForm" action="{{url('/save-post')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label>
                            <input value="{{old('name')}}" type="text" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title post">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="slug">Slug</label>
                            <input value="{{old('slug')}}" type="text" class="form-control" name="slug" id="slug" placeholder="Enter title post">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="author">Author</label>
                            <input value="{{old('author')}}" type="text" class="form-control" name="author" id="author" placeholder="Enter author" required >
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea value="{{old('desc')}}" id="description-post" class="form-control" name="desc" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea value="{{old('content')}}"  id="content-post" class="form-control" name="content" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea value="{{old('keywords')}}"  style="resize:none" id="keywords-post" class="form-control" name="keywords" required></textarea>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Menu</label>
                            <select class="form-control input-sm m-bot15" name="menuPost" required>
                                @foreach($menu_post as $key => $value)
                                <option value="{{$value->menu_post_id}}">{{$value->menu_post_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="">Status</label>
                                <select class="form-control input-sm m-bot15" name="status" required>
                                    <option value="0">Hide</option>
                                    <option value="1">Show</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="thumbnail">Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail" placeholder="Enter thumbnail post">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="document">Document </label>
                            <input type="file" class="form-control" name="document" id="document" placeholder="Enter image product">
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" name="add" class="btn btn-info">Add</button>  
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // upload ckeditor
    CKEDITOR.replace('description-post',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
    CKEDITOR.replace('content-post',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
</script>
@endsection