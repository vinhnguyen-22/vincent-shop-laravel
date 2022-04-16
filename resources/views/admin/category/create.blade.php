@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Category
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
                    <form role="form" id="categoryForm" action="{{url('/save-category-product')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter title category">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea style="resize:none" class="form-control" name="desc" id="desc-cat">

                            </textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea style="resize:none" class="form-control" name="keywords" id="keywords-cat">

                            </textarea>
                        </div>

                        <div class="form-group col-lg-6 ">
                            <label for="">Category</label>
                            
                            <select class="form-control input-sm m-bot15" name="parent" required>
                                <option value="0">--Root--</option>
                                @foreach($category as $key => $value)
                                <option value="{{$value->category_id}}">{{$value->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Status</label>
                                <select class="form-control input-sm m-bot15" name="status">
                                    <option value="0">Hide</option>
                                    <option value="1">Show</option>
                            </select>
                        </div>
                        
                        <button type="submit" name="add" class="btn btn-info">Add</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection