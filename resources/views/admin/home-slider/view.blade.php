@extends('admin.layouts.app')

@section('htmlheader_title')
	Home Slider
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}}</span>
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
                {{-- <h3 class="box-title">{{$singleData->title}}</h3> --}}
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($singleData->image)
                        <img src="{{asset('storage/'.$module.'s/'.$singleData->image)}}" alt="No Image Available" class="img-thumbnail"/>
                        @endif
                        <table class="table table-bordered table-view">
                            <tr><th>Title</th> <td>{{$singleData->title}}</td> </tr>
                            <tr><th>Sub Title</th> <td>{{$singleData->sub_title}}</td> </tr>
                            <tr><th>Description</th> <td>{{$singleData->description}}</td> </tr>
                            @if($singleData->user_id)<tr><th>Created By</th> <td>{{$singleData->user->name}}</td> </tr>@endif
                            <tr><th>Created</th> <td>{{$singleData->created_at}}</td> </tr>
                            <tr><th>Updated</th> <td>{{$singleData->updated_at}}</td> </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection