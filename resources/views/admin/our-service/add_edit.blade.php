@extends('admin.layouts.app')

@section('htmlheader_title')
  Our Services
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
        <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('service_name') ? 'has-error' : '' }}">
                                {!!Form::label("Service Name *")!!}
                                {!!Form::text('service_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Service Name'])!!}
                                <em class="error-msg">{!!$errors->first('service_name')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!!Form::label("Description *")!!}
                                {!!Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Enter event title'])!!}
                                <em class="error-msg">{!!$errors->first('description')!!}</em>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif>
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <!--Date Picker-->
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script>
        $('#datepicker').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    </script>

    <!--Time Picker-->
    <script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script>
        $(".timepicker").timepicker({
            showInputs: false
        });
    </script>
@endsection