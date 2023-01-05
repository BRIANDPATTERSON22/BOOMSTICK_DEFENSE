@extends('admin.layouts.app')

@section('htmlheader_title')
    @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif | Customers
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
        <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
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
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif>
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')

@endsection