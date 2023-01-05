@extends('admin.layouts.app')

@section('htmlheader_title')
    Product Sizes
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{$module}} Sizes</span>
@endsection

@section('contentheader_description')
    Manage products Measurement
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> Size</li>
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
                    <div class="col-md-4">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        <div class="box-header">
                            <h3 class="box-title">
                                @if($singleData->id) Edit Size ID: {{$singleData->id}} @else  Add New Measurement @endif
                            </h3>
                        </div>
                        <div class="box-body">
                            {{-- <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label("Product Size") !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                                <em class="error-msg">{!!$errors->first('name')!!}</em>
                            </div> --}}
                           {{--  <div class="form-group {{ $errors->has('measurement_type') ? 'has-error' : '' }}">
                                @php $measurement_type = ['1' => 'mm', '2' => 'cm', '3' => 'm', '4' => 'inch', '5' => 'ft'] @endphp
                                {!! Form::label("measurement_type") !!}
                                {!! Form::select('measurement_type', $measurement_type ,null, ['class' => 'form-control', 'placeholder' => 'Select  measurement_type']) !!}
                                <em class="error-msg">{!!$errors->first('measurement_type')!!}</em>
                            </div> --}}
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label("Measurement") !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter measurement description', 'required']) !!}
                                <em class="error-msg">{!!$errors->first('name')!!}</em>
                            </div>

                            <div class="form-group {{ $errors->has('measurement_type') ? 'has-error' : '' }}">
                                {!! Form::label("Symbol") !!}
                                {!! Form::text('measurement_type', null, ['class' => 'form-control', 'placeholder' => 'Enter measurement', 'required']) !!}
                                <em class="error-msg">{!!$errors->first('measurement_type')!!}</em>
                            </div>

                            @if($singleData->id)
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!! Form::label("Slug") !!}
                                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter slug (URL)']) !!}
                                    <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                </div>
                            @endif
                        {{--     <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label("Measurement Description") !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows'=>2]) !!}
                                <em class="error-msg">{!!$errors->first('description')!!}</em>
                            </div> --}}
                            {{-- <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'s-brand/'.$singleData->id.'/delete-image')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img src="{{asset('storage/brands/'.$singleData->image)}}" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div> --}}
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
                            <h3 class="box-title">List of Product Measurements</h3>
                            <small class="pull-right">
                                <a href="{{url('admin/products-size')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Measurement</th>
                                        {{-- <th>Measurement Type</th> --}}
                                        <th>Symbol</th>
                                         <th>Slug</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                        <?php $count++; ?>
                                        <tr class="@if($row->status==0) disabledBg @endif">
                                            <td>{{$count}}</td>
                                            {{-- <td><img src="{{asset('storage/sizes/'.$row->image)}}" width="50px"></td> --}}
                                            <td>{!!$row->name!!} 
                                                {{-- @if($row->measurement_type == 1)
                                                    mm
                                                @elseif($row->measurement_type == 2)
                                                    cm
                                                @elseif($row->measurement_type == 3)
                                                    m
                                                @elseif($row->measurement_type == 4)
                                                    inch
                                                @elseif($row->measurement_type == 5)
                                                    feet
                                                @endif --}}
                                            </td>
                                          {{--   <td>
                                                @if($row->measurement_type == 1)
                                                    Milli metre
                                                @elseif($row->measurement_type == 2)
                                                    Centi metre
                                                @elseif($row->measurement_type == 3)
                                                    Metre
                                                @elseif($row->measurement_type == 4)
                                                    inch
                                                @elseif($row->measurement_type == 5)
                                                    Feet
                                                @endif
                                            </td> --}}
                                            <td>{!!$row->measurement_type!!}</td>
                                              <td>{!!$row->slug!!}</td>
                                            <td>
                                                <a href="{{ url('admin/'.$module.'s-size/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                <a href="{{ url('admin/'.$module.'s-size/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a>
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