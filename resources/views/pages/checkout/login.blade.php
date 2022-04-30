@extends('layout')
@section('custom_styles')
<style type="text/css">
.block-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  height: 100%;
}
.block-wrap > div {
  text-align: center;
}

.btn-google, .btn-fb {
  display: inline-block;
  border-radius: 1px;
  text-decoration: none;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.25);
  transition: background-color 0.218s, border-color 0.218s, box-shadow 0.218s;
  margin-top: 12px;
}
.btn-google .google-content, .btn-google .fb-content, .btn-fb .google-content, .btn-fb .fb-content {
  display: flex;
  align-items: center;
  width: 300px;
  height: 50px;
}
.btn-google .google-content .logo, .btn-google .fb-content .logo, .btn-fb .google-content .logo, .btn-fb .fb-content .logo {
  padding: 15px;
  height: inherit;
}
.btn-google .google-content svg, .btn-google .fb-content svg, .btn-fb .google-content svg, .btn-fb .fb-content svg {
  width: 18px;
  height: 18px;
}
.btn-google .google-content p, .btn-google .fb-content p, .btn-fb .google-content p, .btn-fb .fb-content p {
  width: 100%;
  line-height: 1;
  letter-spacing: 0.21px;
  text-align: center;
  font-weight: 500;
  font-family: "Roboto", sans-serif;
}

.btn-google {
  background: #FFF;
}
.btn-google:hover {
  box-shadow: 0 0 3px 3px rgba(66, 133, 244, 0.3);
}
.btn-google:active {
  background-color: #eee;
}
.btn-google .google-content p {
  color: #757575;
}

.btn-fb {
  padding-top: 1.5px;
  background: #4267b2;
  background-color: #3b5998;
}
.btn-fb:hover {
  box-shadow: 0 0 3px 3px rgba(59, 89, 152, 0.3);
}
.btn-fb .fb-content p {
  color: rgba(255, 255, 255, 0.87);
}
</style>
@endsection
@section('content')
<section id="form"><!--form-->
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
            <div class="login-form"><!--login form-->
                <h2>Login to your account</h2>
                <form action="{{url('/customer-login')}}" method="post">
                    {{csrf_field()}}
                    <input type="email" placeholder="Email Address" name="customer_email" />
                    <input type="password" name="customer_password" placeholder="PasswordName" />
                    <span>
                        <input type="checkbox" class="checkbox"> 
                        Keep me signed in
                    </span>
                    <button type="submit" name="login" style="width: 100%;height: 50px; font-weight:bold;" class="btn btn-default">Login</button>

                    <div class="block-wrap">
                        <!-- google	 -->
                        <div>
                            <a class="btn-google" href="{{url('login-customer-google')}}">
                                <div class="google-content">
                                    <div class="logo">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48">
                                            <defs><path id="a" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"/></defs><clipPath id="b"><use xlink:href="#a" overflow="visible"/></clipPath><path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z"/><path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z"/><path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z"/><path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z"/>
                                        </svg>
                                    </div>
                                    <p>Sign in with Google</p>
                                </div>
                            </a>
                        </div>

                        <!-- facebook	 -->
                        <div>
                            <a class="btn-fb" href="{{url('login-customer-facebook')}}">
                                <div class="fb-content">
                                    <div class="logo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" version="1">
                                            <path fill="#FFFFFF" d="M32 30a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h28a2 2 0 0 1 2 2v28z"/>
                                            <path fill="#4267b2" d="M22 32V20h4l1-5h-5v-2c0-2 1.002-3 3-3h2V5h-4c-3.675 0-6 2.881-6 7v3h-4v5h4v12h5z"/>
                                        </svg>
                                    </div>
                                    <p>Sign in with Facebook</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </form>
            </div><!--/login form-->
        </div>
        <div class="col-sm-1">
            <h2 class="or">OR</h2>
        </div>
        <div class="col-sm-6">
            <div class="signup-form"><!--sign up form-->
                <h2>New User Signup!</h2>
                <form action="{{url('/customer-signup')}}" method="post">
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
                    <button type="submit" name="login" style="width: 100%;height: 50px; font-weight:bold;" class="btn btn-default">
                      Sign up
                    </button>
                </form>

                
            </div><!--/sign up form-->
        </div>
    </div>
</section><!--/form-->
@endsection