@extends('admin.layouts.app')

@section('htmlheader_title')
    Testimonials
@endsection

@section('contentheader_title')
    @if(Request::is('*trash')) List of Deleted Testimonial @else List of Testimonials created in the Year {{$year}} @endif
@endsection

@section('contentheader_description')
    Manage testimonials of the hotel
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li><a href="{{url('admin/testimonials')}}"> Testimonials</a></li>
            <li class="active">Deleted Testimonials</li>@else
            <li class="active">Testimonials</li>@endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.testimonial.header')
        <div class="tab-content">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Review/ Testimonial</th>
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
                                <td>
                                    @if($row->image)
                                        <img width="80px" src="{{ asset('storage/testimonials/'.$row->image) }}" alt="guypaul_review">
                                    @else
                                        <img width="80px" src="{{ asset('site/images/avatar.png') }}" alt="guypaul_review">
                                    @endif
                                </td>
                                @if(Request::is('*trash'))<td>{{$row->first_name}} {{ $row->last_name }}</td>@else
                                    <td>
                                        <a href="{{url('admin/testimonial/'.$row->id.'/view')}}">{{$row->first_name}} {{ $row->last_name }}</a>
                                    </td>
                                @endif
                                <td>{!!str_limit($row->review, 200)!!}</td>
                                @if(Request::is('*trash'))<td>{!!$row->deleted_at->format('d M, Y')!!}</td>@else<td>{!!$row->created_at->format('d M, Y')!!}</td>@endif
                                <td>
                                    @if(Request::is('*trash'))
                                        <a class="btn btn-sm btn-success" href="{{url('admin/testimonial/'.$row->id.'/restore')}}">RESTORE</a>
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/testimonial/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}">DELETE</a>
                                    @else
                                        <a class="btn btn-sm btn-success" href="{{url('admin/testimonial/'.$row->id.'/view')}}"><i class="fa fa-search-plus"></i> </a>
                                        <a class="btn btn-sm btn-warning" href="{{url('admin/testimonial/'.$row->id.'/edit')}}"><i class="fa fa-edit"></i> </a>
                                        <a class="btn btn-sm btn-danger" href="{{url('admin/testimonial/'.$row->id.'/soft-delete')}}"><i class="fa fa-trash-o"></i> </a>
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