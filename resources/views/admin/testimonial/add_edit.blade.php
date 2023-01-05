@extends('admin.layouts.app')

@section('htmlheader_title')
    Testimonials
@endsection

@section('contentheader_title')
    @if ($singleData->id) Edit Testimonial ID: {{$singleData->id}} @else Add New Testimonial @endif
@endsection

@section('contentheader_description')

@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('admin/testimonials')}}"> Testimonials</a></li>
        <li class="active"> @if($singleData->id) Edit Testimonial ID: {{$singleData->id}} @else Add New Testimonial @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif>
            <a href="{{url('admin/testimonial/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a>
        </li>
        <li @if(Request::is('*view')) class="active" @endif>
            <a href="{{url('admin/testimonial/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a>
        </li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.testimonial.header')
        <div class="tab-content">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-4 col-md-push-8">
                    @if($singleData->id)
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                            {!!Form::label("Slug")!!}
                            {!!Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter slug'])!!}
                            <em class="error-msg">{!!$errors->first('slug')!!}</em>
                            <em class="help-text">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                        </div>
                    </div>
                    @endif
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                            {!!Form::label("Upload Image")!!}
                            @if($singleData->id && !empty($singleData->image))
                                {!!Form::file('image')!!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="image-close"><a href="{{url('admin/testimonial/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                        {{-- <img src="{{asset('images/testimonials/'.$singleData->id.'/'.$singleData->image)}}" alt="Image" class="img-thumbnail"/> --}}
                                         <img src="{{asset('storage/testimonials/'.$singleData->image)}}" alt="Image" class="img-thumbnail"/>

                                    </div>
                                </div>
                            @else{!!Form::file('image', array())!!}@endif
                            <em class="error-msg">{!!$errors->first('image')!!}</em>
                            <div class="help-text">Image dimension should be 000px * 000px</div>
                        </div>
                    </div>

                   {{--  <div class="box-body">
                        <div class="form-group {{ $errors->has('video') ? 'has-error' : '' }}">
                            {!!Form::label("YouTube Embed Video")!!}
                            {!!Form::text('video', null, ['class' => 'form-control', 'placeholder'=>'Enter YouTube video ID'])!!}
                            <em class="error-msg">{!!$errors->first('video')!!}</em>
                            <div class="help-text">Please paste the YouTube video ID which you can find next to the '/embed/' value available in YouTube's embed code. OR From the URL</div>
                        </div>
                    </div> --}}
                    {{-- <div class="box-body">
                        <div class="form-group {{ $errors->has('album_id') ? 'has-error' : '' }}">
                            {!!Form::label("Gallery Reference")!!}
                            {!!Form::select('album_id', $gallery, null, ['class' => 'form-control select2', 'placeholder' => 'Select a gallery related to the blog'])!!}
                            <em class="error-msg">{!!$errors->first('album_id')!!}</em>
                        </div>
                    </div> --}}
                </div>

                <div class="col-md-8 col-md-pull-4">
                    <div class="box-body">
                        {{-- <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Title *")!!}
                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial title'])!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div> --}}
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            {!!Form::label("first_name *")!!}
                            {!!Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial first_name'])!!}
                            <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            {!!Form::label("last_name *")!!}
                            {!!Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial last_name'])!!}
                            <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                            {!!Form::label("JOb *")!!}
                            {!!Form::text('job', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial job'])!!}
                            <em class="error-msg">{!!$errors->first('job')!!}</em>
                        </div>
                        {{-- @if($singleData->id)
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                            {!!Form::label("Slug")!!}
                            {!!Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter slug'])!!}
                            <em class="error-msg">{!!$errors->first('slug')!!}</em>
                            <em class="help-text">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                        </div>
                        @endif --}}
                        {{-- <div class="form-group {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!!Form::label("Summary")!!}
                            {!!Form::textarea('summary', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial summary', 'rows' => 3])!!}
                            <em class="error-msg">{!!$errors->first('summary')!!}</em>
                        </div> --}}
                        <div class="form-group {{ $errors->has('review') ? 'has-error' : '' }}">
                            {!!Form::label("review *")!!}
                            {!!Form::textarea('review', null, ['class' => 'form-control', 'placeholder' => 'Enter testimonial review', 'rows' => 3])!!}
                            <em class="error-msg">{!!$errors->first('review')!!}</em>
                        </div>
                        {{-- <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            {!!Form::label("Content")!!}
                            {!!Form::textarea('content', null, ['id' => 'page', 'class' => 'form-control', 'placeholder' => 'Enter testimonial content'])!!}
                            <em class="error-msg">{!!$errors->first('content')!!}</em>
                        </div> --}}
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
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) UPDATE @else CREATE @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/testimonials')}}"><i class="fa fa-times-circle-o"></i> CANCEL </a>
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@endsection