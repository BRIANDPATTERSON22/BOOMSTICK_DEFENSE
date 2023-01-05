@extends('admin.layouts.app')

@section('htmlheader_title')
    My Profile
@endsection

@section('contentheader_title')
    My Profile
@endsection

@section('contentheader_description')
    @if(Auth::user()->hasRole('admin'))
        As the <u>Master Admin</u> of the system, you can manage <u>all</u> functions on the system
    @elseif(Auth::user()->hasRole('editor'))
        As the <u>Content Editor</u> of the system, you can manage <u> CMS</u>,part of the system
    @endif
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">My Profile</li>
    </ol>
@endsection

@section('main-content')
    @if (count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, ['files' => true, 'autocomplete' => 'off'])!!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="col-md-4 pull-right">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/users/'.$singleData->id.'/profile-image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img width="150px" src="{{asset('storage/users/'.$singleData->id.'/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!!Form::label("Name *")!!}
                                    {!!Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name'])!!}
                                    <em class="error-msg">{!!$errors->first('name')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!!Form::label("Email (username) *")!!}
                                    {!!Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email (Username)'])!!}
                                    <em class="error-msg">{!!$errors->first('email')!!}</em>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {!! Form::label("Password *") !!}
                                    {!! Form::password('password', ['id' => 'pass2', 'class'=>'form-control', 'placeholder' => 'Enter password']) !!}
                                    <em class="error-msg">{!!$errors->first('password')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                    {!! Form::label("Confirm password *") !!}
                                    {!! Form::password('password_confirmation', ['id' => 'pass1', 'class'=>'form-control', 'oninput' => 'passConfirming()', 'placeholder' => 'Enter confirm password']) !!}
                                    <em class="error-msg">{!!$errors->first('confirm_password')!!}</em>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle-o"></i> Save
                                </button>
                                <a class="btn btn-default" href="{{url('admin/dashboard')}}"><span class="fa fa-times-circle-o"></span> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection