@extends('site.layouts.default')

@section('htmlheader_title')
  Checkout FFL Dealers | Shop
@endsection

@section('page-style')
    <style>
        .select2-container--default .select2-selection--single {background-color: #1b1b1b;border: 1px solid #343a40;border-radius: 4px;}
        .select2-dropdown {background-color: #262626; border: 1px solid #3c3c3c;}
        .select2-container--default .select2-results__option[aria-selected=true] {background-color: #1b1b1b;}
        .select2-container--default .select2-search--dropdown .select2-search__field {color: #eaedef;}
        .select2-results__option {width: 100%;}
        .select2-container--default .select2-results__option--highlighted[aria-selected] {background-color: #1c3481;}
    </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2> Checkout FFL Dealer </h2>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a> Checkout FFL Dealers</a></li>
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

                 {{-- <div class="card">
                   <div class="card-header">Header</div>
                   <div class="card-body">Content</div>
                   <div class="card-footer">Footer</div>
                 </div> --}}

                  <div class="theme-card">
                      <h3 class="text-center">Highlighted(red) product(s) are requiring FFL dealer</h3>
                      <p class="text-center m-3">Firearm products are requiring FFL dealer.</strong></p>

                      <div class="border-top border-dark mt-3 mb-4"></div>

                      <div class="table-responsive">
                          <table class="table table-striped table-darkf table-sm">
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
                              @foreach (Cart::instance('cart')->content() as $item)
                                   <?php $count++; ?>
                                  <tr class="@if($item->options['is_firearm'] == 1) bg-danger @endif">
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
                            </tbody>
                          </table>
                      </div>
                  </div>




                  <div class="theme-card">
                      <h3 class="text-center">Select a FFL Dealer</h3>
                      {{-- <p class="text-center m-3">Highlighted(red) products are requiring FFL dealer.</strong></p> --}}

                      <div class="border-top border-dark mt-3 mb-4"></div>

                      {!!Form::model(null, ['autocomplete'=>'off', 'id' => 'guest_checkout_address_form', 'class' => 'theme-form'])!!}
                      {!!csrf_field()!!}



                      {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}

                      {{-- <div class="border-top border-dark mt-3 mb-3"></div> --}}

                      <div class="row">
                        <input type="hidden" name="ffl_licence" id="id_ffl_licence">
                        <div class="form-group col-md-12">
                          {{-- <label for="id_delivery_state" class="control-label">Delivery State *</label> --}}
                          {{-- @php
                            $fflDealersArr = ['Dealer 1' => "Dealer 1", '2 Dealer' => "Dealer 2", '3 Dealer' => "Dealer 3", '4 Dealer' => "Dealer 4", '5 Dealer' => "Dealer 5", 'Dealer 6' => "Dealer 6", 'Dealer 7' => "Dealer 7"]
                          @endphp
                          {!!Form::select('ffl_dealer', $fflDealersArr, null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'Available FFL Dealers *', 'required'])!!} --}}

                          {{-- {!!Form::select('ffl_dealer', $fflDealers->pluck('Name', 'FFL'), null, ['class' => 'form-control select2', 'placeholder'=>'Available FFL Dealers *', 'required'])!!} --}}

                          <select id="id_ffl_dealers" class="form-control select2" name="ffl_dealer" required>
                              @if($fflDealers->isNotEmpty())
                                @foreach ($fflDealers as $row)
                                  <option value="{{ $row->Name }}" data-ffl-licence="{{ $row->FFL }}">{{ $row->Name }} - ({{ $row->Street }}/ {{ $row->City }}/ {{ $row->State }}/ {{ $row->Zip }})</option>
                                @endforeach
                              @endif
                          </select>
                          <em class="error-msg" id="billing_country_id_error">{!!$errors->first('ffl_dealer')!!}</em>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-outline-dark btn-sm float-left" href="{{url('cart')}}">
                              <i class="icon-arrow-left"></i>
                              <span class="hidden-xs-down">&nbsp;Cart</span>
                            </a>

                            <button type="submit" class="btn btn-outline-success btn-sm float-right" onclick="getFflDealerInfo()">
                                <span class="hidden-xs-down">Continue&nbsp;</span><i class="icon-arrow-right"></i>
                            </button>

                            {{-- <a class="btn btn-outline-danger btn-sm float-right mr-3" href="{{url('remove-products')}}">
                              <i class="icon-arrow-left"></i>
                              <span class="hidden-xs-down">&nbsp;No Remove it</span>
                            </a> --}}
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
    <script>
        function getFflDealerInfo() {
            var fflDealerLicence = $(":selected").attr("data-ffl-licence");
            $('#id_ffl_licence').val(fflDealerLicence);
        }
    </script>
@endsection