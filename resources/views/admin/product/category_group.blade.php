@extends('admin.layouts.app')

@section('htmlheader_title')
    {{ $moduleTitle }}
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{ $moduleTitle }}</span>
@endsection

@section('contentheader_description')
    Manage {{ $moduleTitle }}
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> {{ $moduleTitle }}</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i>
                    <span>
                        @if($singleData->id) Edit {{ $moduleTitle }} ID: {{$singleData->id}} @else  Add New {{ $moduleTitle }} @endif
                    </span>
                 </a>
            </li>
            <li class="pull-right">
                <a href="{{url('admin/'.str_slug($moduleTitle))}}"><i class="fa fa-plus"></i> <span>Add</span></a>
            </li>
        </ul>

        {{-- @include('admin.'.$module.'.header') --}}
        
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        {{-- <div class="box-header">
                            <h3 class="box-title">
                                @if($singleData->id) Edit Shipping Method ID: {{$singleData->id}} @else  Add New Shipping Method @endif
                            </h3>
                        </div> --}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    {!! Form::label("Category Group Title*") !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Category Group Title']) !!}
                                    <em class="error-msg">{!!$errors->first('title')!!}</em>
                                </div>

                                <div class="col-sm-3 form-group {{ $errors->has('is_enabled_on_menu') ? 'has-error' : '' }}">
                                    {!!Form::label("Enable/ Disable on menu *")!!}
                                    {!! Form::select('is_enabled_on_menu', [0 => "Disabled", 1 => "Enabled"], null, ['class'=>'form-control select2', 'placeholder'=>'Select Is Enable/ Disable on menu']) !!}
                                    <em class="error-msg">{!!$errors->first('is_enabled_on_menu')!!}</em>
                                </div>

                                <div class="col-md-3 form-group {{ $errors->has('menu_order_no') ? 'has-error' : '' }}">
                                    {!! Form::label("Menu Order No") !!}
                                    {!! Form::number('menu_order_no', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Order No']) !!}
                                    <em class="error-msg">{!!$errors->first('menu_order_no')!!}</em>
                                </div>

                                <div class="col-md-12 form-group">
                                    {!!Form::label("Select Categories*")!!}
                                    {{-- {!!Form::select('ds_divisions[]', $divisionData, @if($singleData->id && in_array($row->id, $singleData->ds_divisions)) selected @endif, ['class' => 'form-control select2', 'multiple' => 'multiple','data-placeholder' => 'Select the DS Division(s)'])!!} --}}
                                    <select name="categories[]" class="form-control select2" multiple="multiple" data-placeholder="Select Categories">
                                        @foreach($mainCategoriesCollection as $row)
                                            <option value="{{ $row->id }}" @if($singleData->id && in_array($row->id, $singleData->categories)) selected @endif>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <em class="error-msg">{!!$errors->first('categories')!!}</em>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-sm-12 form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    {!! Form::label("Description") !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows' => '2']) !!}
                                    <em class="error-msg">{!!$errors->first('description')!!}</em>
                                </div>
                                <div class="form-group col-md-12 {{ $errors->has('image') ? 'has-error' : '' }}">
                                    {!!Form::label("Upload Image [Size: 512px x 512px]")!!}
                                    {!!Form::file('image', ['accept'=>'image/*'])!!}
                                    @if($singleData->image)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="image-close"><a href="{{url('admin/'.str_slug(str_singular($moduleTitle)).'/'.$singleData->id.'/delete-image')}}"><i class="fa fa-close red-text"></i></a></div>
                                                <img width="100px" src="{{asset('storage/'.str_slug($moduleTitle).'/'.$singleData->image)}}" class="img-thumbnail">
                                            </div>
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('image')!!}</em>
                                </div>
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


    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i> <span>List of {{ $moduleTitle }}</span></a></li>
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
                                                    <th>Image</th>
                                                    <th>Group Name</th>
                                                    <th>Categories </th>
                                                    {{-- <th>Description</th> --}}
                                                    <th>Menu Order No</th>
                                                    <th>Is Enables On Menu</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count = 0; ?>
                                                @foreach ($allData as $row)
                                                    <?php $count++; ?>
                                                    <tr class="@if($row->status==0) disabledBg @endif">
                                                        <td>{{$count}}</td>

                                                        <td>
                                                            @if($row->image)
                                                                <img src="{{asset('storage/'.str_slug($moduleTitle).'/'.$row->image)}}" height="50px">
                                                            @else
                                                                <img src="{{asset('admin/defaults/placeholder.png')}}" width="50px">
                                                            @endif
                                                        </td>

                                                        <td>
                                                            {{ $row->title }}
                                                            <small class="clearfix"><i>{{ $row->description }}</i></small>
                                                        </td>

                                                        <td>
                                                            @foreach ($row->have_main_categories as $category)
                                                                <span class="label label-default">
                                                                    {{ $category->has_main_category ? $category->has_main_category->name : "x Deleted x" }}
                                                                </span>
                                                            @endforeach
                                                        </td>

                                                        {{-- <td>{{ $row->description ? $row->description : '--' }}</td> --}}

                                                        <td>{{ $row->menu_order_no ? $row->menu_order_no : '--' }}</td>

                                                        <td>{!! $row->get_is_enabled_on_menu() !!} </td>

                                                        <td  style="white-space: nowrap;">
                                                            <a href="{{ url('admin/'.str_slug(str_singular($moduleTitle)).'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i> Edit</a>
                                                            <a href="{{ url('admin/'.str_slug(str_singular($moduleTitle)).'/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i> Delete</a>
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

@section('page-script')
@endsection