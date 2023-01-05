@extends('site.layouts.default')

@section('htmlheader_title')
    Trade Sign Up
@endsection

@section('page-style')
    <style>
        .hide{display: none;}
        .validation {position: relative;/*top: -30px;left: 240px;*/}
        #valid-msg {position: absolute;color: green;top: -30px;left: 230px;}
        .error-msg {color: red !important;}
        #error-msg {position: absolute;color: red !important;top: -30px;left: 230px;}
        .inner-about { background: rgba(0, 0, 0, 0) url({{ asset('site/images/sign-up/bg_cake_time_club.jpg') }}) no-repeat scroll center top; height: 130px; background-position: center;}
        .about_page .widget-margin-top {margin-top: -100px;padding: 37px 17px;}
        .about_page {background: #f5f8fc none repeat scroll 0 0;}
        .login-modal-right {padding: 0px;}
        .login-footer-tab {border-top: 1px solid #ccc; /* margin: 0 -30px; */margin: 30px 0px; padding: 30px 0 0;}
        .p-2{padding: 2px !important}
        .p-5{padding: 5px !important}
        .p-8{padding: 8px !important}
        .heading-design-form {font-size: 13px;font-weight: 600;margin: 0 0 20px;position: relative;text-transform: uppercase;}
        .heading-design-form::after {background: rgba(0, 0, 0, 0) linear-gradient(to right, #da318c 0%, #ff0089 100%) repeat scroll 0 0;border-radius: 12px;content: "";height: 1px;left: 0;position: absolute;bottom: -3px;width: 20px;}
        .heading-design-h5::after {left: 45%;}
        .error{color:red;}
        /*.form-group label {font-size: 12px;font-weight: 100;margin: 0;}*/
        .border-form-control {
            background: #ffffff none repeat scroll 0 0;
            border: 1px solid #e6e7ec;
            border-radius: 2px;
            font-size: 14px;
            line-height: normal;
            font-weight: 600;}
            .select2-selection {background: #ffffff none repeat scroll 0 0!important;}

            .login_submit a {
                 line-height: 13px; 
            }
            
            .account_form label:hover {
                color: initial;
            }





    </style>
@endsection

@section('main-content')
  <!--breadcrumbs area start-->
  <div class="breadcrumbs_area">
      <div class="container">   
          <div class="row">
              <div class="col-12">
                  <div class="breadcrumb_content">
                      <ul>
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li>Wholesale Register</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>         
  </div>
  <!--breadcrumbs area end-->

  <!-- customer login start -->
  <div class="customer_login mt-60">
      <div class="container">
          <div class="row">
             <!--login area start-->
              <div class="col-lg-6 col-md-6 mx-auto">
                <div class="inno_shadow">
                    @include('site.partials.flash_message')
                </div>  
                  <div class="account_form inno_shadow">
                    
                    {!! Form::model(null,  array('autocomplete' => 'off', 'id' => 'trade-form')) !!}
                    {!!csrf_field()!!}
                    <div class="section_title_footer title_footer text-center">
                      <h3 style="font-size: 20px;">Register as wholesale customr</h3>
                    </div>

                    <h5 class="heading-design-form">Account Details</h5>
                    <div class="form-group">
                        {!! Form::text('first_name', null, ['class'=>'form-control border-form-control', 'placeholder' => 'First Name *']) !!}
                        <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                    </div>
                    <div class="form-group">
                        {!! Form::text('last_name', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Last Name *']) !!}
                        <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                    </div>
                     <div class="form-group">
                         {!! Form::email('email', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Email Address *']) !!}
                         <em class="error-msg">{!!$errors->first('email')!!}</em>
                     </div>
                     <div class="form-group">
                         {!! Form::password('password', ['id'=>'pass2', 'class'=>'form-control border-form-control', 'placeholder' => 'Password *']) !!}
                         <em class="error-msg">{!!$errors->first('password')!!}</em>
                     </div>
                     <div class="form-group">
                         {!! Form::password('password_confirmation', ['id'=>'pass1', 'class'=>'form-control border-form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Confirm Password *']) !!}
                         <em class="error-msg">{!!$errors->first('password')!!}</em>
                     </div>

                     <div class="form-group">
                         {!! Form::text('mobile', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Contact No*']) !!}
                         <em class="error-msg" id="mobile_error">{!!$errors->first('mobile')!!}</em>
                     </div>
                     
                    
                    {{--  <h5 class="heading-design-form">Company Details</h5>
                     <div class="form-group">
                         {!! Form::text('company_name', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Trade Name *']) !!}
                         <em class="error-msg">{!!$errors->first('company_name')!!}</em>
                     </div>
                     <div class="form-group">
                         {!!Form::text('year_established', null, ['id'=>'year_established', 'class' => 'form-control border-form-control', 'placeholder'=>'Established year'])!!}
                         <em class="error-msg">{!!$errors->first('year_established')!!}</em>
                     </div>
                     <div class="form-group">
                         {!!Form::text('company_reg_no', null, ['id'=>'company_reg_no', 'class' => 'form-control border-form-control', 'placeholder'=>'Registration No'])!!}
                         <em class="error-msg">{!!$errors->first('company_reg_no')!!}</em>
                     </div>
                     <div class="form-group">
                         {!!Form::text('vat_no', null, ['id'=>'vat_no', 'class' => 'form-control border-form-control', 'placeholder'=>'VAT No'])!!}
                         <em class="error-msg">{!!$errors->first('vat_no')!!}</em>
                     </div>
                     <div class="form-group {{ $errors->has('business_type') ? 'has-error' : '' }}">
                          @php $business_type_list = ['1' => 'Sugarcraft Shop', '2' => 'Bakery','3' => 'Cook Shop', '4' => 'Home Trader', '5' => 'Other']; @endphp
                          {!!Form::select('business_type', $business_type_list, null, ['class' => 'form-control', 'placeholder'=>'Business type'])!!}
                          <em class="error-msg">{!!$errors->first('business_type')!!}</em>
                      </div> --}}

                      {{-- <div class="intlmobile">
                          <div class="form-group" style="z-index: 9;">
                              <input type="tel" id="phone" class="form-control text-input number border-form-control" name="mobile" onfocus="ph_focus()" value="{{old('mobile')}}">
                              <input type="hidden" id="mobVal" name="mobile_country">
                              <div class="validation">
                                  <span id="valid-msg" class="hide"><i class="fa fa-check"></i> </span>
                                  <span id="error-msg" class="hide"><i class="fa fa-remove"></i></span>
                              </div>
                              <em class="error-msg" id="mobile_error">{!!$errors->first('mobile')!!}</em>
                          </div>
                          <script>
                              
                              // $(document).ready(function() {
                              //     $('.flag-container').click(function () {
                              //         $("body").addClass("modal-open");
                              //     });
                              // });
                              

                              function ph_focus() {
                                  $("body").removeClass("modal-open");
                              }
                          </script>
                      </div> --}}

                      {{-- <div class="form-group">
                          {!!Form::text('fax', null, ['id'=>'checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Fax No'])!!}
                          <em class="error-msg">{!!$errors->first('fax')!!}</em>
                      </div> --}}
                    {{--   <div class="form-group">
                          {!! Form::url('company_website', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Website']) !!}
                          <em class="error-msg">{!!$errors->first('company_website')!!}</em>
                      </div> --}}
                      
                       <h5 class="heading-design-form">Billing Address</h5>
                       <div id="billing-address">
                         <div class="form-group">
                             {{-- <label for="checkout-address1" class="control-label">Billing Address *</label> --}}
                             {!!Form::textarea('address1', null, ['id'=>'checkout-address1', 'class' => 'form-control border-form-control', 'placeholder'=>'Address *','rows' => '4', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('address1')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('city', null, ['id'=>'checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('city')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('state', null, ['id'=>'checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'State *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('state')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('postal_code', null, ['id'=>'postal_code', 'class' => 'form-control border-form-control', 'placeholder'=>'Zip code *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('postal_code')!!}</em>
                         </div>
                       </div>
                       <div class="form-group">
                         {{-- <label for="checkout-country" class="control-label">Delivery Country *</label> --}}
                         {!!Form::select('billing_country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Country *', 'required'])!!}
                         <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_country_id')!!}</em>
                       </div>
                       <div class="form-group">
                           <label class="d-inline">
                            <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" class="h_15 width_none_">
                           If the Delivery address is same as Billing address, please tick this check box.
                          </label>
                       </div>

                       <div id="delivery-address">
                         <h5 class="heading-design-form">Delivery Address</h5>
                         <div class="form-group">
                             {{-- <label for="checkout-address2" class="control-label">Delivery Address</label> --}}
                             {!!Form::textarea('address2', null, ['id'=>'d-checkout-address2', 'class' => 'form-control border-form-control', 'placeholder'=>'Address *', 'rows' => '4', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('address2')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('delivery_city', null, ['id'=>'d-checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('delivery_state', null, ['id'=>'d-checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'State *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                         </div>
                         <div class="form-group">
                             {!!Form::text('delivery_postel_code', null, ['id'=>'d-checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Zip code *', 'required'])!!}
                             <em class="error-msg">{!!$errors->first('delivery_postel_code')!!}</em>
                         </div>
                         <div class="form-group">
                           {{-- <label for="checkout-country" class="control-label">Delivery Country *</label> --}}
                           {!!Form::select('delivery_country_id', $countries, null, ['id'=>'d-checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Country *', 'required'])!!}
                           <em class="error-msg" id="delivery_country_id_error">{!!$errors->first('delivery_country_id')!!}</em>
                         </div>
                       </div>

                      {{--  <script>
                           function leader_show() {
                               var x = document.getElementById("delivery-address");
                               if (x.style.display === "none") {
                                   x.style.display = "block";
                               } else {
                                   x.style.display = "none";
                               }
                           }
                       </script> --}}

                       

                       


                    
                    <div class="form-group">
                        {!! Recaptcha::render() !!}
                        <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                    </div>
          
                    {{-- <div class="login_submit clearfix">
                        <label for="remember" class="float-left">
                          <input type="checkbox" class="float-left" name="terms_and_conditions" value="1">
                          <a href="{{ url('terms-and-conditions') }}" target="_new" class="clearfix">I Agree with  Term and Conditions. </a>
                        </label>
                    </div>
                    <em class="error-msg float-left" id="terms_and_conditions_error">{!!$errors->first('terms_and_conditions')!!}</em> --}}


                    <div class="form-check">
                      <input name="terms_and_conditions" class="form-check-input" type="checkbox" value="1" id="defaultCheck1" style="width: auto; height: auto;">
                      <label class="form-check-label" for="defaultCheck1" style="line-height:20px;">
                        Your personal data will be used to process your order. See our <a href="{{ url('privacy-policy') }}" target="_new">privacy policy</a> for any questions.
                      </label>
                    </div>
                    <em class="error-msg float-left" id="terms_and_conditions_error">{!!$errors->first('terms_and_conditions')!!}</em>

                    <hr>

                    <div class="form-group text-center">
                         <button type="submit" name="btn_wholesale" class="text-center">Create Wholesale Account</button>
                    </div>

                   {{--  <p>
                       <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                         <input id="subscription-id" type="checkbox" class="custom-control-input" name="is_subscribed" value="0">
                         <span class="custom-control-indicator"></span>
                         <span class="custom-control-description">Subscribe for Newsletter to get product updates! </span>
                       </label>
                    </p> --}}
                    {!! Form::close() !!}
                  </div>    
              </div>
              <!--login area start-->
          </div>
      </div>    
  </div>
  <!-- customer login end -->
@endsection

@section('page-script')
  <script>
      function leader_show() {
          var x = document.getElementById("delivery-address");
          if (x.style.display === "none") {
              x.style.display = "block";
              $('#d-checkout-address2').prop('required',true);
              $('#d-checkout-city').prop('required',true);
              $('#d-checkout-state').prop('required',true);
              $('#d-checkout-zip').prop('required',true);
              $('#d-checkout-country').prop('required',true);
          } else {
              x.style.display = "none";
              $('#d-checkout-address2').removeAttr('required');
              $('#d-checkout-city').removeAttr('required');
              $('#d-checkout-state').removeAttr('required');
              $('#d-checkout-zip').removeAttr('required');
              $('#d-checkout-country').removeAttr('required');
          }
      }
  </script>

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

        // assign function to onclick property of checkbox
        // document.getElementById('subscription-id').onclick = function() {
        //     if ( this.checked ) {
        //         // document.getElementById("subscription-id").value = "1";
        //         this.value = "1";
        //         // alert( this.value );
        //     } else {
        //         // if not checked ...
        //         // document.getElementById("subscription-id").value = "0";
        //         this.value = "0";
        //         // aalert( this.value );lert( this.value );
        //     }
        // };
    </script>
    
   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
      <script>
    $(document).ready(function () {
        $('#trade-form').validate({ // initialize the plugin
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
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true
                },
                // company_name: {
                //     required: true
                // },
                mobile: {
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
                password: "Please enter your password",
                password_confirmation: "Please enter your confirmation password",
                // company_name: "Please enter your company name",
                mobile: "Please enter your contact number",
                
                address1: "Please enter your billing address",
                city: "Please enter your billing city",
                state: "Please enter your billing county",
                postal_code: "Please enter your billing post code",
                billing_country_id: "Please select billing country",
                
                address2: "Please enter your delivery address",
                delivery_city: "Please enter your delivery city",
                delivery_state: "Please enter your delivery county",
                delivery_postel_code: "Please enter your delivery post code",
                delivery_country_id: "Please select delivery country",
                
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
                else if  (element.attr("name") == "mobile" )
                    error.insertAfter("#mobile_error");
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
@endsection
