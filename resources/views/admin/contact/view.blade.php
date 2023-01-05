@extends('admin.layouts.app')

@section('htmlheader_title')
    Enquiries
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} enquiry ID: {{$singleData->id}}</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> Contact Enquiries</a></li>
        <li class="active">{{$singleData->name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {{-- <div class="box-header">
                    <h3 class="box-title">{{$singleData->subject}}</h3>
                </div> --}}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed">
                              <tbody>
                                {{-- <tr>
                                    <th>Task</th>
                                    <th style="width: 40px">Label</th>
                                </tr> --}}
                                {{-- @foreach($singleData->getTableColumns() as $row)
                                    <tr>
                                        <td width="15%;"><strong>{{ str_replace('_', ' ', Illuminate\Support\Str::title($row)) }}</strong></td>
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
                                        @elseif($row == 'is_viewed')
                                            <td>
                                                @if($singleData->is_viewed == 0)
                                                    <span class="badge bg-red">Pending</span>
                                                @else
                                                    <span class="badge bg-green">Viewed</span>
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
                                @endforeach --}}

                                    <tr>
                                        <td width="15%;"><strong>First Name</strong></td>
                                        <td>{{ $singleData->first_name ?? "---" }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td width="15%;"><strong>Last name</strong></td>
                                        <td>{{ $singleData->last_name ?? "---" }}</td>
                                    </tr> --}}
                                    <tr>
                                        <td width="15%;"><strong>Email</strong></td>
                                        <td>{{ $singleData->email ?? "---" }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%;"><strong>Phone No</strong></td>
                                        <td>{{ $singleData->phone_no ?? "---" }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%;"><strong>Order No</strong></td>
                                        <td>{{ $singleData->order_no ?? "---" }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%;"><strong>Conatct Reason</strong></td>
                                        <td>{{ $singleData->get_conatct_reason() }}</td>
                                    </tr>
                                   {{--  <tr>
                                        <td width="15%;"><strong>Subject</strong></td>
                                        <td>{{ $singleData->subject ?? "---" }}</td>
                                    </tr> --}}
                                    <tr>
                                        <td width="15%;"><strong>Inquiry</strong></td>
                                        <td>{{ $singleData->inquiry ?? "---" }}</td>
                                    </tr>

                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection