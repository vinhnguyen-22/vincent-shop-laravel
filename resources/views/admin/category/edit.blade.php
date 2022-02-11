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
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_category->category_id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" value="{{ $edit_category->category_name }}" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{ $edit_category->category_slug }}" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea style="resize:none" class="form-control" name="desc" id="desc-cat">
                                {{ $edit_category->category_desc }}
                            </textarea>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea style="resize:none" class="form-control" name="keywords" id="keywords-cat">
                                {{ $edit_category->category_keywords }}
                            </textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="">Category</label>
                            
                            <select class="form-control input-sm m-bot15" name="parent" required>
                                <option value="0">--Root--</option>
                                @foreach($category as $key => $value)
                                        @if($value->category_parentId == 0)
                                            <option value="{{$value->category_id}}" {{$value->category_id == $edit_category->category_parentId ? ' selected="selected"' : ''}} >--| {{$value->category_name}}</option>
                                        @endif
                                        
                                        @foreach($category as $key => $val2)
                                            @if($val2->category_parentId == $value->category_id)
                                                <option {{$val2->category_id == $edit_category->category_parentId ? ' selected="selected"' : ''}} value="{{$val2->category_id}}">--|--| {{$val2->category_name}}</option>
                                            @endif
                                        @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection