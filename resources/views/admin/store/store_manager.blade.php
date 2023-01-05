@extends('admin.layouts.app')

@section('htmlheader_title')
    Store Managers
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{$module}} Categories</span>
@endsection

@section('contentheader_description')
    Manage Store Managers
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> store-managers</li>
    </ol>
@endsection

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
    <style>
        /*.select2-dropdown .select2-search__field:focus, .select2-search--inline .select2-search__field:focus { outline: none;border: none;}*/
        .multiselect-container {box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);border : 1px solid #d2d6de;border-radius: 0px;}
        .btn-default {border-radius: 0px;}
    </style>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

        <ul class="nav nav-tabs">
            <li @if(Request::is('admin/store-manager')) class="active" @endif>
                <a href="{{url('admin/store-manager')}}"><i class="fa fa-list"></i> 
                    <span>
                        @if($singleData->id) Edit store-manager ID: {{$singleData->id}} @else  Add New store-manager @endif
                    </span>
                </a>
            </li>
            @yield('actions')
            <li class="pull-right">
                <a href="{{url('admin/store-manager')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        {{-- <div class="box-header">
                            <h3 class="box-title">
                                @if($singleData->id) Edit store-manager ID: {{$singleData->id}} @else  Add New store-manager @endif
                            </h3>
                        </div> --}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                   <div class="row">
                                       <div class="form-group col-md-6 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                           {!!Form::label("first_name *")!!}
                                           {!!Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Enter the first_name'])!!}
                                           <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                                       </div>

                                       <div class="form-group col-md-6 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                           {!!Form::label("last_name *")!!}
                                           {!!Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter the last_name'])!!}
                                           <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                                       </div>
                                   </div>
                                   
                                    <div class="col-md-6_">
                                        <div class="form-group {{ $errors->has('phone_no') ? 'has-error' : '' }}">
                                            {!! Form::label("Phone No") !!}
                                            {!! Form::text('phone_no', null, ['class' => 'form-control', 'placeholder' => 'Enter phone_no']) !!}
                                            <em class="error-msg">{!!$errors->first('phone_no')!!}</em>
                                        </div>
                                    </div> 

                                    {{-- <div class="col-md-6_">
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            {!! Form::label("Email") !!}
                                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter the email']) !!}
                                            <em class="error-msg">{!!$errors->first('email')!!}</em>
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                            {!!Form::label("email *")!!}
                                            {!!Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter the email'])!!}
                                            <em class="error-msg">{!!$errors->first('email')!!}</em>
                                        </div>
                                        <div class="col-md-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                            {!! Form::label("Password *") !!}
                                            {!! Form::password('password', ['id' => 'pass2', 'class'=>'form-control', 'placeholder' => 'Enter password']) !!}
                                            <em class="error-msg">{!!$errors->first('password')!!}</em>
                                        </div>    
                                    </div>
                                    

                                    <div class="col-md-6_">
                                        @if($singleData->id)
                                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                {!! Form::label("Slug") !!}
                                                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter slug (URL)']) !!}
                                                <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                            </div>
                                        @endif
                                    </div> 
                                    <div class="col-sm-12_ form-group">
                                        {!!Form::label("Select Store(s) *")!!}
                                        <span class="pull-right"><a href="{{url('admin/stores')}}" target="_blank">Add Stores</a></span>
                                        <select name="stores[]" id="stores" class="form-control" multiple="multiple">
                                            @foreach($storeCategoriesData as $row)
                                                <optgroup label=" DIVISION - {{ strtoupper($row->title) }} ">
                                                    @foreach ($row->storesData as $store)
                                                        <option value="{{ $store->store_id }}" @if($singleData->id && in_array($store->store_id, $singleData->stores)) selected @endif>
                                                            {{ $store->banner }} - {{ $store->store_id }}
                                                        </option>
                                                    @endforeach
                                                  </optgroup>
                                            @endforeach
                                        </select>
                                         <em class="error-msg">{!!$errors->first('stores')!!}</em>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12_">
                                        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                            {!!Form::label("Upload Image")!!}
                                            {!!Form::file('image', ['accept'=>'image/*'])!!}
                                            @if($singleData->image)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="image-close"><a href="{{url('admin/store-manager/'.$singleData->id.'/delete-image')}}"><i class="fa fa-close red-text"></i></a></div>
                                                        <img src="{{asset('storage/store-managers/'.$singleData->image)}}" class="img-thumbnail" width="215px;">
                                                    </div>
                                                </div>
                                            @endif
                                            <em class="error-msg">{!!$errors->first('image')!!}</em>
                                        </div>
                                    </div> 
                                </div>
                            </div>

                           {{--  <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label("Category Description") !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows'=>5]) !!}
                                <em class="error-msg">{!!$errors->first('description')!!}</em>
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
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i> <span>Manage Sales Persons</span></a></li>
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
                                                    <th>Name</th>
                                                    {{-- <th>Slug</th> --}}
                                                    <th>Email</th>
                                                    <th>Phone No</th>
                                                    <th>Stores</th>
                                                    <th></th>
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
                                                                <img src="{{asset('storage/store-managers/'.$row->image)}}" width="50px">
                                                            @else
                                                                <img src="https://via.placeholder.com/80x40?text=No+Image" alt="Image not found">
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->first_name }} {{ $row->last_name }} </td>
                                                        {{-- <td>{{ $row->slug }}</td> --}}
                                                        <td>{{ $row->email }}</td>
                                                        <td>{{ $row->phone_no }}</td>
                                                        <td>
                                                            @foreach ($row->haveStores as $storeRow)
                                                                <span class="label label-default">{{ $storeRow->store->banner }} - {{ $storeRow->store->store_id }} </span> &nbsp
                                                            @endforeach
                                                        </td>
                                                        <td style="white-space: nowrap;">
                                                            <a href="{{ url('admin/store-manager/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a>
                                                            <a href="{{ url('admin/store-manager/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-getting-started, #stores').multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                collapseOptGroupsByDefault: true,
                enableFiltering: true,
                // includeSelectAllOption: true,
                buttonWidth: '100%',
                buttonClass: 'btn btn-default btn-block btn-flat',
                maxHeight: 300,
            });
        });
    </script>
@endsection