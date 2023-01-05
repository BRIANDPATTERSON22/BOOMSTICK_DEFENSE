@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->title}} | Events
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}}</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->title}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
                <div class="box-header">
                    <a class="btn btn-primary pull-right" href="{{url($module.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a>
                    <h3 class="box-title">{{$singleData->title}}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($singleData->image)
                                <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <i class="fa fa-clock-o"></i> {{$singleData->date}}, {{$singleData->time}} <br/>
                            <i class="fa fa-map-marker"></i> {{$singleData->venue}} <br/>
                            <em>{{$singleData->summary}}</em><hr>
                            {!! $singleData->content !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} by {{$singleData->user->name}}</em>
                </div>
            </div>
        </div>
    </div>
@endsection