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
                        <div class="col-md-9">
                            <div class="box-body">
                                {{-- <div class="row">
                                    <div class="col-sm-12 form-group {{ $errors->has('parent_product_id') ? 'has-error' : '' }}">
                                        {!!Form::label("parent_product")!!}
                                        {!!Form::select('parent_product_id', $parentProducts, null, ['class' => 'form-control select2', 'placeholder' => 'Select Parent Product'])!!}
                                        <em class="error-msg">{!!$errors->first('parent_product_id')!!}</em>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-sm-12 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        {!!Form::label("Product Name *")!!} <em class="error-msg">{!!$errors->first('title')!!}</em>
                                        {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter product title'])!!}
                                        {{-- <em class="error-msg">{!!$errors->first('title')!!}</em> --}}
                                    </div>

                                   {{--  <div class="col-sm-6 form-group">
                                        {!!Form::label("Select Store(s) *")!!}
                                        <span class="pull-right"><a href="{{url('admin/stores')}}" target="_blank">Add Stores</a></span>
                                        <select name="stores[]" id="example-getting-started" class="form-control" multiple="multiple">
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
                                    </div> --}}
                                </div>

                                 <div class="row">   
                                    <div class="col-sm-4 form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
                                        {!!Form::label("product_id *")!!}
                                        {!!Form::text('product_id', null, ['class' => 'form-control', 'placeholder' => 'product_id'])!!}
                                        <em class="error-msg">{!!$errors->first('product_id')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('upc') ? 'has-error' : '' }}">
                                        {!!Form::label("UPC *")!!}
                                        {!!Form::text('upc', null, ['class' => 'form-control', 'placeholder' => 'UPC/ Barcode'])!!}
                                        <em class="error-msg">{!!$errors->first('upc')!!}</em>
                                    </div>
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('sku') ? 'has-error' : '' }}">
                                        {!!Form::label("SKU")!!}
                                        {!!Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU'])!!}
                                        <em class="error-msg">{!!$errors->first('sku')!!}</em>
                                    </div> --}}
                                   {{--  <div class="col-sm-3 form-group {{ $errors->has('vat') ? 'has-error' : '' }}">
                                        @php $vat_percentage = ['0' => 'T0  -  Zero rated', '1' => 'Standard rate (20%)'] @endphp
                                        {!!Form::label("VAT *")!!}
                                        {!!Form::select('vat', $vat_percentage, null, ['class' => 'form-control', 'placeholder' => 'Select VAT'])!!}
                                        <em class="error-msg">{!!$errors->first('vat')!!}</em>
                                    </div> --}}
                               
                                    <div class="col-sm-4 form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                        {!!Form::label("Quantity *")!!}
                                        {!!Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('quantity')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- <div class="col-sm-4 form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                        {!!Form::label("Price *")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Price'])!!}
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('price')!!}</em>
                                    </div> --}}
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('special_price') ? 'has-error' : '' }}">
                                        {!!Form::label("Special/ Offer Price")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!!Form::text('special_price', null, ['class' => 'form-control', 'placeholder' => 'Special price'])!!}
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('special_price')!!}</em>
                                    </div> --}}
                                   {{--  <div class="col-sm-4 form-group {{ $errors->has('discount_percentage') ? 'has-error' : '' }}">
                                        {!!Form::label("Discount")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!!Form::number('discount_percentage', null, ['class' => 'form-control', 'placeholder' => 'Discount Percentage'])!!}
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('discount_percentage')!!}</em>
                                    </div> --}}
                                    {{-- <div class="col-sm-4 form-group {{ $errors->has('dicounted_price') ? 'has-error' : '' }}">
                                        {!!Form::label("Discounted Price")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('dicounted_price', null, ['class' => 'form-control', 'placeholder' => 'Discount price', 'readonly'])!!}
                                        </div>
                                        <em class="error-msg">{!!$errors->first('dicounted_price')!!}</em>
                                    </div> --}}
                                  
                              {{--       <div class="col-sm-2 form-group {{ $errors->has('weight') ? 'has-error' : '' }}">
                                        {!!Form::label("Weight (Kg)")!!}
                                        <div class="input-group">
                                            {!!Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Weight'])!!}
                                            <span class="input-group-addon">kg</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('weight')!!}</em>
                                    </div> --}}
                                </div>

                                  <div class="row">
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                                        {!!Form::label("MSRP Sale Price *")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('sale_price', null, ['class' => 'form-control', 'placeholder' => 'MSRP Sale Price'])!!}
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('sale_price')!!}</em>
                                    </div> --}}

                                    <div class="col-sm-4 form-group {{ $errors->has('retail_price') ? 'has-error' : '' }}">
                                        {!!Form::label("retail_price*")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('retail_price', null, ['class' => 'form-control', 'placeholder' => 'Retail Price'])!!}
                                            {{-- <span class="input-group-addon">.00</span> --}}
                                        </div>
                                        <em class="error-msg">{!!$errors->first('retail_price')!!}</em>
                                    </div>

                                    <div class="col-sm-4 form-group {{ $errors->has('discount_percentage') ? 'has-error' : '' }}">
                                        {!!Form::label("Discount")!!}
                                        <div class="input-group">
                                            {{-- <span class="input-group-addon">$</span> --}}
                                            {!!Form::number('discount_percentage', null, ['class' => 'form-control', 'placeholder' => 'Discount Percentage'])!!}
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('discount_percentage')!!}</em>
                                    </div>

                                    <div class="col-sm-4 form-group {{ $errors->has('dicounted_price') ? 'has-error' : '' }}">
                                        {!!Form::label("Discounted Price")!!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                            {!!Form::text('dicounted_price', null, ['class' => 'form-control', 'placeholder' => 'Discount price', 'readonly'])!!}
                                        </div>
                                        <em class="error-msg">{!!$errors->first('dicounted_price')!!}</em>
                                    </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-sm-4 form-group {{ $errors->has('manufacturer_id') ? 'has-error' : '' }}">
                                          {!!Form::label("manufacturer_id *")!!}
                                          {!!Form::text('manufacturer_id', null, ['class' => 'form-control', 'placeholder' => 'manufacturer_id'])!!}
                                          <em class="error-msg">{!!$errors->first('manufacturer_id')!!}</em>
                                      </div>
                                      <div class="col-sm-4 form-group {{ $errors->has('full_manufacturer_name') ? 'has-error' : '' }}">
                                          {!!Form::label("full_manufacturer_name *")!!}
                                          {!!Form::text('full_manufacturer_name', null, ['class' => 'form-control', 'placeholder' => 'full_manufacturer_name'])!!}
                                          <em class="error-msg">{!!$errors->first('full_manufacturer_name')!!}</em>
                                      </div>
                                      <div class="col-sm-4 form-group {{ $errors->has('manufacturer_part_number') ? 'has-error' : '' }}">
                                          {!!Form::label("manufacturer_part_number *")!!}
                                          {!!Form::text('manufacturer_part_number', null, ['class' => 'form-control', 'placeholder' => 'manufacturer_part_number'])!!}
                                          <em class="error-msg">{!!$errors->first('manufacturer_part_number')!!}</em>
                                      </div>
                                  </div>


                                {{--<div class="row">--}}
                                    {{--<div class="col-sm-3 form-group {{ $errors->has('cake_time_club_discount') ? 'has-error' : '' }}">--}}
                                        {{--{!!Form::label("Caketime discount *")!!}--}}
                                        {{--<div class="input-group">--}}
                                            {{--{!!Form::text('cake_time_club_discount', null, ['class' => 'form-control', 'placeholder' => 'Caketime club discount'])!!}--}}
                                            {{--<span class="input-group-addon">%</span>--}}
                                        {{--</div>--}}
                                        {{--<em class="error-msg">{!!$errors->first('cake_time_club_discount')!!}</em>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-3 form-group {{ $errors->has('cake_time_club_price') ? 'has-error' : '' }}">--}}
                                        {{--{!!Form::label("Caketime club price")!!}--}}
                                        {{--<div class="input-group">--}}
                                            {{--<span class="input-group-addon">$</span>--}}
                                            {{--{!!Form::text('cake_time_club_price', null, ['class' => 'form-control', 'placeholder' => 'Caketime club price', 'readonly'])!!}--}}
                                            {{-- <span class="input-group-addon">.00</span> --}}
                                        {{--</div>--}}
                                        {{--<em class="error-msg">{!!$errors->first('cake_time_club_price')!!}</em>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-3 form-group {{ $errors->has('trade_discount') ? 'has-error' : '' }}">--}}
                                        {{--{!!Form::label("Trade Discount *")!!}--}}
                                        {{--<div class="input-group">--}}
                                            {{--{!!Form::text('trade_discount', null, ['class' => 'form-control', 'placeholder' => 'Trade discount'])!!}--}}
                                            {{--<span class="input-group-addon">%</span>--}}
                                        {{--</div>--}}
                                        {{--<em class="error-msg">{!!$errors->first('trade_discount')!!}</em>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-3 form-group {{ $errors->has('trade_price') ? 'has-error' : '' }}">--}}
                                        {{--{!!Form::label("Trade Price")!!}--}}
                                        {{--<div class="input-group">--}}
                                            {{--<span class="input-group-addon">$</span>--}}
                                            {{--{!!Form::text('trade_price', null, ['class' => 'form-control', 'placeholder' => 'Trade Price', 'readonly'])!!}--}}
                                            {{-- <span class="input-group-addon">.00</span> --}}
                                        {{--</div>--}}
                                        {{--<em class="error-msg">{!!$errors->first('trade_price')!!}</em>--}}
                                    {{--</div>--}}
                                {{--</div>--}}


                              {{--   <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('weight_lbs') ? 'has-error' : '' }}">
                                        {!!Form::label("Weight (lbs)")!!}
                                        <div class="input-group">
                                            {!!Form::text('weight_lbs', null, ['class' => 'form-control', 'placeholder' => 'Weight in lbs)'])!!}
                                            <span class="input-group-addon">lbs</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('weight_lbs')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('height_inch') ? 'has-error' : '' }}">
                                        {!!Form::label("Height (Inches)")!!}
                                        <div class="input-group">
                                            {!!Form::text('height_inch', null, ['class' => 'form-control', 'placeholder' => 'Height'])!!}
                                            <span class="input-group-addon">In</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('height_inch')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('width_inch') ? 'has-error' : '' }}">
                                        {!!Form::label("Width (Inches)")!!}
                                        <div class="input-group">
                                            {!!Form::text('width_inch', null, ['class' => 'form-control', 'placeholder' => 'Width'])!!}
                                            <span class="input-group-addon">IN</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('width_inch')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('length_inch') ? 'has-error' : '' }}">
                                        {!!Form::label("Length (Inches)")!!}
                                        <div class="input-group">
                                            {!!Form::text('length_inch', null, ['class' => 'form-control', 'placeholder' => 'Length'])!!}
                                            <span class="input-group-addon">IN</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('length_inch')!!}</em>
                                    </div>
                                </div> --}}

                                {{-- <div class="row">
                                    <div class="col-sm-12 form-group {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Brand *")!!}
                                        {!!Form::select('brand_id', $brand, null, ['class' => 'form-control select2', 'placeholder' => 'Select Brand'])!!}
                                        <em class="error-msg">{!!$errors->first('brand_id')!!}</em>
                                    </div>
                                </div> --}}



                                <div class="row">
                                     <div class="col-sm-6 form-group {{ $errors->has('category_main_id') ? 'has-error' : '' }}">
                                         {!!Form::label("Category *")!!}
                                         {!! Form::select('category_main_id', $categories, $singleData->main_category_id, ['class'=>'form-control pro-cat-name select2', 'onchange'=>"select_category_menu('".url('/')."')", 'placeholder'=>'Select category']) !!}
                                         <em class="error-msg">{!!$errors->first('category_main_id')!!}</em>
                                     </div>
                                     <div class="col-sm-6 form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                         {!!Form::label("Sub Category *")!!}
                                         {!! Form::select('category_id', $categorySubs, $singleData->sub_category_id, ['class'=>'form-control pro-cat-sub-name pro-sub-cat-type-name select2', 'placeholder'=>'Select sub category', 'onchange'=>"select_sub_category_type_menu('".url('/')."')"]) !!}
                                         <em class="error-msg">{!!$errors->first('category_id')!!}</em>
                                     </div>
                                     {{-- <div class="col-sm-4 form-group {{ $errors->has('sub_category_type_id') ? 'has-error' : '' }}">
                                         {!!Form::label("Sub category type")!!}
                                         {!! Form::select('sub_category_type_id', $categoryTypes, null, ['class'=>'form-control pro-cat-type-name select2', 'placeholder'=>'Select a category type']) !!}
                                         <em class="error-msg">{!!$errors->first('sub_category_type_id')!!}</em>
                                     </div> --}}
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 form-group {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Brand *")!!}
                                        {!!Form::select('brand_id', $brand, null, ['class' => 'form-control select2', 'placeholder' => 'Select Brand'])!!}
                                        <em class="error-msg">{!!$errors->first('brand_id')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('model_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Model")!!}
                                        {!!Form::select('model_id', $model, null, ['class' => 'form-control select2', 'placeholder' => 'Select Model'])!!}
                                        <em class="error-msg">{!!$errors->first('model_id')!!}</em>
                                    </div>
                                   
                                    <div class="col-sm-4 form-group {{ $errors->has('color_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Colour")!!}
                                        {!!Form::select('color_id', $colors, null, ['class' => 'form-control select2', 'placeholder' => 'Select Product Colour'])!!}
                                        <em class="error-msg">{!!$errors->first('color_id')!!}</em>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- <div class="col-sm-4 form-group {{ $errors->has('measurement_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Measurement")!!}
                                        {!!Form::select('measurement_id', $sizeWithSymbol, null, ['id' => 'measurement-id','class' => 'form-control select2', 'placeholder' => 'Select measurement'])!!}
                                        <em class="error-msg">{!!$errors->first('measurement_id')!!}</em>
                                    </div> --}}
                                    
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('measurement_type_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Symbol")!!}
                                        {!!Form::select('measurement_type_id', $sizesMeasurement, null, ['class' => 'form-control', 'placeholder' => 'Measurement Symbol'])!!}
                                        <em class="error-msg">{!!$errors->first('measurement_type_id')!!}</em>
                                    </div> --}}

                                    {{--  <div class="col-sm-4 form-group {{ $errors->has('measurement') ? 'has-error' : '' }}">
                                        {!!Form::label("Size")!!}
                                        {!!Form::number('measurement', null, ['class' => 'form-control', 'placeholder' => 'Enter the product measurement', 'step' => '0.01', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('measurement')!!}</em>
                                    </div>  --}}

                                    {{-- <div class="col-sm-4 form-group {{ $errors->has('measurement') ? 'has-error' : '' }}">
                                        {!!Form::label("Size [Ex: 00.00 or 00x00]")!!}
                                        {!!Form::text('measurement', null, ['id' => 'measurement','class' => 'form-control', 'placeholder' => 'Enter the product measurement', 'step' => '0.01', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('measurement')!!}</em>
                                    </div> --}}
                                    
                                    
                                    <div class="col-sm-3 form-group {{ $errors->has('weight') ? 'has-error' : '' }}">
                                        {!!Form::label("weight")!!}
                                        <div class="input-group">
                                            {!!Form::number('weight', null, ['class' => 'form-control', 'placeholder' => 'weight'])!!}
                                            <span class="input-group-addon">lbs</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('weight')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('width') ? 'has-error' : '' }}">
                                        {!!Form::label("Width")!!}
                                        <div class="input-group">
                                            {!!Form::number('width', null, ['class' => 'form-control', 'placeholder' => 'width'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('width')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('length') ? 'has-error' : '' }}">
                                        {!!Form::label("length")!!}
                                        <div class="input-group">
                                            {!!Form::number('length', null, ['class' => 'form-control', 'placeholder' => 'length'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('length')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('height') ? 'has-error' : '' }}">
                                        {!!Form::label("height")!!}
                                        <div class="input-group">
                                            {!!Form::number('height', null, ['class' => 'form-control', 'placeholder' => 'height'])!!}
                                            <span class="input-group-addon">in</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('height')!!}</em>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('caliber') ? 'has-error' : '' }}">
                                        {!!Form::label("caliber")!!}
                                        {!!Form::text('caliber', null, ['class' => 'form-control', 'placeholder' => 'caliber'])!!}
                                        <em class="error-msg">{!!$errors->first('caliber')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('barrel_length') ? 'has-error' : '' }}">
                                        {!!Form::label("barrel_length")!!}
                                        {!!Form::text('barrel_length', null, ['class' => 'form-control', 'placeholder' => 'barrel_length'])!!}
                                        <em class="error-msg">{!!$errors->first('barrel_length')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('action') ? 'has-error' : '' }}">
                                        {!!Form::label("action")!!}
                                        {!!Form::text('action', null, ['class' => 'form-control', 'placeholder' => 'action'])!!}
                                        <em class="error-msg">{!!$errors->first('action')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('finish') ? 'has-error' : '' }}">
                                        {!!Form::label("finish")!!}
                                        {!!Form::text('finish', null, ['class' => 'form-control', 'placeholder' => 'finish'])!!}
                                        <em class="error-msg">{!!$errors->first('finish')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('grips') ? 'has-error' : '' }}">
                                        {!!Form::label("grips")!!}
                                        {!!Form::text('grips', null, ['class' => 'form-control', 'placeholder' => 'grips'])!!}
                                        <em class="error-msg">{!!$errors->first('grips')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('hand') ? 'has-error' : '' }}">
                                        {!!Form::label("hand")!!}
                                        {!!Form::text('hand', null, ['class' => 'form-control', 'placeholder' => 'hand'])!!}
                                        <em class="error-msg">{!!$errors->first('hand')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                        {!!Form::label("type")!!}
                                        {!!Form::text('type', null, ['class' => 'form-control', 'placeholder' => 'type'])!!}
                                        <em class="error-msg">{!!$errors->first('type')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('wt_characteristics') ? 'has-error' : '' }}">
                                        {!!Form::label("wt_characteristics")!!}
                                        {!!Form::text('wt_characteristics', null, ['class' => 'form-control', 'placeholder' => 'wt_characteristics'])!!}
                                        <em class="error-msg">{!!$errors->first('wt_characteristics')!!}</em>
                                    </div>
                                </div>



                                <div class="row">
                                    
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('model_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Model")!!}
                                        {!!Form::select('model_id', $model, null, ['class' => 'form-control', 'placeholder' => 'Select Model'])!!}
                                        <em class="error-msg">{!!$errors->first('model_id')!!}</em>
                                    </div> --}}



                                    {{-- <div id='calendar1' class="col-sm-3 form-group">
                                        {!!Form::label("Released Year")!!}
                                        <div class="input-group {{ $errors->has('year') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('year', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick Year', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('year')!!}</em>
                                    </div> --}}
                                    {{-- <div id='calendar1' class="col-sm-6 form-group">
                                        {!!Form::label("Offer End Date")!!}
                                        <div class="input-group {{ $errors->has('offer_ended_at') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('offer_ended_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick offer end date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('offer_ended_at')!!}</em>
                                    </div> --}}
                                  {{--   <div class="col-sm-6 form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                                        {!!Form::label("Warranty")!!}
                                        {!!Form::number('warranty', null, ['class' => 'form-control', 'placeholder' => 'Warranty period', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('warranty')!!}</em>
                                    </div> --}}
                                </div>

                                
                                <div class="row">
                                    {{-- <div id='calendar11' class="col-sm-3 form-group">
                                        {!!Form::label("Offer Start Date")!!}
                                        <div class="input-group {{ $errors->has('offer_started_at') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('offer_started_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick offer start date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('offer_started_at')!!}</em>
                                    </div> --}}
                                   {{--  <div id='calendar11' class="col-sm-3 form-group">
                                        {!!Form::label("Offer End Date")!!}
                                        <div class="input-group {{ $errors->has('offer_ended_at') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('offer_ended_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick offer end date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('offer_ended_at')!!}</em>
                                    </div> --}}
                                    {{-- <div id='calendar11' class="col-sm-3 form-group">
                                        {!!Form::label("Product Available Date")!!}
                                        <div class="input-group {{ $errors->has('available_at') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('available_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick available date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('available_at')!!}</em>
                                    </div> --}}
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                                        {!!Form::label("Warranty")!!}
                                        {!!Form::number('warranty', null, ['class' => 'form-control', 'placeholder' => 'Warranty period', 'min' => '0'])!!}
                                        <em class="error-msg">{!!$errors->first('warranty')!!}</em>
                                    </div> --}}
                                    {{-- <div class="col-sm-3 form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                                        {!!Form::label("Warranty")!!}
                                        {!!Form::text('warranty', null, ['class' => 'form-control', 'placeholder' => 'Warranty period'])!!}
                                        <em class="error-msg">{!!$errors->first('warranty')!!}</em>
                                    </div> --}}
                                </div>
                                

                              {{--   <div class="row">
                                    <div class="col-sm-3 form-group {{ $errors->has('material_type') ? 'has-error' : '' }}">
                                        {!!Form::label("Material Type")!!}
                                        {!!Form::text('material_type', null, ['class' => 'form-control', 'placeholder' => 'Enter material type'])!!}
                                        <em class="error-msg">{!!$errors->first('material_type')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('engine_type') ? 'has-error' : '' }}">
                                        {!!Form::label("Engine Type")!!}
                                        {!!Form::text('engine_type', null, ['class' => 'form-control', 'placeholder' => 'Enter engine type'])!!}
                                        <em class="error-msg">{!!$errors->first('engine_type')!!}</em>
                                    </div>
                                    <div class="col-sm-3 form-group {{ $errors->has('fuel_type') ? 'has-error' : '' }}">
                                        {!!Form::label("Fuel Type")!!}
                                        {!!Form::text('fuel_type', null, ['class' => 'form-control', 'placeholder' => 'Enter Fuel Type'])!!}
                                        <em class="error-msg">{!!$errors->first('fuel_type')!!}</em>
                                    </div>
                                    <div id='calendar1' class="col-sm-3 form-group">
                                        {!!Form::label("Offer End Date")!!}
                                        <div class="input-group {{ $errors->has('offer_ended_at') ? 'has-error' : '' }}">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            {!!Form::text('offer_ended_at', null, ['class' => 'datepicker form-control', 'placeholder' => 'Pick offer end date', 'data-inputmask' => 'alias:yyyy/mm/dd', 'data-mask'])!!}
                                        </div><em class="error-msg">{!!$errors->first('offer_ended_at')!!}</em>
                                    </div>
                                </div> --}}
                                
                                <!--
                                <div class="row">
                                    <div class="col-sm-4 form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                                        {!!Form::label("Color")!!}
                                        {!!Form::text('color', null, ['class' => 'form-control', 'placeholder' => 'Enter the color'])!!}
                                        <em class="error-msg">{!!$errors->first('color')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('interior_color') ? 'has-error' : '' }}">
                                        {!!Form::label("Interior Color")!!}
                                        {!!Form::text('interior_color', null, ['class' => 'form-control', 'placeholder' => 'Enter Interior Color'])!!}
                                        <em class="error-msg">{!!$errors->first('interior_color')!!}</em>
                                    </div>
                                    <div class="col-sm-4 form-group {{ $errors->has('exterior_color') ? 'has-error' : '' }}">
                                        {!!Form::label("Exterior Color")!!}
                                        {!!Form::text('exterior_color', null, ['class' => 'form-control', 'placeholder' => 'Enter Exterior Color'])!!}
                                        <em class="error-msg">{!!$errors->first('exterior_color')!!}</em>
                                    </div>
                                </div>
                                -->

                                <div class="row">
                                    {{-- <div class="form-group">
                                        <div class="form-line {{ $errors->has('resorts_id') ? 'error' : '' }}">
                                            {!!Form::label("Resort(s) *")!!}
                                            <select name="resorts_id[]" class="form-control" multiple data-live-search="true">
                                                @foreach($pluckStorsData as $row)
                                                    <option value="{{$row->id}}" @if($singleData->id && in_array($row->id, $singleData->resorts_id)) selected @endif>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <em class="help-info">{!!$errors->first('resorts_id')!!}</em>
                                    </div> --}}

                                    {{-- <div class="col-sm-6 form-group">
                                        {!!Form::label("Select Store(s) *")!!}
                                        <span class="pull-right"><a href="{{url('admin/stores')}}" target="_blank">Add Stores</a></span>
                                        <select name="stores[]" class="form-control select2" multiple="multiple" data-placeholder="Select stores">
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
                                        <span class="pull-right"><a href="{{url('admin/store-products')}}" target="_blank">Add Store Products</a></span>
                                    </div> --}}
                            
                                    {{-- <div class="col-sm-12 form-group">
                                        {!!Form::label("Select Store(s) *")!!}
                                        <span class="pull-right"><a href="{{url('admin/stores')}}" target="_blank">Add Stores</a></span>
                                        <select name="stores[]" id="example-getting-started" class="form-control" multiple="multiple">
                                            @foreach($storeCategoriesData as $row)
                                                <optgroup label=" DIVISION - {{ strtoupper($row->title) }} ">
                                                    @foreach ($row->storesData as $store)
                                                        <option value="{{ $store->store_id }}" @if($singleData->id && in_array($store->store_id, $singleData->stores) || (!$singleData->id && $store->store_id == 0)) selected @endif>
                                                            {{ $store->banner }} - {{ $store->store_id }}
                                                        </option>
                                                    @endforeach
                                                  </optgroup>
                                            @endforeach
                                        </select>
                                         <em class="error-msg">{!!$errors->first('stores')!!}</em>
                                    </div> --}}

                                    <div class="col-sm-12 form-group">
                                        {!!Form::label("Select Related Product(s)")!!}
                                        <select name="related_products[]" id="related_products" class="form-control" multiple="multiple">
                                            @foreach($relatedProducts as $row)
                                                <option value="{{ $row->id }}" @if($singleData->id && in_array($row->id, $singleData->related_products) || (!$singleData->id && $row->id == 0)) selected @endif>
                                                    {{ $row->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                         <em class="error-msg">{!!$errors->first('related_products')!!}</em>
                                    </div>

                                </div>

                                <div class="row">
                                    {{-- <div class="col-sm-12 form-group {{ $errors->has('store_category_id') ? 'has-error' : '' }}">
                                        {!!Form::label("Division *")!!}
                                        {!! Form::select('store_category_id', $storeCategoriesData, $singleData->id ? $singleData->category->mainCategory->id : null, ['class'=>'form-control select2', 'id' => 'store_category_id', 'onchange'=>"select_division('".url('/')."')", 'placeholder'=>'Select Store(s)']) !!}
                                        <em class="error-msg">{!!$errors->first('store_category_id')!!}</em>
                                    </div>

                                    <div class="col-sm-12 form-group {{ $errors->has('stores') ? 'has-error' : '' }}">
                                        {!!Form::label("Select Store(s) *")!!}
                                        {!! Form::select('stores[]', $pluckStorsData,  null , ['class'=>'form-control select2', 'id' => 'stores', 'multiple' => "multiple" ,'data-placeholder'=>'Select Store']) !!}
                                        <em class="error-msg">{!!$errors->first('stores')!!}</em>
                                    </div> --}}

                                     {{--   <div class="col-sm- form-group">
                                           {!!Form::label("Select Store(s) *")!!}
                                           <select name="stores[]" class="form-control select2" multiple="multiple" data-placeholder="Select stores" id="stores">
                                                <option value="{{ $row->store_id }}" @if($singleData->id && in_array($row->store_id, $singleData->stores)) selected @endif>{{ $row->city }}</option> 
                                           </select>
                                           <em class="error-msg">{!!$errors->first('stores')!!}</em>
                                       </div> --}}
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group {{ $errors->has('short_description') ? 'has-error' : '' }}">
                                        {!!Form::label("short_description/ Excerpt")!!}
                                        {!!Form::textarea('short_description', null, ['id' => 'page_', 'class' => 'form-control', 'placeholder' => 'Enter short_description', 'rows'=>2])!!}
                                        <em class="error-msg">{!!$errors->first('short_description')!!}</em>
                                    </div>
                                    <div class="col-sm-12 form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                        {!!Form::label("Description *")!!}
                                        {!!Form::textarea('content', null, ['id' => 'page', 'class' => 'form-control', 'placeholder' => 'Enter content', 'rows'=>10])!!}
                                        <em class="error-msg">{!!$errors->first('content')!!}</em>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box-body">
                                @if($singleData->id)
                                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                        {!!Form::label("Slug")!!}
                                        {!!Form::text('slug', null, array('class' => 'form-control', 'required', 'readonly'))!!}
                                        <em class="error-msg">{!!$errors->first('slug')!!}</em>
                                        <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
                                    </div>
                                @endif

                               {{--  <div class="form-group">
                                    {!!Form::label("Hide Price")!!} <br>
                                    <label class="switch" title="@if($singleData->is_price_display == 1) Enabled @else Disabled @endif">
                                        <input type="checkbox" name="is_price_display" value="1" @if($singleData->is_price_display == 1) checked @endif >
                                        <div class="slider round"></div>
                                    </label>
                                </div> --}}

                                {{-- <div class="form-group">
                                    {!! Form::label("is_firearm") !!}
                                    {!!Form::select('is_firearm', config('default.answerArray'), null, ['id'=>'is_firearm', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select is firearm'])!!}
                                    <em class="error-msg" id="is_firearm">{!!$errors->first('is_firearm')!!}</em>
                                </div>

                                <div class="form-group">
                                    {!! Form::label("disclaimer_agreement") !!}
                                    {!!Form::select('is_disclaimer_agreement_enabled', config('default.statusArray'), null, ['id'=>'is_disclaimer_agreement_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select disclaimer agreement'])!!}
                                    <em class="error-msg" id="is_disclaimer_agreement_enabled">{!!$errors->first('is_disclaimer_agreement_enabled')!!}</em>
                                </div>

                                <div class="form-group">
                                    {!! Form::label("Warning") !!}
                                    {!!Form::select('is_warning_enabled', config('default.statusArray'), null, ['id'=>'is_warning_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select is warning'])!!}
                                    <em class="error-msg" id="is_warning_enabled">{!!$errors->first('is_warning_enabled')!!}</em>
                                </div>

                                <div class="form-group">
                                    {!! Form::label("Retail Price Display") !!}
                                    {!!Form::select('is_retail_price_enabled', config('default.statusArray'), null, ['id'=>'is_retail_price_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select status'])!!}
                                    <em class="error-msg" id="is_retail_price_enabled">{!!$errors->first('is_retail_price_enabled')!!}</em>
                                </div>

                                <div class="form-group">
                                    {!! Form::label("Shopping Cart Display") !!}
                                    {!!Form::select('is_purchase_enabled', config('default.statusArray'), null, ['id'=>'is_purchase_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select status'])!!}
                                    <em class="error-msg" id="is_purchase_enabled">{!!$errors->first('is_purchase_enabled')!!}</em>
                                </div> --}}

                                {{-- <div class="form-group">
                                    {!!Form::label("Enable/ Disable Firearm")!!} <br>
                                    <label class="switch" title="@if($singleData->is_firearm == 1) Enabled @else Disabled @endif">
                                        <input type="checkbox" name="is_firearm" value="1" @if($singleData->is_firearm == 1) checked @endif >
                                        <div class="slider round"></div>
                                    </label>
                                </div> --}}

                                @if($singleData->id)
                                  {{-- <div class="form-group">
                                      {!!Form::label("Enable/ Disable Retail Price")!!} <br>
                                      <label class="switch" title="@if($singleData->is_retail_price_enabled == 1) Enabled @else Disabled @endif">
                                          <input type="checkbox" name="is_retail_price_enabled" value="1" @if($singleData->is_retail_price_enabled == 1) checked @endif >
                                          <div class="slider round"></div>
                                      </label>
                                  </div> --}}
                                  {{-- <div class="form-group">
                                      {!!Form::label("Enable/ Disable MSRP Sale Price")!!} <br>
                                      <label class="switch" title="@if($singleData->is_sale_price_display == 1) Enabled @else Disabled @endif">
                                          <input type="checkbox" name="is_sale_price_display" value="1" @if($singleData->is_sale_price_display == 1) checked @endif >
                                          <div class="slider round"></div>
                                      </label>
                                  </div> --}}
                                  {{-- <div class="form-group">
                                      <label for="" style="display: block">Enable/ Disable Shopping Cart</label>
                                      <label class="switch" title="@if($singleData->is_purchase_enabled == 1) Enabled @else Disabled @endif">
                                          <input type="checkbox" name="is_purchase_enabled" value="1" @if($singleData->is_purchase_enabled == 1) checked @endif >
                                          <div class="slider round"></div>
                                      </label>
                                  </div> --}}
                                @endif
                                
                                {{-- <div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
                                    {!!Form::label("External Sources")!!}
                                    {!! Form::url('source', null, ['class' => 'form-control', 'placeholder' => 'Source URL (YouTube, Vimeo, Facebook)']) !!}
                                    <em class="error-msg">{!!$errors->first('source')!!}</em>
                                    <small>Copy and past source URL from browser address bar.</small>
                                </div> --}}

                                <div class="form-group {{ $errors->has('youtube') ? 'has-error' : '' }}">
                                    {!!Form::label("YouTube")!!}
                                    {!! Form::url('youtube', null, ['class' => 'form-control', 'placeholder' => 'Enter the youtube url']) !!}
                                    <em class="error-msg">{!!$errors->first('youtube')!!}</em>
                                    <small>Right click on youtube video and click the "Copy Video URL Copy" link and paste it here.</small>
                                </div>

                                @if($singleData->youtube)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="item-remove"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/source-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <div class="video-play mx-auto">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe src="https://www.youtube.com/embed/{{$singleData->you_tube_video_id()}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>

                                                    {{-- <iframe width="748" height="421" src="https://www.youtube.com/embed/2HFSaxIsJCE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- @if($singleData->video_type == "youtube")
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="item-remove"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/source-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <div class="video-play mx-auto">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe src="https://www.youtube.com/embed/{{$singleData->video_code}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}

                              {{--   @if($singleData->video_type == "vimeo")
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="item-remove"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/source-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            <div class="video-play mx-auto">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe src="https://player.vimeo.com/video/{{$singleData->video_code}}?color=ffffff&title=0&byline=0&portrait=0" width="100%" frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}
                                <hr>

                                <div class="form-group {{ $errors->has('main_image') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Image [512 x 512]")!!}
                                    {!!Form::file('main_image', ['accept'=>'image/*'])!!}
                                    @if($singleData->main_image)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="item-remove" @if($singleData->main_image == "image-coming-soon.jpg") style="display: none; @endif">
                                                    <a href="{{url('admin/'.$module.'/'.$singleData->id.'/main-image-delete')}}"><i class="fa fa-close red-text"></i></a>
                                                </div>
                                                <img src="{{asset('storage/'.$module.'s/images/'.$singleData->main_image)}}" alt="Image" class="img-responsive">
                                            </div>
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('main_image')!!}</em>
                                </div>
                                <hr>

                                <div class="form-group {{ $errors->has('banner_image') ? 'has-error' : '' }}">
                                    {!!Form::label("Banner Image [1024px x 350]")!!}
                                    {!!Form::file('banner_image', ['accept'=>'image/*'])!!}
                                    @if($singleData->banner_image)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="item-remove" @if($singleData->banner_image == "image-coming-soon.jpg") style="display: none; @endif">
                                                    {{-- <a href="{{url('admin/'.$module.'/'.$singleData->id.'/main-image-delete')}}"><i class="fa fa-close red-text"></i></a> --}}
                                                </div>
                                                <img src="{{asset('storage/'.$module.'s/banner-images/'.$singleData->banner_image)}}" alt="Image" class="img-responsive">
                                            </div>
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('banner_image')!!}</em>
                                </div>
                                <hr>

                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Gallery [1024px x 1024px]")!!}
                                    {!!Form::file('photo[image][]', ['id' => 'inputPhotos', 'class'=>'file-input', 'multiple', 'accept'=>'image/*,.jpg,.gif,.png,.jpeg'])!!}
                                    @if($singleData->image)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="item-remove"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                                <img src="{{asset('storage/'.$module.'s/images/'.$singleData->image)}}" alt="Image" class="img-responsive">
                                            </div>
                                        </div>
                                    @endif
                                    @if($photos)
                                        <div class="R5">
                                            @foreach($photos as $row)
                                                <div class="col-xs-6 col-sm-3 P5">
                                                    <div class="photo-remove"><a href="{{url('admin/'.$module.'-photo/'.$row->id.'/delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                                    <div class="gallery-edit-thumb" style="background-image: url('{{asset('storage/'.$module.'s/photos/'.$row->product_id.'/'.$row->image)}}')"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('image')!!}</em>
                                    {{-- <small>Maximum 5 images are allowed</small> --}}
                                </div>
                                
                                </br>

                               {{--  <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    {!!Form::label("Feature Images [370 x 222px]")!!}
                                    {!!Form::file('photo[add_images][]', ['id' => 'inputPhotos', 'class'=>'file-input', 'multiple', 'accept'=>'image/*,.jpg,.gif,.png,.jpeg'])!!}
                                    @if($singleData->image)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="item-remove"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                                <img src="{{asset('storage/'.$module.'s/images/'.$singleData->image)}}" alt="Image" class="img-responsive">
                                            </div>
                                        </div>
                                    @endif
                                    @if($photos)
                                        <div class="R5">
                                            @foreach($photos as $row)
                                                <div class="col-xs-6 col-sm-3 P5">
                                                    <div class="photo-remove"><a href="{{url('admin/'.$module.'-photo/'.$row->id.'/delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                                    <div class="gallery-edit-thumb" style="background-image: url('{{asset('storage/'.$module.'s/photos/'.$row->product_id.'/'.$row->image)}}')"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <em class="error-msg">{!!$errors->first('add_images')!!}</em>
                                    <small>Maximum 5 images are allowed</small>
                                </div>
                                
                                </br> --}}
                                
                                {{-- <div class="form-group {{ $errors->has('image_view_type') ? 'has-error' : '' }}">
                                    @php $arr_image_view_type = ['0' => 'Light Box Effect', '1' => 'Zoom Effect'] @endphp
                                    {!!Form::label("Product image display type")!!}
                                    {!!Form::select('image_view_type', $arr_image_view_type, null, ['class' => 'form-control', 'placeholder' => 'Product image display type'])!!}
                                    <em class="error-msg">{!!$errors->first('image_view_type')!!}</em>
                                </div> --}}
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
                        <i class="fa fa-list"></i> <span>Display</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box-body">
                        <div class="row">
                            {{-- <div class="form-group col-md-3">
                                {!! Form::label("is_firearm") !!}
                                {!!Form::select('is_firearm', config('default.answerArray'), null, ['id'=>'is_firearm', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select is firearm'])!!}
                                <em class="error-msg" id="is_firearm">{!!$errors->first('is_firearm')!!}</em>
                            </div> --}}

                            <div class="form-group col-md-3">
                                {!! Form::label("disclaimer_agreement") !!}
                                {!!Form::select('is_disclaimer_agreement_enabled', config('default.statusArray'), null, ['id'=>'is_disclaimer_agreement_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select disclaimer agreement'])!!}
                                <em class="error-msg" id="is_disclaimer_agreement_enabled">{!!$errors->first('is_disclaimer_agreement_enabled')!!}</em>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::label("Warning") !!}
                                {!!Form::select('is_warning_enabled', config('default.statusArray'), null, ['id'=>'is_warning_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select is warning'])!!}
                                <em class="error-msg" id="is_warning_enabled">{!!$errors->first('is_warning_enabled')!!}</em>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::label("Retail Price Display") !!}
                                {!!Form::select('is_retail_price_enabled', config('default.statusArray'), null, ['id'=>'is_retail_price_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select status'])!!}
                                <em class="error-msg" id="is_retail_price_enabled">{!!$errors->first('is_retail_price_enabled')!!}</em>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::label("Shopping Cart Display") !!}
                                {!!Form::select('is_purchase_enabled', config('default.statusArray'), null, ['id'=>'is_purchase_enabled', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select status'])!!}
                                <em class="error-msg" id="is_purchase_enabled">{!!$errors->first('is_purchase_enabled')!!}</em>
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
                        <i class="fa fa-list"></i> <span>States</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box-body" id="states">
                        {{-- <div class="callout callout-warning">
                            <h4>I am a warning callout!</h4>
                            <p>Availablity based on RSR API. If you want to overwrite you can change it.</p>
                        </div> --}}
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