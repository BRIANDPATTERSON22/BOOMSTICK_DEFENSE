@extends('admin.layouts.app')

@section('htmlheader_title')
    Advertisements
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add new {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s) </a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add new {{$module}} @endif</li>
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
                {!!Form::model($singleData, ['files' => true, 'autocomplete' => 'off'])!!}
                {!!csrf_field()!!}
                <?php
                $display = [
                    'UnderFeaturedItems'=>'Under Featured Items (1042 x 111 px)',
                    'UnderNewProducts'=>'Under New Products (1042 x 111 px)',
                    'UnderTopCategories'=>'Under Top categories (1042 x 111 px)',
                    'UnderSpecialOffers'=>'Under Special Offers (1042 x 111 px)',
                    'MainMenuCategory'=>'Main Menu(Category) Botttom Right (338 x 399 px)',
                    'UnderSinglePageProductLeft'=>'Under Single page product Left (800 x 152 px)',
                    'UnderSinglePageProductRight'=>'Under Single page product Right (800 x 152 px)',
                ];
                ?>
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group">
                                 {!!Form::label("Is Permanent Advertisement Image")!!} <br>
                                <label class="switch">
                                    <input type="checkbox" name="is_permanent" value="1" @if($singleData->is_permanent == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Advertisement Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="PT10">
                                        <img src="{{asset('storage/'.$module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    {!!Form::label("Title *")!!}
                                    {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title'])!!}
                                    <em class="error-msg">{!!$errors->first('title')!!}</em>
                                </div>
                                <div class="col-md-6 form-group {{ $errors->has('display') ? 'has-error' : '' }}">
                                    {!!Form::label("Display *")!!}
                                    {!! Form::select('display', $display , null, ['class' => 'form-control', 'placeholder'=>'Select display area']) !!}
                                    <em class="error-msg">{!!$errors->first('display')!!}</em>
                                </div>
                            </div>
                            <div class="row">
                                <div id='calendar1' class="col-md-6 form-group">
                                    {!!Form::label("Start Date")!!}
                                    <div class="input-group {{ $errors->has('start_at') ? 'has-error' : '' }}">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        {!!Form::text('start_at', null, ['id' => 'datepicker1', 'class' => 'form-control', 'placeholder' => 'Select start date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                    </div><em class="error-msg">{!!$errors->first('start_at')!!}</em>
                                </div>
                                <div id='calendar1' class="col-md-6 form-group">
                                    {!!Form::label("End Date *")!!}
                                    <div class="input-group {{ $errors->has('end_at') ? 'has-error' : '' }}">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        {!!Form::text('end_at', null, ['id' => 'datepicker2', 'class' => 'form-control', 'placeholder' => 'Select end date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                    </div><em class="error-msg">{!!$errors->first('end_at')!!}</em>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
                                {!!Form::label("Link")!!}
                                {!!Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'Enter target link'])!!}
                                <em class="error-msg">{!!$errors->first('link')!!}</em>
                            </div>
                            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }} display-hidden">
                                {!!Form::label("Description")!!}
                                {!!Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter content'])!!}
                                <em class="error-msg">{!!$errors->first('content')!!}</em>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
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
        $('#datepicker1').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true,
            startDate:'-0d'
        });
    </script>
    <script>
        $('#datepicker2').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true,
            startDate:'-0d'
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