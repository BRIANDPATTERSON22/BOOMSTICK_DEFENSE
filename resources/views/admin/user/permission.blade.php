@extends('admin.layouts.app')

@section('htmlheader_title')
    Permissions
@endsection

@section('contentheader_title')
    Manage Permissions
@endsection

@section('contentheader_description')
    Manage permission for role and user of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Permissions</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.user.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        <div class="box-header">
                            <h3 class="box-title">@if($singleData->id) Edit Permission @else Add Permission @endif</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label("Name") !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter role name']) !!}
                                    <em class="error-msg">{!!$errors->first('name')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('guard_name') ? 'has-error' : '' }}">
                                    {!! Form::label("Guard Name") !!}
                                    {!! Form::text('guard_name', null, ['class' => 'form-control', 'placeholder' => 'Enter role display name']) !!}
                                    <em class="error-msg">{!!$errors->first('guard_name')!!}</em>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <button type="reset" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Reset
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-8">
                        <div class="box-header">
                            <h3 class="box-title">Permissions</h3>
                            <small class="pull-right">
                                <a href="{{ url('admin/permissions') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach($allData as $row)
                                        <?php $count++; ?>
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{!!$row->name!!}</td>
                                            <td>{!!$row->guard_name!!}</td>
                                            <td>
                                                <a href="{{ url('admin/permission/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                <a href="{{ url('admin/permission/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i> </a>
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