@extends('site.layouts.default')

@section('htmlheader_title')
    Sign Up
@endsection

@section('page-style')
    <style>
        .hide{display: none;}
        .validation {position: relative;}
        #valid-msg {position: absolute;color: green;top: -30px;left: 230px;}
        .error-msg {color: red !important;}
        #error-msg {position: absolute;color: red !important;top: -30px;left: 230px;}
          .account_form form {
               border: 0px; 
          }
          .account_form{
            border-bottom: 5px solid #81d742;
            border-radius: 5px;
          }
    </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>register</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>register</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <section class="login-page section-big-py-space bg-light">
      <div class="custom-container">
          <div class="row">
              <div class="col-lg-6 mx-auto">
                 @include('site.partials.flash_message')
                  <div class="theme-card">
                      <h3 class="text-center">Create account</h3>

                      {!! Form::model(null,  array('autocomplete' => 'off', 'class' => 'theme-form')) !!}
                      {!!csrf_field()!!}
                      <div class="form-group">
                          {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder' => 'First Name *']) !!}
                          <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder' => 'Last Name *']) !!}
                          <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Form::text('phone_no', null, ['class'=>'form-control', 'placeholder' => 'Phone No *']) !!}
                          <em class="error-msg">{!!$errors->first('phone_no')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'Email Address *']) !!}
                          <em class="error-msg">{!!$errors->first('email')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Form::password('password', ['id'=>'pass2', 'class'=>'form-control', 'placeholder' => 'Password *']) !!}
                          <em class="error-msg">{!!$errors->first('password')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Form::password('password_confirmation', ['id'=>'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Confirm Password *']) !!}
                          <em class="error-msg">{!!$errors->first('password')!!}</em>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label" for="terms_and_conditions">
                          <input type="checkbox" class="form-check-input" id="terms_and_conditions" name="terms_and_conditions" value="1" style="width: auto; height: auto;">
                          <a href="{{ url('terms-of-service') }}" target="_new"> I Agree with Term and Conditions. </a>
                        </label>
                        <em class="error-msg">{!!$errors->first('terms_and_conditions')!!}</em>
                      </div>
                      <div class="form-group">
                          {!! Recaptcha::render() !!}
                          <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-normal btn-block">Create Your Account</button>
                      </div>
                      {!! Form::close() !!}

                      {{-- <form class="theme-form">
                          <div class="form-row">
                              <div class="col-md-12 form-group">
                                  <label for="email">First Name</label>
                                  <input type="text" class="form-control" id="fname" placeholder="First Name" required="">
                              </div>
                              <div class="col-md-12 form-group">
                                  <label for="review">Last Name</label>
                                  <input type="text" class="form-control" id="lname" placeholder="Last Name" required="">
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12 form-group">
                                  <label for="email">email</label>
                                  <input type="text" class="form-control" id="email" placeholder="Email" required="">
                              </div>
                              <div class="col-md-12 form-group">
                                  <label for="review">Password</label>
                                  <input type="password" class="form-control" id="review" placeholder="Enter your password" required="">
                              </div>
                              <div class="col-md-12 form-group"><a href="register.html#" class="btn btn-normal">create Account</a></div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12 ">
                                  <p >Have you already account? <a href="login.html" class="txt-default">click</a> here to &nbsp;<a href="login.html" class="txt-default">Login</a></p>
                              </div>
                          </div>
                      </form> --}}
                  </div>
              </div>
          </div>
      </div>
  </section>
@endsection

@section('page-script')
    <script>
        function passConfirming() {
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            if (pass1 != pass2) {
                document.getElementById("pass1").style.borderColor = "red";
                document.getElementById("pass2").style.borderColor = "red";
            }
            else {
                document.getElementById("pass1").style.borderColor = "green";
                document.getElementById("pass2").style.borderColor = "green";
            }
        }

        document.getElementById('subscription-id').onclick = function() {
            if ( this.checked ) {
                this.value = "1";
            } else {
                this.value = "0";
            }
        };
    </script>
@endsection