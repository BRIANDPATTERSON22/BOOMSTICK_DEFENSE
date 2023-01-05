@extends('admin.layouts.app')

@section('htmlheader_title')
   Section Offer
@endsection

@section('contentheader_title')
   Section Offer
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Section Offer</li>
    </ol>
@endsection

@section('main-content')

<div class="nav-tabs-custom">
     @include('admin.'.$module.'.header')
    <div class="tab-content">
        <div class="tab-pane active">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Title word 1")!!}
                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title 1'])!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('title_2') ? 'has-error' : '' }}">
                            {!!Form::label("Title word 2")!!}
                            {!!Form::text('title_2', null, ['class' => 'form-control', 'placeholder' => 'Enter title_2'])!!}
                            <em class="error-msg">{!!$errors->first('title_2')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!!Form::label("Offer word 1")!!}
                            {!!Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description'])!!}
                            <em class="error-msg">{!!$errors->first('description')!!}</em>
                        </div>
                       
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">

                         <div class="form-group {{ $errors->has('description_2') ? 'has-error' : '' }}">
                            {!!Form::label("Offer word 2")!!}
                            {!!Form::text('description_2', null, ['class' => 'form-control', 'placeholder' => 'Enter description 2'])!!}
                            <em class="error-msg">{!!$errors->first('description_2')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                            {!!Form::label("URL")!!}
                            {!!Form::url('url', null, ['class' => 'form-control', 'placeholder' => 'Enter title 2'])!!}
                            <em class="error-msg">{!!$errors->first('url')!!}</em>
                        </div>

                        <div id='calendar1' class="form-group">
                            {!!Form::label("Offer End Date")!!}
                            <div class="input-group {{ $errors->has('offer_ended_at') ? 'has-error' : '' }}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!!Form::text('offer_ended_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick offer end date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                            </div><em class="error-msg">{!!$errors->first('offer_ended_at')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                      
                        <div class="form-group {{ $errors->has('ad_word') ? 'has-error' : '' }}">
                            {!!Form::label("Ad word")!!}
                            {!!Form::text('ad_word', null, ['class' => 'form-control', 'placeholder' => 'Enter ad word'])!!}
                            <em class="error-msg">{!!$errors->first('ad_word')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('offer_image') ? 'has-error' : '' }}">
                            {!!Form::label("Logo")!!}
                            {!!Form::file('offer_image', ['accept'=>'image/*'])!!}
                            @if ($singleData->offer_image)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/section-offers/delete-offer-image')}}"><i class="fa fa-close"></i></a></div>
                                    <img src="{{asset('storage/section-offers/'.$singleData->offer_image)}}" alt="offer image" class="img-thumbnail"/>
                                </div>
                            </div>
                            @endif
                        </div>
                        <em class="error-msg">{!!$errors->first('offer_image')!!}</em>
                      
                    </div>
                </div>

                

                
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check-circle-o"></i> Save
                </button>
                <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel</a>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection