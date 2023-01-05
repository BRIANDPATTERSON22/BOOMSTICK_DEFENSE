@extends('admin.layouts.app')

@section('htmlheader_title')
    Videos
@endsection

@section('contentheader_title')
    <span class="text-capitalize">{{$module}} Albums</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> Albums</li>
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
                            <h3 class="box-title">@if($singleData->id) Edit Video Album ID: {{$singleData->id}} @else  Add New Video Album @endif</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('album_name') ? 'has-error' : '' }}">
                                {!! Form::label("Album Tile") !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter video album title']) !!}
                                <em class="small-font">{!!$errors->first('album_name')!!}</em>
                            </div>
                            @if($singleData->id)
                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                {!! Form::label("Album Slug") !!}
                                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter video album slug (URL)']) !!}
                                <em class="small-font">{!!$errors->first('slug')!!}</em>
                            </div>
                            @endif
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label("Album Description") !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter video album description', 'rows'=>5]) !!}
                                <em class="small-font">{!!$errors->first('description')!!}</em>
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
                                    <span class="fa fa-check-circle-o"></span> @if($singleData->id) Update @else Create @endif
                                </button>
                                <button type="reset" class="btn btn-default">
                                    <i class="fa fa-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-8">
                        <div class="box-header">
                            <h3 class="box-title">List of Video Albums</h3>
                            <small class="pull-right">
                                <a href="{{url('admin/'.$module.'s/album') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Album</th>
                                        <th>Slug</th>
                                        <th>Description</th>
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
                                            <td>{!!$row->description!!}</td>
                                            <td>
                                                <a href="{{ url('admin/videos/album/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                <a href="{{ url('admin/videos/album/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i> </a>
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