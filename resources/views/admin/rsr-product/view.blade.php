@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->title}} | {{ $module }}
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
            <div class="tab-pane active @if($singleData->status==0) bg-danger @endif">
                <div class="box-header">
                    {{-- <a class="btn btn-primary pull-right" href="{{url($module.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a> --}}
                    {{-- <h3 class="box-title">{{$singleData->title}}</h3> --}}
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                      <tbody>
                        {{-- <tr>
                            <th>Task</th>
                            <th style="width: 40px">Label</th>
                        </tr> --}}
                        @foreach($singleDataColumns as $row)
                            <tr>
                                <td><strong>{{ str_replace('_', ' ', Illuminate\Support\Str::title($row)) }}</strong></td>
                                @if($row == 'content')
                                    <td><span class="badge_ bg-grey text-justify">{!! $singleData->$row !!}</span></td>
                                @elseif($row == 'image')
                                    <td>
                                        @if($singleData->image)
                                            <img src="{{url('storage/'. $module. 's/' . $singleData->image)}}" width="100" height="100" alt="Image" class="img-circle">
                                        @else
                                            <img src="{{asset('admin/images/default.png')}}" width="100" alt="Image" class="img-circle">
                                        @endif
                                    </td>
                                @elseif($row == 'status')
                                    <td>
                                        @if($singleData->status == 0)
                                            <span class="badge bg-red">Disabled</span>
                                        @else
                                            <span class="badge bg-green">Enabled</span>
                                        @endif
                                    </td>
                                @else
                                    <td>{{ $singleData->$row }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} by {{Auth::user()->name}}</em>
                </div>
            </div>
        </div>
    </div>
@endsection