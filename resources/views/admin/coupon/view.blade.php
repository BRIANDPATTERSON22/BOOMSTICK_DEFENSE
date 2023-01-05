@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->name}} | Coupons
@endsection

@section('contentheader_title')
    Coupon ID: {{$singleData->id}}
@endsection

@section('contentheader_description')

@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('admin/coupons')}}"> Coupons</a></li>
        <li class="active">{{$singleData->name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif>
        <a href="{{url('admin/coupon/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a>
    </li>
    <li class="active">
        <a href="{{url('admin/coupon/'.$singleData->id.'/edit')}}"><i class="fa fa-search-plus"></i> <span>View</span></a>
    </li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.coupon.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="info-box bg-yellow" style="margin-top: 40px">
                            <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{$singleData->name}}</span>
                                <span class="info-box-number">{{$singleData->series_no}}</span>
                                <?php $x = ($singleData->use_count/$singleData->count)*100 ?>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{$x}}"></div>
                                </div>
                                <span class="progress-description">
                                    {{$x}}% used, Expire on {{$singleData->expiry_date}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection