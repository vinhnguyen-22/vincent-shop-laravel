
@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Manage video
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center">

                    <form role="form" action="{{url('/save-video')}}" name="videoForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug video_title" data-slug="slug" name="title" id="title" placeholder="Enter title">
                        </div>
                        
                        <div class="form-group col-lg-12 col-lg-12">
                            <label for="slug">Slug</label>
                            <input value="{{old('slug')}}" type="text" class="form-control video_slug" name="slug" id="slug" placeholder="Enter title post">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="link">Link</label>
                            <input type="text" class="form-control video_link" name="link" id="link" placeholder="Enter link">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control video_desc" name="desc" id="description">

                            </textarea>
                        </div>

                         <div class="form-group">
                            <label for="image">Thumbnail</label>
                            <input type="file" class="form-control" name="video_image" accept="image/*" id="video_image" >
                        </div>
                        
                        <input type="button" name="add" class="btn btn-info add-video" value="Create" />
                    </form>

                    <span id="error_gallery"></span>

                </div>

                <form >
                    @csrf   
                    <div id="load-video">

                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

 <!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="modal-video-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
@endsection