@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Manage order
        </div>
     
        <div class="row w3-res-tb">
            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Order code</th>
                    <th>Total price</th>
                    <th>Order status</th>
                    <th>Order date</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0 @endphp
                @foreach($all_order as $key => $order)
                    @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{$order ->order_code}}</td>
                    <td>{{$order ->order_total}}</td>
                    <td>
                    @switch($order ->order_status)
                        @case(1)
                            {{'Pending'}}
                            @break
                        @case(2)
                            {{'Processed'}}
                            @break
                        @case(2)
                            {{'Deliveried'}}
                            @break
                        @default
                            {{'Cancel'}}
                    @endswitch    
                    </td>
                    <td>{{$order ->created_at}}</td>

                    <td>
                        <a href="{{URL::to('/view-order/'.$order->order_code)}}">
                        <i class="fa fa-eye text-success text-active"></i>
                        </a>
                        <a href="{{URL::to('/delete-order/'.$order->order_code)}}" onclick="return confirm('Are you sure you want to delete this category?')">
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
            {{ $all_order->links() }}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection