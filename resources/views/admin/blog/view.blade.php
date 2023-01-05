@extends('admin.layouts.app')

@section('htmlheader_title')
	Blogs
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}} </span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{URL::to('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->title}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{URL::to('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{URL::to('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
<div class="nav-tabs-custom">
    @include('admin.'.$module.'.header')
    <div class="tab-content">
        <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
            <div class="box-header">
                <h3 class="box-title">{{$singleData->title}}</h3>
                <small class="pull-right"><a class="btn btn-primary" href="{{url($module.'/'.$singleData->category->slug.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a></small>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($singleData->image)
                        <img src="{{asset('storage/'.$module.'s/'.$singleData->id.'/'.$singleData->image)}}" alt="No Image Available" class="img-thumbnail"/>
                        @endif
                        @if($singleData->video)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe src="https://www.youtube.com/embed/{{$singleData->video}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                        </div>
                        @endif
                        @if($singleData->audio)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{{$singleData->audio}}&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true"></iframe>
                        </div>
                        @endif
                        <table class="table table-bordered table-view">
                            <tr><th>Slug</th> <td>{{$singleData->slug}}</td> </tr>
                            @if($singleData->category_id)<tr><th>Category</th> <td>{{$singleData->category->title}}</td> </tr>@endif
                            @if($singleData->album_id)
                            <tr><th class="text-nowrap">Album Ref.</th> <td><a href="{{url('admin/photo/'.$singleData->gallery->id.'/view')}}"> {{$singleData->gallery->title}}</a></td> </tr>
                            @endif
                            <tr><th>Display</th> <td>{{$singleData->display}}</td> </tr>
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