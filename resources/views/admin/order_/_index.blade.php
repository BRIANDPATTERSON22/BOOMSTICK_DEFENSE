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
                                <th>Discount Type</th>
                                <th>Shipping</th>
                                <th>Vat</th>
                                <th>Grand Total</th>
                                <th>Payment Type</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Delivery Status</th>
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
                                    @if(Request::is('*trash'))
                                        <td>{!!$row->order_no!!}</td>
                                    @else
                                        <td><a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}">{!!$row->order_no!!}</a></td>
                                    @endif
                                    <td>
                                        @if($row->customer)
                                            <strong><a href="{{ url('admin/customer/'.$row->customer_id.'/view') }}" target="__blank">{!!$row->customer->first_name!!}</a></strong> <br>
                                            @if($row->customer->role_id == 2)
                                                 <span class="label label-info "> Normal Customer</span>
                                            @elseif($row->customer->role_id == 3)
                                                 <span class="label label-warning ">Trade Customer</span>
                                            @elseif($row->customer->role_id == 4)
                                                 <span class="label label-success ">Cake Time Club</span>
                                            @endif
                                            <br>
                                            <span class="label label-default">{{$row->customer->email}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$option->currency_symbol}}{!!number_format($row->amount,2)!!}
                                    </td>
                                    <td>
                                        {{-- @if($row->coupon_id || $row->order_value_discount)
                                            @if($row->coupon_id)
                                                <span class="label label-primary">Coupon Discount</span><br>
                                                <span class="label label-success "> {{$row->coupongId->percentage}}% off </span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->amount * ($row->coupongId->percentage/100), 2)}}</strong>
                                            @endif
                                            @if($row->order_value_discount)
                                                <span class="label label-warning">Order Value Discount</span><br>
                                                <span class="label label-success"> {{$row->order_value_discount_percentage}}% off </span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->order_value_discount, 2)}}</strong>
                                            @endif
                                       @else
                                            <strike><span class="label label-danger ">No Discount!</span></strike>
                                        @endif --}}
                                        @if ($row->total_discount == 0)
                                            <strike><span class="label label-danger ">No Discount!</span></strike>
                                        @else
                                            @if ($row->discount_type == 1)
                                                <span class="label label-warning">Coupon Discount</span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->total_discount, 2)}}</strong>
                                            @elseif($row->discount_type == 2)
                                                <span class="label label-primary">Order Value Discount 50 - 100</span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->total_discount, 2)}}</strong>
                                            @elseif($row->discount_type == 3)
                                                <span class="label label-info">Order Value Discount over 100</span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->total_discount, 2)}}</strong>
                                            @elseif($row->discount_type == 4)
                                                <span class="label label-default">Normal Discount</span><br>
                                                <strong">{{$option->currency_symbol}}{{ number_format($row->total_discount, 2)}}</strong>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$option->currency_symbol}}{{number_format($row->shipping,2)}}</td>
                                    {{-- <td>{{$option->currency_symbol}}{{number_format($row->tax,2)}}</td> --}}
                                    <td>{{$option->currency_symbol}}{{number_format($row->vat,2)}}</td>
                                    <td>
                                        {{-- @if($row->coupon_id)
                                            <strong>${{number_format($row->amount + $row->shipping + $row->vat - $row->amount * ($row->coupongId->percentage/100),2)}}</strong>
                                        @else
                                             <strong>{{$option->currency_symbol}}{{number_format($row->amount + $row->shipping + $row->vat ,2)}}</strong>
                                        @endif --}}
                                         <strong>{{$option->currency_symbol}}{{number_format($row->amount + $row->shipping + $row->vat ,2)}}</strong>
                                    </td>
                                    <td>
                                        {{-- {{ $row->paymentMethod->title }} --}}
                                        @if($row->payment_id == 1)
                                            <span class="label label-primary">Pay on Delivery</span>
                                        @elseif($row->payment_id == 2)
                                            <span class="label label-info">Pay with PayPal</span>
                                        @elseif($row->payment_id == 3)
                                            <span class="label label-success">Pay to Bank</span>
                                        @elseif($row->payment_id == 4)
                                            <span class="label label-success">Pay with Credit Card</span>
                                        @elseif($row->payment_id == 5)
                                            <span class="label label-success">Sage Pay</span>
                                        @elseif($row->payment_id == 6)
                                            <span class="label label-warning">Pay by Invoice</span>
                                        @else
                                            <span class="label label-danger">Payment Failed!</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->pay_status == 'PAID')
                                            <span class="label label-success">PAID</span>
                                        @else
                                            <span class="label label-danger">UNPAID</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->status == 1)
                                            <span class="label label-default">Process Not Completed</span>
                                        @elseif($row->status == 2)
                                            <strike><span class="label label-danger">Cancelled by user</span></strike> 
                                        @elseif($row->status == 3)
                                            <span class="label label-warning">Pending</span>
                                        @elseif($row->status == 4)
                                            <span class="label label-primary">Processing</span>
                                        @elseif($row->status == 5)
                                            <span class="label label-info">Dispatched</span>
                                        @elseif($row->status == 6)
                                            <span class="label label-success">Delivered</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->status == 1)
                                            <div class="btn btn-sm btn-default"> <i class="fa fa-close"></i> </div>
                                        @endif

                                        @if($row->status == 2)
                                            <div class="btn btn-sm btn-danger"> <i class="fa fa-close"></i> </div>
                                        @endif

                                        {{-- @if($row->status == 3)
                                            <a onclick="if(!confirm('Are you sure to mark this as process started?')){return false;}" title="Mark as Paid" href="{{url('admin/'.$module.'/'.$row->id.'/start-processing')}}" class="btn btn-sm btn-info"> <i class="fa fa-check-square"></i> </a>
                                        @endif --}}

                                        @if($row->status == 3)
                                            @if(($row->payment_id == 6 || $row->payment_id  == 3 || $row->payment_id == 3) && $row->pay_status == 'UNPAID')
                                                <a onclick="if(!confirm('Are you sure to mark this order as paid?')){return false;}" title="Mark as Paid" href="{{url('admin/'.$module.'/'.$row->id.'/paid')}}" class="btn btn-sm btn-warning"> <i class="fa fa-check-square"></i> </a>
                                            @else
                                                <a onclick="if(!confirm('Are you sure to mark this as process started?')){return false;}" title="Mark as Paid" href="{{url('admin/'.$module.'/'.$row->id.'/start-processing')}}" class="btn btn-sm btn-warning"> <i class="fa fa-check-square"></i> </a>
                                            @endif
                                        @endif

                                        @if($row->status == 4)
                                            <a onclick="if(!confirm('Are you sure to mark this order as dispatched?')){return false;}" title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$row->id.'/mark-as-dispatched')}}" class="btn btn-sm btn-primary"> <i class="fa fa-truck"></i> </a>
                                        @endif

                                        @if($row->status == 5)
                                            <a onclick="if(!confirm('Are you sure to mark this order as delivered? It will reduce the product')){return false;}" title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$row->id.'/delivered')}}" class="btn btn-sm btn-primary"> <i class="fa fa-long-arrow-right"></i> </a>
                                        @endif

                                        @if($row->status == 6)
                                            <div class="btn btn-sm btn-success"> <i class="fa fa-check-square"></i> </div>
                                        @endif

                                        {{-- @if($row->payment_id == 1 && $row->status != 3 && $row->status != 4)
                                            <a onclick="if(!confirm('Are you sure to mark this order as paid?')){return false;}" title="Mark as Paid" href="{{url('admin/'.$module.'/'.$row->id.'/paid')}}" class="btn btn-sm btn-primary"> <i class="fa fa-check-square"></i> </a>
                                        @endif --}}
                                    </td>
                                    @if(Request::is('*trash'))
                                        <td>{!!$row->deleted_at->format('d M, Y')!!}</td>
                                    @else
                                        <td>{!!$row->created_at->format('d M, Y')!!}</td>
                                    @endif
                                    <td>
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
                </div>
            </div>
        </div>
    </div>
@endsection