@extends('layout')
@section('custom_styles')
@endsection
@section('content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            HISTORY ORDER
        </div>
     
        <div class="row w3-res-tb">
            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Order code</th>
                    <th>Total price</th>
                    <th>Order status</th>
                    <th>Order date</th>
                    <th style="width:50px;text-align:center;">View</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0 @endphp
                @foreach($all_order as $key => $order)
                    @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
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
                        @case(3)
                            {{'Deliveried'}}
                            @break
                        @default
                            {{'Cancel'}}
                    @endswitch    
                    </td>
                    <td>{{$order ->created_at}}</td>

                    <td style="width:100px;text-align:center;">
                        <a href="{{url('/view-order-history/'.$order->order_code)}}">
                        Watch
                        <i class="fa fa-eye text-success text-active"></i>
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
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {{ $all_order->links() }}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
