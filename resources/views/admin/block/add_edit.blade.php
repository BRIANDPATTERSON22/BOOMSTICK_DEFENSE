@extends('admin.layouts.app')

@section('htmlheader_title')
    @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif | Blocks
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
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-7 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Title *")!!}
                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title'])!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="col-sm-5 form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                            {!!Form::label("key *")!!}
                            {!!Form::text('slug', null, array('class' => 'form-control', $singleData->id ? 'readonly' : ''))!!}
                            <em class="error-msg">{!!$errors->first('slug')!!}</em>
                        </div>
                    </div>
                    @if($singleData->is_admin == 0)
                    <style type="text/css" media="screen">
                        #editor {
                            width: 100%;
                            height: 400px;
                        }
                    </style>
                    <div class="form-group">
                        {!!Form::label("Content")!!} (HTML only)
                        <div id="editor">
                            {{ $singleData->content }}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                        {!!Form::hidden('content_value', null, ['id' => 'editorValue'])!!}
                        <em class="error-msg">{!!$errors->first('content')!!}</em>
                    </div>
                    @else
                        <h3>System block</h3>
                    @endif
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
                    <button type="submit" class="btn btn-success" onclick="get_editor_value()">
                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                    </button>
                    <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('/plugins/ace-editor/ace.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/javascript");

        function get_editor_value(){
            var code = editor.getValue();
            document.getElementById("editorValue").value = code;
        }
    </script>
@endsection