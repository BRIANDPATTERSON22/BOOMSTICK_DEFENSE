@extends('site.layouts.default')

@section('htmlheader_title')
  My Account
@endsection

@section('page-style')
  <style>
    .control-label {color: #343a40;font-weight: 700!important;letter-spacing: 1px;text-transform: uppercase;}
  </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>My account</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a> My account</a></li>
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
                 {!!Form::model($customer, ['autocomplete' => 'off'])!!}
                 {!!csrf_field()!!}
                 <div class="row">
                   <div class="col-sm-6">
                     <div class="form-group">
                       <label for="checkout-fn" class="control-label" >First Name *</label>
                       {!!Form::text('first_name', null, ['id'=>'checkout-fn', 'class' => 'form-control border-form-control', 'placeholder'=>'First name'])!!}
                       <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                     </div>
                   </div>
                   <div class="col-sm-6">
                     <div class="form-group">
                       <label for="checkout-ln" class="control-label" >Last Name *</label>
                       {!!Form::text('last_name', null, ['id'=>'checkout-ln', 'class' => 'form-control border-form-control', 'placeholder'=>'Last name'])!!}
                       <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-sm-5">
                     <div class="form-group">
                       <label for="checkout-email" class="control-label" >E-mail Address *</label>
                       {!!Form::email('email', null, ['id'=>'checkout-email', 'class' => 'form-control border-form-control', 'readonly', 'placeholder'=>'Email address'])!!}
                       <em class="error-msg">{!!$errors->first('email')!!}</em>
                     </div>
                   </div>
                   <div class="col-sm-3">
                     <div class="form-group">
                       <label for="checkout-phone" class="control-label" >Country Code *</label>
                       {!!Form::tel('mobile_contry_code', null, ['id'=>'checkout-phone', 'class' => 'form-control border-form-control', 'placeholder'=>'Country Code'])!!}
                       <em class="error-msg">{!!$errors->first('mobile_contry_code')!!}</em>
                     </div>
                   </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                       <label for="checkout-phone" class="control-label" >Phone Number *</label>
                       {!!Form::tel('mobile', null, ['id'=>'checkout-phone', 'class' => 'form-control border-form-control', 'placeholder'=>'Mobile number'])!!}
                       <em class="error-msg">{!!$errors->first('mobile')!!}</em>
                     </div>
                   </div>
                 </div>
                 {{-- <div class="row">
                   <div class="col-sm-6">
                     <div class="form-group">
                       <label for="checkout-company" class="control-label" >Company</label>
                       {!!Form::text('company', null, ['id'=>'checkout-company', 'class' => 'form-control border-form-control', 'placeholder'=>'Company name'])!!}
                       <em class="error-msg">{!!$errors->first('company')!!}</em>
                     </div>
                   </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                       <label for="checkout-country" class="control-label" >Country *</label>
                       {!!Form::select('country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Select country'])!!}
                       <em class="error-msg">{!!$errors->first('country_id')!!}</em>
                     </div>
                   </div>
                 </div> --}}


                    <hr>
                   <div id="billing-address">
                     <div class="row">
                       <div class="col-sm-12">
                         <div class="form-group">
                           <label for="checkout-address1" class="control-label" >Billing Address *</label>
                           {!!Form::textarea('address1', null, ['id'=>'checkout-address1', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Your Billing Address', 'rows' => '4', 'required'])!!}
                           <em class="error-msg">{!!$errors->first('address1')!!}</em>
                         </div>
                       </div>
                     </div>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="checkout-city" class="control-label" >City *</label>
                        {!!Form::text('city', null, ['id'=>'checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('city')!!}</em>
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                           <label for="checkout-state" class="control-label" >County *</label>
                          {!!Form::text('state', null, ['id'=>'checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County', 'required'])!!}
                          <em class="error-msg">{!!$errors->first('state')!!}</em>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="checkout-zip" class="control-label" > Post code *</label>
                        {!!Form::text('postal_code', null, ['id'=>'checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('postal_code')!!}</em>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="checkout-country" class="control-label" >Country *</label>
                        {!!Form::select('billing_country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Select country'])!!}
                        <em class="error-msg">{!!$errors->first('billing_country_id')!!}</em>
                      </div>
                    </div>
                  </div>
                    </div>

                   <div class="form-group">
                       <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" @if($customer->is_same_as_billing == 1) checked @endif >
                       <label>If the Delivery address is same as Billing address, please tick this check box.</label>
                   </div>

                   <div id="delivery-address" @if($customer->is_same_as_billing == 1) style="display: none" @endif>
                     <hr>
                   <div class="row">
                     <div class="col-sm-12">
                       <div class="form-group">
                         <label for="checkout-address2" class="control-label">Delivery Address *</label>
                         {!!Form::textarea('address2', null, ['id'=>'d-checkout-address2', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Your Delivery Address', 'rows' => '4', 'required'])!!}
                         <em class="error-msg">{!!$errors->first('address2')!!}</em>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-sm-3">
                       <div class="form-group">
                         <label for="checkout-city" class="control-label" >City *</label>
                         {!!Form::text('delivery_city', null, ['id'=>'d-checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City', 'required'])!!}
                         <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <div class="form-group">
                            <label for="checkout-state" class="control-label" >County *</label>
                           {!!Form::text('delivery_state', null, ['id'=>'d-checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County', 'required'])!!}
                           <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <div class="form-group">
                         <label for="checkout-zip" class="control-label" >Post code *</label>
                         {!!Form::text('delivery_postel_code', null, ['id'=>'d-checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *', 'required'])!!}
                         <em class="error-msg">{!!$errors->first('delivery_postel_code')!!}</em>
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <div class="form-group">
                         <label for="checkout-country" class="control-label" >Country *</label>
                         {!!Form::select('delivery_country_id', $countries, null, ['id'=>'d-checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Select country' , 'required'])!!}
                         <em class="error-msg">{!!$errors->first('delivery_country_id')!!}</em>
                       </div>
                     </div>
                   </div>
                   </div>

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
                 

                  
                  

                 <div class="row padding-bottom-1x">
                   <div class="col-12">
                     <div class="d-flex flex-wrap justify-content-between align-items-center">
                       <button class="btn btn-outline-danger btn-lg pull-left" type="submit">Cancel</button>
                       <button class="btn btn-outline-success btn-lg cursor-pointer" type="submit">Update Profile</button>
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