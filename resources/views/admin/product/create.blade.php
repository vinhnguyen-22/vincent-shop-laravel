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
                echo '<div class="text-alert text-alert-success">' .$message. '</d>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center row">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title product">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Enter price product">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="desc" id="description">

                            </textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="desc" id="content">

                            </textarea>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Category</label>
                                <select class="form-control input-sm m-bot15" name="status">
                                    <option value="0">Hide</option>
                                    <option value="1">Show</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Brand</label>
                                <select class="form-control input-sm m-bot15" name="status">
                                    <option value="0">Hide</option>
                                    <option value="1">Show</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="imgae">Image</label>
                            <input type="file" class="form-control" name="imgae" id="imgae" placeholder="Enter imgae product">
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