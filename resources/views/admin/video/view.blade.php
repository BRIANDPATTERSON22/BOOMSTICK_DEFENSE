@extends('admin.layouts.app')

@section('htmlheader_title')
    Videos
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}}</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}</a></li>
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
                    <small class="pull-right"><a class="btn btn-primary" href="{{url($module.'/'.$singleData->album->slug.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a></small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($singleData->type == "youtube")
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="https://www.youtube.com/embed/{{$singleData->code}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                                </div>
                            @elseif($singleData->type == "vimeo")
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="https://player.vimeo.com/video/{{$singleData->code}}?color=ffffff&title=0&byline=0&portrait=0" width="100%" height="320px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            @elseif($singleData->type == "smule")
                                <iframe frameborder="0" width="100%" src="https://www.smule.com/recording/bette-midler-in-my-life/{{$singleData->code}}/frame"></iframe>
                            @elseif($singleData->type == "facebook")
                                <div class="fb-video" data-href="{{$singleData->code}}" data-width="500" data-allowfullscreen="true"></div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <i class="fa fa-image"></i> {{$singleData->album->title}} <br/>
                            {!!$singleData->content!!}
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