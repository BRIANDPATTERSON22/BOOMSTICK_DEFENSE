@extends('site.layouts.default')

@section('htmlheader_title')
    Reset Password
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>Reset Password</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>Reset Password</a></li>
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
                        <h3 class="text-center">Reset Password</h3>
                        {!! Form::model(null,  array('autocomplete' => 'off', 'class' => 'theme-form')) !!}
                        {!!csrf_field()!!}
                        <div class="form-group input-group">
                            {!! Form::password('password', ['id'=>'pass2', 'class'=>'form-control', 'placeholder' => 'New Password']) !!}
                            {{-- <span class="input-group-addon"><i class="icon-lock"></i></span> --}}
                            <em class="error-msg">{!!$errors->first('password')!!}</em>
                        </div>
                        <div class="form-group input-group">
                            {!! Form::password('password_confirmation', ['id'=>'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Confirm Password']) !!}
                            {{-- <span class="input-group-addon"><i class="icon-lock"></i></span> --}}
                            <em class="error-msg">{!!$errors->first('password')!!}</em>
                        </div>
                        <div class="form-group {{{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}}">
                            {!! Recaptcha::render() !!}
                            <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary margin-bottom-none" type="submit">Reset</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <!--Validation with password confirming-->
    <script>
        function passConfirming() {
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            if (pass1 != pass2) {
                //alert("Passwords Do not match");
                document.getElementById("pass1").style.borderColor = "red";
                document.getElementById("pass2").style.borderColor = "red";
            }
            else {
                document.getElementById("pass1").style.borderColor = "green";
                document.getElementById("pass2").style.borderColor = "green";
            }
        }
    </script>
@endsection