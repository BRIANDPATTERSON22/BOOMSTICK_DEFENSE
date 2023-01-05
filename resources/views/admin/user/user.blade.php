@extends('admin.layouts.app')

@section('htmlheader_title')
    @if($singleData->id) Edit User @else Add New User @endif | Users
@endsection

@section('contentheader_title')
    Manage Users
@endsection

@section('contentheader_description')
    Manage login users of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Users</li>
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
                            <h3 class="box-title">@if($singleData->id) Edit User | <a data-toggle="modal" data-target="#Password{{$singleData->id}}" ><i class="fa fa-lock"></i> Password</a> @else Add New User @endif</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label("Full Name *") !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                                <em class="error-msg">{!!$errors->first('name')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                {!! Form::label("Email (Username) *") !!}
                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email (username)']) !!}
                                <em class="error-msg">{!!$errors->first('email')!!}</em>
                            </div>
                            @if(!$singleData->id)
                                <div class="row">
                                    <div class="col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        {!! Form::label("Password *") !!}
                                        {!! Form::password('password', ['id' => 'pass2', 'class'=>'form-control', 'placeholder' => 'Enter password']) !!}
                                        <em class="error-msg">{!!$errors->first('password')!!}</em>
                                    </div>
                                    <div class="col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        {!! Form::label("Confirm password") !!}
                                        {!! Form::password('password_confirmation', ['id' => 'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Confirm password']) !!}
                                        <em class="error-msg">{!!$errors->first('password')!!}</em>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('roles_id') ? 'has-error' : '' }}">
                                {!! Form::label("User role *") !!}
                                {!! Form::select('roles_id[]', $roles, null, ['class' => 'form-control', 'multiple']) !!}
                                <em class="error-msg">{!!$errors->first('roles_id')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('permissions_id') ? 'has-error' : '' }}">
                                {!! Form::label("User permissions") !!}
                                {!! Form::select('permissions_id[]', $permissions, null, ['class' => 'form-control', 'multiple', 'style'=>'height:300px;']) !!}
                                <em class="error-msg">{!!$errors->first('permissions_id')!!}</em>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">
                                <span class="fa fa-check-circle-o"></span> @if($singleData->id) Update @else Create @endif
                            </button>
                            <button type="reset" class="btn btn-default"> <i class="fa fa-refresh"></i> Reset </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-8">
                        <div class="box-header">
                            <h3 class="box-title">List Of Users</h3>
                            <small class="pull-right">
                                <a href="{{ url('admin/'.$module.'s') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Roles</th>
                                        {{-- <th>Permissions</th> --}}
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                        <?php $count++; ?>
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{!!$row->name!!}</td>
                                            <td>{!!$row->email!!}</td>
                                            <td>
                                                @foreach($row->roles as $list)
                                                    <span class="label label-default">{{$list->name}}</span>
                                                @endforeach
                                            </td>
                                            {{-- <td>
                                                @foreach($row->permissions as $list)
                                                    <span class="label label-default">{{$list->name}}</span>
                                                @endforeach
                                            </td> --}}
                                            <td>
                                                <a href="{{ url('admin/'.$module.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                @if($row->id != 1)
                                                    <a href="{{ url('admin/'.$module.'/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i> </a>
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
        </div>
    </div>

    @if($singleData->id)
        <!-- Add Modal -->
        <div id="Password{{$singleData->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        <h4>Change Password for:  <u>{{$singleData->email}}</u></h4>
                    </div>
                    {!! Form::open(['files'=>true, 'url'=>'admin/user/'.$singleData->id.'/password']) !!}
                    {!!csrf_field()!!}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                {!! Form::label("Password") !!}
                                {!! Form::password('password', ['id' => 'pass2', 'class'=>'form-control', 'placeholder' => 'Enter password']) !!}
                                <em class="error-msg">{!!$errors->first('password')!!}</em>
                            </div>
                            <div class="col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                {!! Form::label("Confirm password") !!}
                                {!! Form::password('password_confirmation', ['id' => 'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Enter confirm password']) !!}
                                <em class="error-msg">{!!$errors->first('password')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success MR15"><i class="fa fa-check-circle-o"></i> Change Password</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
@endsection