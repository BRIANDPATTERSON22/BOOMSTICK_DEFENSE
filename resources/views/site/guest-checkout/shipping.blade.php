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
                                <input type="hidden" name="main_shipping_method" id="id_main_shipping_method">

                                  <h3>Select a Shipping Method <span class="pull-right"></span></h3>
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
                                                                required 
                                                                data-sub-shipping-charge = "{{ $row['amount'] }}" 
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

                                    <div class="border-top border-dark mt-3 mb-3"></div>

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

                              {!!Form::close()!!} 
                            </div>
                        {{-- @endif --}}
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

        // $('input[name=sub_shipping_method]').change(function(){
        //      var shippingAmount = $(this).attr('data-sub-shipping-charge');
        //      var shippingServiceName = $(this).attr('data-sub-shipping-service');
        //      $('#subShippingMethodPrice').val(shippingAmount);
        //      $('#subShippingServiceName').val(shippingServiceName);
        //      // $('#subShippingMethodPrice').val()
        //     $('form[name="shipping_form"]').submit();
        // });
      });

      // function get_shipping_data(){
      //    var shippingAmount = $(this).attr('data-sub-shipping-charge'); alert($(this));
      //    var shippingServiceName = $(this).attr('data-sub-shipping-service');
      //    var mainShippingId = $(this).attr('data-main-shiping-id');
      //    $('#subShippingMethodPrice').val(shippingAmount);
      //    $('#subShippingServiceName').val(shippingServiceName);
      //    $('#id_main_shipping_method').val(mainShippingId);
      //    // alert('fu');
      // }

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
@endsection