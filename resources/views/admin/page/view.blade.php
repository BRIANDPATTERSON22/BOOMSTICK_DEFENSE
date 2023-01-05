@extends('admin.layouts.app')

@section('htmlheader_title')
    Pages
@endsection

@section('contentheader_title')
    <span class="text-capitalize">View {{$module}} ID: {{$singleData->id}}</span>
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
                    <h3 class="box-title">{{$singleData->title}}</h3>
                    <small class="pull-right"><a class="btn btn-primary" href="{{url($singleData->slug)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a></small>
                </div>
                <div class="box-body">
                    <div class="row">
                        @if($singleData->image)
                            <div class="col-md-4">
                                <img src="{{asset('storage/'.$module.'s/'.$singleData->image)}}" class="img-thumbnail">
                            </div>
                        @endif
                        <div class="col-md-8">
                            <em>{{$singleData->summary}}</em><hr>
                            {!! $singleData->content !!}
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} @if($singleData->user_id > 0) by {{$singleData->user->name}} @endif</em>
                </div>
            </div>
        </div>
    </div>
@endsection