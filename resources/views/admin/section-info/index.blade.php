@extends('admin.layouts.app')

@section('htmlheader_title')
   Section Info
@endsection

@section('contentheader_title')
   Section Info
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Section Info</li>
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
                        <div class="form-group {{ $errors->has('title_1') ? 'has-error' : '' }}">
                            {!!Form::label("Title 1")!!}
                            {!!Form::text('title_1', null, ['class' => 'form-control', 'placeholder' => 'Enter title 1'])!!}
                            <em class="error-msg">{!!$errors->first('title_1')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description_1') ? 'has-error' : '' }}">
                            {!!Form::label("Description 1")!!}
                            {!!Form::text('description_1', null, ['class' => 'form-control', 'placeholder' => 'Enter Description 1'])!!}
                            <em class="error-msg">{!!$errors->first('description_1')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('url_1') ? 'has-error' : '' }}">
                            {!!Form::label("URL 1")!!}
                            {!!Form::url('url_1', null, ['class' => 'form-control', 'placeholder' => 'Enter url 1'])!!}
                            <em class="error-msg">{!!$errors->first('url_1')!!}</em>
                        </div>
                         <div class="form-group {{ $errors->has('bg_color_1') ? 'has-error' : '' }}">
                            {{-- {!!Form::label("Background Color 1")!!} --}}
                            <label for="" style="background-color: {{$singleData->bg_color_1}}; color: white;">Background Color 1</label>
                            {!!Form::text('bg_color_1', null, ['class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Background Color 1'])!!}
                            <em class="error-msg">{!!$errors->first('bg_color_1')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title_2') ? 'has-error' : '' }}">
                            {!!Form::label("Title 2")!!}
                            {!!Form::text('title_2', null, ['class' => 'form-control', 'placeholder' => 'Enter title 2'])!!}
                            <em class="error-msg">{!!$errors->first('title_2')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description_2') ? 'has-error' : '' }}">
                            {!!Form::label("Description 2")!!}
                            {!!Form::text('description_2', null, ['class' => 'form-control', 'placeholder' => 'Enter Description 2'])!!}
                            <em class="error-msg">{!!$errors->first('description_2')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('url_2') ? 'has-error' : '' }}">
                            {!!Form::label("URL 2")!!}
                            {!!Form::url('url_2', null, ['class' => 'form-control', 'placeholder' => 'Enter url 2'])!!}
                            <em class="error-msg">{!!$errors->first('url_2')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('bg_color_2') ? 'has-error' : '' }}">
                            {{-- {!!Form::label("Background Color 2")!!} --}}
                            <label for="" style="background-color: {{$singleData->bg_color_2}}; color: white;">Background Color 2</label>
                            {!!Form::text('bg_color_2', null, ['class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Background Color 2'])!!}
                            <em class="error-msg">{!!$errors->first('bg_color_2')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title_3') ? 'has-error' : '' }}">
                            {!!Form::label("Title 3")!!}
                            {!!Form::text('title_3', null, ['class' => 'form-control', 'placeholder' => 'Enter title 3'])!!}
                            <em class="error-msg">{!!$errors->first('title_3')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description_3') ? 'has-error' : '' }}">
                            {!!Form::label("Description 3")!!}
                            {!!Form::text('description_3', null, ['class' => 'form-control', 'placeholder' => 'Enter Description 3'])!!}
                            <em class="error-msg">{!!$errors->first('description_3')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('url_3') ? 'has-error' : '' }}">
                            {!!Form::label("URL 3")!!}
                            {!!Form::url('url_3', null, ['class' => 'form-control', 'placeholder' => 'Enter url 3'])!!}
                            <em class="error-msg">{!!$errors->first('url_3')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('bg_color_3') ? 'has-error' : '' }}">
                            {{-- {!!Form::label("Background Color 3")!!} --}}
                             <label for="" style="background-color: {{$singleData->bg_color_3}};color: white;">Background Color 3</label>
                            {!!Form::text('bg_color_3', null, ['class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Background Color 3'])!!}
                            <em class="error-msg">{!!$errors->first('bg_color_3')!!}</em>
                        </div>
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