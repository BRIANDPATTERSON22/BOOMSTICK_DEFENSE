@extends('admin.layouts.app')

@section('htmlheader_title')
    Videos
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
        <li class="text-capitalize active"> @if ($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
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
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('album_id') ? 'has-error' : '' }}">
                                {!!Form::label("Video Album *")!!}
                                {!!Form::select('album_id', $albums, null, ['class' => 'form-control', 'placeholder' => 'Select a album'])!!}
                                <em class="error-msg">{!!$errors->first('album_id')!!}</em>
                                <span class="pull-right"><a href="{{url('admin/'.$module.'s/album')}}" target="_blank">Add video album</a></span>
                            </div>
                            @if($singleData->id)
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!!Form::label("Slug")!!}
                                    {!!Form::text('slug', null, array('class' => 'form-control', 'required'))!!}
                                    <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                    <em class="small-font">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                {!!Form::label("Title *")!!}
                                {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title'])!!}
                                <em class="error-msg">{!!$errors->first('title')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
                                {!!Form::label("External Sources Videos *")!!}
                                {!!Form::text('source', null, ['class' => 'form-control', 'placeholder' => 'Enter external source URL (YouTube, Vimeo, Facebook)'])!!}
                                <em class="error-msg">{!!$errors->first('source')!!}</em>
                                <em class="small-font">Copy and past the URL from browser</em>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!!Form::label("Description")!!}
                                {!!Form::textarea('content', null, ['id'=>'page', 'class' => 'form-control', 'placeholder' => 'Enter content'])!!}
                                <em class="error-msg">{!!$errors->first('description')!!}</em>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-remove"></i> Cancel</a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection