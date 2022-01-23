@extends('layout')
@section('content')
<section id="form"><!--form-->
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
            <div class="login-form"><!--login form-->
                <h2>Login to your account</h2>
                <form action="{{URL::to('/customer-login')}}" method="post">
                    {{csrf_field()}}
                    <input type="email" placeholder="Email Address" name="customer_email" />
                    <input type="password" name="customer_password" placeholder="PasswordName" />
                    <span>
                        <input type="checkbox" class="checkbox"> 
                        Keep me signed in
                    </span>
                    <button type="submit" name="login" class="btn btn-default">Login</button>
                </form>
            </div><!--/login form-->
        </div>
        <div class="col-sm-1">
            <h2 class="or">OR</h2>
        </div>
        <div class="col-sm-6">
            <div class="signup-form"><!--sign up form-->
                <h2>New User Signup!</h2>
                <form action="{{URL::to('/customer-signup')}}" method="post">
                    {{csrf_field()}}
                    <ul>
                        @foreach($errors->all() as $val)
                            <li>{{$val}}</li>
                        @endforeach    
                    </ul>
                    <input type="text" name="customer_name" placeholder="Name"/>
                    <input type="email" name="customer_email" placeholder="Email Address"/>
                    <input type="password" name="customer_password" placeholder="Password"/>
                    <input type="number" name="customer_phone" placeholder="Phone"/>
                    
                    <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}">
                
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-default">Signup</button>
                </form>
            </div><!--/sign up form-->
        </div>
    </div>
</section><!--/form-->


@endsection