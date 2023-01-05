@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->order_no}} | Orders
@endsection

@section('contentheader_title')
    ORDER#: {{$singleData->order_no}}, STATUS:
    @if($singleData->status == 1)
        <span class="label label-warning">Processing</span>
    @elseif($singleData->status == 2)
        <span class="label label-danger">Pending</span>
    @elseif($singleData->status == 3)
        <span class="label label-success">Paid</span> by
        @if($singleData->payment_id == 1)
            <span class="label label-info">Pay on Delivery</span>
        @elseif($singleData->payment_id == 2)
            <span class="label label-info">Pay with PayPal</span>
        @elseif($singleData->payment_id == 3)
            <span class="label label-info">Pay to Bank</span>
        @elseif($singleData->payment_id == 4)
            <span class="label label-info">Pay with Credit Card</span>
        @elseif($singleData->payment_id == 5)
            <span class="label label-info">Sage Pay</span>
        @endif
    @elseif($singleData->status == 4)
        <span class="label label-info">Delivered</span>
    @endif
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->order_no}} {{$singleData->last_name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="order-title">Customer</h4>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>: {{$singleData->customer->first_name}} {{$singleData->customer->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>: {{$singleData->customer->mobile}} {{$singleData->customer->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>: {{$singleData->customer->address1}} {{$singleData->customer->address2}} {{$singleData->customer->city}} {{$singleData->customer->state}} {{$singleData->customer->postal_code}} @if($singleData->customer->country_id) {{$singleData->customer->country->nicename}} @endif</td>
                                </tr>
                                @if($singleData->payment_id)
                                <tr>
                                    <th>Payment method</th>
                                    <td>: {{$singleData->paymentMethod->title}}</td>
                                </tr>
                                @endif
                                @if($singleData->shipping_id)
                                <tr>
                                    <th>Shipping method</th>
                                    <td>: {{$singleData->shippingMethod->title}}</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th colspan="2">Product</th>
                                        <th class="text-center">Qty.</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderItems as $item)
                                        <tr>
                                            <td></td>
                                            <td style="width: 80px"><img height="40" src="{{asset('storage/products/images/'.$item->product->main_image)}}"> </td>
                                            <td>{{$item->product->name}}</td>
                                            <td class="text-center">{{$item->quantity}}</td>
                                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->price, 2)}}</td>
                                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->quantity * $item->price, 2)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="3">Sub total</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->amount,2)}}</th>
                                    </tr>

                                    @if($singleData->coupon_id)
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="3">Coupon/ Discount <span class="label label-warning "> {{$singleData->coupongId->percentage}}% off </span></th>
                                            <th class="text-right">{{$option->currency_symbol}}{{ number_format($singleData->amount * ($singleData->coupongId->percentage/100), 2)}}</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="3">Coupon/ Discount</th>
                                            <th class="text-right">$0.00</th>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="3">Shipping</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->shipping,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="3">Tax</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->tax,2)}}</th>
                                    </tr>

                                    @if($singleData->coupon_id)
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="3"><h4>Grand Total</h4></th>
                                            <th class="text-right"><h4>{{$option->currency_symbol}}{{number_format($singleData->amount +$singleData->shipping + $singleData->tax - $singleData->amount * ($singleData->coupongId->percentage/100),2)}}</h4></th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="3"><h4>Grand Total</h4></th>
                                            <th class="text-right"><h4>{{$option->currency_symbol}}{{number_format($singleData->amount + $singleData->tax + $singleData->shipping, 2)}}</h4></th>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-5 no-padding">
                        <p class="pull-left">Created at {{$singleData->created_at}} & Updated at {{$singleData->updated_at}}</p>
                    </div>
                 
                    {{-- <a title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$singleData->id.'/delivered')}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-check-square"></i> Update</a>
                    <a title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$singleData->id.'/delivered')}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-check-square"></i> Repeat </a> --}}
                  {{-- <a href="invoice-print.html" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a> --}}
                    <div class="col-md-7 no-padding">
                        
                        <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-repeat"></i> Repeat</button>
                        <button type="button" class="btn btn-info pull-right" style="margin-right: 5px;"><i class="fa fa-credit-card"></i> Refund</button>
                      {{--   <button type="button" class="btn btn-primary pull-left" style="margin-right: 5px;"><i class="fa fa-download"></i> Invoice</button>
                        <button type="button" class="btn btn-default pull-left" style="margin-right: 5px;"><i class="fa fa-envelope"></i> Send eMail</button> --}}
                        
                        
                        <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modal-order-edit"><i class="fa fa-credit-card"></i> Edit</button>
                        <div class="modal fade" id="modal-order-edit">
                          <div class="modal-dialog">
                            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                            {!!csrf_field()!!}
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Default Modal</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6 form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                                        {!!Form::label("customer_id")!!}
                                        {!!Form::text('customer_id', null, ['class' => 'form-control', 'placeholder' => 'Enter customer_id'])!!}
                                        <em class="error-msg">{!!$errors->first('customer_id')!!}</em>
                                    </div>
                                    <div class="col-sm-6 form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                                        {!!Form::label("amount *")!!}
                                        {!!Form::text('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter amount'])!!}
                                        <em class="error-msg">{!!$errors->first('amount')!!}</em>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group {{ $errors->has('coupon_amount') ? 'has-error' : '' }}">
                                        {!!Form::label("coupon_amount *")!!}
                                        {!!Form::text('coupon_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter coupon_amount'])!!}
                                        <em class="error-msg">{!!$errors->first('coupon_amount')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('shipping') ? 'has-error' : '' }}">
                                        {!!Form::label("shipping *")!!}
                                        {!!Form::tel('shipping', null, ['class' => 'form-control', 'placeholder' => 'Enter shipping '])!!}
                                        <em class="error-msg">{!!$errors->first('shipping')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('tax') ? 'has-error' : '' }}">
                                        {!!Form::label("tax")!!}
                                        {!!Form::tel('tax', null, ['class' => 'form-control', 'placeholder' => 'Enter tax'])!!}
                                        <em class="error-msg">{!!$errors->first('tax')!!}</em>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 form-group {{ $errors->has('grand_total') ? 'has-error' : '' }}">
                                        {!!Form::label("grand_total *")!!}
                                        {!!Form::text('grand_total', null, ['class' => 'form-control', 'placeholder' => 'grand_total'])!!}
                                        <em class="error-msg">{!!$errors->first('grand_total')!!}</em>
                                    </div>
                                    <div class="col-sm-5 form-group {{ $errors->has('address2') ? 'has-error' : '' }}">
                                        {!!Form::label("delivery_date")!!}
                                        {!!Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'delivery_date'])!!}
                                        <em class="error-msg">{!!$errors->first('address2')!!}</em>
                                    </div>
                                    <div class="col-sm-2 form-group {{ $errors->has('coupon_id') ? 'has-error' : '' }}">
                                        {!!Form::label("coupon_id")!!}
                                        {!!Form::text('coupon_id', null, ['class' => 'form-control', 'placeholder' => 'Enter coupon_id'])!!}
                                        <em class="error-msg">{!!$errors->first('coupon_id')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('shipping_id') ? 'has-error' : '' }}">
                                        {!!Form::label("shipping_id *")!!}
                                        {!!Form::text('shipping_id', null, ['class' => 'form-control', 'placeholder' => 'Enter shipping_id'])!!}
                                        <em class="error-msg">{!!$errors->first('shipping_id')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('payment_id') ? 'has-error' : '' }}">
                                        {!!Form::label("payment_id")!!}
                                        {!!Form::text('payment_id', null, ['class' => 'form-control', 'placeholder' => 'Enter payment_id'])!!}
                                        <em class="error-msg">{!!$errors->first('payment_id')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('pay_status') ? 'has-error' : '' }}">
                                        {!!Form::label("pay_status *")!!}
                                        {!!Form::select('pay_status', $countries, null, ['class' => 'form-control', 'placeholder' => 'Select pay_status'])!!}
                                        <em class="error-msg">{!!$errors->first('pay_status')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('order_no') ? 'has-error' : '' }}">
                                        {!!Form::label("order_no *")!!}
                                        {!!Form::text('order_no', null, ['class' => 'form-control', 'placeholder' => 'Enter order_no'])!!}
                                        <em class="error-msg">{!!$errors->first('order_no')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                        {!!Form::label("status *")!!}
                                        {!!Form::text('status', null, ['class' => 'form-control', 'placeholder' => 'Enter status'])!!}
                                        <em class="error-msg">{!!$errors->first('status')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('paypal_payment_id') ? 'has-error' : '' }}">
                                        {!!Form::label("paypal_payment_id *")!!}
                                        {!!Form::text('paypal_payment_id', null, ['class' => 'form-control', 'placeholder' => 'Enter paypal_payment_id'])!!}
                                        <em class="error-msg">{!!$errors->first('paypal_payment_id')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('paypal_payer_id') ? 'has-error' : '' }}">
                                        {!!Form::label("paypal_payer_id *")!!}
                                        {!!Form::text('paypal_payer_id', null, ['class' => 'form-control', 'placeholder' => 'Enter paypal_payer_id'])!!}
                                        <em class="error-msg">{!!$errors->first('paypal_payer_id')!!}</em>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                @if($singleData->id)
                                    <div class="pull-left form-group">
                                        <label class="switch">
                                            <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif>
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                                </button>
                                {{-- <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a> --}}
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                              </div>
                            </div>
                            {!!Form::close()!!}
                          </div>
                        </div>



                        {{-- @if($singleData->status == 3)
                            <a title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$singleData->id.'/delivered')}}" class="btn btn-success"><i class="fa fa-check-square"></i> Mark as Delivered </a>
                        @endif --}}
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
@endsection