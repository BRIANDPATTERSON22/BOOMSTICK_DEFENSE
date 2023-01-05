@extends('admin.layouts.app')

@section('htmlheader_title')
	{{ $module }}
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if ($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{URL::to('admin/'.$module.'s')}}"> {{$module}}</a></li>
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
    <div class="tab-content">
        <div class="tab-pane active">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}
            <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
            <div class="row">
                <div class="col-md-4 col-md-push-8">
                    <div class="box-body">
                        
                        @if($singleData->id)
                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                {!!Form::label("Slug")!!}
                                {!!Form::text('slug', null, array('class' => 'form-control', 'required'))!!}
                                <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                <em class="small-font">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                            </div>
                        @endif

                        <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                            {!!Form::label("Blog Category *")!!}
                            {!!Form::select('category_id', $category, null, ['class' => 'form-control', 'placeholder'=>'Select a blog category'])!!}
                            <em class="error-msg">{!!$errors->first('category_id')!!}</em>
                            <span class="pull-right"><a href="{{url('admin/blogs/category')}}" target="_blank">Add category</a></span>
                        </div>
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                            {!!Form::label("Featured Image [800x500]")!!}
                            {!!Form::file('image')!!}
                            @if($singleData->image)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                    <img src="{{asset('storage/'.$module.'s/'.$singleData->id.'/'.$singleData->image)}}" alt="Image" class="img-responsive"/>
                                </div>
                            </div>
                            @endif
                            <em class="error-msg">{!!$errors->first('image')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
                            {!!Form::label("Link *")!!}
                            {!!Form::url('link', null, ['class' => 'form-control', 'placeholder' => 'Enter the link URL'])!!}
                            <em class="error-msg">{!!$errors->first('link')!!}</em>
                        </div>
                    </div>
               </div>
                <div class="col-md-8 col-md-pull-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Title *")!!}
                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter blog title'])!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!!Form::label("Summary *")!!}
                            {!!Form::textarea('summary', null, ['class' => 'form-control', 'placeholder' => 'Enter blog summary', 'rows' => '3'])!!}
                            <em class="error-msg">{!!$errors->first('summary')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            {!!Form::label("Content")!!}
                            {!!Form::textarea('content', null, ['id' => 'page', 'class' => 'form-control', 'placeholder' => 'Enter blog content'])!!}
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
                        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection