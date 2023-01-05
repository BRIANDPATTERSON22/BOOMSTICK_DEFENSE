@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->email}} | Reviews
@endsection

@section('contentheader_title')
    Room Review ID: {{$singleData->id}}
@endsection

@section('contentheader_description')

@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('admin/reviews')}}"> Reviews</a></li>
        <li class="active">{{$singleData->name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*view')) class="active" @endif>
        <a href="{{url('admin/review/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> View</a>
    </li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.review.header')
        <div class="tab-content @if($singleData->status==0) disabledBg @endif">
            <div class="box-header">
                <small class="pull-right">
                    {!! Form::open(array('url' => 'admin/review/'.$singleData->id.'/approve')) !!}
                    @if($singleData->status==0)
                        <input type="number" name="status" value="1" hidden>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> Approve</button>
                    @else
                        <input type="number" name="status" value="0" hidden>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Block</button>
                    @endif
                    {!! Form::close() !!}
                </small>
                <h3>{{$singleData->name}}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-bordered table-view">
                            <tr><th>Email</th> <td>{{$singleData->email}}</td> </tr>
                            @if($singleData->phone)
                                <tr><th>Phone</th> <td>{{$singleData->phone}}</td> </tr>
                            @endif
                            <tr><th>Product</th> <td>{{$singleData->product->name}}</td> </tr>
                        </table>
                    </div>
                    <div class="col-sm-8">
                        {!!$singleData->review!!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <em>Created at {{$singleData->created_at}}</em>
            </div>
        </div>
    </div>
@endsection