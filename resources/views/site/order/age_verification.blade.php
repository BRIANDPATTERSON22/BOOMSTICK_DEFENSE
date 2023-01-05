@extends('site.layouts.default')

@section('htmlheader_title')
    Checkout Age Verification | Shop
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2> Age Verification </h2>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a>Age Verification</a></li>
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
                      <h3 class="text-center">Are you 18+?</h3>
                      <p class="text-center m-3 text-danger text-uppercase">(If your age is under 18 highlighted(red) products will be removed from your cart)</p>

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
                                  <tr class="@if($item->options['is_age_verification_required'] == 1) bg-danger @endif">
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
                                  {{-- <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Sub Total</td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($subTotal, 2)}}</td>
                                  </tr> --}}
                                  {{-- <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Shipping </td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($shippingAmount, 2)}}</td>
                                  </tr> --}}
                                  {{-- <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Service Charge </td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->dp_transaction_amount, 2)}}</td>
                                  </tr> --}}
                                  {{-- <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                                      <td class="text-right font-weight-bold"><strong>{{ $option->currency_symbol }}{{number_format($grandTotal, 2)}}</strong></td>
                                  </tr> --}}
                            </tbody>
                          </table>
                      </div>


                      {!!Form::model(null, ['autocomplete'=>'off', 'id' => 'guest_checkout_address_form', 'class' => 'theme-form'])!!}
                      {!!csrf_field()!!}

                      {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}

                      <div class="border-top border-dark mt-3 mb-3"></div>

                      <div class="row">
                        <div class="col-md-12">
                            {{-- <a class="btn btn-outline-dark btn-sm float-left" href="{{url('cart')}}">
                              <i class="icon-arrow-left"></i>
                              <span class="hidden-xs-down">&nbsp;Cart</span>
                            </a> --}}

                            <a class="btn btn-outline-dark btn-sm float-left" href="{{url('checkout-remove-products')}}">
                              <i class="icon-arrow-left"></i>
                              <span class="hidden-xs-down">&nbsp;No</span>
                            </a>

                            <button type="submit" class="btn btn-outline-success btn-sm float-right">
                                <span class="hidden-xs-down">Yes &nbsp;</span><i class="icon-arrow-right"></i>
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
  
@endsection