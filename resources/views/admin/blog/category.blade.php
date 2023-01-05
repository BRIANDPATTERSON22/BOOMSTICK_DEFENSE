@extends('admin.layouts.app')

@section('htmlheader_title')
    Blogs
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{$module}} Categories</span>
@endsection

@section('contentheader_description')
    Manage blog categories
@endsection

@section('breadcrumb_title')
<ol class="breadcrumb">
    <li class="text-capitalize"><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="text-capitalize"><a href="{{URL::to('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
    <li class="text-capitalize active"> Categories</li>
</ol>
@endsection

@section('main-content')
<div class="nav-tabs-custom">
    @include('admin.'.$module.'.header')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="row">
                <div class="col-md-6">
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
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter category name']) !!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                            {!! Form::label("Slug") !!}
                            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter category slug (URL)']) !!}
                            <em class="error-msg">{!!$errors->first('slug')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!! Form::label("Category Description") !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter category description', 'rows'=>5]) !!}
                            <em class="error-msg">{!!$errors->first('description')!!}</em>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right form-group">
                            <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <button type="reset" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title">List of Blog Categories</h3>
                        <small class="pull-right">
                           <a href="{{URL::to('admin/blogs/category')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Category</a>
                        </small>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                    <?php $count++; ?>
                                    <tr class="@if($row->status==0) disabledBg @endif">
                                        <td>{{$count}}</td>
                                        <td>{!!$row->title!!}</td>
                                        <td>{!!$row->slug!!}</td>
                                        <td>
                                            <a href="{{ URL::to('admin/'.$module.'s/category/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                            <a href="{{ URL::to('admin/'.$module.'s/category/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a>
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