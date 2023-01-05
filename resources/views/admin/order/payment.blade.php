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
    @include('admin.partials.flash_message')

    @if($singleData->id)
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i>
                        <span>
                            @if($singleData->id) Edit Payment Method ID: {{$singleData->id}} @else  Add New Payment Method @endif
                        </span>
                     </a>
                </li>
                <li class="pull-right">
                    <a href="{{url('admin/payments')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                            {!!csrf_field()!!}
                           {{--  <div class="box-header">
                                <h3 class="box-title">
                                    @if($singleData->id) Edit Payment Method ID: {{$singleData->id}} @else  Add New Payment Method @endif
                                </h3>
                            </div> --}}
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label("Title") !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
                                    <em class="error-msg">{!!$errors->first('name')!!}</em>
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    {!! Form::label("Description") !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows'=>2]) !!}
                                    <em class="error-msg">{!!$errors->first('description')!!}</em>
                                </div>
                                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                    {!! Form::label("Content") !!} (Payment method information to display after checkout)
                                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter content',  'rows' => 3]) !!}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i> <span>List of Payment Methods</span></a></li>
            {{-- <li class="pull-right">
                <a href="{{url('admin/shippings')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                   {{--  <div class="box-header">
                                        <small class="pull-right">
                                            <a href="{{url('admin/shippings')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                                        </small>
                                    </div> --}}
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Content</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count = 0; ?>
                                                @foreach ($allData as $row)
                                                    <?php $count++; ?>
                                                    <tr class="@if($row->status==0) disabledBg @endif">
                                                        <td>{{$count}}</td>
                                                        <td>{{ $row->title }}</td>
                                                        <td>{{ $row->description ?? "---" }}</td>
                                                        <td>{{ $row->content ?? "---" }}</td>
                                                        <td class="text-nowrap">
                                                            <a href="{{ url('admin/payment/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i> Edit</a>
                                                            <a href="{{ url('admin/payment/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger disabled"><i class="fa fa-trash-o"> </i> Delete</a>
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
            </div>
        </div>
    </div>
@endsection