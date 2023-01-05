@extends('admin.layouts.app')

@section('htmlheader_title')
    Data Import
@endsection

@section('contentheader_title')
    <span class="text-capitalize">Import</span>
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
                {!!Form::open(['url' => 'admin/products/xlsx-import', 'files' => true])!!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3 form-group {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Brand *")!!}
                                    {!!Form::select('brand_id', $brand, null, ['class' => 'form-control', 'placeholder' => 'Select Brand'])!!}
                                    <em class="error-msg">{!!$errors->first('brand_id')!!}</em>
                                </div>
                                <div class="col-sm-3 form-group {{ $errors->has('category_main_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Category *")!!}
                                    {!! Form::select('category_main_id', $categories, $singleData->id ? $singleData->category->mainCategory->id : null, ['class'=>'form-control pro-cat-name', 'onchange'=>"select_category_menu('".url('/')."')", 'placeholder'=>'Select category']) !!}
                                    <em class="error-msg">{!!$errors->first('category_main_id')!!}</em>
                                </div>
                                <div class="col-sm-3 form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Sub Category *")!!}
                                    {!! Form::select('category_id', $categorySubs, null, ['class'=>'form-control pro-cat-sub-name', 'placeholder'=>'Select sub category']) !!}
                                    <em class="error-msg">{!!$errors->first('category_id')!!}</em>
                                </div>
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
                    <a class="btn btn-default" href="{{url('admin/'.$module.'s/xlsx-import')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')

@endsection