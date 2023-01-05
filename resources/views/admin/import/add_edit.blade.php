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
    </style>
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
                                <div class="col-sm-3 form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                                    {!!Form::label("MSRP Sale Price *")!!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                        {!!Form::text('sale_price', null, ['class' => 'form-control', 'placeholder' => 'MSRP Sale Price'])!!}
                                        {{-- <span class="input-group-addon">.00</span> --}}
                                    </div>
                                    <em class="error-msg">{!!$errors->first('sale_price')!!}</em>
                                </div>

                                <div class="col-sm-3 form-group {{ $errors->has('discount_percentage') ? 'has-error' : '' }}">
                                    {!!Form::label("Discount")!!}
                                    <div class="input-group">
                                        {{-- <span class="input-group-addon">$</span> --}}
                                        {!!Form::number('discount_percentage', null, ['class' => 'form-control', 'placeholder' => 'Discount Percentage'])!!}
                                        <span class="input-group-addon">%</span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('discount_percentage')!!}</em>
                                </div>

                                <div class="col-sm-3 form-group {{ $errors->has('dicounted_price') ? 'has-error' : '' }}">
                                    {!!Form::label("Discounted Price")!!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                        {!!Form::text('dicounted_price', null, ['class' => 'form-control', 'placeholder' => 'Discount price', 'readonly'])!!}
                                    </div>
                                    <em class="error-msg">{!!$errors->first('dicounted_price')!!}</em>
                                </div>

                                <div class="col-sm-3 form-group {{ $errors->has('retail_price') ? 'has-error' : '' }}">
                                    {!!Form::label("Wholesales price *")!!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $option->currency_symbol }}</span>
                                        {!!Form::text('retail_price', null, ['class' => 'form-control', 'placeholder' => 'Retail Price'])!!}
                                        {{-- <span class="input-group-addon">.00</span> --}}
                                    </div>
                                    <em class="error-msg">{!!$errors->first('retail_price')!!}</em>
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
                                     {!! Form::select('category_main_id', $categories, $singleData->category ? $singleData->category->mainCategory->id : null, ['class'=>'form-control pro-cat-name select2', 'onchange'=>"select_category_menu('".url('/')."')", 'placeholder'=>'Select category']) !!}
                                     <em class="error-msg">{!!$errors->first('category_main_id')!!}</em>
                                 </div>
                                 <div class="col-sm-6 form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                     {!!Form::label("Sub Category *")!!}
                                     {!! Form::select('category_id', $categorySubs, null, ['class'=>'form-control pro-cat-sub-name pro-sub-cat-type-name select2', 'placeholder'=>'Select sub category', 'onchange'=>"select_sub_category_type_menu('".url('/')."')"]) !!}
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
                                        {!!Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'weight'])!!}
                                        <span class="input-group-addon">lbs</span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('weight')!!}</em>
                                </div>
                                <div class="col-sm-3 form-group {{ $errors->has('width') ? 'has-error' : '' }}">
                                    {!!Form::label("Width")!!}
                                    <div class="input-group">
                                        {!!Form::text('width', null, ['class' => 'form-control', 'placeholder' => 'width'])!!}
                                        <span class="input-group-addon">in</span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('width')!!}</em>
                                </div>
                                <div class="col-sm-3 form-group {{ $errors->has('length') ? 'has-error' : '' }}">
                                    {!!Form::label("length")!!}
                                    <div class="input-group">
                                        {!!Form::text('length', null, ['class' => 'form-control', 'placeholder' => 'length'])!!}
                                        <span class="input-group-addon">in</span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('length')!!}</em>
                                </div>
                                <div class="col-sm-3 form-group {{ $errors->has('height') ? 'has-error' : '' }}">
                                    {!!Form::label("height")!!}
                                    <div class="input-group">
                                        {!!Form::text('height', null, ['class' => 'form-control', 'placeholder' => 'height'])!!}
                                        <span class="input-group-addon">in</span>
                                    </div>
                                    <em class="error-msg">{!!$errors->first('height')!!}</em>
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
                                <div class="col-sm-3 form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                                    {!!Form::label("Warranty")!!}
                                    {!!Form::text('warranty', null, ['class' => 'form-control', 'placeholder' => 'Warranty period'])!!}
                                    <em class="error-msg">{!!$errors->first('warranty')!!}</em>
                                </div>
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
                                    {!!Form::text('slug', null, array('class' => 'form-control', 'required'))!!}
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

                            @if($singleData->id)
                              <div class="form-group">
                                  {!!Form::label("Enable/ Disable Retail Price")!!} <br>
                                  <label class="switch" title="@if($singleData->is_retail_price_display == 1) Enabled @else Disabled @endif">
                                      <input type="checkbox" name="is_retail_price_display" value="1" @if($singleData->is_retail_price_display == 1) checked @endif >
                                      <div class="slider round"></div>
                                  </label>
                              </div>
                              <div class="form-group">
                                  {!!Form::label("Enable/ Disable MSRP Sale Price")!!} <br>
                                  <label class="switch" title="@if($singleData->is_sale_price_display == 1) Enabled @else Disabled @endif">
                                      <input type="checkbox" name="is_sale_price_display" value="1" @if($singleData->is_sale_price_display == 1) checked @endif >
                                      <div class="slider round"></div>
                                  </label>
                              </div>
                              <div class="form-group">
                                  <label for="" style="display: block">Enable/ Disable Shopping Cart</label>
                                  <label class="switch" title="@if($singleData->is_purchase_enabled == 1) Enabled @else Disabled @endif">
                                      <input type="checkbox" name="is_purchase_enabled" value="1" @if($singleData->is_purchase_enabled == 1) checked @endif >
                                      <div class="slider round"></div>
                                  </label>
                              </div>
                            @endif
                            
                            <div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
                                {!!Form::label("External Sources")!!}
                                {!! Form::url('source', null, ['class' => 'form-control', 'placeholder' => 'Source URL (YouTube, Vimeo, Facebook)']) !!}
                                <em class="error-msg">{!!$errors->first('source')!!}</em>
                                <small>Copy and past source URL from browser address bar.</small>
                            </div>
                            @if($singleData->video_type == "youtube")
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
                            @endif
                            @if($singleData->video_type == "vimeo")
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
                            @endif
                            <hr>

                            <div class="form-group {{ $errors->has('main_image') ? 'has-error' : '' }}">
                                {!!Form::label("Product Image [400 x 400px]")!!}
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
            {!!Form::close()!!}
        </div>
    </div>
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