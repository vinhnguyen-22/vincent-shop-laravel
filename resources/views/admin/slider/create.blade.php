@extends('admin_layout')
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
                    <form role="form" id="productForm" action="{{url('/save-slider')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title category">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="desc" required>

                            </textarea>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter image product">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="">Status</label>
                                <select class="form-control input-sm m-bot15" name="status" required>
                                    <option value="0">Hide</option>
                                    <option value="1">Show</option>
                            </select>
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