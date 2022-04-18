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
                    <form role="form" action="{{url('/update-product/'.$edit_product->product_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control convert_slug" data-slug="slug" value="{{$edit_product->product_name}}" name="title" id="title" placeholder="Enter title product">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{ $edit_product->product_slug }}" name="slug" id="slug" placeholder="Enter title category">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="tag">Tag</label>
                            <input type="text" value="{{ $edit_product->product_tags }}" class="form-control" data-role="tagsinput" name="tag" id="tag">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" value="{{$edit_product->product_price}}" name="price" id="price" placeholder="Enter price product">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="price">Price</label>
                            <input type="text" class="form-control price-format" value="{{$edit_product->product_cost}}" name="cost" id="cost" placeholder="Enter price product">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control price-format" value="{{$edit_product->product_quantity}}" name="quantity" id="quantity" placeholder="Enter quantity product">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea id="description-product" class="form-control" name="desc" id="description">{{$edit_product->product_desc}}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea id="content-product" class="form-control" name="content" id="content">{{$edit_product->product_content}}</textarea>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="keywords">Keywords</label>
                            <textarea style="resize:none" id="keywords-product" class="form-control" name="keywords" required>{{$edit_product->product_keywords}}   </textarea>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="">Category</label>
                                <select class="form-control input-sm m-bot15" name="category">
                                    @foreach($cat_product as $key => $cat)
                                        @if($edit_product->category_id == $cat->category_id)
                                            <option selected value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                                        @else
                                            <option value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Brand</label>
                                <select class="form-control input-sm m-bot15" name="brand">
                                    @foreach($brand_product as $key => $brand)
                                        @if($brand->brand_id == $edit_product->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter image product">
                        </div>
                        <div class="form-group col-lg-6">
                            <img src="{{url('public/uploads/product/'.$edit_product->product_image)}}" width="100" height="100" alt="">
                        </div>
                        
                        <div class="col-lg-12">
                            <button type="submit" name="update" class="btn btn-info">Update</button>
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
<script type="text/javascript" src="{{asset('public/backend/js/simple.money.format.js')}}"></script>
@endsection