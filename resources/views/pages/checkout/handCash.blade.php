@extends('layout')
@section('content')
<section id="cart_items">
    <div class="">   
        <div class="review-payment">
            <h2>Thank you for placing an order with us, we will contact you as soon as possible</h2>
            <h3>
                <button type="submit" class="btn btn-default"><a href="{{URL::to('/')}}">Shopping now</a></button>
            </h3>
        </div>      
    </div>
</section>
@endsection