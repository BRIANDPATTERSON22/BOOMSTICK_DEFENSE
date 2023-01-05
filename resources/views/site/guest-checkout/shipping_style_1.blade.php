@extends('site.layouts.default')

@section('htmlheader_title')
    Checkout Shipping | Shop
@endsection

@section('main-content')
      <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>Shipping Methods</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>Shipping Methods</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('site.guest-checkout.checkout_steps')

    <section class="login-page section-big-py-space bg-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                   @include('site.partials.flash_message')
                    <div class="theme-card">
                        {{-- <h3 class="text-center">Select a Shipping Method</h3> --}}
                        {{-- @if (session('addressValidationSession') && count($rating) > 0) --}}
                            <div class="checkout_form_inner inno_shadow p-3 b_0 mb-4">
                                {!!Form::open(['url'=> 'shipping-methods', 'autocomplete'=>'off', 'name' => 'shipping_form'])!!}
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
                                                                 <th scope="col" class="text-left">Available Shipping methods</th>
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
                                                                        <th scope="col" class="text-left">Available Shipping methods</th>
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
                        {{-- @endif --}}

                        {{-- {!!Form::open(['autocomplete' => 'off'])!!}
                            <div class="table-responsive x">
                            <table class="table table-sm table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Shipping methods<</th>
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
                                        <td scope="row" style="white-space: nowrap;">{{$count}}</td>
                                        <td class="text-left">
                                            <label>
                                                <input type="radio" name="ship_method" value="{{ $row->id }}" required>
                                                {{$row->title}}
                                                <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small>
                                            </label>
                                        </td>
                                        <td class="text-left">{{$row->time}}</td>
                                        <td class="text-left">{{ $option->currency_symbol }}{{number_format($row->amount, 2)}}</td>
                                    </tr>
                                @endforeach
                              </tbody>
                            </table>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                  <a class="btn btn-outline-dark btn-sm float-left" href="{{url('address')}}">
                                    <i class="icon-arrow-left"></i>
                                    <span class="hidden-xs-down">&nbsp;Go Back</span>
                                  </a>

                                  <button type="submit" class="btn btn-outline-success btn-sm float-right">
                                      <span class="hidden-xs-down">Continue&nbsp;</span><i class="icon-arrow-right"></i>
                                  </button>
                              </div>
                            </div>
                        {!!Form::close()!!} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
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
      });
    </script>
@endsection