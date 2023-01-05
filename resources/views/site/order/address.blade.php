@extends('site.layouts.default')

@section('htmlheader_title')
    Checkout Address | Shop
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2> Checkout Address</h2>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a>Checkout Address</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @include('site.order.checkout_steps')

  <section class="login-page section-big-py-space bg-light">
      <div class="custom-container">
          <div class="row">
              <div class="col-lg-8 mx-auto">
                 @include('site.partials.flash_message')

                  <div class="theme-card">
                      <h3 class="text-center">Enter Your Address</h3>
                      {!!Form::model($customer, ['autocomplete' => 'off', 'id' => 'guest_checkout_address_form'])!!}
                      {!!csrf_field()!!}

                      {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}
                      <div class="row">
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>First Name <span class="required">*</span></label>
                                  {!!Form::text('first_name', null, ['id'=>'checkout-fn', 'class' => 'form-control ', 'placeholder'=>'First name'])!!}
                                  <em class="text-danger">{!!$errors->first('first_name')!!}</em>
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Last Name <span class="required">*</span></label>
                                  {!!Form::text('last_name', null, ['id'=>'checkout-ln', 'class' => 'form-control ', 'placeholder'=>'Last name'])!!}
                                 <em class="text-danger">{!!$errors->first('last_name')!!}</em>
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Email Address <span class="required">*</span></label>
                                  {!!Form::email('email', null, ['id'=>'checkout-email', 'class' => 'form-control ', 'placeholder'=>'Email address', 'readonly'])!!}
                                 <em class="text-danger">{!!$errors->first('email')!!}</em>
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Phone No<span class="required">*</span></label>
                                  {!!Form::tel('phone_no', null, ['id'=>'checkout-phone', 'class' => 'form-control ', 'placeholder'=>'Phone Number'])!!}
                                 <em class="text-danger">{!!$errors->first('phone_no')!!}</em>
                              </div>
                          </div>
                      </div>

                      <div class="border-top border-dark mt-3 mb-3"></div>

                      <div id="billing-address">
                          {{-- <h5 class="heading-design-form">Enter Your Billing Info</h5> --}}
                          <div class="row">
                              <div class="form-group col-md-12">
                                  <label for="id_billing_address" class="control-label">Billing Address *</label>
                                  {!!Form::textarea('billing_address', null, ['id'=>'id_billing_address', 'class' => 'form-control ', 'placeholder'=>'Address *','rows' => '2', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('billing_address')!!}</em>
                              </div>
                              <div class="form-group col-md-3">
                                <label for="id_billing_country_id" class="control-label">Billing Country *</label>
                                {!!Form::select('billing_country_id', $countries, null, ['id'=>'id_billing_country_id', 'class' => 'form-control ', 'placeholder'=>'Country *', 'required'])!!}
                                <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_country_id')!!}</em>
                              </div>
                              <div class="form-group col-md-3">
                                  <label for="id_billing_city" class="control-label">Billing City *</label>
                                  {!!Form::text('billing_city', null, ['id'=>'id_billing_city', 'class' => 'form-control ', 'placeholder'=>'City *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('billing_city')!!}</em>
                              </div>
                              {{-- <div class="form-group col-md-3">
                                  <label for="id_billing_state" class="control-label">Billing State *</label>
                                  {!!Form::text('billing_state', null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('billing_state')!!}</em>
                              </div> --}}
                              <div class="form-group col-md-3">
                                <label for="id_billing_state" class="control-label">Billing State *</label>
                                {!!Form::select('billing_state', config('default.usStates'), null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                                <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_state')!!}</em>
                              </div>
                              <div class="form-group col-md-3">
                                  <label for="id_billing_postal_code" class="control-label">Billing Zip code *</label>
                                  {!!Form::text('billing_postal_code', null, ['id'=>'id_billing_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('billing_postal_code')!!}</em>
                              </div>
                          </div>
                      </div>
             {{--          <div class="form-group">
                          <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" @if($customer->is_same_as_billing == 1) checked @endif >
                          <label>If the Delivery address is same as Billing address, please tick this check box.</label>
                      </div> --}}
                      
                      <div class="row">
                          <div class="form-group col-md-12">
                              <label class="d-inline">
                               <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" class=""  @if($customer->is_same_as_billing == 1) checked @endif>
                              {{-- If the Delivery address is same as Billing address, please tick this check box. --}}
                              If the delivery address is different from the billing address, please uncheck this box.
                             </label>
                          </div>
                      </div>

                      {{-- <div class="border-top border-dark mt-3 mb-3"></div> --}}

                      <div id="delivery-address" @if($customer->is_same_as_billing == 1) style="display: none" @endif>
                        {{-- <h5 class="heading-design-form">Enter Delivery Info</h5> --}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="id_delivery_address" class="control-label">Delivery Address *</label>
                                {!!Form::textarea('delivery_address', null, ['id'=>'id_delivery_address', 'class' => 'form-control ', 'placeholder'=>'Address *','rows' => '2', 'required'])!!}
                                <em class="error-msg">{!!$errors->first('delivery_address')!!}</em>
                            </div>
                            <div class="form-group col-md-3">
                              <label for="id_delivery_country_id" class="control-label">Delivery Country *</label>
                              {!!Form::select('delivery_country_id', $countries, null, ['id'=>'id_delivery_country_id', 'class' => 'form-control ', 'placeholder'=>'Country *', 'required'])!!}
                              <em class="error-msg" id="delivery_country_id_error">{!!$errors->first('delivery_country_id')!!}</em>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="id_delivery_city" class="control-label">Delivery City *</label>
                                {!!Form::text('delivery_city', null, ['id'=>'id_delivery_city', 'class' => 'form-control ', 'placeholder'=>'City *', 'required'])!!}
                                <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                            </div>
                            {{-- <div class="form-group col-md-3">
                                <label for="id_delivery_state" class="control-label">Delivery State *</label>
                                {!!Form::text('delivery_state', null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                                <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                            </div> --}}
                            <div class="form-group col-md-3">
                              <label for="id_delivery_state" class="control-label">Delivery State *</label>
                              {!!Form::select('delivery_state', config('default.usStates'), null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                              <em class="error-msg" id="billing_country_id_error">{!!$errors->first('delivery_state')!!}</em>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="id_delivery_postal_code" class="control-label">Delivery Zip code *</label>
                                {!!Form::text('delivery_postal_code', null, ['id'=>'id_delivery_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                                <em class="error-msg">{!!$errors->first('delivery_postal_code')!!}</em>
                            </div>
                        </div>
                      </div>

                      <div class="border-top border-dark mt-3 mb-3"></div>

                      <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-outline-dark btn-sm float-left" href="{{url('cart')}}">
                              <i class="icon-arrow-left"></i>
                              <span class="hidden-xs-down">&nbsp;Go Back</span>
                            </a>

                            <button type="submit" class="btn btn-outline-success btn-sm float-right">
                                <span class="hidden-xs-down">Continue&nbsp;</span><i class="icon-arrow-right"></i>
                            </button>
                        </div>

                      </div>
                      {!! Form::close() !!}
                  </div>
              </div>
          </div>
        </div>
  </section>
@endsection

@section('page-script')
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
   <script>
       $(document).ready(function () {
           $('#guest_checkout_address_form').validate({ // initialize the plugin
               rules: {
                   first_name: {
                       required: true
                   },
                   last_name: {
                       required: true
                   },
                   email: {
                       required: true,
                       email: true
                   },
                   // password: {
                   //     required: true,
                   // },
                   // email: {
                   //     required: true,
                   //     email: true
                   // },
                   phone_no: {
                       required: true
                   },
                   // g-recaptcha-response: {
                   //     required: true
                   // },
                   terms_and_conditions: {
                       required: true
                   }
               },
               
               messages: {
                   first_name: "Please enter your first name",
                   last_name: "Please enter your last name",
                   email: "Please enter your email id",
                   // password: "Please enter your password",
                   phone_no: "Please enter your contact number",
                   
                   billing_country_id: "Please select billing country",
                   billing_address: "Please enter your billing address",
                   billing_city: "Please enter your billing city",
                   billing_state: "Please enter your billing state",
                   billing_postal_code: "Please enter your billing zip code",
                   
                   delivery_country_id: "Please select delivery country",
                   delivery_address: "Please enter your delivery address",
                   delivery_city: "Please enter your delivery city",
                   delivery_state: "Please enter your delivery state",
                   delivery_postal_code: "Please enter your delivery zip code",
                   
                   // g-recaptcha-response: "Please fill reCAPTCHA to continue",
                   terms_and_conditions: "Please agree to the terms & condition ",
               },

               // errorElement : 'em',
               // errorLabelContainer: '.error-msg',

               errorPlacement: function(error, element) {
                   if (element.attr("name") == "delivery_country_id" )
                       error.insertAfter("#delivery_country_id_error");
                   else if  (element.attr("name") == "billing_country_id" )
                       error.insertAfter("#billing_country_id_error");
                   else if  (element.attr("name") == "terms_and_conditions" )
                       error.insertAfter("#terms_and_conditions_error");
                   else
                       error.insertAfter(element);
               },
               
               // Called when the element is invalid:
               highlight: function(element) {
                   $(element).css('background', '#ffdddd');
               },
               
               // Called when the element is valid:
               unhighlight: function(element) {
                   $(element).css('background', '#ffffff');
               }
           });
       });
   </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
  <script>
      $( document ).ready(function() {
          $('#timezone_identifier').val(moment.tz.guess())
      });        
  </script>

  <script>
      function leader_show() {
          var x = document.getElementById("delivery-address");
          if (x.style.display === "none") {
              x.style.display = "block";
              $('#id_delivery_country_id').prop('required',true);
              $('#id_delivery_city').prop('required',true);
              $('#id_delivery_state').prop('required',true);
              $('#id_delivery_postal_code').prop('required',true);
              $('#id_delivery_address').prop('required',true);
          } else {
              x.style.display = "none";
              $('#id_delivery_country_id').removeAttr('required');
              $('#id_delivery_city').removeAttr('required');
              $('#id_delivery_state').removeAttr('required');
              $('#id_delivery_postal_code').removeAttr('required');
              $('#id_delivery_address').removeAttr('required');
          }
      }
  </script>

  @if($customer->is_same_as_billing == 1)
    <script>
      $(document).ready( function() {
          $('#id_delivery_country_id').removeAttr('required');
          $('#id_delivery_city').removeAttr('required');
          $('#id_delivery_state').removeAttr('required');
          $('#id_delivery_postal_code').removeAttr('required');
          $('#id_delivery_address').removeAttr('required');
      });
    </script>
  @endif

  @if($customer->is_same_as_billing != 1)
      <script>
          $( document ).ready(function() {
            // $('#xxx :checkbox').attr('checked', 'checked').change();
            // $(':checkbox').attr('checked', 'checked').change();
            $(":checkbox").trigger('click');
          });        
      </script>
  @endif
@endsection