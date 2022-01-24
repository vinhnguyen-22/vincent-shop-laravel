@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List coupon
        </div>
        <?php
            $message = Session::get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
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
                    <th>Title</th>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Method</th>
                    <th></th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list_coupon as $key => $coupon)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{$coupon ->coupon_name}}</td>
                    <td>{{$coupon ->coupon_code}}</td>
                    <td>{{$coupon ->coupon_time}}</td>
                    @if($coupon ->coupon_method == 1)
                        <td>${{$coupon ->coupon_rate}}</td>
                        <td>DESC By Cash</td>
                    @elseif($coupon ->coupon_method == 2)
                        <td>{{$coupon ->coupon_rate}}%</td>
                        <td>DESC By Percentage</td>
                    @endif
                    <td>
                        <a href="{{URL::to('/edit-coupon/'.$coupon->coupon_id)}}">
                        <i class="fa fa-edit text-success text-active"></i>
                        </a>
                        <a href="{{URL::to('/delete-coupon/'.$coupon->coupon_id)}}" onclick="return confirm('Are you sure you want to delete this coupon?')">
                            <i class="fa fa-trash text-danger text"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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