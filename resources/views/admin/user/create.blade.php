@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create User
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
                    <form role="form" id="productForm" action="{{URL::to('/save-user')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-12">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" name="name" id="name" placeholder="Enter name">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="phone">phone</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter phone">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
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