@extends('admin.layouts.app')

@section('htmlheader_title')
	Home Slider
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{URL::to('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{URL::to('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{URL::to('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
    @endif
@endsection

@section('main-content')
<div class="nav-tabs-custom">
    @include('admin.'.$module.'.header')
    @if ($errors->any())
     <ul id="errors">
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
     </ul>
    @endif
    <div class="tab-content">
        <div class="tab-pane active">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Title *")!!}
                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter event title'])!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('sub_title') ? 'has-error' : '' }}">
                            {!!Form::label("Title 2 *")!!}
                            {!!Form::text('sub_title', null, ['class' => 'form-control', 'placeholder' => 'Enter title 2'])!!}
                            <em class="error-msg">{!!$errors->first('sub_title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!!Form::label("Description *")!!}
                            {!!Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter slider description', 'rows'=>3])!!}
                            <em class="error-msg">{!!$errors->first('description')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
                            {!!Form::label("Link/ Relative URL")!!}
                            {!!Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'Enter slider link'])!!}
                            <em class="error-msg">{!!$errors->first('link')!!}</em>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right form-group">
                            <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check-circle-o"></i> @if($singleData->id)Update @else Create @endif
                        </button>
                        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-times-circle-o"></i> Cancel</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                            {!!Form::label("Upload Image [1539*600px]")!!}
                            {!!Form::file('image')!!}
                            @if($singleData->image)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                    <img src="{{asset('storage/'.$module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail"/>
                                </div>
                            </div>
                            @endif
                            <em class="error-msg">{!!$errors->first('image')!!}</em>
                        </div>
                    </div>
                </div>
              
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection