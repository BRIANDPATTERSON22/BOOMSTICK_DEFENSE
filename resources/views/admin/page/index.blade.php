@extends('admin.layouts.app')

@section('htmlheader_title')
    Pages & Modules
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) @endif</span>
@endsection

@section('contentheader_description')
    Manage basic pages of the web-site - <em class="text-red">Cache clear required</em>
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        @if(Request::is('*trash'))
            <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
            <li class="text-capitalize active">Deleted {{$module}}(s)</li>
        @else
            <li class="text-capitalize active">{{$module}}(s)</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Summary</th>
                                <th>User</th>
                                @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr class="@if($row->status==0) disabledBg @endif">
                                    <td>{{$count}}</td>
                                    @if(Request::is('*trash'))
                                        <td>{!!$row->title!!}</td>
                                    @else
                                        <td><a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">{!!$row->title!!}</a></td>
                                    @endif
                                    <td>{!!$row->slug!!}</td>
                                    <td>{!!str_limit($row->summary, 100)!!}</td>
                                    <td>
                                        @if($row->user_id) {!!$row->user->name!!} @endif
                                    </td>
                                    @if(Request::is('*trash'))
                                        <td>{!!$row->deleted_at->format('d M, Y')!!}</td>
                                    @else
                                        <td>{!!$row->created_at->format('d M, Y')!!}</td>
                                    @endif
                                    <td>
                                        @if(Request::is('*trash'))
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE</a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection