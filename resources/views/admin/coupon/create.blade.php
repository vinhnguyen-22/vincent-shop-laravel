@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Coupon
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" id="couponForm" action="{{url('/save-coupon')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title coupon</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title coupon">
                        </div>

                        <div class="form-group">
                            <label for="coupon_code">Coupon code</label>
                            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter coupon">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Number of code</label>
                            <input type="number" class="form-control" name="coupon_time" id="coupon_time" placeholder="Enter coupon">
                        </div>

                        <div class="form-group">
                            <label for="method">Method</label>
                            <select class="form-control input-sm m-bot15" name="method">
                                <option value="0">--choose--</option>
                                <option value="1">Descrease by cash</option>
                                <option value="2">Descrease by percentage</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Enter rate of percent or cash</label>
                            <input type="number" class="form-control" name="rate" id="rate" placeholder="Enter rate coupon">
                        </div>

                        <div class="form-group">
                            <label for="start">Start day</label>
                            <input type="text" id="start" name="start" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="expired">Expire day</label>
                            <input type="text" id="expired" name="expired" class="form-control">
                        </div>
                        
                        <button type="submit" name="add" class="btn btn-info">Add Coupon</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('public/backend/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    var dateFormat = "mm/dd/yy",
    from = $( "#start" )
        .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
        })
        .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
        }),
    to = $( "#expired" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
    })
    .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
    });
    
    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
        return date;
    }
</script>
@endsection