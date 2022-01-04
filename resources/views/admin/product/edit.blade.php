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
                    @foreach($edit_product as $key => $pro)
                    <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" value="{{$pro->product_name}}" name="title" id="title" placeholder="Enter title product">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" value="{{$pro->product_price}}" name="price" id="price" placeholder="Enter price product">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="desc" id="description">
                                {{$pro->product_desc}}
                            </textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content">
                                {{$pro->product_content}}
                            </textarea>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="">Category</label>
                                <select class="form-control input-sm m-bot15" name="category">
                                    @foreach($cat_product as $key => $cat)
                                        @if($pro->category_id == $cat->category_id)
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
                                        @if($brand->brand_id == $pro->brand_id)
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
                            <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" width="100" height="100" alt="">
                        </div>
                        
                        <div class="col-lg-12">
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection