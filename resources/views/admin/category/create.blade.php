@extends('admin_layout')
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
                    <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="title" class="form-control" name="title" id="title" placeholder="Enter title category">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="desc" id="description">

                            </textarea>
                        </div>
                        
                        <div class="form-group">
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