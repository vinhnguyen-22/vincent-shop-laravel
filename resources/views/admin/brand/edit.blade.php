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
                    <form role="form" action="{{url('/update-brand-product/'.$edit_brand->brand_id)}}" method="post">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" value="{{ $edit_brand->brand_name }}" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title brand">
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" value="{{ $edit_brand->brand_slug }}" name="slug" id="slug" placeholder="Enter title brand">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="desc" id="description">
                                    {{ $edit_brand->brand_desc }}
                                </textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Keywords</label>
                                <textarea class="form-control" name="keywords" id="keywords">
                                    {{ $edit_brand->brand_keywords }}
                                </textarea>
                            </div>
                        <button type="submit" name="update" class="btn btn-info">Update</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection