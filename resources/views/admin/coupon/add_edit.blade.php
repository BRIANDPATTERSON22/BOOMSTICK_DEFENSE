@extends('admin.layouts.app')

@section('htmlheader_title')
    Coupons
@endsection

@section('contentheader_title')
    @if ($singleData->id) Edit Coupon ID: {{$singleData->id}} @else Add New Coupon @endif
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li ><a href="{{url('admin/coupons')}}">Coupons</a></li>
        <li class="active"> @if($singleData->id) Edit Coupon ID: {{$singleData->id}} @else Add New Coupon @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif>
            <a href="{{url('admin/coupon/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a>
        </li>
        <li @if(Request::is('*view')) class="active" @endif>
            <a href="{{url('admin/coupon/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a>
        </li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.coupon.header')
        <div class="tab-content">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-4 col-md-push-8 col-xs-12">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('series_no') ? 'has-error' : '' }}">
                            {!!Form::label("Coupon Code")!!}
                            {!!Form::text('series_no', $series, ['class' => 'form-control', 'placeholder' => 'Enter coupon code'])!!}
                            <em class="error-msg">{!!$errors->first('series_no')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('pin_no') ? 'has-error' : '' }}">
                            {!!Form::label("Pin No.")!!}
                            {!!Form::text('pin_no', $pin, ['class' => 'form-control', 'placeholder' => 'Enter pin no', 'readonly'])!!}
                            <em class="error-msg">{!!$errors->first('pin_no')!!}</em>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-md-pull-4 col-xs-12">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!!Form::label("Coupon Name")!!}
                            {!!Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter coupon name'])!!}
                            <em class="error-msg">{!!$errors->first('name')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('coupon_type') ? 'has-error' : '' }}">
                            <?php $coupon_type = ['1' => 'Seasons Coupon', '2' => 'Customer Coupon'] ?>
                            {!!Form::label("Coupon Type")!!}
                            {!!Form::select('coupon_type', $coupon_type, null, ['class' => 'form-control select2', 'placeholder' => 'Select coupon type'])!!}
                            <em class="error-msg">{!!$errors->first('coupon_type')!!}</em>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                {!!Form::label("Start Date *")!!}
                                {!!Form::text('start_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'yyyy-mm-dd'])!!}
                                <em class="error-msg">{!!$errors->first('start_date')!!}</em>
                            </div>
                            <div class="col-md-6 form-group {{ $errors->has('expiry_date') ? 'has-error' : '' }}">
                                {!!Form::label("End Date *")!!}
                                {!!Form::text('expiry_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'yyyy-mm-dd'])!!}
                                <em class="error-msg">{!!$errors->first('expiry_date')!!}</em>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                                {!!Form::label("Discount Percentage *")!!}
                                <div class="input-group">
                                    {!!Form::text('percentage', null, ['class' => 'form-control', 'placeholder' => 'Percentage'])!!}
                                    <span class="input-group-addon">%</span>
                                </div>
                                <em class="error-msg">{!!$errors->first('percentage')!!}</em>
                            </div>
                            <div class="col-sm-6 form-group {{ $errors->has('count') ? 'has-error' : '' }}">
                                {!!Form::label("Usage Count *")!!}
                                {!!Form::text('count', null, ['class' => 'form-control', 'placeholder' => 'Usage counts'])!!}
                                <em class="error-msg">{!!$errors->first('count')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        @if($singleData->id)
                        <div class="pull-right form-group">
                            <label class="switch">
                                <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@endsection