@extends('site.layouts.default')

@section('htmlheader_title')
    Cart
@endsection

@section('page-style')
  <style>
    .card {background-color: #1a1a1a; margin-bottom: 1rem;}
    .card-body {padding: 0.5rem;}
    .table th, .table td {border-top: 1px solid #212529;}
  </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>Review </h2>
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
                <div class="col-md-6 mx-auto">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">
                                Billing Info
                                {{-- <a href="{{ url('address') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}
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
                                        <td class="text-left">Address</td>
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

                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">
                              Delivery Info
                              {{-- <a href="{{ url('address') }}" class="float-right btn btn-dark btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change</a> --}}
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
                                          <td class="text-left">Address</td>
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

                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">Payment and Shipping Info</div>
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
                                                <td class="text-left">{{$paymentMethod}}</td>
                                            </tr>
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

                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">Order Details</div>
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
                                                   {{$item->quantity}} x {{ $option->currency_symbol }}{{$item->price}}
                                               </td>
                                               <td class="text-right">
                                                   {{ $option->currency_symbol }}{{number_format($item->quantity * $item->price, 2 )}}
                                               </td>
                                           </tr>
                                       @endforeach
                                           <tr class="table-active">
                                               <td colspan="3" class="text-right font-weight-bold">Sub Total</td>
                                               <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($subTotal, 2)}}</td>
                                           </tr>
                                           <tr class="table-active">
                                               <td colspan="3" class="text-right font-weight-bold">Shipping </td>
                                               <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($shippingAmount, 2)}}</td>
                                           </tr>
                                           {{-- <tr class="table-active">
                                               <td colspan="3" class="text-right font-weight-bold">Service Charge </td>
                                               <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->dp_transaction_amount, 2)}}</td>
                                           </tr> --}}
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

                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-footer">
                                {!!Form::open(['autocomplete' => 'off'])!!}
                                {!!csrf_field()!!}
                                  <input type="hidden" name="timezone_identifier" id="timezone_identifier">
                                  <div class="checkout_btn">
                                      {{-- <a href="{{ url('checkout') }}">Order Now</a> --}}
                                         <button type="submit" class="btn btn-normal btn-block">ORDER NOW</button>
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
@endsection



@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#timezone_identifier').val(moment.tz.guess())
        });        
    </script>
@endsection