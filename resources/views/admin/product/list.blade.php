@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List product
        </div>
        <?php
            $message = Session::get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
        {{-- <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control w-sm inline v-middle">
                <option value="0">Bulk action</option>
                <option value="1">Delete selected</option>
                <option value="2">Bulk edit</option>
                <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-default">Apply</button>                
            </div>
           
            <div class="col-sm-4"></div>
            <div class="col-sm-3">
                <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="productTable">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Gallery</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list_product as $key => $product)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>
                        <img src="public/uploads/product/{{$product ->product_image}}" height="100" width="100" alt="" />    
                    </td>
                    <td>{{$product ->product_name}}</td>
                    <td>{{$product ->category_name}}</td>
                    <td>{{$product ->brand_name}}</td>
                    <td>{{$product ->product_price}}</td>
                    <td>{{$product ->product_cost}}</td>
                    <td>{{$product ->product_quantity}}</td>
                    <td>
                        @if($product ->product_status == 0)
                            <a href="{{url('/inactive-product/'.$product->product_id)}}">
                                <i class="fa fa-eye-style fa-eye-slash text text-danger"></i>
                            </a>
                        @else
                        <a href="{{url('/active-product/'.$product->product_id)}}">
                            <i class="fa fa-eye-style fa-eye text text-success"></i>
                        </a>
                        @endif 
                    </td>
                    <td><a href="{{url('/manage-gallery-product/'.$product->product_id)}}">Add</a></td>
                    <td>
                        <a href="{{url('/edit-product/'.$product->product_id)}}">
                        <i class="fa fa-edit text-success text-active"></i>
                        </a>
                        <a href="{{url('/delete-product/'.$product->product_id)}}" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa fa-trash text-danger text"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <form action="{{url('import-csv')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx"><br>
            <input type="submit" value="Import CSV" name="import_csv" class="btn btn-warning">
        </form>
        <form action="{{url('export-csv')}}" method="POST">
            @csrf
            <input type="submit" value="Export CSV" name="export_csv" class="btn btn-success">
        </form>

    </div>
    {{-- <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {!! $list_product->links() !!}
        </div>
      </div>
    </footer> --}}
  </div>
</div>
@endsection