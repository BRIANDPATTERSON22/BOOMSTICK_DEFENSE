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
    </style>
@endsection

@section('main-content')
    <section class="login_page">
       <div class="container">
          <div class="row">
             <div class="col-lg-6 col-md-6 mx-auto">
              @include('site.partials.flash_message')
                <div class="widget">
                   <div class="login-modal-right">
                      <div class="tab-content">
                         <div class="tab-pane active" id="register" role="tabpanel">
                            <h5 class="heading-design-h5">GUEST CHECKOUT</h5>
                            {!! Form::model(null,  array('autocomplete' => 'off')) !!}
                            {!!csrf_field()!!}
                            <div class="form-group">
                                {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder' => 'First Name *']) !!}
                                <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                            </div>
                            <div class="form-group">
                                {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder' => 'Last Name *']) !!}
                                <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                            </div>
                            <div class="intlmobile">
                                <div class="form-group" style="z-index: 9;">
                                    <input type="tel" id="phone" class="form-control text-input number" name="mobile" onfocus="ph_focus()" value="{{old('mobile')}}">
                                    <input type="hidden" id="mobVal" name="mobile_country">
                                    <div class="validation">
                                        <span id="valid-msg" class="hide"><i class="fa fa-check"></i> </span>
                                        <span id="error-msg" class="hide"><i class="fa fa-remove"></i></span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('mobile')!!}</em>
                                </div>
                                <script>
                                    /*
                                    $(document).ready(function() {
                                        $('.flag-container').click(function () {
                                            $("body").addClass("modal-open");
                                        });
                                    });
                                    */
                                    function ph_focus() {
                                        $("body").removeClass("modal-open");
                                    }
                                </script>
                            </div>
                            <div class="form-group">
                                {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'Email Address *']) !!}
                                <em class="error-msg">{!!$errors->first('email')!!}</em>
                            </div>
                            {{-- <div class="form-group">
                                {!! Form::password('password', ['id'=>'pass2', 'class'=>'form-control', 'placeholder' => 'Password *']) !!}
                                <em class="error-msg">{!!$errors->first('password')!!}</em>
                            </div> --}}
                            {{-- <div class="form-group">
                                {!! Form::password('password_confirmation', ['id'=>'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Confirm Password *']) !!}
                                <em class="error-msg">{!!$errors->first('password')!!}</em>
                            </div> --}}
                            {{-- <div class="form-group">
                                {!! Recaptcha::render() !!}
                                <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                            </div> --}}
                            {{-- <p>
                               <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                 <input type="checkbox" class="custom-control-input" name="terms_and_conditions" value="1">
                                 <span class="custom-control-indicator"></span>
                                 <span class="custom-control-description">I Agree with <a href="{{ url('terms-and-conditions') }}" target="_new"> Term and Conditions. </a></span>
                               </label>
                                <em class="error-msg" style="display: block;">{!!$errors->first('terms_and_conditions')!!}</em>
                            </p> --}}
                           {{--  <p>
                               <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                 <input id="subscription-id" type="checkbox" class="custom-control-input" name="is_subscribed" value="0">
                                 <span class="custom-control-indicator"></span>
                                 <span class="custom-control-description">Subscribe for Newsletter! </span>
                               </label>
                            </p> --}}
                            <fieldset class="form-group">
                               <button name="register" type="submit" class="btn btn-lg btn-theme-round btn-block cursor-pointer">Continue</button>
                            </fieldset>
                            {!! Form::close() !!}
                         </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="text-center login-footer-tab">
                         <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                               <a class="nav-link" href="{{ url('login') }}"><i class="icofont icofont-lock"></i> LOGIN</a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link active" href="{{ url()->current() }}"><i class="icofont icofont-pencil-alt-5"></i> REGISTER</a>
                            </li>
                         </ul>
                      </div>
                      <div class="clearfix"></div>
                   </div>
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

        // document.getElementById('subscription-id').onclick = function() {
        //     if ( this.checked ) {
        //         this.value = "1";
        //     } else {
        //         this.value = "0";
        //     }
        // };
    </script>
@endsection