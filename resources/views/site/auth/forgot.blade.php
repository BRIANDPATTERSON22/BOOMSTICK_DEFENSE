@extends('site.layouts.default')

@section('htmlheader_title')
    Forgot Password
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>Forgot Password</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>Forgot Password</a></li>
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
                        <h3 class="text-center">Forgot Password</h3>
                        {!! Form::model(null,  array('autocomplete' => 'off', 'class' => 'theme-form')) !!}
                        {!!csrf_field()!!}
                        <div class="form-group  {{{ $errors->has('email') ? 'has-error' : '' }}}">
                            {!!Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Enter your email address'))!!}
                            <em class="error-msg">{!!$errors->first('email')!!}</em>
                        </div>
                        <div class="form-group {{{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}}">
                            {!! Recaptcha::render() !!}
                            <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary margin-bottom-none" type="submit">Get new password</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection