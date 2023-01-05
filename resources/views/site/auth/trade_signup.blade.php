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


    </style>
@endsection

@section('main-content')
   {{--  <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger" style="margin-top: 15px">
                <strong>Whoops!</strong>
                There were some problems with your input.
            </div><br>
        @endif
    </div> --}}

{{--     <div class="osahan-breadcrumb">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12">
                <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="register.html#"><i class="icofont icofont-ui-home"></i> Home</a></li>
                   <li class="breadcrumb-item"><a href="register.html#">Pages</a></li>
                   <li class="breadcrumb-item active">Page Name</li>
                </ol>
             </div>
          </div>
       </div>
    </div> --}}

  <div class="inner-about">
  </div>
  <section class="about_page">
     <div class="container">
        <div class="row">
           <div class="col-lg-6 col-md-6 mx-auto">
              <div class="widget widget-margin-top">
                 <div class="section-header section-header-center text-center">
                    <h5 class="text-primary"> <b>WHY</b></h5>
                    <h3 class="heading-design-center-h3">
                       TRADE MEMBERSHIP
                    </h3>
                    <p>Why trade membership? Creating an account has many benefits: check out faster, keep more than one address, track orders and more.</p>
                    <br>
                 </div>

                 <div class="row">
                    <div class="col-4 p-8">
                       <div class="about_page_widget widget p-5">
                          <i class="icofont icofont-files" style="font-size: 50px;"></i>
                          <h2 style="font-size: 16px;">200+</h2>
                          <h5 style="font-size:10px !important;">Categories</h5>
                          {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> --}}
                       </div>
                    </div>
                    <div class="col-4 p-8">
                       <div class="about_page_widget widget p-5">
                          <i class="icofont icofont-globe" style="font-size: 50px;"></i>
                          <h2 style="font-size: 16px;">100+</h2>
                          <h5 style="font-size:10px !important;">Brands</h5>
                          {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> --}}
                       </div>
                    </div>
                    <div class="col-4 p-8">
                       <div class="about_page_widget widget p-5">
                          <i class="icofont icofont-cart-alt" style="font-size: 50px;"></i>
                          <h2 style="font-size: 16px;">1000+</h2>
                          <h5 style="font-size:10px !important;">Products</h5>
                          {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> --}}
                       </div>
                    </div>
                 </div>
                 <br>
                
                <div class="login-modal-right">
                   <!-- Tab panes -->
                   <div class="tab-content">
                      <div class="tab-pane active" id="register" role="tabpanel">
                         <h5 class="heading-design-h5 text-center">Register Now!</h5>
                         @include('site.partials.flash_message')
                         {!! Form::model(null,  array('autocomplete' => 'off', 'id' => 'trade-form')) !!}
                         {!!csrf_field()!!}
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
                          
                        
                          <h5 class="heading-design-form">Company Details</h5>
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
                           </div>
                           <div class="intlmobile">
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
                           {{-- <div class="form-group">
                               {!!Form::text('fax', null, ['id'=>'checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Fax No'])!!}
                               <em class="error-msg">{!!$errors->first('fax')!!}</em>
                           </div> --}}
                           <div class="form-group">
                               {!! Form::url('company_website', null, ['class'=>'form-control border-form-control', 'placeholder' => 'Website']) !!}
                               <em class="error-msg">{!!$errors->first('company_website')!!}</em>
                           </div>
                           
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
                                  {!!Form::text('state', null, ['id'=>'checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('state')!!}</em>
                              </div>
                              <div class="form-group">
                                  {!!Form::text('postal_code', null, ['id'=>'postal_code', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('postal_code')!!}</em>
                              </div>
                            </div>
                            <div class="form-group">
                              {{-- <label for="checkout-country" class="control-label">Delivery Country *</label> --}}
                              {!!Form::select('billing_country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Country *', 'required'])!!}
                              <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_country_id')!!}</em>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1">
                                <label>If the Delivery address is same as Billing address, please tick this check box.</label>
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
                                  {!!Form::text('delivery_state', null, ['id'=>'d-checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County *', 'required'])!!}
                                  <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                              </div>
                              <div class="form-group">
                                  {!!Form::text('delivery_postel_code', null, ['id'=>'d-checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *', 'required'])!!}
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

                            


                        
                         <div class="form-group">
                             {!! Recaptcha::render() !!}
                             <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                         </div>
                         <p>
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                              <input type="checkbox" class="custom-control-input" name="terms_and_conditions" value="1">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">I Agree with <a href="{{ url('terms-and-conditions') }}" target="_new"> Term and Conditions. </a></span>
                            </label>
                             <em class="error-msg" id="terms_and_conditions_error" style="display: block;">{!!$errors->first('terms_and_conditions')!!}</em>
                         </p>

                         <p>
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                              <input id="subscription-id" type="checkbox" class="custom-control-input" name="is_subscribed" value="0">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">Subscribe for Newsletter to get product updates! </span>
                            </label>
                         </p>

                         <fieldset class="form-group">
                            <button name="trade-signup" type="submit" class="btn btn-lg btn-theme-round btn-block cursor-pointer">Create Trade Account</button>
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


{{--     <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>Sign Up</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="separator">&nbsp;</li>
                    <li>Sign Up</li>
                </ul>
            </div>
        </div>
    </div> --}}
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

        // assign function to onclick property of checkbox
        document.getElementById('subscription-id').onclick = function() {
            if ( this.checked ) {
                // document.getElementById("subscription-id").value = "1";
                this.value = "1";
                // alert( this.value );
            } else {
                // if not checked ...
                // document.getElementById("subscription-id").value = "0";
                this.value = "0";
                // aalert( this.value );lert( this.value );
            }
        };
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
                company_name: {
                    required: true
                },
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
                company_name: "Please enter your company name",
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
