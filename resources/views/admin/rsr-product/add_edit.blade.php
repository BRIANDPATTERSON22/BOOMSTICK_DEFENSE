@extends('admin.layouts.app')

@section('htmlheader_title')
    @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif | Products
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
        <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
    @endif
@endsection

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
    <style>
        .select2-dropdown .select2-search__field:focus, .select2-search--inline .select2-search__field:focus { outline: none;border: none;}
        .multiselect-container {box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);border : 1px solid #d2d6de;border-radius: 0px;}
        .btn-default {border-radius: 0px;}
        .gallery-edit-thumb {height: 100px; background-size: contain;background-repeat: no-repeat;}
        #states .form-group{margin-bottom: 0px !important;}
    </style>
@endsection

@section('main-content')
    {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
    {!!csrf_field()!!}
        <div class="nav-tabs-custom">
            @include('admin.'.$module.'.header')
            <div class="tab-content">
                <div class="tab-pane active">
                    <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6 form-group {{ $errors->has('rsr_stock_number') ? 'has-error' : '' }}">
                                        {!!Form::label("rsr_stock_number *")!!}
                                        {!!Form::text('rsr_stock_number', null, ['class' => 'form-control', 'placeholder' => 'rsr_stock_number', 'readonly'])!!}
                                        <em class="error-msg">{!!$errors->first('rsr_stock_number')!!}</em>
                                    </div>
                                    <div class="col-sm-6 form-group {{ $errors->has('upc_code') ? 'has-error' : '' }}">
                                        {!!Form::label("upc_code *")!!}
                                        {!!Form::text('upc_code', null, ['class' => 'form-control', 'placeholder' => 'upc_code', 'readonly'])!!}
                                        <em class="error-msg">{!!$errors->first('upc_code')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group {{ $errors->has('product_description') ? 'has-error' : '' }}">
                                        {!!Form::label("product_description *")!!}
                                        {!!Form::text('product_description', null, ['class' => 'form-control', 'placeholder' => 'product_description'])!!}
                                        <em class="error-msg">{!!$errors->first('product_description')!!}</em>
                                    </div>
                                    <div class="col-sm-12 form-group {{ $errors->has('expanded_product_description') ? 'has-error' : '' }}">
                                        {!!Form::label("expanded_product_description")!!}
                                        {!!Form::textarea('expanded_product_description', null, ['id' => 'page_', 'class' => 'form-control', 'placeholder' => 'Enter expanded_product_description', 'rows'=>2])!!}
                                        <em class="error-msg">{!!$errors->first('expanded_product_description')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('department_number') ? 'has-error' : '' }}">
                                        {!!Form::label("department_number *")!!}
                                        {!! Form::select('department_number', $rsrMainCategories, null, ['class'=>'form-control select2', 'placeholder'=>'department_number']) !!}
                                        <em class="error-msg">{!!$errors->first('department_number')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('inventory_quantity') ? 'has-error' : '' }}">
                                        {!!Form::label("inventory_quantity *")!!}
                                        {!!Form::number('inventory_quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('inventory_quantity')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('is_retail_price_display') ? 'has-error' : '' }}">
                                        {!!Form::label("retail_price *")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('retail_price', null, ['class' => 'form-control', 'placeholder' => 'retail_price'])!!}
                                            {{-- <span class="input-group-addon">.00</span> --}}
                                        </div>
                                        <em class="error-msg">{!!$errors->first('retail_price')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('rsr_pricing') ? 'has-error' : '' }}">
                                        {!!Form::label("rsr_pricing *")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('rsr_pricing', null, ['class' => 'form-control', 'placeholder' => 'rsr_pricing'])!!}
                                            {{-- <span class="input-group-addon">.00</span> --}}
                                        </div>
                                        <em class="error-msg">{!!$errors->first('rsr_pricing')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('model') ? 'has-error' : '' }}">
                                        {!!Form::label("model *")!!}
                                        {!!Form::text('model', null, ['class' => 'form-control', 'placeholder' => 'model'])!!}
                                        <em class="error-msg">{!!$errors->first('model')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('manufacturer_id') ? 'has-error' : '' }}">
                                        {!!Form::label("manufacturer_id *")!!}
                                        {!!Form::text('manufacturer_id', null, ['class' => 'form-control', 'placeholder' => 'manufacturer_id'])!!}
                                        <em class="error-msg">{!!$errors->first('manufacturer_id')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('full_manufacturer_name') ? 'has-error' : '' }}">
                                        {!!Form::label("full_manufacturer_name *")!!}
                                        {!!Form::text('full_manufacturer_name', null, ['class' => 'form-control', 'placeholder' => 'full_manufacturer_name'])!!}
                                        <em class="error-msg">{!!$errors->first('full_manufacturer_name')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('manufacturer_part_number') ? 'has-error' : '' }}">
                                        {!!Form::label("manufacturer_part_number *")!!}
                                        {!!Form::text('manufacturer_part_number', null, ['class' => 'form-control', 'placeholder' => 'manufacturer_part_number'])!!}
                                        <em class="error-msg">{!!$errors->first('manufacturer_part_number')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('product_weight') ? 'has-error' : '' }}">
                                        {!!Form::label("product_weight")!!}
                                        <div class="input-group">
                                            {!!Form::text('product_weight', null, ['class' => 'form-control', 'placeholder' => 'product_weight'])!!}
                                            <span class="input-group-addon">lbs</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('product_weight')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('shipping_length') ? 'has-error' : '' }}">
                                        {!!Form::label("shipping_length")!!}
                                        <div class="input-group">
                                            {!!Form::text('shipping_length', null, ['class' => 'form-control', 'placeholder' => 'shipping_length'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('shipping_length')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('shipping_width') ? 'has-error' : '' }}">
                                        {!!Form::label("shipping_width")!!}
                                        <div class="input-group">
                                            {!!Form::text('shipping_width', null, ['class' => 'form-control', 'placeholder' => 'shipping_width'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('shipping_width')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('shipping_height') ? 'has-error' : '' }}">
                                        {!!Form::label("shipping_height")!!}
                                        <div class="input-group">
                                            {!!Form::text('shipping_height', null, ['class' => 'form-control', 'placeholder' => 'shipping_height'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('shipping_height')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('allocated_closeout_deleted') ? 'has-error' : '' }}">
                                        {!!Form::label("allocated_closeout_deleted *")!!}
                                        {!!Form::text('allocated_closeout_deleted', null, ['class' => 'form-control', 'placeholder' => 'allocated_closeout_deleted'])!!}
                                        <em class="error-msg">{!!$errors->first('allocated_closeout_deleted')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('ground_shipments_only') ? 'has-error' : '' }}">
                                        {!!Form::label("ground_shipments_only *")!!}
                                        {!!Form::text('ground_shipments_only', null, ['class' => 'form-control', 'placeholder' => 'ground_shipments_only'])!!}
                                        <em class="error-msg">{!!$errors->first('ground_shipments_only')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('adult_signature_required') ? 'has-error' : '' }}">
                                        {!!Form::label("adult_signature_required *")!!}
                                        {!!Form::text('adult_signature_required', null, ['class' => 'form-control', 'placeholder' => 'adult_signature_required'])!!}
                                        <em class="error-msg">{!!$errors->first('adult_signature_required')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('blocked_from_dropship') ? 'has-error' : '' }}">
                                        {!!Form::label("blocked_from_dropship *")!!}
                                        {!!Form::text('blocked_from_dropship', null, ['class' => 'form-control', 'placeholder' => 'blocked_from_dropship'])!!}
                                        <em class="error-msg">{!!$errors->first('blocked_from_dropship')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('retail_map') ? 'has-error' : '' }}">
                                        {!!Form::label("retail_map *")!!}
                                        {!!Form::text('retail_map', null, ['class' => 'form-control', 'placeholder' => 'retail_map'])!!}
                                        <em class="error-msg">{!!$errors->first('retail_map')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('prop_65') ? 'has-error' : '' }}">
                                        {!!Form::label("prop_65 *")!!}
                                        {!!Form::text('prop_65', null, ['class' => 'form-control', 'placeholder' => 'prop_65'])!!}
                                        <em class="error-msg">{!!$errors->first('prop_65')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('vendor_approval_required') ? 'has-error' : '' }}">
                                        {!!Form::label("vendor_approval_required *")!!}
                                        {!!Form::text('vendor_approval_required', null, ['class' => 'form-control', 'placeholder' => 'vendor_approval_required'])!!}
                                        <em class="error-msg">{!!$errors->first('vendor_approval_required')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('image_disclaimer') ? 'has-error' : '' }}">
                                        {!!Form::label("image_disclaimer *")!!}
                                        {!!Form::text('image_disclaimer', null, ['class' => 'form-control', 'placeholder' => 'image_disclaimer'])!!}
                                        <em class="error-msg">{!!$errors->first('image_disclaimer')!!}</em>
                                    </div>
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('image_name') ? 'has-error' : '' }}">
                                        {!!Form::label("image_name *")!!}
                                        {!!Form::text('image_name', null, ['class' => 'form-control', 'placeholder' => 'image_name'])!!}
                                        <em class="error-msg">{!!$errors->first('image_name')!!}</em>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a>
                        <i class="fa fa-list"></i> <span>RSR Photo(s)</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    @if($singleData->rsr_gallery_hr_image_count())
                                        <div class="R5">
                                            @foreach($singleData->rsr_gallery_hr_images() as $key => $value)
                                                <div class="col-xs-3 col-sm-2 P5">
                                                    {{-- <div class="photo-remove"><a href="{{url('admin/'.$module.'-photo/'.$row->id.'/delete')}}"><i class="fa fa-close red-text"></i></a></div> --}}
                                                    <div class="gallery-edit-thumb" style="background-image: url('{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}')"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('image')!!}</em>
                                    {{-- <small>Maximum 5 images are allowed</small> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a>
                        <i class="fa fa-list"></i> <span>Photo</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Gallery [1024px x 1024px]")!!}
                                    {!!Form::file('photos[]', ['id' => 'inputPhotos', 'class'=>'file-input', 'multiple', 'accept'=>'image/*,.jpg,.gif,.png,.jpeg'])!!}
                                    
                                    @if($photos)
                                        <div class="R5">
                                            @foreach($photos as $row)
                                                <div class="col-xs-3 col-sm-2 P5">
                                                    <div class="photo-remove"><a href="{{url('admin/'.$module.'-photo/'.$row->id.'/delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                                    <div class="gallery-edit-thumb" style="background-image: url('{{asset('storage/'.$module.'s/rsr-photos/'.$row->product_id.'/'.$row->image)}}')"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('image')!!}</em>
                                    {{-- <small>Maximum 5 images are allowed</small> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a>
                        <i class="fa fa-list"></i> <span>States</span> <span class="text-yellow"><u><strong>[Availablity based on RSR API. If you want to overwrite you can change it]</strong></u></span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box-body" id="states">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Alaska") !!}
                                {!!Form::select('ak', config('default.isAvailable'), $singleData->ak == "Y" ? "Y" : "N", ['id'=>'ak', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ak">{!!$errors->first('ak')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Alabama") !!}
                                {!!Form::select('al', config('default.isAvailable'), $singleData->al == "Y" ? "Y" : "N", ['id'=>'al', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="al">{!!$errors->first('al')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Arkansas") !!}
                                {!!Form::select('ar', config('default.isAvailable'), $singleData->ar == "Y" ? "Y" : "N", ['id'=>'ar', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ar">{!!$errors->first('ar')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Arizona") !!}
                                {!!Form::select('az', config('default.isAvailable'), $singleData->az == "Y" ? "Y" : "N", ['id'=>'az', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="az">{!!$errors->first('az')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("California") !!}
                                {!!Form::select('ca', config('default.isAvailable'), $singleData->ca == "Y" ? "Y" : "N", ['id'=>'ca', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ca">{!!$errors->first('ca')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Colorado") !!}
                                {!!Form::select('co', config('default.isAvailable'), $singleData->co == "Y" ? "Y" : "N", ['id'=>'co', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="co">{!!$errors->first('co')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Connecticut") !!}
                                {!!Form::select('ct', config('default.isAvailable'), $singleData->ct == "Y" ? "Y" : "N", ['id'=>'ct', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ct">{!!$errors->first('ct')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("District of Columbia") !!}
                                {!!Form::select('dc', config('default.isAvailable'), $singleData->dc == "Y" ? "Y" : "N", ['id'=>'dc', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="dc">{!!$errors->first('dc')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Delaware") !!}
                                {!!Form::select('de', config('default.isAvailable'), $singleData->de == "Y" ? "Y" : "N", ['id'=>'de', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="de">{!!$errors->first('de')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Florida") !!}
                                {!!Form::select('fl', config('default.isAvailable'), $singleData->fl == "Y" ? "Y" : "N", ['id'=>'fl', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="fl">{!!$errors->first('fl')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Georgia") !!}
                                {!!Form::select('ga', config('default.isAvailable'), $singleData->ga == "Y" ? "Y" : "N", ['id'=>'ga', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ga">{!!$errors->first('ga')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Hawaii") !!}
                                {!!Form::select('hi', config('default.isAvailable'), $singleData->hi == "Y" ? "Y" : "N", ['id'=>'hi', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="hi">{!!$errors->first('hi')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Iowa") !!}
                                {!!Form::select('ia', config('default.isAvailable'), $singleData->ia == "Y" ? "Y" : "N", ['id'=>'ia', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ia">{!!$errors->first('ia')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Idaho") !!}
                                {!!Form::select('id_idaho', config('default.isAvailable'), $singleData->id_idaho == "Y" ? "Y" : "N", ['id'=>'id_idaho', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="id_idaho">{!!$errors->first('id_idaho')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Illinois") !!}
                                {!!Form::select('il', config('default.isAvailable'), $singleData->il == "Y" ? "Y" : "N", ['id'=>'il', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="il">{!!$errors->first('il')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Indiana") !!}
                                {!!Form::select('in', config('default.isAvailable'), $singleData->in == "Y" ? "Y" : "N", ['id'=>'in', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="in">{!!$errors->first('in')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Kansas") !!}
                                {!!Form::select('ks', config('default.isAvailable'), $singleData->ks == "Y" ? "Y" : "N", ['id'=>'ks', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ks">{!!$errors->first('ks')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Kentucky") !!}
                                {!!Form::select('ky', config('default.isAvailable'), $singleData->ky == "Y" ? "Y" : "N", ['id'=>'ky', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ky">{!!$errors->first('ky')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Louisiana") !!}
                                {!!Form::select('la', config('default.isAvailable'), $singleData->la == "Y" ? "Y" : "N", ['id'=>'la', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="la">{!!$errors->first('la')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Massachusetts") !!}
                                {!!Form::select('ma', config('default.isAvailable'), $singleData->ma == "Y" ? "Y" : "N", ['id'=>'ma', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ma">{!!$errors->first('ma')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Maryland") !!}
                                {!!Form::select('md', config('default.isAvailable'), $singleData->md == "Y" ? "Y" : "N", ['id'=>'md', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="md">{!!$errors->first('md')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Maine") !!}
                                {!!Form::select('me', config('default.isAvailable'), $singleData->me == "Y" ? "Y" : "N", ['id'=>'me', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="me">{!!$errors->first('me')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Michigan") !!}
                                {!!Form::select('mi', config('default.isAvailable'), $singleData->mi == "Y" ? "Y" : "N", ['id'=>'mi', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="mi">{!!$errors->first('mi')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Minnesota") !!}
                                {!!Form::select('mn', config('default.isAvailable'), $singleData->mn == "Y" ? "Y" : "N", ['id'=>'mn', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="mn">{!!$errors->first('mn')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Missouri") !!}
                                {!!Form::select('mo', config('default.isAvailable'), $singleData->mo == "Y" ? "Y" : "N", ['id'=>'mo', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="mo">{!!$errors->first('mo')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Mississippi") !!}
                                {!!Form::select('ms', config('default.isAvailable'), $singleData->ms == "Y" ? "Y" : "N", ['id'=>'ms', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ms">{!!$errors->first('ms')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Montana") !!}
                                {!!Form::select('mt', config('default.isAvailable'), $singleData->mt == "Y" ? "Y" : "N", ['id'=>'mt', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="mt">{!!$errors->first('mt')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("North Carolina") !!}
                                {!!Form::select('nc', config('default.isAvailable'), $singleData->nc == "Y" ? "Y" : "N", ['id'=>'nc', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nc">{!!$errors->first('nc')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("North Dakota") !!}
                                {!!Form::select('nd', config('default.isAvailable'), $singleData->nd == "Y" ? "Y" : "N", ['id'=>'nd', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nd">{!!$errors->first('nd')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Nebraska") !!}
                                {!!Form::select('ne', config('default.isAvailable'), $singleData->ne == "Y" ? "Y" : "N", ['id'=>'ne', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ne">{!!$errors->first('ne')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("New Hampshire") !!}
                                {!!Form::select('nh', config('default.isAvailable'), $singleData->nh == "Y" ? "Y" : "N", ['id'=>'nh', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nh">{!!$errors->first('nh')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("New Jersey") !!}
                                {!!Form::select('nj', config('default.isAvailable'), $singleData->nj == "Y" ? "Y" : "N", ['id'=>'nj', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nj">{!!$errors->first('nj')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("New Mexico") !!}
                                {!!Form::select('nm', config('default.isAvailable'), $singleData->nm == "Y" ? "Y" : "N", ['id'=>'nm', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nm">{!!$errors->first('nm')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Nevada") !!}
                                {!!Form::select('nv', config('default.isAvailable'), $singleData->nv == "Y" ? "Y" : "N", ['id'=>'nv', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="nv">{!!$errors->first('nv')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("New York") !!}
                                {!!Form::select('ny', config('default.isAvailable'), $singleData->ny == "Y" ? "Y" : "N", ['id'=>'ny', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ny">{!!$errors->first('ny')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Ohio") !!}
                                {!!Form::select('oh', config('default.isAvailable'), $singleData->oh == "Y" ? "Y" : "N", ['id'=>'oh', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="oh">{!!$errors->first('oh')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Oklahoma") !!}
                                {!!Form::select('ok', config('default.isAvailable'), $singleData->ok == "Y" ? "Y" : "N", ['id'=>'ok', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ok">{!!$errors->first('ok')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Oregon") !!}
                                {!!Form::select('or', config('default.isAvailable'), $singleData->or == "Y" ? "Y" : "N", ['id'=>'or', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="or">{!!$errors->first('or')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Pennsylvania") !!}
                                {!!Form::select('ph', config('default.isAvailable'), $singleData->ph == "Y" ? "Y" : "N", ['id'=>'ph', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ph">{!!$errors->first('ph')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Rhode Island") !!}
                                {!!Form::select('ri', config('default.isAvailable'), $singleData->ri == "Y" ? "Y" : "N", ['id'=>'ri', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ri">{!!$errors->first('ri')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("South Carolina") !!}
                                {!!Form::select('sc', config('default.isAvailable'), $singleData->sc == "Y" ? "Y" : "N", ['id'=>'sc', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="sc">{!!$errors->first('sc')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("South Dakota") !!}
                                {!!Form::select('sd', config('default.isAvailable'), $singleData->sd == "Y" ? "Y" : "N", ['id'=>'sd', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="sd">{!!$errors->first('sd')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Tennessee") !!}
                                {!!Form::select('tn', config('default.isAvailable'), $singleData->tn == "Y" ? "Y" : "N", ['id'=>'tn', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="tn">{!!$errors->first('tn')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Texas") !!}
                                {!!Form::select('tx', config('default.isAvailable'), $singleData->tx == "Y" ? "Y" : "N", ['id'=>'tx', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="tx">{!!$errors->first('tx')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Utah") !!}
                                {!!Form::select('ut', config('default.isAvailable'), $singleData->ut == "Y" ? "Y" : "N", ['id'=>'ut', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="ut">{!!$errors->first('ut')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Virginia") !!}
                                {!!Form::select('va', config('default.isAvailable'), $singleData->va == "Y" ? "Y" : "N", ['id'=>'va', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="va">{!!$errors->first('va')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Vermont") !!}
                                {!!Form::select('vt', config('default.isAvailable'), $singleData->vt == "Y" ? "Y" : "N", ['id'=>'vt', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="vt">{!!$errors->first('vt')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Washington") !!}
                                {!!Form::select('wa', config('default.isAvailable'), $singleData->wa == "Y" ? "Y" : "N", ['id'=>'wa', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="wa">{!!$errors->first('wa')!!}</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label("Wisconsin") !!}
                                {!!Form::select('wi', config('default.isAvailable'), $singleData->wi == "Y" ? "Y" : "N", ['id'=>'wi', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="wi">{!!$errors->first('wi')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("West Virginia") !!}
                                {!!Form::select('wv', config('default.isAvailable'), $singleData->wv == "Y" ? "Y" : "N", ['id'=>'wv', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="wv">{!!$errors->first('wv')!!}</em>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label("Wyoming") !!}
                                {!!Form::select('wy', config('default.isAvailable'), $singleData->wy == "Y" ? "Y" : "N", ['id'=>'wy', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select Availability'])!!}
                                <em class="error-msg" id="wy">{!!$errors->first('wy')!!}</em>
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
                        <button type="submit" class="btn btn-success" onclick="check_measurement_status()">
                            <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                        </button>
                        <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                    </div>
                </div>
            </div>
        </div>
    {!!Form::close()!!}
@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
{{--     <script type="text/javascript">
    $(document).ready(function() {
        $('#example-enableCollapsibleOptGroups-enableClickableOptGroups-enableFiltering-includeSelectAllOption').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true
        });
    });
    </script> --}}
    
    <!-- Initialize the plugin: -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-getting-started').multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                collapseOptGroupsByDefault: true,
                enableFiltering: true,
                // includeSelectAllOption: true,
                buttonWidth: '100%',
                buttonClass: 'btn btn-default btn-block btn-flat',
                maxHeight: 300,
            });

            $('#related_products').multiselect({
                // enableClickableOptGroups: true,
                // enableCollapsibleOptGroups: true,
                // collapseOptGroupsByDefault: true,
                enableFiltering: true,
                // includeSelectAllOption: true,
                buttonWidth: '100%',
                buttonClass: 'btn btn-default btn-block btn-flat',
                maxHeight: 300,
            });
        });
    </script>
    
<!-- <script>
    $(document).ready(function(){
        if($('#measurement').val != ''){
            $('#measurement-id').prop('required',true);
        }else{
            $('#d-checkout-address2').removeAttr('required');
        }
    });
</script> -->

<script>
    // $("#measurement").click(function( event ) {
    //     if($('#measurement').val != ''){
    //         $('#measurement-id').prop('required',true);
    //     }
    //     if($('#measurement').val == ''){
    //         $('#measurement-id').removeAttr('required');
    //     }
    // });

    // $("#measurement").on('click', function(){
    //     if($('#measurement').val != ''){
    //         $('#measurement-id').prop('required',true);
    //     }
    // });

    // $("#measurement").on('click', function(){
    //     if($('#measurement').val == ''){
    //         $('#measurement-id').removeAttr('required');
    //     }
    // });

    // function check_measurement_status(){
    //     if($('#measurement').val() != ''){
    //         $('#measurement-id').prop('required',true);
    //     }
    //     if($('#measurement').val() == ''){
    //         $('#measurement-id').removeAttr('required');
    //     }
    //     if($('#measurement-id').val() != ''){
    //         $('#measurement').prop('required',true);
    //     }
    //     if($('#measurement-id').val() == ''){
    //         $('#measurement').removeAttr('required');
    //     }
    // }
</script>

@endsection