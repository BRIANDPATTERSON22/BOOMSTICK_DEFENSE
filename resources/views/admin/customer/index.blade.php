@extends('admin.layouts.app')

@section('htmlheader_title')
    Customers
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{ session('customerType') }} {{$module}}(s) Created in the Year {{$year}} @endif</span>
@endsection

@section('contentheader_description')
    Manage customers of the site
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
                                <th>Name</th>
                                <th>Customer Type</th>
                                {{-- <th>Discount</th> --}}
                                {{-- <th>Verification</th> --}}
                                <th>Contact Info</th>
                                {{-- <th>Address</th> --}}
                                @if(Request::is('*trash'))<th>Deleted At</th>@else<th>Created At</th>@endif
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr class="@if($row->status==0) disabledBg_ @endif">
                                    <td>{{$count}}</td>
                                    @if(Request::is('*trash'))
                                        <td>{!!$row->first_name!!}</td>
                                    @else
                                        <td>
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}">{!!$row->first_name!!} {!!$row->last_name!!}</a>
                                            {{-- @if(count($row->hasOrdered) > 0)
                                                <span class="label label-success show">Ordered Customer</span>
                                            @endif --}}                                            
                                        </td>
                                    @endif

                                    @if($row->role_id == 3)
                                        <td class="bg-normal-customers">
                                            <span class="label label-info">Registered Customers</span>  
                                        </td> 
                                    @else
                                        <td class="bg-trade">
                                            <span class="label label-warning">Guest Customer</span>
                                        </td>
                                    @endif

                                    {{-- <td>{{ $row->discount_percentage ? $row->discount_percentage.'%' : '--' }}</td> --}}

                                    {{-- <td>
                                        @if ($row->user_id)
                                            <label class="switch" title="@if($row->user->status == 1)  value={{ $row->user->status }} Enabled @else Disabled @endif">
                                                <input type="checkbox" name="status"  class="check" value={!! $row->id !!} @if($row->user->status == 1) checked @endif >
                                                <div class="slider round"></div>
                                            </label>
                                        @else
                                            <small>Not Required.</small>
                                        @endif
                                    </td> --}}

                                    <td>
                                        <div class="clear-fix"> {{ $row->phone_no }} </div>
                                        <div class="clear-fix"> {{ $row->mobile_no }} </div>
                                        <small>{{ $row->email }}</small>
                                    </td>
                                    {{-- <td>
                                    	<strong>{{ $row->address1 }}</strong>
                                        <small class="show"> Country - @if($row->billing_country_id) {{$row->billingCountry->nicename}} @endif</small>
                                        <small class="show"> City -{{$row->city}} </small>
                                        <small class="show"> State -{{$row->state }} </small>
                                        <small class="show"> Postal code -{{$row->postal_code}} </small>
                                    </td> --}}

                                    <td>
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

@section('page-script')
    <script>
        $(".check").change(function()  {
            var status = $(this).val();
            if(status) {
                $.ajax({
                    url: "{{ route('status') }}",
                    type: "GET",
                    data: {id:status},
                    dataType: "json",
                });
            }
        });
    </script>
@endsection