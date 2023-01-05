@extends('admin.layouts.app')

@section('htmlheader_title')
    {{ $module }}(s)
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) Created in the Year {{$year}}@endif</span>
@endsection

@section('contentheader_description')
    Manage {{ $module }}(s) of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
                                <th>Store Name</th>
                                <th>Image</th>
                                <th>Division</th>
                                <th>Banner</th>
                                <th>Legacy</th>
                                <th>Store ID</th>
                                <th>Address</th>
                                <th>
                                    @if(Request::is('*trash'))
                                        Deleted
                                    @else
                                        Created
                                    @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr class="@if($row->status == 0) bg-danger @endif">
                                    <td>{{$count}}</td>
                                    @if(Request::is('*trash'))
                                        <td>{{ str_limit($row->title, 30) }}</td>
                                    @else
                                        <td><a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}">{{ str_limit($row->title, 30) }}</a></td>
                                    @endif
                                    <td>
                                        @if($row->image)
                                            <img src="{{asset('storage/'.$module.'s/'.$row->image)}}" height="80px">
                                        @else
                                            <img src="{{asset('admin/images/default.png')}}" height="50px">
                                        @endif
                                    </td>
                                    <td>{{ $row->division }}</td>
                                    <td>{{ $row->banner }}</td>
                                    <td>{{ $row->legacy }}</td>
                                    <td>{{ $row->store_id }}</td>
                                    <td>
                                        <u> {{ str_limit($row->address_1) }} </u>
                                        <small class="center-block"> City -  {{ $row->city }} </small>
                                        <small class="center-block"> State -  {{ $row->state }} </small>
                                        <small class="center-block"> Zip -  {{ $row->zip }} </small>
                                        <small class="center-block"> Phone -  {{ $row->phone_no }} </small>
                                    </td>
                                    <td>
                                        <div class="clear-fix">
                                            @if($row->user_id) By {!!$row->user->name!!} @endif
                                        </div>
                                        @if(Request::is('*trash'))
                                            <small> {{ $row->deleted_at->format('d M, Y') }} </small>
                                        @else
                                            <small>{{ $row->created_at->format('d M, Y') }}</small>
                                        @endif
                                    </td>

                                    <td style="white-space: nowrap;">
                                        @if(Request::is('*trash'))
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> </a>
                                            {{-- <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a> --}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        @if ($allData)
                            {{ $allData->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection