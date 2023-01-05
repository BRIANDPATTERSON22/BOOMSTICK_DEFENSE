@extends('site.layouts.default')

@section('htmlheader_title')
    Sign In
@endsection

@section('page-style')
    <style>
    </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>login</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>login</a></li>
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
              <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                  @include('site.partials.flash_message')

                  <div class="theme-card inno_shadow_dark_">
                      <h3 class="text-center">Login</h3>
                      {!! Form::model(null,  array('autocomplete' => 'off', 'class' => 'theme-form')) !!}
                      {!!csrf_field()!!}
                        <div class="form-group {{ $errors->has('login_email') ? 'has-error' : '' }}}">
                          <label>Email <span>*</span></label>
                          {!!Form::text('login_email', null, array('class' => 'form-control inno_shadow_', 'placeholder' => 'Enter username (Email)'))!!}
                            <em class="error-msg">{!!$errors->first('login_email')!!}</em>
                        </div>
                        <div class="form-group {{{ $errors->has('login_pass') ? 'has-error' : '' }}}">
                            <label>Passwords <span>*</span></label>
                            {!!Form::password('login_pass', array('class' => 'form-control', 'placeholder' => 'Enter password'))!!}
                            <em class="error-msg">{!!$errors->first('login_pass')!!}</em>
                        </div>
                        <fieldset class="form-group {{{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}}">
                        {!! Recaptcha::render() !!}
                        <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                        </fieldset>

             {{--              <a href="login.html#" class="btn btn-normal">Login</a> --}}
                          <button class="btn btn-normal" type="submit">login</button>
                          <a class="float-right txt-default mt-2" href="{{ url('forgot-password') }}" id="fgpwd">Forgot your password?</a>
                      {!! Form::close() !!}
                      {{-- <p class="mt-3">Sign up for a free account at our store. Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.</p> --}}
                      <a href="{{ url('register') }}" class="txt-default pt-3 d-block">Create an Account</a>
                  </div>
              </div>
          </div>
      </div>
  </section>
@endsection