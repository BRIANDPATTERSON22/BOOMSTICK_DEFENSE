@extends('admin.layouts.app')

@section('htmlheader_title')
    Payment Methods
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> Payment Methods</span>
@endsection

@section('contentheader_description')
    Manage payment methods
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> Payment Methods</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-6">
                        @if($singleData->id)
                            {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                            {!!csrf_field()!!}
                            <div class="box-header">
                                <h3 class="box-title">
                                    @if($singleData->id) Edit Payment Method ID: {{$singleData->id}} @else  Add New Payment Method @endif
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label("Title") !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
                                    <em class="error-msg">{!!$errors->first('name')!!}</em>
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    {!! Form::label("Description") !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows'=>3]) !!}
                                    <em class="error-msg">{!!$errors->first('description')!!}</em>
                                </div>
                                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                    {!! Form::label("Content") !!} (Payment method information to display after checkout)
                                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter content']) !!}
                                    <em class="error-msg">{!!$errors->first('content')!!}</em>
                                </div>
                            </div>
                            <div class="box-footer">
                                @if($singleData->id)
                                    <div class="pull-right form-group">
                                        <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                            <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="box-header">
                            <h3 class="box-title">List of Payment Methods</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                        <?php $count++; ?>
                                        <tr class="@if($row->status==0) disabledBg @endif">
                                            <td>{{$count}}</td>
                                            <td>{!!$row->title!!}</td>
                                            <td>{!!$row->description!!}</td>
                                            <td>
                                                <a href="{{ url('admin/payment/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                {{-- <a href="{{ url('admin/payment/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a> --}}
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
        </div>
    </div>
@endsection