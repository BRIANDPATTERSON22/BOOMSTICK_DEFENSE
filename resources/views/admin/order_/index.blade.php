@extends('admin.layouts.app')

@section('htmlheader_title')
    Orders
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) Created in the Year {{$year}} @endif</span>
@endsection

@section('contentheader_description')
    Manage orders of the site
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
                                <th>Order#</th>
                                <th>Customer</th>
                                <th>Sub Total</th>
                                <th>Shipping</th>
                                {{-- <th>Service Charge</th> --}}
                                <th>Grand Total</th>
                                <th>Payment Status</th>
                                {{-- <th>Order Status</th> --}}
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
                                        <td>{!!$row->order_no!!}</td>
                                    @else
                                        <td>
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}" class="clearfix">{!!$row->order_no!!}</a>
                                            {{-- @if($row->status == 1)
                                                <span class="label label-default">Approval pending</span>
                                            @elseif($row->status == 2)
                                                <span class="label label-warning">Order Approved</span>
                                            @elseif($row->status == 3)
                                                <strike><span class="label label-danger">Order Rejected</span></strike> 
                                            @elseif($row->status == 4)
                                                <span class="label label-primary">Dispatched</span>
                                            @elseif($row->status == 5)
                                                <span class="label label-success">Delivered</span>
                                            @endif --}}
                                        </td>
                                    @endif
                                    <td>
                                        @if($row->customer)
                                            <strong class="clearfix"><a href="{{ url('admin/customer/'.$row->customer_id.'/view') }}" target="__blank">{!!$row->customer->first_name!!} {!!$row->customer->last_name!!}</a></strong>
                                            <small style="white-space: nowrap;">{{$row->customer->mobile}}</small>
                                        @endif
                                    </td>

                                    <td>
                                        {{$option->currency_symbol}}{!!number_format($row->amount,2)!!}
                                    </td>

                                    <td>{{$option->currency_symbol}}{{number_format($row->shipping,2)}}</td>

                                    {{-- <td>{{$option->currency_symbol}}{{ number_format($row->dp_transaction_amount, 2) }}</td> --}}

                                    <td><strong>{{ $option->currency_symbol.$row->grand_total }}</strong></td>

                                    <td>
                                        @if ($row->pay_status == 'PAID')
                                            <span class="label label-success">PAID</span>
                                        @elseif($row->pay_status == 'UNPAID')
                                            <span class="label label-primary bg-navy">UNPAID</span>
                                        @elseif($row->pay_status == 'INCOMPLETED')
                                            <span class="label label-default">INCOMPLETED</span>
                                        @elseif($row->pay_status == 'FAILED')
                                            <strike> <span class="label label-danger">FAILED</span> </strike>
                                        @else
                                            <span class="label label-danger">ERROR</span>
                                        @endif
                                        <u>
                                            <small class="clearfix">{{ str_limit($row->payment_id ? $row->paymentMethod->title : '--', 50 )  }} </small>
                                        </u>
                                    </td>
                                    
                                    {{-- <td>
                                        @if($row->status == 1)
                                            <a onclick="if(!confirm('Are you sure to mark this as approved order?')){return false;}" title="Mark as approved order" href="{{url('admin/'.$module.'/'.$row->id.'/start-processing')}}" class="btn btn-sm btn-warning"> <i class="fa fa-check-square"></i> 
                                            </a>
                                            <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_{{ $row->id }}"> <i class="fa fa-close"></i> </div>
                                            <div class="modal fade" id="modal_{{ $row->id }}">
                                                <div class="modal-dialog">
                                                    
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Order Rejection for - {{ $row->order_no }}</h4>
                                                            </div>
                                                            {!! Form::open(['files' => true, 'url' => 'admin/order/'.$row->id.'/rejected', 'autocomplete'=>'off']) !!}
                                                            {!!csrf_field()!!}
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 form-group {{ $errors->has('rejection_message') ? 'has-error' : '' }}">
                                                                        {!!Form::label("rejection_message")!!}
                                                                        {!!Form::textarea('rejection_message', null, ['class' => 'form-control', 'placeholder' => 'Enter the message', 'required'])!!}
                                                                        <em class="error-msg">{!!$errors->first('rejection_message')!!}</em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Send Rejected Mail</button>
                                                            </div>
                                                            {!!Form::close()!!}
                                                        </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($row->status == 3)
                                            <div class="btn btn-sm btn-danger"> <i class="fa fa-close"> Rejected</i> </div>
                                        @endif 

                                        @if($row->status == 2)
                                           <a onclick="if(!confirm('Are you sure to mark this order as dispatched?')){return false;}" title="Mark as dispatched" href="{{url('admin/'.$module.'/'.$row->id.'/mark-as-dispatched')}}" class="btn btn-sm btn-primary"> <i class="fa fa-truck"></i> </a>
                                        @endif

                                        @if($row->status == 4)
                                            <a onclick="if(!confirm('Are you sure to mark this order as delivered? It will reduce the product')){return false;}" title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$row->id.'/delivered')}}" class="btn btn-sm btn-primary"> <i class="fa fa-long-arrow-right"></i> </a>
                                        @endif

                                        @if($row->status == 5)
                                            <div class="btn btn-sm btn-success"> <i class="fa fa-check-square"> Delivered</i> </div>
                                        @endif

                                    </td> --}}

                                    @if(Request::is('*trash'))
                                        <td style="white-space: nowrap;"><small>{!!$row->deleted_at->format('d M, Y')!!}</small></td>
                                    @else
                                        <td style="white-space: nowrap;"><small>{!!$row->created_at->format('d M, Y')!!}</small></td>
                                    @endif

                                    <td style="white-space: nowrap;">
                                        @if(Request::is('*trash'))
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   {{--  @if ($allData)
                        {{ $allData->links() }}
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection