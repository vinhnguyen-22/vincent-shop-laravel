@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Update Brand
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success align-self-center">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    @foreach($edit_brand as $key => $edit_value)
                    <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" value="{{ $edit_value->brand_name }}"class="form-control" name="title" id="title" placeholder="Enter title brand">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="desc" id="description">
                                    {{ $edit_value->brand_desc }}
                                </textarea>
                            </div>
                        <button type="submit" name="update" class="btn btn-info">Update</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection