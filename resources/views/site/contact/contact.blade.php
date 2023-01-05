@extends('site.layouts.default')

@section('htmlheader_title')
    Contact us
@endsection

@section('page-style')
  <style>
  </style>
@endsection

@section('main-content')
  <!-- breadcrumb start -->
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>Conatct Us</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>Conatct Us</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- breadcrumb End -->

  <!--section start-->
  <section class="contact-page section-big-py-space bg-light">
      <div class="custom-container">
          <div class="row">
              <div class="col-xl-6 offset-xl-3">
                  {{-- <h3 class="text-center mb-3">Get in touch</h3> --}}
                  <div class="row">
                    <div class="container">
                      @include('site.partials.flash_message')
                        {{-- @if (count($errors) > 0)
                            <div class="alert alert-danger" style="margin-top: 15px">
                                <strong>Whoops!</strong>
                                There were some problems with your input.
                            </div><br>
                        @endif --}}
                      </div>
                  </div>

                  {!! Form::model(null,  array('files' => true, 'autocomplete' => 'off', 'id' => '', 'class' => 'theme-form')) !!}
                  {!!csrf_field()!!}
                  <div class="form-row">
                    <div class="col-sm-12">
                        <div class="form-group {{{ $errors->has('contact_reason') ? 'has-error' : '' }}}">
                         <label> Conatct Reason *</label>
                            {!!Form::select('contact_reason', config('default.contactReason'), null, array('class' => 'form-control border-form-control', 'placeholder' => 'Contact Reason'))!!}
                            <em class="error-msg">{!!$errors->first('contact_reason')!!}</em>
                        </div>
                    </div>
                  </div>
                  <div class="row form-row_  wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                      <div class="col-sm-6">
                          <div class="form-group {{{ $errors->has('first_name') ? 'has-error' : '' }}}">
                           <label>First Name *</label>
                              {!!Form::text('first_name', null, array('class' => 'form-control border-form-control', 'placeholder' => 'Name'))!!}
                              <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
                            <label> Email *</label>
                              {!!Form::text('email', null, array('class' => 'form-control border-form-control', 'placeholder' => 'Email'))!!}
                              <em class="error-msg">{!!$errors->first('email')!!}</em>
                          </div>
                      </div>
                  </div>
                  <div class="row form-row_  wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                      {{-- <div class="col-sm-6">
                          <div class="form-group {{{ $errors->has('subject') ? 'has-error' : '' }}}">
                              <label> Subject *</label>
                              {!!Form::text('subject', null, array('class' => 'form-control border-form-control', 'placeholder' => 'Subject'))!!}
                              <em class="error-msg">{!!$errors->first('subject')!!}</em>
                          </div>
                      </div> --}}
                      <div class="col-sm-6">
                          <div class="form-group {{{ $errors->has('phone_no') ? 'has-error' : '' }}}">
                              <label> Phone * </label>
                              {!!Form::text('phone_no', null, array('class' => 'form-control border-form-control', 'placeholder' => 'Phone'))!!}
                              <em class="error-msg">{!!$errors->first('phone_no')!!}</em>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group {{{ $errors->has('order_no') ? 'has-error' : '' }}}">
                              <label> order number</label>
                              {!!Form::text('order_no', null, array('class' => 'form-control border-form-control', 'placeholder' => 'Order No'))!!}
                              <em class="error-msg">{!!$errors->first('order_no')!!}</em>
                          </div>
                      </div>
                  </div>

                  <div class="form-group {{{ $errors->has('inquiry') ? 'has-error' : '' }}}">
                      <label> inquiry * </label>
                      {!!Form::textarea('inquiry', null, array('class' => 'form-control border-form-control', 'placeholder' => 'inquiry', 'rows' => '3'))!!}
                      <em class="error-msg">{!!$errors->first('inquiry')!!}</em>
                  </div>
                  
                  <div class="row form-row_">
                    <div class="col-sm-12">
                      <div class="form-group {{{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}}">
                          {!! Recaptcha::render() !!}
                          <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                      </div>
                    </div>
                     <div class="col-sm-12">
                        {{-- <button type="button" class="btn btn-outline-danger"> Cencel </button> --}}
                        <button type="submit" class="btn btn-normal btn-block"> Submit Form </button>
                     </div>
                  </div>
                  {!! Form::close() !!}
              </div>
          </div>

          {{-- <div class="row">
              <div class="col-lg-12 map">
                  <div class="theme-card">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1605.811957341231!2d25.45976406005396!3d36.3940974010114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1550912388321"  allowfullscreen></iframe>
                  </div>
              </div>
          </div> --}}
      </div>
  </section>
@endsection