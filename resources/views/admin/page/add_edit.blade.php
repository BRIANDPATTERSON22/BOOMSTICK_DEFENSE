@extends('admin.layouts.app')

@section('htmlheader_title')
    Pages
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if ($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}}@endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit ID: {{$singleData->id}} @else Add New @endif</li>
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
                            @if($singleData->id)
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!!Form::label("Slug *")!!}
                                    {!!Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter slug', 'required', $singleData->slug == "contact-us" ? 'readonly' : ''])!!}
                                    <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                    <em class="small-font">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
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
                            
                            <hr>
                            <div class="form-group">
                                {!!Form::label("Content Display")!!} <br>
                                <label class="switch" title="@if($singleData->content_display == 1) Enabled @else Disabled @endif">
                                    <input type="checkbox" name="content_display" value="1" @if($singleData->content_display == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>

                            <hr>
                            <div class="form-group">
                                {!!Form::label("Title Display")!!} <br>
                                <label class="switch" title="@if($singleData->title_display == 1) Enabled @else Disabled @endif">
                                    <input type="checkbox" name="title_display" value="1" @if($singleData->title_display == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>

                            <hr>
                            <div class="form-group">
                                {!!Form::label("Summary Display")!!} <br>
                                <label class="switch" title="@if($singleData->summary_display == 1) Enabled @else Disabled @endif">
                                    <input type="checkbox" name="summary_display" value="1" @if($singleData->summary_display == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>

                            <hr>
                            <div class="form-group">
                                {!!Form::label("Image Display")!!} <br>
                                <label class="switch" title="@if($singleData->image_display == 1) Enabled @else Disabled @endif">
                                    <input type="checkbox" name="image_display" value="1" @if($singleData->image_display == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                {!!Form::label("Title *")!!}
                                {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter page title'])!!}
                                <em class="error-msg">{!!$errors->first('title')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('summary') ? 'has-error' : '' }}">
                                {!!Form::label("Summary")!!}
                                {!!Form::textarea('summary', null, ['class' => 'form-control', 'placeholder' => 'Enter page summary', 'rows' => 3])!!}
                                <em class="error-msg">{!!$errors->first('summary')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                {!!Form::label("Content")!!}
                                {!!Form::textarea('content', null, ['id' => 'page', 'class' => 'form-control', 'placeholder' => 'Enter page content'])!!}
                                <em class="error-msg">{!!$errors->first('content')!!}</em>
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
                            <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection