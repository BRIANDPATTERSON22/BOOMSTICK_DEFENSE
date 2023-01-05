@extends('admin.layouts.app')

@section('htmlheader_title')
    Inquiries
@endsection

@section('contentheader_title')
    <span class=" text-capitalize"> @if(Request::is('*trash')) List of deleted enquiry @else List of Inquiries @endif</span>
@endsection

@section('contentheader_description')
    Inquiries from site-wide contact form
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> Inquiries</a></li>
            <li class="text-capitalize active"> Trash</li>@else
            <li class="text-capitalize active"> Inquiries</li>@endif
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
                                <th>First Name</th>
                                {{-- <th>Order No</th> --}}
                                <th>Conatct Reason</th>
                                <th>Inquiry</th>
                                <th>Conatct Info</th>
                                {{-- <th>Phone</th> --}}
                                {{-- <th>Email</th> --}}
                                <th>Is Viewed</th>
                                @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr>
                                    <td>{{$count}}</td>

                                    @if(Request::is('*trash'))
                                        <td>{{ $row->first_name }}</td>
                                    @else
                                        <td><a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}">{{ $row->first_name }}</a></td>
                                    @endif

                                    {{-- <td>{{ $row->order_no }}</td> --}}

                                    <td><strong>{{ $row->get_conatct_reason() }}</strong></td>

                                    <td>
                                       {{str_limit($row->inquiry, 80)}}
                                    </td>

                                    <td>
                                        <div class="clearfix"><strong>{{ $row->phone_no }}</strong></div>
                                        <small>{{ $row->email }}</small>
                                    </td>

                                    {{-- <td>{{ $row->phone_no }}</td> --}}

                                    {{-- <td>{{ $row->email }}</td> --}}

                                    @if($row->is_viewed == 1)
                                         <td><span class="label label-success">Yes</span></td>
                                    @else
                                         <td><span class="label label-danger">No</span></td>
                                    @endif

                                    @if(Request::is('*trash'))
                                        <td>{!!$row->deleted_at->format('d M, Y')!!}</td>
                                    @else
                                        <td>{!!$row->created_at->format('d M, Y')!!}</td>
                                    @endif

                                    <td class="text-nowrap">
                                        @if(Request::is('*trash'))
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!!$allData->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection