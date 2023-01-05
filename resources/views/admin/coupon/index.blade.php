@extends('admin.layouts.app')

@section('htmlheader_title')
    Coupons
@endsection

@section('contentheader_title')
    @if(Request::is('*trash')) List of Deleted Coupons @else List of Coupons created in the Year {{$year}} @endif
@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/administration')}}"><i class="fa fa-dashboard"></i> Administration</a></li>
        <li ><a href="{{url('admin/coupons')}}">Coupons</a></li>
        <li class="active">Manage</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.coupon.header')
        <div class="tab-content">
            <div class="box-body">
                <div class="row">
                    @foreach($allData as $row)
                    <div class="col-sm-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon">{{number_format($row->percentage, 0)}} <em>%</em></span>
                            <div class="info-box-content">
                                <span class="pull-right">
                                @if(Request::is('*trash'))
                                    <a class="btn btn-sm btn-success" href="{{url('admin/coupon/'.$row->id.'/restore')}}"> RESTORE</a>
                                    <a class="btn btn-sm btn-danger" href="{{url('admin/coupon/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}"> DELETE</a>
                                @else
                                    <!--
                                    <a class="btn btn-sm btn-primary" href="{{url('admin/coupon/'.$row->id.'/view')}}"> <i class="fa fa-search-plus"></i></a>
                                    -->
                                    <a class="btn btn-sm btn-success" href="{{url('admin/coupon/'.$row->id.'/edit')}}"> <i class="fa fa-edit"></i> </a>
                                    <a class="btn btn-sm btn-danger" href="{{url('admin/coupon/'.$row->id.'/soft-delete')}}"> <i class="fa fa-trash-o"></i> </a>
                                @endif
                                </span>
                                <span class="info-box-text">{{$row->name}}</span>
                                <span class="info-box-number">{{$row->series_no}}</span>
                                <?php $x = ($row->use_count/$row->count)*100 ?>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{$x}}"></div>
                                </div>
                                <!--
                                <span class="pull-right">
                                    <a title="Send coupon to All subscribers" class="btn btn-sm btn-primary" href="{{url('admin/coupon/'.$row->id.'/send-subscribers')}}"><i class="fa fa-at"></i> SEND</a>
                                    <a title="Send coupon to All guests" class="btn btn-sm btn-primary" href="{{url('admin/coupon/'.$row->id.'/send-guests')}}"><i class="fa fa-users"></i> SEND</a>
                                </span>
                                -->
                                <span class="progress-description">
                                    {{$x}}% used, Expire on {{$row->expiry_date}}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection