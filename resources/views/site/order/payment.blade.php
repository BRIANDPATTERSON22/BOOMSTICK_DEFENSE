@extends('site.layouts.default')

@section('htmlheader_title')
    Checkout Payment | Shop
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>Checkout Payment</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>Payment</a></li>
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
                    <div class="theme-card">
                        <h3 class="text-center">Select a Payment method</h3>

                        {!!Form::open(['autocomplete' => 'off'])!!}
                        {!!csrf_field()!!}
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                  <thead>
                                    <tr>
                                      {{-- <th scope="col">#</th> --}}
                                      <th scope="col">Available Payment methods</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $count = 0; ?>
                                    @foreach($payments as $row)
                                    <?php $count++; ?>
                                        <tr>
                                            {{-- <td scope="row" style="white-space: nowrap;">{{$count}}</td> --}}
                                            <td class="text-left">
                                                <label>
                                                    <input type="radio" name="payment_method" value="{{ $row->id }}" required>
                                                    {{$row->title}}
                                                    <small> {{$row->description ? '(' . $row->description . ')' : ""}}</small>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                  <a class="btn btn-outline-dark btn-sm float-left" href="{{url('shipping-methods')}}">
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
                </div>
            </div>
        </div>
    </section>
@endsection