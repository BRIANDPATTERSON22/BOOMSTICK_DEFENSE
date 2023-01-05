@extends('site.layouts.default')

@section('htmlheader_title')
  Checkout As Guest
@endsection

@section('page-style')
  <style>
    .table-responsive {
        /*overflow: hidden;*/
    }
    .modal-header .close {
         padding: 0rem; 
    }

    .modal-content button.close {
        top: 25px;
    }


    .heading-design-form {font-size: 13px;font-weight: 600;margin: 0 0 20px;position: relative;text-transform: uppercase;}
    .heading-design-form::after {background: rgba(0, 0, 0, 0) linear-gradient(to right, #da318c 0%, #ff0089 100%) repeat scroll 0 0;border-radius: 12px;content: "";height: 1px;left: 0;position: absolute;bottom: -3px;width: 20px;}
    .heading-design-h5::after {left: 45%;}

    .error {
        color: red;
    }
    .order_table table tbody tr td {
        padding: 2px 0px;
    }

    .order_table table tfoot tr th {
        padding: 2px 0px;
        font-size: 11px;
    }

    .order_table table tfoot tr td {
        padding: 2px 0px;
        font-size: 11px;
    }

    .order_table table thead tr th {
        padding: 3px 0;
    }

    .table-responsive table tbody tr td {
        font-size: 11px;
    }

    label {
        margin-bottom: .1rem;
    }

    .heading-design-form { margin: 0 0 5px;}
    .checkout_form h3 { font-size: 12px; padding: 0px 10px;}
    .table td, .table th { padding: .1rem;}
    .checkout_form input { font-size: 12px;}
    .form-control {font-size: 12px;}
    .checkout_form label {font-weight: 500; font-size: 11px;}
    .table thead th {font-size: 11px;}
  </style>
@endsection

@section('main-content')

  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>checkout</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a> Checkout As Guest</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

{{--   <section class="section-big-py-space bg-light">
      <div class="custom-container">
          <div class="checkout-page contact-page">
              <div class="checkout-form">
                  <form>
                      <div class="row">
                          <div class="col-lg-6 col-sm-12 col-xs-12">
                              <div class="checkout-title">
                                  <h3>Billing Details</h3></div>
                              <div class="theme-form">
                                  <div class="row check-out ">

                                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                          <label>First Name</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                          <label>Last Name</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                          <label class="field-label">Phone</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                          <label class="field-label">Email Address</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                          <label class="field-label">Country</label>
                                          <select>
                                              <option>India</option>
                                              <option>South Africa</option>
                                              <option>United State</option>
                                              <option>Australia</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                          <label class="field-label">Address</label>
                                          <input type="text" name="field-name" value="" placeholder="Street address">
                                      </div>
                                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                          <label class="field-label">Town/City</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                          <label class="field-label">State / County</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                          <label class="field-label">Postal Code</label>
                                          <input type="text" name="field-name" value="" placeholder="">
                                      </div>
                                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                          <input type="checkbox" name="shipping-option" id="account-option"> &ensp;
                                          <label for="account-option">Create An Account?</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-6 col-sm-12 col-xs-12">
                              <div class="checkout-details theme-form  section-big-mt-space">
                                  <div class="order-box">
                                      <div class="title-box">
                                          <div>Product <span>Total</span></div>
                                      </div>
                                      <ul class="qty">
                                          <li>Pink Slim Shirt × 1 <span>$25.10</span></li>
                                          <li>SLim Fit Jeans × 1 <span>$555.00</span></li>
                                      </ul>
                                      <ul class="sub-total">
                                          <li>Subtotal <span class="count">$380.10</span></li>
                                          <li>Shipping
                                              <div class="shipping">
                                                  <div class="shopping-option">
                                                      <input type="checkbox" name="free-shipping" id="free-shipping">
                                                      <label for="free-shipping">Free Shipping</label>
                                                  </div>
                                                  <div class="shopping-option">
                                                      <input type="checkbox" name="local-pickup" id="local-pickup">
                                                      <label for="local-pickup">Local Pickup</label>
                                                  </div>
                                              </div>
                                          </li>
                                      </ul>
                                      <ul class="total">
                                          <li>Total <span class="count">$620.00</span></li>
                                      </ul>
                                  </div>
                                  <div class="payment-box">
                                      <div class="upper-box">
                                          <div class="payment-options">
                                              <ul>
                                                  <li>
                                                      <div class="radio-option">
                                                          <input type="radio" name="payment-group" id="payment-1" checked="checked">
                                                          <label for="payment-1">Check Payments<span class="small-text">Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span></label>
                                                      </div>
                                                  </li>
                                                  <li>
                                                      <div class="radio-option">
                                                          <input type="radio" name="payment-group" id="payment-2">
                                                          <label for="payment-2">Cash On Delivery<span class="small-text">Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span></label>
                                                      </div>
                                                  </li>
                                                  <li>
                                                      <div class="radio-option paypal">
                                                          <input type="radio" name="payment-group" id="payment-3">
                                                          <label for="payment-3">PayPal<span class="image"><img src="https://themes.pixelstrap.com/bigdeal/html/assets/images/paypal.png" alt=""></span></label>
                                                      </div>
                                                  </li>
                                              </ul>
                                          </div>
                                      </div>
                                      <div class="text-right"><a href="checkout.html#" class="btn-normal btn">Place Order</a></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </section> --}}
  


    <section class="section-big-py-space bg-light">
        <div class="container">
            @if(count($cartItems)>0)
                <div class="checkout_form">
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            {{-- Address --}}
                            <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4">
                                <h3>Billing Details</h3>
                                {!!Form::model( session('addressValidationSession') ?? null, ['url'=> 'address', 'autocomplete'=>'off', 'id' => 'wholesale-form'])!!}
                                {!!csrf_field()!!}

                                {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>First Name <span class="required">*</span></label>
                                            {!!Form::text('first_name', null, ['id'=>'checkout-fn', 'class' => 'form-control border-form-control', 'placeholder'=>'First name'])!!}
                                            <em class="text-danger">{!!$errors->first('first_name')!!}</em>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <span class="required">*</span></label>
                                            {!!Form::text('last_name', null, ['id'=>'checkout-ln', 'class' => 'form-control border-form-control', 'placeholder'=>'Last name'])!!}
                                           <em class="text-danger">{!!$errors->first('last_name')!!}</em>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Email Address <span class="required">*</span></label>
                                            {!!Form::email('email', null, ['id'=>'checkout-email', 'class' => 'form-control border-form-control', 'placeholder'=>'Email address'])!!}
                                           <em class="text-danger">{!!$errors->first('email')!!}</em>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Mobile <span class="required">*</span></label>
                                            {!!Form::tel('mobile', null, ['id'=>'checkout-phone', 'class' => 'form-control border-form-control', 'placeholder'=>'Contact Number'])!!}
                                           <em class="text-danger">{!!$errors->first('mobile')!!}</em>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                             {!!Form::text('company_name', null, ['id'=>'checkout-ln', 'class' => 'form-control border-form-control', 'placeholder'=>'Company Name'])!!}
                                            <em class="text-danger">{!!$errors->first('company_name')!!}</em>
                                        </div>
                                    </div>
                                </div>

                                <div id="billing-address">
                                    <h5 class="heading-design-form">Enter Your Billing Info</h5>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="checkout-address1" class="control-label">Address *</label>
                                            {!!Form::textarea('address1', null, ['id'=>'checkout-address1', 'class' => 'form-control border-form-control', 'placeholder'=>'Address *','rows' => '2', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('address1')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="checkout-address1" class="control-label">City *</label>
                                            {!!Form::text('city', null, ['id'=>'checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('city')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="checkout-address1" class="control-label">State *</label>
                                            {!!Form::text('state', null, ['id'=>'checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'State *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('state')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="checkout-address1" class="control-label">Zip *</label>
                                            {!!Form::text('postal_code', null, ['id'=>'postal_code', 'class' => 'form-control border-form-control', 'placeholder'=>'Zip code *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('postal_code')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="checkout-country" class="control-label">Country *</label>
                                          {!!Form::select('billing_country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Country *', 'required'])!!}
                                          <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_country_id')!!}</em>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="d-inline">
                                         <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" class="h_15 width_none_"  @if(session('isSameAsBillingSession') == 1) checked @endif>
                                        If the Delivery address is same as Billing address, please tick this check box.
                                       </label>
                                    </div>
                                </div>

                                <div id="delivery-address" @if(session('isSameAsBillingSession') == 1) style="display: none" @endif>
                                    <h5 class="heading-design-form">Enter Delivery Info</h5>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            {!!Form::textarea('address2', null, ['id'=>'d-checkout-address2', 'class' => 'form-control border-form-control', 'placeholder'=>'Address *', 'rows' => '2', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('address2')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!!Form::text('delivery_city', null, ['id'=>'d-checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!!Form::text('delivery_state', null, ['id'=>'d-checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'State *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!!Form::text('delivery_postel_code', null, ['id'=>'d-checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Zip code *', 'required'])!!}
                                            <em class="error-msg">{!!$errors->first('delivery_postel_code')!!}</em>
                                        </div>
                                        <div class="form-group col-md-3">
                                          {{-- <label for="checkout-country" class="control-label">Delivery Country *</label> --}}
                                          {!!Form::select('delivery_country_id', $countries, null, ['id'=>'d-checkout-country', 'class' => 'form-control border-form-control', 'placeholder'=>'Country *', 'required'])!!}
                                          <em class="error-msg" id="delivery_country_id_error">{!!$errors->first('delivery_country_id')!!}</em>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mt-4">
                                        <div class="form-grou text-center">
                                            {{-- <a href="{{ url('cart') }}" class="btn btn-secondary order-btn mr-auto" style="border-radius: 30px;">Back to Cart</a> --}}
                                            <button type="submit" class="btn btn-success order-btn float-right_" style="border-radius: 30px;">Choose Shipping Methods</button>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            {{-- API Shipping method --}}
                                @if (session('addressValidationSession') && count($rating) > 0)
                                    <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4">
                                        {!!Form::open(['url'=> 'shipping', 'autocomplete'=>'off', 'name' => 'shipping_form'])!!}
                                        {!!csrf_field()!!}

                                        <input type="hidden" name="sub_shipping_method_price" id="subShippingMethodPrice">
                                        <input type="hidden" name="sub_shipping_method_service_name" id="subShippingServiceName">

                                          <h3>Shipping Method <span class="pull-right">{{-- {{ Session::get('totalWeightSesssion') }} LBS --}}</span></h3> 
                                          {{-- UPS --}}
                                          @if (count($rating) > 0)
                                              <div class="payment_method">
                                                 <div class="panel-default">
                                                      <input data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult" id="payment_defult" name="main_shipping_method" type="radio" data-target="createp_account" value="2" @if(session('mainShippingIdSession') == 2) checked @endif />
                                                      <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">
                                                        UPS 
                                                        {{-- <img src="assets/img/icon/papyel.png" alt=""> --}}
                                                      </label>

                                                      <div id="collapsedefult" class="collapse one" data-parent="#accordion">
                                                          <div class="card-body1">
                                                               {{-- <h3>Select shipping Method</h3>  --}}
                                                               <div class="table-responsive">
                                                                   <table class="table table-hover_ table-borderless">
                                                                     <thead>
                                                                       <tr>
                                                                         {{-- <th scope="col">#</th> --}}
                                                                         <th scope="col" class="text-left">Shipping methods</th>
                                                                         {{-- <th scope="col">Delivery time</th> --}}
                                                                         {{-- <th scope="col">Handling fee</th> --}}
                                                                       </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                        <?php $count = 0; ?>
                                                                        @foreach($rating as $row)
                                                                        <?php $count++; ?>
                                                                            <tr>
                                                                            {{-- <input type="hidden" name="sub_shipping_method_price" id="subShippingMethodPrice"> --}}
                                                                            {{-- <th scope="row">{{$count}}</th> --}}
                                                                            <td class="text-left">
                                                                                <label style="margin-left: 10px;">
                                                                                    <input style="width: auto; height: auto;" type="radio" name="sub_shipping_method" value="{{ $row['shipping_code'] }}" @if(session('subShippingIdSession') == $row['shipping_code']) checked @endif required data-sub-shipping-charge = "{{ $row['amount'] }}" data-sub-shipping-service = "{{$row['shipping_service']}}">
                                                                                    {{$row['shipping_service']}}
                                                                                    {{-- <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small> --}}
                                                                                    
                                                                                    <b> <u>{{ $option->currency_symbol }}{{number_format($row['amount'], 2)}}</u> </b>
                                                                                </label>
                                                                            </td>
                                                                            {{-- <td>{{ $row['shipping_code'] }}</td> --}}
                                                                            {{-- <td>{{ $option->currency_symbol }}{{number_format($row['amount'], 2)}}</td> --}}
                                                                            </tr>
                                                                        @endforeach
                                                                     </tbody>
                                                                   </table>
                                                                 </div>
                                                                  {{-- <button type="submit" class="btn btn-succes" name="shipping_btn">Add</button> --}}
                                                          </div>
                                                      </div>
                                                  </div>

                                                  {{-- <div class="order_button">
                                                      <button  type="submit">Proceed to PayPal</button> 
                                                  </div> --}}    
                                              </div> 
                                          @endif


                                            @if (count($fedExRating) > 0)
                                                <div class="payment_method">
                                                    <div class="panel-default">
                                                        <input data-toggle="collapse" data-target="#collapseFedEx" aria-controls="collapseFedEx" id="fedex_label" name="main_shipping_method" type="radio" data-target="createp_account" value="5" @if(session('mainShippingIdSession') == 5) checked @endif />
                                                        <label for="fedex_label" data-toggle="collapse" data-target="#collapseFedEx" aria-controls="collapseFedEx">
                                                        FedEx 
                                                        {{-- <img src="{{ asset('site/img/icon/papyel.png') }}" alt=""> --}}
                                                        </label>

                                                      <div id="collapseFedEx" class="collapse one" data-parent="#accordion">
                                                          <div class="card-body1">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover_ table-borderless">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" class="text-left">Shipping methods</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($fedExRating as $row)
                                                                                <tr>
                                                                                    <td class="text-left">
                                                                                        <label class="ml-2">
                                                                                            <input style="width: auto; height: auto;" type="radio" name="sub_shipping_method" value="{{ $row['shipping_code'] }}" @if(session('subShippingIdSession') == $row['shipping_code']) checked @endif required data-sub-shipping-charge = "{{ $row['amount'] }}" data-sub-shipping-service = "{{$row['shipping_service']}}">
                                                                                            {{ str_replace("_", " ", $row['shipping_service']) }}
                                                                                            <b> <u>{{ $option->currency_symbol }}{{number_format($row['amount'], 2)}}</u> </b>
                                                                                        </label>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                          </div>
                                                      </div>
                                                    </div>   
                                                </div> 
                                            @endif



                                      {!!Form::close()!!} 
                                    </div>
                                @endif

                                {{-- Shipping --}}
                                {{-- <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4">
                                  {!!Form::open(['url'=> 'shipping', 'autocomplete'=>'off', 'name' => 'shipping_form'])!!}
                                  {!!csrf_field()!!}
                                     <h3>Select shipping Method</h3> 
                                     <div class="table-responsive">
                                         <table class="table">
                                           <thead>
                                             <tr>
                                               <th scope="col">#</th>
                                               <th scope="col" class="text-left">Shipping methods</th>
                                               <th scope="col">Delivery time</th>
                                               <th scope="col">Handling fee</th>
                                             </tr>
                                           </thead>
                                           <tbody>
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach($shippingData as $row)
                                                    @php
                                                        $count++;
                                                    @endphp
                                                    <tr>
                                                    <th scope="row">{{$count}}</th>
                                                    <td class="text-left">
                                                        <label style="margin-left: 10px;">
                                                            <input style="width: auto; height: auto;" type="radio" name="ship_method" value="{{ $row->id }}" @if(session('shippingIdSession') == $row->id) checked @endif required>
                                                            {{$row->title}}
                                                            <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small>
                                                        </label>
                                                    </td>
                                                    <td>{{$row->time}}</td>
                                                    <td>{{ $option->currency_symbol }}{{number_format($row->amount, 2)}}</td>
                                                    </tr>
                                                @endforeach
                                           </tbody>
                                         </table>
                                       </div>
                                        <button type="submit" class="btn btn-succes" name="shipping_btn">Add</button>
                                   {!!Form::close()!!}
                                </div> --}}

                                @if (session('shippingSingleDataSession'))
                                    {{-- Payment Method --}}
                                    <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4">
                                        {!!Form::open(['url'=> 'payment', 'autocomplete'=>'off', 'name' => 'payment_form'])!!}
                                        {!!csrf_field()!!}
                                         <h3>Payment Method</h3> 
                                         <div class="table-responsive">
                                             <table class="table table-borderless">
                                               <thead>
                                                 <tr>
                                                   {{-- <th scope="col">#</th> --}}
                                                   {{-- <th scope="col" class="text-left">Select a Payment method</th> --}}
                                                 </tr>
                                               </thead>
                                               <tbody>
                                                    <?php $count = 0; ?>
                                                    @foreach($allPaymentsData as $row)
                                                    <?php $count++; ?>
                                                        <tr>
                                                        {{-- <th scope="row">{{$count}}</th> --}}
                                                        <td class="text-left">
                                                            <label style="margin-left: 10px;">
                                                                <input style="width: auto; height: auto;" type="radio" name="payment_method" value="{{ $row->id }}" @if(session('paymentIdSession') == $row->id) checked @endif required>
                                                                {{$row->title}}
                                                                <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small>
                                                            </label>
                                                        </td>
                                                        </tr>
                                                    @endforeach
                                               </tbody>
                                             </table>
                                           </div>
                                            {{-- <button type="submit" class="btn btn-succes" name="payment_btn">Add</button> --}}
                                       {!!Form::close()!!}
                                    </div>
                                @endif
                        </div>

                        <div class="col-lg-4 col-md-4">
                          @if(session('addressValidationSession') && session('shippingSingleDataSession') && session('paymentSingleDataSession'))
                              {{-- Total Amount --}}
                              <div class="checkout_form_inner inno_shadow p-3 b_0">
                                {{-- {!!Form::open(['url'=> 'shipping', 'autocomplete'=>'off'])!!}
                                {!!csrf_field()!!} --}}
                                    <h3>Order Summary</h3> 
                                    <div class="order_table table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($cartItems as $item)
                                                <tr>
                                                    <td> {{str_limit($item->name, 100)}} <strong> × {{ $item->qty }}</strong></td>
                                                    <td> {{ $option->currency_symbol }}{{number_format(($item->qty * $item->price), 2)}} </td>
                                                </tr>
                                                @php 
                                                    $arrSubTotal[] = $item->qty * $item->price;
                                                @endphp
                                               @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Cart Subtotal</th>
                                                    <td>{{ $option->currency_symbol }}{{ number_format(array_sum($arrSubTotal), 2 ) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping</th>
                                                    <td>
                                                      <strong>{{ $option->currency_symbol }}{{ number_format($shippingAmount ? $shippingAmount : 0 , 2) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Payment</th>
                                                    <td>
                                                      <strong>{{$paymentSingleData ? $paymentSingleData->title : '--' }}</strong>
                                                    </td>
                                                </tr>
                                                <tr class="order_total">
                                                    <th>Grand Total</th>
                                                    <td><strong>{{ $option->currency_symbol }}{{ number_format(array_sum($arrSubTotal) + $shippingAmount , 2)}}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>     
                                    </div>
                                    
                                   {{--  <div class="payment_method">
                                       <div class="panel-default">
                                            <input id="payment" name="check_method" type="radio" data-target="createp_account" />
                                            <label for="payment" data-toggle="collapse" data-target="#method" aria-controls="method">Create an account?</label>

                                            <div id="method" class="collapse one" data-parent="#accordion">
                                                <div class="card-body1">
                                                   <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                </div>
                                            </div>
                                        </div> 
                                       <div class="panel-default">
                                            <input id="payment_defult" name="check_method" type="radio" data-target="createp_account" />
                                            <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">PayPal <img src="assets/img/icon/papyel.png" alt=""></label>

                                            <div id="collapsedefult" class="collapse one" data-parent="#accordion">
                                                <div class="card-body1">
                                                   <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order_button">
                                            <button  type="submit">Proceed to PayPal</button> 
                                        </div>    
                                    </div>  --}}
                               {{-- {!!Form::close()!!} --}}
                              </div>

                              {{-- Complete Order --}}
                              <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4" style="border-bottom: 5px solid #81d742 !important;">
                                  <h3>Complete the Order</h3>
                                  {!!Form::open(['url'=> 'checkout', 'autocomplete'=>'off', 'id' => 'order-form'])!!}
                                  {!!csrf_field()!!}
                                  <input type="hidden" name="timezone_identifier" id="timezone_identifier">
                                  <div class="row">
                                      <div class="col-lg-12 col-md-12">
                                          <div class="form-group">
                                              {!!Form::textarea('note', null, ['id'=>'d-checkout-note', 'class' => 'form-control border-form-control', 'placeholder'=>'Order Notes', 'rows' => '3'])!!}
                                              <em class="error-msg">{!!$errors->first('note')!!}</em>
                                          </div>

                                          <div class="form-group">
                                              {!! Recaptcha::render() !!}
                                              <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
                                          </div>
                                          
                                          <div class="form-check mb-20">
                                            <input name="terms_and_conditions" class="form-check-input" type="checkbox" value="1" id="defaultCheck1" style="width: auto; height: auto;">
                                            <label class="form-check-label" for="defaultCheck1" style="line-height:20px;">
                                              Your personal data will be used to process your order. See our <a href="{{ url('privacy-policy') }}" target="_new"><u>privacy policy.</u></a>
                                            </label>
                                          </div>
                                          <em class="error-msg float-left" id="terms_and_conditions_error">{!!$errors->first('terms_and_conditions')!!}</em>
                                      </div>
                                      <div class="col-lg-12 col-md-12">
                                          <div class="form-group">
                                              <a href="{{ url('cart') }}" class="btn btn-secondary order-btn mr-auto" style="border-radius: 30px;">Back to Cart</a>
                                              <button type="submit" class="btn btn-success order-btn float-right" style="border-radius: 30px;">Place Order</button>
                                          </div>
                                      </div>
                                  </div>
                                  {!! Form::close() !!}
                              </div>
                          @endif

                        </div>
                    </div> 
                </div> 
            @endif
        </div>       
    </div>
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

   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
      <script>
    $(document).ready(function () {
        $('#wholesale-form').validate({ // initialize the plugin
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
                mobile: "Please enter your contact number",
                
                address1: "Please enter your billing address",
                city: "Please enter your billing city",
                state: "Please enter your billing state",
                postal_code: "Please enter your billing zip code",
                billing_country_id: "Please select billing country",
                
                address2: "Please enter your delivery address",
                delivery_city: "Please enter your delivery city",
                delivery_state: "Please enter your delivery state",
                delivery_postel_code: "Please enter your delivery zip code",
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


        $('#order-form').validate({ // initialize the plugin
            rules: {
                // first_name: {
                //     required: true
                // },
                // last_name: {
                //     required: true
                // },
                // email: {
                //     required: true,
                //     email: true
                // },
                // mobile: {
                //     required: true
                // },
                // g-recaptcha-response: {
                //     required: true
                // },
                terms_and_conditions: {
                    required: true
                }
            },
            
            messages: {
                // first_name: "Please enter your first name",
                // last_name: "Please enter your last name",
                // email: "Please enter your email id",
                // mobile: "Please enter your contact number",
                
                // address1: "Please enter your billing address",
                // city: "Please enter your billing city",
                // state: "Please enter your billing state",
                // postal_code: "Please enter your billing zip code",
                // billing_country_id: "Please select billing country",
                
                // address2: "Please enter your delivery address",
                // delivery_city: "Please enter your delivery city",
                // delivery_state: "Please enter your delivery state",
                // delivery_postel_code: "Please enter your delivery zip code",
                // delivery_country_id: "Please select delivery country",
                
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

<script type='text/javascript'>
  $(document).ready(function() { 
    // $('input[name=ship_method]').change(function(){
    //     $('form[name="shipping_form"]').submit();
    // });

    $('input[name=sub_shipping_method]').change(function(){
         var shippingAmount = $(this).attr('data-sub-shipping-charge');
         var shippingServiceName = $(this).attr('data-sub-shipping-service');
         $('#subShippingMethodPrice').val(shippingAmount);
         $('#subShippingServiceName').val(shippingServiceName);
         // $('#subShippingMethodPrice').val()
        $('form[name="shipping_form"]').submit();
    });

    $('input[name=payment_method]').change(function(){
        $('form[name="payment_form"]').submit();
    });
  });
</script>

@if(session('isSameAsBillingSession') == 1)
  <script>
    $(document).ready( function() {
        $('#d-checkout-address2').removeAttr('required');
        $('#d-checkout-city').removeAttr('required');
        $('#d-checkout-state').removeAttr('required');
        $('#d-checkout-zip').removeAttr('required');
        $('#d-checkout-country').removeAttr('required');
    });
  </script>
@endif

@if(session('shippingSingleDataSession'))
    <script>
        $(document).ready( function() {
            var xx = $('#subShippingMethodPrice').val({{ session('subShippingAmountSession') }});
            var yy = $('#subShippingServiceName').val('{{ session('subShippingServiceNamesSession') }}');
            // $('form[name="shipping_form"]').submit();
            // $("input[type='checkbox']").val();
            // var selectedShippingMethod = $('form[name="shipping_form"]').attr('data-sub-shipping-service');var xx = 
            var xxs = $('#subShippingMethodPrice').val();
            alert(xxs);
        });
    </script>
@endif
@endsection
