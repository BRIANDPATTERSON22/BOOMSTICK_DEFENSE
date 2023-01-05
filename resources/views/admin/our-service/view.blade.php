@extends('admin.layouts.app')

@section('htmlheader_title')
    Events
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
                    <h3 class="box-title">{{$singleData->title}}</h3>
                    <small class="pull-right"><a class="btn btn-primary" href="{{url($module.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a></small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($singleData->image)
                                <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                            @endif
                            <table class="table table-bordered table-view">
                                <tr><th>Slug</th> <td>{{$singleData->slug}}</td> </tr>
                                <tr><th>Date/Time</th> <td>{{$singleData->date}}, {{$singleData->time}}</td> </tr>
                                <tr><th>Venue</th> <td>{{$singleData->venue}}</td> </tr>
                                @if($singleData->user_id)<tr><th>Created By</th> <td>{{$singleData->user->name}}</td> </tr>@endif
                                <tr><th>Created</th> <td>{{$singleData->created_at}}</td> </tr>
                                <tr><th>Updated</th> <td>{{$singleData->updated_at}}</td> </tr>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <em>{{$singleData->summary}}</em><hr>
                            {!! $singleData->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection