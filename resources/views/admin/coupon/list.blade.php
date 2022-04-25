@extends('admin.admin_layout')
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
            <div class="col-sm-5"><a href="{{url('/send-coupon-vip')}}" class="btn btn-default">Send coupon</a></div>
            <div class="col-sm-4"></div>
            <div class="col-md-3">
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
                    <th>Start day</th>
                    <th>Expire day</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Expiry</th>
                    <th style="width:30px;"></th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list_coupon as $key => $coupon)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{date('d/m/Y', strtotime($coupon->coupon_start))}}</td>
                    <td>{{date('d/m/Y', strtotime($coupon->coupon_expired))}}</td>
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

                    @if($coupon ->coupon_status == 1)
                        <td style="color:green">actived</td>
                    @else
                        <td style="color:coral">inactived</td>
                    @endif
                    
                    @if($today < $coupon->coupon_expired)
                        <td style="color:green">not expired</td>
                    @else
                        <td style="color:coral">expired</td>
                    @endif
                    
                    <td>
                        <a href="{{url('/delete-coupon/'.$coupon->coupon_id)}}" onclick="return confirm('Are you sure you want to delete this coupon?')">
                            <i class="fa fa-trash text-danger text"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{url('/send-coupon-vip',
                        [
                            'coupon_name' => $coupon->coupon_name,
                            'coupon_rate' => $coupon->coupon_rate,
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_time' => $coupon->coupon_time,
                            'coupon_method' => $coupon->coupon_method,
                            'coupon_expired' => $coupon->coupon_expired,
                            'coupon_start' => $coupon->coupon_start,
                        ]
                        )}}" class="btn btn-sm" style=" width:100%;margin-bottom:10px;color:black; background-color:yellow">Send for vip
                            <i class="fa fa-send text-information text-active"></i>
                        </a>
                        <a href="{{url('/send-coupon',
                         [
                            'coupon_name' => $coupon->coupon_name,
                            'coupon_rate' => $coupon->coupon_rate,
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_time' => $coupon->coupon_time,
                            'coupon_method' => $coupon->coupon_method,
                            'coupon_expired' => $coupon->coupon_expired,
                            'coupon_start' => $coupon->coupon_start,
                        ])}}" class="btn btn-sm btn-default">Send coupon
                            <i class="fa fa-send text-information text-active"></i>
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
            {{ $list_coupon->links() }}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection