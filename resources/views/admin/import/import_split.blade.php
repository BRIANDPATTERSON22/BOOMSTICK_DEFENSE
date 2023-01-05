@extends('admin.layouts.app')

@section('htmlheader_title')
    Import Category
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> Import Category</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s/xlsx-import')}}">Import Products</a></li>

    </ol>
@endsection

@section('actions')
     <!--    <li @if(Request::is('*products/xlsx-import')) class="active" @endif><a href="{{url('admin/'.$module.'s/xlsx-import')}}"><i class="fa fa-edit"></i> <span>IMPORT</span></a></li> -->
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::open(['url' => 'admin/import/split', 'files' => true])!!}
                {!!csrf_field()!!}
                    <div class="row">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-3 form-group">
                                        {!!Form::label("Upload file (.xlsx) *")!!}
                                        {!!Form::file('file', null, ['class' => 'form-control'])!!}
                                        <em class="help-info">{!!$errors->first('file')!!}</em>
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success" name="xlsx_submit">
                            <i class="fa fa-check-circle-o"></i> Upload
                        </button>
                        <a class="btn btn-default" href="{{url('admin/import/category')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                    </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
@endsection