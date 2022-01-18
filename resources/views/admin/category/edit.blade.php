@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Update Category
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
                    @foreach($edit_category as $key => $edit_value)
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                        {{csrf_field()}}
                              <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" value="{{ $edit_value->category_name }}" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title category">
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" value="{{ $edit_value->category_slug }}" name="slug" id="slug" placeholder="Enter title category">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea style="resize:none" class="form-control" name="desc" id="desc-cat">
                                    {{ $edit_value->category_desc }}
                                </textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <textarea style="resize:none" class="form-control" name="keywords" id="keywords-cat">
                                    {{ $edit_value->category_keywords }}
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