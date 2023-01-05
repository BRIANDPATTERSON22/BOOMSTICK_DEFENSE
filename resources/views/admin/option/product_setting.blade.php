@extends('admin.layouts.app')

@section('htmlheader_title')
	Options
@endsection

@section('contentheader_title')
    Options
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Options</li>
    </ol>
@endsection


@section('page-style')
    <style>
        #editor { width: 100%; height: 400px;}
    </style>
@endsection

@section('main-content')

<div class="nav-tabs-custom">
    @include('admin.'.$module.'.header')
    
    <div class="tab-content">
        <div class="tab-pane active">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('currency_code') ? 'has-error' : '' }}">
                                {!!Form::label("currency_code")!!}
                                {!!Form::text('currency_code', null, array('class' => 'form-control', 'placeholder' => 'currency_code'))!!}
                                <em class="error-msg">{!!$errors->first('currency_code')!!}</em>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('currency_symbol') ? 'has-error' : '' }}">
                                {!!Form::label("currency_symbol")!!}
                                {!!Form::text('currency_symbol', null, array('class' => 'form-control', 'placeholder' => 'currency_symbol'))!!}
                                <em class="error-msg">{!!$errors->first('currency_symbol')!!}</em>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('disclaimer_agreement_message') ? 'has-error' : '' }}">
                                {!!Form::label("disclaimer_agreement_message")!!}
                                {!!Form::textarea('disclaimer_agreement_message', null, array('class' => 'form-control', 'placeholder' => 'Enter the disclaimer_agreement_message', 'rows' => 5))!!}
                                <em class="error-msg">{!!$errors->first('disclaimer_agreement_message')!!}</em>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('warning_message') ? 'has-error' : '' }}">
                                {!!Form::label("warning_message")!!}
                                {!!Form::textarea('warning_message', null, array('class' => 'form-control', 'placeholder' => 'Enter the warning_message', 'rows' => 5))!!}
                                <em class="error-msg">{!!$errors->first('warning_message')!!}</em>
                            </div>
                            <div class="col-sm-6 form-group {{ $errors->has('retail_price_percentage') ? 'has-error' : '' }}">
                                {!!Form::label("retail_price_percentage")!!}
                                <div class="input-group">
                                    {{-- <span class="input-group-addon">$</span> --}}
                                    {!!Form::number('retail_price_percentage', null, ['class' => 'form-control', 'placeholder' => 'Retail Price percentage'])!!}
                                    <span class="input-group-addon">%</span>
                                </div>
                                <em class="error-msg">{!!$errors->first('retail_price_percentage')!!}</em>
                            </div>

                            <div class="form-group col-md-6 {{ $errors->has('is_display_bs_products') ? 'has-error' : '' }}">
                                {!!Form::label("Enable/ Disable boomstick prodcuts")!!}
                                {!!Form::select('is_display_bs_products', config('default.statusArray'), null ,array('class' => 'form-control select2', 'placeholder' => 'Select an option'))!!}
                                <em class="error-msg">{!!$errors->first('is_display_bs_products')!!}</em>
                            </div>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="box-body">
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> Update
                            </button>
                            <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel</a>
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