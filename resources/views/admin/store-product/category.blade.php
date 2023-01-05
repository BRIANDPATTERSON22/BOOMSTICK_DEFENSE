@extends('admin.layouts.app')

@section('htmlheader_title')
    {{ ucfirst($module) }} Categories
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{$module}} Categories</span>
@endsection

@section('contentheader_description')
    Manage {{ $module }}-categories
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> Categories</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        <div class="box-header">
                            <h3 class="box-title">
                                @if($singleData->id) Edit Category ID: {{$singleData->id}} @else  Add New Category @endif
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                {!! Form::label("Category Name") !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter category title']) !!}
                                <em class="error-msg">{!!$errors->first('title')!!}</em>
                            </div>
                            @if($singleData->id)
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!! Form::label("Slug") !!}
                                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter category slug (URL)']) !!}
                                    <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label("Category Description") !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter category description', 'rows'=>5]) !!}
                                <em class="error-msg">{!!$errors->first('description')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image [Size: 309 x 400px]")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'s-category/'.$singleData->id.'/delete-image')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img src="{{asset('storage/'.$module.'-categories/'.$singleData->image)}}" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
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

                    <div class="col-md-8">
                        <div class="box-header">
                            <h3 class="box-title">List of {{ $module }} Categories</h3>
                            <small class="pull-right">
                                <a href="{{url('admin/'.$module.'s-category')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                        <?php $count++; ?>
                                        <tr class="@if($row->status==0) bg-danger @endif">
                                            <td>{{$count}}</td>
                                            <td>
                                                @if($row->image)
                                                    <img src="{{asset('storage/'.$module.'-categories/'.$row->image)}}" height="40px">
                                                @else
                                                    <img src="{{asset('admin/images/default.png')}}" height="30px">
                                                @endif
                                            </td>
                                            <td>{!!$row->title!!}</td>
                                            <td>{!!$row->slug!!}</td>
                                            <td>{!!$row->description!!}</td>
                                            <td>
                                                <a href="{{ url('admin/'.$module.'s-category/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                <a href="{{ url('admin/'.$module.'s-category/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a>
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