@extends('admin.layouts.app')

@section('htmlheader_title')
    {{ ucfirst(($module)) }}
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
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                {!!Form::label("Store Name *")!!}
                                {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter event title'])!!}
                                <em class="error-msg">{!!$errors->first('title')!!}</em>
                            </div>
                            <div class="row">
{{--                                 <div class="col-sm-4 form-group {{ $errors->has('division') ? 'has-error' : '' }}">
                                    {!!Form::label("division *")!!}
                                    {!!Form::text('division', null, ['class' => 'form-control', 'placeholder' => 'Enter division'])!!}
                                    <em class="error-msg">{!!$errors->first('division')!!}</em>
                                </div> --}}
                                <div class="col-sm-4 form-group {{ $errors->has('store_category_id') ? 'has-error' : '' }}">
                                    <span class="pull-right"><a href="{{url('admin/stores-category')}}" target="_blank">Add Division</a></span>
                                    {!!Form::label("Store dividion *")!!}
                                    {!!Form::select('store_category_id', $storeCategoriesData, null, ['class' => 'form-control select2', 'placeholder'=>'Select a Store dividion'])!!}
                                    <em class="error-msg">{!!$errors->first('store_category_id')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('banner') ? 'has-error' : '' }}">
                                    {!!Form::label("banner *")!!}
                                    {!!Form::text('banner', null, ['class' => 'form-control', 'placeholder' => 'Enter banner'])!!}
                                    <em class="error-msg">{!!$errors->first('banner')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('legacy') ? 'has-error' : '' }}">
                                    {!!Form::label("legacy *")!!}
                                    {!!Form::text('legacy', null, ['class' => 'form-control', 'placeholder' => 'Enter legacy'])!!}
                                    <em class="error-msg">{!!$errors->first('legacy')!!}</em>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 form-group {{ $errors->has('store_id') ? 'has-error' : '' }}">
                                    {!!Form::label("store_id *")!!}
                                    {!!Form::text('store_id', null, ['class' => 'form-control', 'placeholder' => 'Enter store_id'])!!}
                                    <em class="error-msg">{!!$errors->first('store_id')!!}</em>
                                </div>
                                <div class="col-sm-12 form-group {{ $errors->has('address_1') ? 'has-error' : '' }}">
                                    {!!Form::label("address_1 *")!!}
                                    {!!Form::textarea('address_1', null, ['class' => 'form-control', 'placeholder' => 'Enter event address_1', 'rows'=>3])!!}
                                    <em class="error-msg">{!!$errors->first('address_1')!!}</em>
                                </div>
                                <div class="col-sm-12 form-group {{ $errors->has('address_2') ? 'has-error' : '' }}">
                                    {!!Form::label("address_2 *")!!}
                                    {!!Form::textarea('address_1', null, ['class' => 'form-control', 'placeholder' => 'Enter event address_2', 'rows'=>3])!!}
                                    <em class="error-msg">{!!$errors->first('address_2')!!}</em>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                    {!!Form::label("city *")!!}
                                    {!!Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Enter event city'])!!}
                                    <em class="error-msg">{!!$errors->first('city')!!}</em>
                                </div>

                                <div class="col-sm-4 form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                                    {!!Form::label("state *")!!}
                                    {!!Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'Enter event state'])!!}
                                    <em class="error-msg">{!!$errors->first('state')!!}</em>
                                </div>

                                <div class="col-sm-4 form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                                    {!!Form::label("zip *")!!}
                                    {!!Form::text('zip', null, ['class' => 'form-control', 'placeholder' => 'Enter event zip'])!!}
                                    <em class="error-msg">{!!$errors->first('zip')!!}</em>
                                </div>
                            </div>
                           
                           
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('phone_no') ? 'has-error' : '' }}">
                                    {!!Form::label("phone_no *")!!}
                                    {!!Form::text('phone_no', null, ['class' => 'form-control', 'placeholder' => 'Enter event phone_no'])!!}
                                    <em class="error-msg">{!!$errors->first('phone_no')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                                    {!!Form::label("mobile_no")!!}
                                    {!!Form::text('mobile_no', null, ['class' => 'form-control', 'placeholder' => 'Enter event mobile_no'])!!}
                                    <em class="error-msg">{!!$errors->first('mobile_no')!!}</em>
                                </div>
                            </div>
                           

                           <div class="row">
                               <div class="col-sm-12 form-group {{ $errors->has('short_description') ? 'has-error' : '' }}">
                                   {!!Form::label("Short Description/ Excerpt")!!}
                                   {!!Form::textarea('short_description', null, ['class' => 'form-control', 'placeholder' => 'Enter event short_description', 'rows'=>3])!!}
                                   <em class="error-msg">{!!$errors->first('short_description')!!}</em>
                               </div>
                               <div class="col-sm-12 form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                   {!!Form::label("Content")!!}
                                   {!!Form::textarea('content', null, ['id' => 'page', 'class' => 'form-control', 'placeholder' => 'Enter event content'])!!}
                                   <em class="error-msg">{!!$errors->first('content')!!}</em>
                               </div>
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
                    
                    <div class="col-md-4">
                        <div class="box-body">
                            {{-- <div class="form-group {{ $errors->has('course_category_id') ? 'has-error' : '' }}">
                                {!!Form::label("course_category_id *")!!}
                                {!! Form::select('course_category_id', $arrCourseCategory , null, ['class' => 'form-control select2', 'placeholder'=>'Select course_category_id']) !!}
                                <em class="error-msg">{!!$errors->first('course_category_id')!!}</em>
                            </div> --}}

                          {{--   <div class="form-group {{ $errors->has('commencement') ? 'has-error' : '' }}">
                                {!!Form::label("commencement *")!!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!!Form::text('commencement', null, array('id' => 'commencement', 'class' => 'form-control', 'placeholder' => 'Enter commencement'))!!}
                                </div>
                                <em class="error-msg">{!!$errors->first('commencement')!!}</em>
                            </div> --}}

                          {{--   <div class="form-group {{ $errors->has('register_before') ? 'has-error' : '' }}">
                                {!!Form::label("register_before")!!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!!Form::text('register_before', null, array('id' => 'register_before', 'class' => 'form-control', 'placeholder' => 'Enter register_before'))!!}
                                </div>
                                <em class="error-msg">{!!$errors->first('register_before')!!}</em>
                            </div> --}}

                           {{--  <div class="form-group {{ $errors->has('lecture_time') ? 'has-error' : '' }}">
                                {!!Form::label("lecture_time")!!}
                                {!!Form::text('lecture_time', null, ['class' => 'form-control', 'placeholder' => 'Enter member lecture_time'])!!}
                                <em class="error-msg">{!!$errors->first('lecture_time')!!}</em>
                            </div> --}}
                            
                            {{-- <div class="form-group {{ $errors->has('total_amount') ? 'has-error' : '' }}">
                                {!!Form::label("total_amount")!!}
                                <div class="input-group">
                                    <span class="input-group-addon">Rs.</span>
                                    {!!Form::number('total_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter total_amount', 'step' => '1', 'min' => '0'])!!}
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <em class="error-msg">{!!$errors->first('total_amount')!!}</em>
                            </div> --}}
                            
                          {{--   <div class="form-group {{ $errors->has('first_installment_fee') ? 'has-error' : '' }}">
                                {!!Form::label("first_installment_fee")!!}
                                <div class="input-group">
                                    <span class="input-group-addon">Rs.</span>
                                    {!!Form::number('first_installment_fee', null, ['class' => 'form-control', 'placeholder' => 'Enter first_installment_fee', 'step' => '1', 'min' => '0'])!!}
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <em class="error-msg">{!!$errors->first('first_installment_fee')!!}</em>
                            </div> --}}

                            {{-- <div class="form-group {{ $errors->has('monthly_installment_fee') ? 'has-error' : '' }}">
                                {!!Form::label("monthly_installment_fee")!!}
                                <div class="input-group">
                                    <span class="input-group-addon">Rs.</span>
                                    {!!Form::number('monthly_installment_fee', null, ['class' => 'form-control', 'placeholder' => 'Enter monthly_installment_fee', 'step' => '1', 'min' => '0'])!!}
                                    <span class="input-group-addon">.00</span>
                                </div>
                                <em class="error-msg">{!!$errors->first('monthly_installment_fee')!!}</em>
                            </div> --}}

                           {{--  <div class="form-group {{ $errors->has('measurement') ? 'has-error' : '' }}">
                                {!!Form::label("Size")!!}
                                {!!Form::number('measurement', null, ['class' => 'form-control', 'placeholder' => 'Enter the product measurement', 'step' => '0.01', 'min' => '0'])!!}
                                <em class="error-msg">{!!$errors->first('measurement')!!}</em>
                            </div> --}}

                            @if($singleData->id)
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {!!Form::label("Slug *")!!}
                                    {!!Form::text('slug', null, array('class' => 'form-control'))!!}
                                    <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                    <em class="small-font">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                                </div>
                            @endif

                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <img src="{{ asset('storage/'.$module.'s/'.$singleData->image) }}" alt="Image" class="img-thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        // $('#commencement').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true
        // });
        // $('#register_before').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true
        // });
    </script>
@endsection