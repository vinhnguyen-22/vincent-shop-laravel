@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Shipping Fee
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</d>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-shippingfee')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Province</label>
                            <select id="province" class="form-control input-sm m-bot15 optionSelect province" name="province">
                                <option value="0">--choose--</option>
                                @foreach($province as $key => $val)
                                <option value="{{$val->matp}}">{{$val->province_name}}</option>
                                @endforeach;
                            </select>
                        </div>
                         
                        <div class="form-group">
                            <label for="">District</label>
                            <select id="district" class="form-control input-sm m-bot15 optionSelect district" name="district">
                                <option value="0">--choose--</option>
                                @foreach($district as $key => $val)
                                <option value="{{$val->maqh}}">{{$val->district_name}}</option>
                                @endforeach;
                        </select>
                        </div>

                        <div class="form-group">
                            <label for="">Ward</label>
                            <select id="ward" class="form-control input-sm m-bot15 ward" name="ward">
                                <option value="0">--choose--</option>
                                @foreach($ward as $key => $val)
                                <option value="{{$val->xaid}}">{{$val->ward_name}}</option>
                                @endforeach;
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Shipping Fee</label>
                            <input type="number" name="shippingfee" class="form-control shippingfee" placeholder="feeshipping">
                        </div>

                        <button type="button" name="add_delivery" class="btn btn-info add_delivery">Add</button>
                    </form>
                </div>

                <div id="load-delivery">

                </div>
            </div>
        </section>
    </div>
</div>
@endsection