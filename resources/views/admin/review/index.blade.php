@extends('admin.layouts.app')

@section('htmlheader_title')
    Reviews
@endsection

@section('contentheader_title')
    @if(Request::is('*trash')) List of Deleted Room Reviews @else List of Room Reviews created in the Year {{$year}} @endif
@endsection

@section('contentheader_description')
    Reviews from customers
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li><a href="{{url('admin/review')}}"> Reviews</a></li>
            <li class="active"> Deleted Reviews</li>
        @else
            <li class="active"> Reviews</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.review.header')
        <div class="tab-content">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Product</th>
                            <th>Review</th>
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
                                @if(Request::is('*trash'))<td>{!!$row->name!!}</td>@else
                                    <td><a href="{{ url('admin/review/'.$row->id.'/view')}}">{!!$row->name!!} </a><br/> {!!$row->email!!}</td>@endif
                                <td>{{$row->product->name}}</td>
                                <td>{{str_limit($row->review, 200)}}</td>
                                @if(Request::is('*trash'))<td>{!!$row->deleted_at->format('d M, Y')!!}</td>@else<td>{!!$row->created_at->format('d M, Y')!!}</td>@endif
                                <td>
                                    @if(Request::is('*trash'))
                                        <a href="{{url('admin/review/'.$row->id.'/restore')}}"><button type="submit" class="btn btn-sm btn-success"> RESTORE</button></a>
                                        <a href="{{url('admin/review/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}"><button type="submit" class="btn btn-sm btn-danger"> DELETE </button></a>
                                    @else
                                        <a class="btn btn-sm btn-success" href="{{ url('admin/review/'.$row->id.'/view')}}"> <i class="fa fa-search-plus"></i> </a>
                                        <a class="btn btn-sm btn-danger" href="{{ url('admin/review/'.$row->id.'/soft-delete')}}"> <i class="fa fa-trash-o"></i> </a>
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