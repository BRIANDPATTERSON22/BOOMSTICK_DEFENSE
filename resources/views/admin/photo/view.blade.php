@extends('admin.layouts.app')

@section('htmlheader_title')
    Photo Albums
@endsection

@section('contentheader_title')
    <span class="text-capitalize">View {{$module}} album ID: {{$album->id}}</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}} Albums</a></li>
        <li class="text-capitalize active">{{str_limit($album->title, 50)}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$album->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$album->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($album->status==0) disabledBg @endif">
                <div class="box-header">
                    <h3 class="box-title">{{$album->title}}</h3>
                    <small class="pull-right"><a class="btn btn-primary" href="{{url($module.'/'.$album->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a></small>
                </div>
                <div class="box-body">
                    {!!$album->content!!}
                    <hr>
                    <div class="R5">
                        @foreach($photos as $row)
                            <div class="col-xs-6 col-sm-3 P5">
                                <div class="gallery-thumb" style="background-image: url('{{asset('storage/'.$module.'s/'.$row->album_id.'/'.$row->image)}}')"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="box-footer">
                    <em class="pull-right">Created on {{$album->created_at}} & Updated on {{$album->updated_at}} by {{$album->user->name}}</em>
                </div>
            </div>
        </div>
    </div>
@endsection