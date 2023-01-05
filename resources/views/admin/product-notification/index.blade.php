@extends('admin.layouts.app')

@section('htmlheader_title')
    Product Notification
@endsection

@section('contentheader_title')
    @if(Request::is('*trash')) List of Deleted Product Notification @else List of Product Notification Created in the Year {{$year}} @endif
@endsection

@section('contentheader_description')
    Product Notification
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li><a href="{{url('admin/product-notifications')}}"> Product Notification</a></li>
            <li class="active"> Trash</li>
        @else
            <li class="active"> Subscribes</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.product-notification.header')
        <div class="tab-content">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            {{-- <th>Image</th> --}}
                            <th>Product Name</th>
                            <th>Email</th>
                            @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 0; ?>
                        @foreach ($allData as $row)
                            <?php $count++; ?>
                            <tr class="@if($row->status == 1) bg-success @else bg-danger @endif">
                                <td>{{$count}}</td>

                                <td>
                                    <strong class="clearfix">{{$row->title}}</strong>
                                    @if ($row->store_type == 0)
                                        <small>Boomstick</small>
                                    @else
                                        <small>RSR Product</small>
                                    @endif

                                   {{--  @if($row->store_type == 0)
                                        {{$row->product ? $row->product->title : "---"}}
                                    @endif --}}

                                    {{-- @if($row->store_type == 1)
                                        {{$row->rsr_product ? $row->rsr_product->product_description : "---"}}
                                    @endif --}}
                                </td>

                                <td>{{$row->email}}</td>

                                @if(Request::is('*trash'))<td>{!!$row->deleted_at->format('d M, Y')!!}</td>@else<td>{!!$row->created_at->format('d M, Y')!!}</td>@endif
                                <td>
                                    @if(Request::is('*trash'))
                                        <a class="btn btn-sm btn-success" href="{{url('admin/product-notification/'.$row->id.'/restore')}}">RESTORE</a>
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/product-notification/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}">DELETE</a>
                                    @else
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/product-notification/'.$row->id.'/soft-delete')}}"><i class="fa fa-trash-o"></i> DELETE</a>
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