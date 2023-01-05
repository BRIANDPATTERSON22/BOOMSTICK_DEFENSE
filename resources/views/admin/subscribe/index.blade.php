@extends('admin.layouts.app')

@section('htmlheader_title')
    Subscribers
@endsection

@section('contentheader_title')
    @if(Request::is('*trash')) List of Deleted Subscriber @else List of Subscriber Created in the Year {{$year}} @endif
@endsection

@section('contentheader_description')
    Subscribers from site-wide subscribe form
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li><a href="{{url('admin/subscribes')}}"> Subscribers</a></li>
            <li class="active"> Trash</li>
        @else
            <li class="active"> Subscribes</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.subscribe.header')
        <div class="tab-content">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 0; ?>
                        @foreach ($allData as $row)
                            <?php $count++; ?>
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$row->email}}</td>
                                @if(Request::is('*trash'))<td>{!!$row->deleted_at->format('d M, Y')!!}</td>@else<td>{!!$row->created_at->format('d M, Y')!!}</td>@endif
                                <td>
                                    @if(Request::is('*trash'))
                                        <a class="btn btn-sm btn-success" href="{{url('admin/subscribe/'.$row->id.'/restore')}}">RESTORE</a>
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/subscribe/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}">DELETE</a>
                                    @else
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/subscribe/'.$row->id.'/soft-delete')}}"><i class="fa fa-trash-o"></i> </a>
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
@endsection