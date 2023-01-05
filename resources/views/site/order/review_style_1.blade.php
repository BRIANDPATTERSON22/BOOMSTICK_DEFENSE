@extends('site.layouts.default')

@section('htmlheader_title')
    Order Review
@endsection

@section('page-style')
  <style>
      .card {background-color: #1a1a1a;margin-bottom: 0.5rem;}
      .card-body {padding: 0.1rem;}
      .table{margin-bottom: 0rem;}
      .table th, .table td {border-top: 1px solid #212529;}
      .btn-sm{padding: 0.1rem 0.3rem;font-size: 0.8rem;border-radius: 0px;background: bottom;border: 0px;border-bottom: 2px solid #1c3481; font-size: 0.8rem;}
      .modal-header {border-bottom: 1px solid #484f55;}
      .modal-header {border-bottom: 1px solid #484f55;}
      .modal-footer {border-top: 1px solid #484f55;}
      .card-header {padding: 0.25rem 0.6rem;}
      .table-sm th, .table-sm td {padding: 0.1rem 0.5rem;}
  </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>Order Review </h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>Review </a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  @include('site.order.checkout_steps')

  <section class="cart-section_ section-big-py-space bg-light">
      <div class="custom-container">
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                              <div class="card-header">
                                <span class="font-weight-bold">Billing Info</span>
                                {{-- <a href="{{ url('address') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}

                                <button type="button" class="float-right btn btn-dark btn-sm" data-toggle="modal" data-target="#addressModel">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Change</span>
                                </button>
                                {{-- @include('site.guest-checkout._address') --}}
                            </div>
                            
                              <div class="card-body">
                                <div class="table-responsive table-sm">
                                  <table class="table table-condensed">
                                      {{-- <thead class="thead-dark">
                                      <tr>
                                          <th colspan="2">Billing Info</th>
                                      </tr>
                                      </thead> --}}
                                    <tbody>
                                      <tr>
                                        <td class="text-left">Billing Address</td>
                                        <td class="text-left">{{Session::get('guestAddressSession')['billing_address']}}</td>
                                      </tr>
                                     {{--  <tr>
                                        <td class="text-left">Billing country</td>
                                        <td class="text-left">{{ Session::get('guestAddressSession')['']->hasOrderbillingCountry ? Session::get('guestAddressSession')['']->hasOrderbillingCountry->nicename : '---'  }}</td>
                                      </tr> --}}
                                      <tr>
                                        <td class="text-left">Billing city</td>
                                        <td class="text-left">{{ Session::get('guestAddressSession')['billing_city']}}</td>
                                      </tr>
                                      <tr>
                                        <td class="text-left">Billing state</td>
                                        <td class="text-left">{{ Session::get('guestAddressSession')['billing_state']}}</td>
                                      </tr>
                                      <tr>
                                        <td class="text-left">Billing postal code</td>
                                        <td class="text-left">{{ Session::get('guestAddressSession')['billing_postal_code']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div> 
                              </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                              <div class="card-header">
                                <span class="font-weight-bold">Delivery Info</span>
                              {{-- <a href="{{ url('address') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}

                              <button type="button" class="float-right btn btn-dark btn-sm" data-toggle="modal" data-target="#addressModel">
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Change</span>
                              </button>
                            </div>
                              <div class="card-body">
                                @if(Session::get('isSameAsBillingSession') == 1)
                                  <div class="table-responsive table-sm">
                                    <table class="table table-condensed">
                                        {{-- <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Billing Info</th>
                                        </tr>
                                        </thead> --}}
                                      <tbody>
                                        <tr>
                                          <td class="text-left">Delivery Address</td>
                                          <td class="text-left">{{Session::get('guestAddressSession')['billing_address']}}</td>
                                        </tr>
                                       {{--  <tr>
                                          <td class="text-left">Billing country</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['']->hasOrderbillingCountry ? Session::get('guestAddressSession')['']->hasOrderbillingCountry->nicename : '---'  }}</td>
                                        </tr> --}}
                                        <tr>
                                          <td class="text-left">Delivery city</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['billing_city']}}</td>
                                        </tr>
                                        <tr>
                                          <td class="text-left">Delivery state</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['billing_state']}}</td>
                                        </tr>
                                        <tr>
                                          <td class="text-left">Delivery postal code</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['billing_postal_code']}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div> 
                              @else
                                  <div class="table-responsive table-sm">
                                    <table class="table table-condensed">
                                       {{--  <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Delivery Info</th>
                                        </tr>
                                        </thead> --}}
                                      <tbody>
                                        <tr>
                                          <td class="text-left">Address</td>
                                          <td class="text-left">{{Session::get('guestAddressSession')['delivery_address']}}</td>
                                        </tr>
                                     {{--    <tr>
                                          <td class="text-left">Delivery country</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['']$hasOrderdeliveryCountry ? Session::get('guestAddressSession')['']$hasOrderdeliveryCountry->nicename : '---'  }}</td>
                                        </tr> --}}
                                        <tr>
                                          <td class="text-left">Delivery city</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['delivery_city']}}</td>
                                        </tr>
                                        <tr>
                                          <td class="text-left">Delivery state</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['delivery_state']}}</td>
                                        </tr>
                                        <tr>
                                          <td class="text-left">Delivery postal code</td>
                                          <td class="text-left">{{ Session::get('guestAddressSession')['delivery_postal_code']}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                              @endif
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                          <div class="card">
                            <div class="card-header">
                              <span class="font-weight-bold">Shipping Info</span>
                              {{-- <a href="{{ url('shipping-methods') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}
                              <button type="button" class="float-right btn btn-dark btn-sm" data-toggle="modal" data-target="#shippingModel">
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Change</span>
                              </button>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive table-sm">
                                  <table class="table table-condensed">
                                      {{-- <thead class="thead-dark">
                                          <tr>
                                              <th colspan="2">Payment and Shipping Info</th>
                                          </tr>
                                      </thead> --}}
                                      <tbody>
                                          <tr>
                                              <td class="text-left">Shpping Method</td>
                                              <td class="text-left">{{ $mainShippingMethod }} - {{$shippingServiceName}}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                      </div>


                      <div class="col-lg-12 col-md-12">
                          <div class="card">
                            <div class="card-header">
                               <span class="font-weight-bold">Payment Info</span>
                              {{-- <a href="{{ url('payment-methods') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}

                              <button type="button" class="float-right btn btn-dark btn-sm" data-toggle="modal" data-target="#paymentModel">
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Change</span>
                              </button>

                              

                            </div>
                            <div class="card-body">
                              <div class="table-responsive table-sm">
                                  <table class="table table-condensed">
                                      {{-- <thead class="thead-dark">
                                          <tr>
                                              <th colspan="2">Payment and Shipping Info</th>
                                          </tr>
                                      </thead> --}}
                                      <tbody>
                                          <tr>
                                              <td class="text-left">Payment Method</td>
                                              <td class="text-left">{{$paymentMethod ?? "-"}}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                      </div>



                    </div>
                </div>

                <div class="col-md-7">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <div class="card-header">
                            <span class="font-weight-bold">Order Summary</span>
                        
                          {{-- <a href="{{ url('cart') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}
                        </div>
                          <div class="card-body">
                           <div class="table-responsive">
                               <table class="table table-striped table-sm">
                                  <thead class="thead-dark">
                                   <tr>
                                     <th>#</th>
                                     <th>Product</th>
                                     <th class="text-right">Quantity</th>
                                     <th class="text-right">Price</th>
                                   </tr>
                                 </thead>

                                 <tbody>
                                   <?php $count = 0; ?>
                                   @foreach ($cartItems as $item)
                                        <?php $count++; ?>
                                       <tr>
                                           <td>{{ $count }}</td>
                                           <td class="text-left text-nowrap text-light">
                                               {{$item->name}}
                                           </td>
                                           <td class="text-right">
                                               {{$item->qty}} x {{ $option->currency_symbol }}{{$item->price}}
                                           </td>
                                           <td class="text-right">
                                               {{ $option->currency_symbol }}{{number_format($item->qty * $item->price, 2 )}}
                                           </td>
                                       </tr>
                                   @endforeach
                                       <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">Sub Total</td>
                                           <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($subTotal, 2)}}</td>
                                       </tr>
                                       {{-- <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">Shipping </td>
                                           <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($shippingAmount, 2)}}</td>
                                       </tr> --}}
                                       {{-- <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">Service Charge </td>
                                           <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->dp_transaction_amount, 2)}}</td>
                                       </tr> --}}
                                       <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">Boomstick Shipping </td>
                                           <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($shippingAmount, 2)}}</td>
                                       </tr>

                                       <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">RSR Shipping </td>
                                           <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($totalRsrShippingAMount, 2)}}</td>
                                       </tr>
                                       <tr class="table-active">
                                           <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                                           <td class="text-right font-weight-bold"><strong>{{ $option->currency_symbol }}{{number_format($grandTotal, 2)}}</strong></td>
                                       </tr>
                                 </tbody>
                               </table>
                           </div>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <div class="card-footer">
                            {!!Form::open(['autocomplete' => 'off', 'id' => 'id_submit_form'])!!}
                            {!!csrf_field()!!}
                              <input type="hidden" name="timezone_identifier" id="timezone_identifier">
                              <div class="checkout_btn">
                                  {{-- <a href="{{ url('checkout') }}">Order Now</a> --}}
                                     <button type="submit" class="btn btn-normal btn-block" id="id_submit_btn">ORDER NOW</button>
                              </div>

                              {{-- <a href="{{ url('products') }}" class="btn btn-normal">continue shopping</a>  --}}
                            {!!Form::close()!!}
                             {{--  <a href="{{ url('login') }}" class="btn btn-normal">Login & Checkout</a> 
                              <a href="{{ url('checkout') }}" class="btn btn-normal ml-3">checkout as guest</a> --}}
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
      </div>
  </section>

  {{-- Address --}}
  <div class="modal fade " id="addressModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          {!!Form::model($customer, ['url'=>'checkout-address', 'autocomplete'=>'off', 'id' => 'guest_checkout_address_form', 'class' => 'theme-form'])!!}
          {!!csrf_field()!!}
          <div class="modal-content  bg-dark">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Your Address</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-dark">
              {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}
              <input type="hidden" name="data_from" value="checkout">

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
                          {!!Form::email('email', null, ['id'=>'checkout-email', 'class' => 'form-control ', 'placeholder'=>'Email address'])!!}
                         <em class="text-danger">{!!$errors->first('email')!!}</em>
                      </div>
                  </div>
                  {{-- <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                          <label>Mobile <span class="required">*</span></label>
                          {!!Form::tel('mobile', null, ['id'=>'checkout-phone', 'class' => 'form-control ', 'placeholder'=>'Contact Number'])!!}
                         <em class="text-danger">{!!$errors->first('mobile')!!}</em>
                      </div>
                  </div> --}}

                  <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                          <label>Phone No<span class="required">*</span></label>
                          {!!Form::tel('phone_no', null, ['id'=>'checkout-phone', 'class' => 'form-control ', 'placeholder'=>'Phone Number'])!!}
                         <em class="text-danger">{!!$errors->first('phone_no')!!}</em>
                      </div>
                  </div>
              </div>

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
                      <div class="form-group col-md-3">
                        <label for="id_billing_state" class="control-label">Billing State *</label>
                        {!!Form::select('billing_state', config('default.usStates'), null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                        <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_state')!!}</em>
                      </div>
                      {{-- <div class="form-group col-md-3">
                          <label for="id_billing_state" class="control-label">Billing State *</label>
                          {!!Form::text('billing_state', null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                          <em class="error-msg">{!!$errors->first('billing_state')!!}</em>
                      </div> --}}
                      <div class="form-group col-md-3">
                          <label for="id_billing_postal_code" class="control-label">Billing Zip code *</label>
                          {!!Form::text('billing_postal_code', null, ['id'=>'id_billing_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                          <em class="error-msg">{!!$errors->first('billing_postal_code')!!}</em>
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
                    <div class="form-group col-md-3">
                      <label for="id_delivery_state" class="control-label">Delivery State *</label>
                      {!!Form::select('delivery_state', config('default.usStates'), null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                      <em class="error-msg" id="billing_country_id_error">{!!$errors->first('delivery_state')!!}</em>
                    </div>
                   {{--  <div class="form-group col-md-3">
                        <label for="id_delivery_state" class="control-label">Delivery State *</label>
                        {!!Form::text('delivery_state', null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                    </div> --}}
                    <div class="form-group col-md-3">
                        <label for="id_delivery_postal_code" class="control-label">Delivery Zip code *</label>
                        {!!Form::text('delivery_postal_code', null, ['id'=>'id_delivery_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('delivery_postal_code')!!}</em>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
          {!! Form::close() !!}
      </div>
  </div>

  {{-- Shipping --}}
  <div class="modal fade " id="shippingModel" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          {!!Form::model(null, ['url'=>'checkout-shipping', 'autocomplete'=>'off', 'id' => 'guest_checkout_shipping_form', 'class' => 'theme-form'])!!}
          {!!csrf_field()!!}
          <div class="modal-content  bg-dark">
            <div class="modal-header">
              <h5 class="modal-title" id="shippingModalLabel">SELECT A SHIPPING METHOD</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-dark">
                  <input type="hidden" name="sub_shipping_method_price" id="subShippingMethodPrice">
                  <input type="hidden" name="sub_shipping_method_service_name" id="subShippingServiceName">
                  <input type="hidden" name="main_shipping_method" id="id_main_shipping_method">
                  <input type="hidden" name="data_from" value="checkout">
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      {{-- <thead>
                        <tr>
                          <th scope="col">Shipping methods</th>
                          <th scope="col">Shipping Amount</th>
                        </tr>
                      </thead> --}}
                      <tbody>
                          {{-- @if (count($rating) > 0)
                              @foreach($rating as $row)
                                  <tr>
                                      <td class="text-left">
                                          <label>
                                              <input type="radio" 
                                                  name="sub_shipping_method"
                                                  value="{{ $row['shipping_code'] }}"
                                                  data-sub-shipping-charge = "{{ $row['amount'] }}" 
                                                  data-sub-shipping-service = "{{$row['shipping_service']}}" 
                                                  data-main-shiping-id="2"
                                                  required 
                                                  @if(session('subShippingIdSession') == $row['shipping_code']) checked @endif
                                                  onclick="get_shipping_data(this)">
                                                  {{$row['shipping_service']}}
                                          </label>
                                      </td>
                                      <td class="text-left">{{ $option->currency_symbol }}{{number_format($row['amount'], 2)}}</td>
                                  </tr>
                              @endforeach
                          @endif --}}

                          {{-- @if (count($fedExRating) > 0)
                              @foreach($fedExRating as $row)
                                <tr>
                                    <td class="text-left">
                                        <label>
                                            <input type="radio" 
                                              name="sub_shipping_method" 
                                              value="{{ $row['shipping_code'] }}" 
                                              @if(session('subShippingIdSession') == $row['shipping_code']) checked @endif 
                                              required data-sub-shipping-charge = "{{ $row['amount'] }}" 
                                              data-sub-shipping-service = "{{$row['shipping_service']}}" 
                                              data-main-shiping-id="5"
                                              onclick="get_shipping_data(this)">
                                            {{$row['shipping_service']}}
                                        </label>
                                    </td>
                                    <td class="text-left">{{ $option->currency_symbol }}{{number_format($row['amount'], 2)}}</td>
                                </tr>
                              @endforeach
                          @endif --}}

                          @foreach($shippingData as $row)
                            <tr>
                                <td class="text-left">
                                    <label>
                                        <input type="radio"
                                          name="sub_shipping_method"
                                          value="{{ $row->sub_shipping_code }}"
                                          @if(session('subShippingIdSession') == $row->sub_shipping_code) checked @endif 
                                          required 
                                          data-sub-shipping-charge ="{{ collect($shippingServices)->where('shipping_code', $row->sub_shipping_code)->first()['amount'] ?? $row->amount}}" 
                                          data-sub-shipping-service = "{{$row->title}}" 
                                          data-main-shiping-id="{{ $row->id }}"
                                          onclick="get_shipping_data(this)">
                                        {{$row->title}}
                                    </label>
                                </td>
                            </tr>
                          @endforeach

                      </tbody>
                    </table>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
          {!! Form::close() !!}
      </div>
  </div>

  {{-- Payment --}}
  <div class="modal fade " id="paymentModel" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          {!!Form::model(null, ['url'=>'checkout-payment', 'autocomplete'=>'off', 'id' => 'guest_checkout_payment_form', 'class' => 'theme-form'])!!}
          {!!csrf_field()!!}
          <div class="modal-content  bg-dark">
            <div class="modal-header">
              <h5 class="modal-title" id="paymentModalLabel">SELECT A PAYMENT METHOD</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-dark">
              <div class="table-responsive">
                  <table class="table table-sm table-striped">
                    <tbody>
                      <?php $count = 0; ?>
                      @foreach($payments as $row)
                      <?php $count++; ?>
                          <tr>
                              {{-- <td scope="row" style="white-space: nowrap;">{{$count}}</td> --}}
                              <td class="text-left">
                                  <label>
                                      <input type="radio" name="payment_method" value="{{ $row->id }}" required @if($row->id == session('paymentIdSession')) checked @endif>
                                      {{$row->title}}
                                      <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small>
                                  </label>
                              </td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
          {!! Form::close() !!}
      </div>
  </div>
@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#timezone_identifier').val(moment.tz.guess())
        });        
    </script>

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
                     // mobile_no: "Please enter your contact number",
                     phone_no: "Please enter your contact number",
                     
                     billing_country_id: "Please select billing country",
                     billing_address: "Please enter your billing address",
                     billing_city: "Please enter your billing city",
                     billing_state: "Please enter your billing county",
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

    @if(session('isSameAsBillingSession') == 1)
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

    <script>
      function get_shipping_data(shippingData){
          var shippingAmount = shippingData.getAttribute("data-sub-shipping-charge");
          var shippingServiceName = shippingData.getAttribute("data-sub-shipping-service");
          var mainShippingId = shippingData.getAttribute("data-main-shiping-id");
          // document.getElementById("subShippingMethodPrice").value = shippingAmount;
          $('#subShippingMethodPrice').val(shippingAmount);
          $('#subShippingServiceName').val(shippingServiceName);
          $('#id_main_shipping_method').val(mainShippingId);
      }
    </script>

    <script type="text/javascript">
        $('#id_submit_form').submit(function(){
            $("#id_submit_btn", this)
              .html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i> PLACING THE ORDER...')
              .attr('disabled', 'disabled');
            return true;
        });
    </script>
@endsection