@extends('site.layouts.default')

@section('htmlheader_title')
  Password
@endsection

@section('page-style')
  <style>
    .form-group label {color: #343a40;font-weight: 800!important;letter-spacing: 1px;text-transform: uppercase;}
  </style>
@endsection

@section('main-content')

  <div class="container">
    @if (count($errors) > 0)
      <div class="alert alert-danger" style="margin-top: 15px">
        <strong>Whoops!</strong>
        There were some problems with your input.
      </div><br>
    @endif
  </div>

  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>Change Password</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>Change Password</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

    <section class="shopping_cart_page">
     <div class="container">
        <div class="row">
           @include('site.customer.sidebar')
           <div class="col-lg-8 col-md-8 col-sm-7">
              <div class="widget inno_shadow p_15">
                 <div class="section-header">
                    <h5 class="heading-design-h5">
                       My Profile
                    </h5>
                 </div>
                  
                  {!!Form::model($user, ['autocomplete' => 'off'])!!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account-email control-label">E-mail Address *</label>
                        {!!Form::email('email', null, ['id'=>'account-email', 'class' => 'form-control', 'readonly'])!!}
                        <em class="error-msg">{!!$errors->first('email')!!}</em>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account-email control-label">Old Password *</label>
                        {!!Form::password('old_password', ['id'=>'account-email', 'class' => 'form-control'])!!}
                        <em class="error-msg">{!!$errors->first('old_password')!!}</em>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account-pass control-label">New Password *</label>
                        {!!Form::password('password', ['id'=>'account-pass', 'class' => 'form-control'])!!}
                        <em class="error-msg">{!!$errors->first('password')!!}</em>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account-confirm-pass control-label">Confirm Password *</label>
                        {!!Form::password('password_confirmation', ['id'=>'account-confirm-pass', 'oninput' => 'passConfirming()', 'class' => 'form-control'])!!}
                        <em class="error-msg">{!!$errors->first('password_confirmation')!!}</em>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <button class="btn btn-primary margin-right-none" type="submit">Change Password</button>
                      </div>
                    </div>
                  </div>
                  {!!Form::close()!!}
                 
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
          var pass1 = document.getElementById("account-pass").value;
          var pass2 = document.getElementById("account-confirm-pass").value;
          if (pass1 != pass2) {
              document.getElementById("account-pass").style.borderColor = "red";
              document.getElementById("account-confirm-pass").style.borderColor = "red";
          }
          else {
              document.getElementById("account-pass").style.borderColor = "green";
              document.getElementById("account-confirm-pass").style.borderColor = "green";
          }
      }
  </script>
@endsection