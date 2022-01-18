@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info ">
    <div class="panel panel-default">
        <div class="panel-heading">
            Information customer
        </div>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$order_by_id ->customer_name}}</td>
                    <td>{{$order_by_id ->customer_phone}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Information Shipping
        </div>      
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$order_by_id ->shipping_name}}</td>
                    <td>{{$order_by_id ->shipping_address}}</td>
                    <td>{{$order_by_id ->shipping_phone}}</td>
                    <td>{{$order_by_id ->shipping_notes}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    

<br><br>

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Order Details
        </div>
     
        <div class="row w3-res-tb">
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
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail_by_orderId as $key => $order_details)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{$order_details ->product_name}}</td>
                    <td>{{$order_details ->product_sales_quantity}}</td>
                    <td>{{$order_details ->product_price}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <div class="total_area">
                <ul>
                    {{-- <li>Sub Total <span>${{(int)$order_by_id ->order_total}}</span></li>
                    <li>Eco Tax <span>${{(int)$order_by_id ->order_total * 0.1 }}</span></li>
                    <li>Shipping Cost <span>Free</span></li> --}}
                    <li>Total <span>${{$order_by_id ->order_total}}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
                <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection