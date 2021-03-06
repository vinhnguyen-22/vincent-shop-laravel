@extends('admin.admin_layout')
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
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center row">
                    <form role="form" id="productForm" action="{{url('/save-product')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" name="title" id="title" placeholder="Enter title category">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="tag">Tag</label>
                            <input type="text" class="form-control" data-role="tagsinput" name="tag" id="tag">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="price">Price</label>
                            <input type="text" class="form-control price-format" name="price" id="price" placeholder="Enter price product" required >
                        </div>
            
                        <div class="form-group col-lg-6">
                            <label for="cost">Cost</label>
                            <input type="text" class="form-control price-format" name="cost" id="cost" placeholder="Enter cost product" required >
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Enter quantity product" required >
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea id="description-product" class="form-control" name="desc" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea id="content-product" class="form-control" name="content" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea style="resize:none" id="keywords-product" class="form-control" name="keywords" required></textarea>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Category</label>
                            <select class="form-control input-sm m-bot15" name="category" required>
                                @foreach($cat_product as $key => $value)
                                <option value="{{$value->category_id}}">{{$value->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Brand</label>
                            <select class="form-control input-sm m-bot15" name="brand" required>
                                @foreach($brand_product as $key => $value)
                                <option value="{{$value->brand_id}}">{{$value->brand_name}}</option>
                                @endforeach
                            </select>
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


@section('scripts')
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/simple.money.format.js')}}"></script>
<script type="text/javascript">
    // upload ckeditor
    CKEDITOR.replace('description-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
    CKEDITOR.replace('content-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
</script>
<script type="text/javascript">
     // format price
    $(".price-format").simpleMoneyFormat();
</script>
@endsection