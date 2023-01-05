@if(request()->segment(1) == 'category' || request()->segment(1) == 'products' || request()->segment(1) == 'product-filter')
    {!!Form::open(['url'=>'product-filter'])!!}
    {{-- <div class="row"> --}}
        {{ csrf_field() }}
        {{--<div class="col-lg-3">--}}
            {{--<div class="form-group">--}}
                {{--<select name="year" id="year" class="form-control input-lg dynamic" data-dependent="make">--}}
                    {{--<option value="">Select Year...</option>--}}
                    {{--@foreach($years as $country)--}}
                        {{--<option value="{{$country->year}}">{{$country->year}}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-3">--}}
            {{--<div class="form-group">--}}
                {{--<select name="make" id="make" class="form-control input-lg dynamic" data-dependent="model">--}}
                    {{--<option value="">Select Make...</option>--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-3">--}}
            {{--<div class="form-group" style="margin-bottom: 0px !important;">--}}
                {{--<select name="model" id="model" class="form-control input-lg">--}}
                    {{--<option value="">Select Model...</option>--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-3">--}}
            {{--<input class="submit" id="submit" type="submit" value="GO" class="submit btn btn-lg btn-primary">--}}
        {{--</div>--}}
            <div class="form-row" id="guypaul-filter">
                <div class="form-group col-md-2">
                    {{-- <label for="inputCity" class="col-form-label">City</label> --}}
                    <select id="filter-sub-category" class="form-control" name="filter_sub_category">
                        {{-- @if(session('sessionFilterBrandId'))
                            <option value="{{session('sessionFilterBrandId')}}">{{session('sessionFilterBrandName')}}</option>
                        @endif --}}
                        {{-- <option value="" disabled="">Select Category</option> --}}
                        <option value="">- Sub Category -</option>
                        @foreach($filtersubCategoryData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFiltersubCategoryData') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    {{-- <label for="inputCity" class="col-form-label">City</label> --}}
                    <select id="filter-brand" class="form-control" name="brand_id">
                        {{-- @if(session('sessionFilterBrandId'))
                            <option value="{{session('sessionFilterBrandId')}}">{{session('sessionFilterBrandName')}}</option>
                        @endif --}}
                        {{-- <option value="" disabled="">Select Brand</option> --}}
                        <option value="">- Brand -</option>
                        @foreach($filterBrandData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterBrandId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    {{-- <label for="inputZip" class="col-form-label">Zip</label> --}}
                    {{-- <input type="text" class="form-control" id="inputZip"> --}}
                    <select id="filter-type" class="form-control" name="sub_category_type_id">
                      {{--   @if(session('sessionFilterSubCategoryTypeId'))
                            <option value="{{session('sessionFilterSubCategoryTypeId')}}">{{session('sessionFilterSubCategoryTypeName')}}</option>
                        @endif --}}
                        <option value="">- Type -</option>
                        @foreach($filterSubCategoryTypeData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterSubCategoryTypeId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    {{-- <label for="inputState" class="col-form-label">State</label> --}}
                    <select id="filter-size" class="form-control" name="size_id">
                        {{-- @if(session('sessionFilterSizeId'))
                            <option value="{{session('sessionFilterSizeId')}}">{{session('sessionFilterSizeName')}}</option>
                        @endif --}}
                        <option value=""> - Size -</option>
                        @foreach($filterSizeData as $row)
                            <option value="{{$row->id}}"  @if(session('sessionFilterSizeId') == $row->id)selected @endif>
                                {{$row->measurement}} - @if($row->sizeData) {{ $row->sizeData->measurement_type }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    {{-- <label for="inputZip" class="col-form-label">Zip</label> --}}
                    {{-- <input type="text" class="form-control" id="inputZip"> --}}
                    <select id="filter-color" class="form-control" name="color_id">
                        {{-- @if(session('sessionFilterColorId'))
                            <option value="{{session('sessionFilterColorId')}}">{{session('sessionFilterColorName')}}</option>
                        @endif --}}
                        <option value="">- Color -</option>
                        @foreach($filterColorData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterColorId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-outline-primary cursor-pointer btn-block">Find  <span id="ajax-loader"><i class="fa fa-spinner fa-1x fa-spin"></i></span></button>
                </div>
            </div>
    {{-- </div> --}}
    {!!Form::close()!!}
@endif





@if(request()->segment(1) == 'brand' || request()->segment(1) == 'brand-filter')
    {!!Form::open(['url'=>'brand-filter'])!!}
        {{ csrf_field() }}
            <div class="form-row" id="guypaul-filter">
                <div class="form-group col-md-2">
                    <select id="filter-brand" class="form-control" name="brand_id">
                        <option value="">- Brand -</option>
                        @foreach($filterBrandData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterBrandId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter-sub-category" class="form-control" name="filter_sub_category">
                        <option value="">- Sub Category -</option>
                        @foreach($filtersubCategoryData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFiltersubCategoryData') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter-type" class="form-control" name="sub_category_type_id">
                        <option value="">- Type -</option>
                        @foreach($filterSubCategoryTypeData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterSubCategoryTypeId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter-size" class="form-control" name="size_id">
                        <option value=""> - Size -</option>
                        @foreach($filterSizeData as $row)
                            <option value="{{$row->id}}"  @if(session('sessionFilterSizeId') == $row->id)selected @endif>
                                {{$row->measurement}} - @if($row->sizeData) {{ $row->sizeData->measurement_type }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter-color" class="form-control" name="color_id">
                        <option value="">- Color -</option>
                        @foreach($filterColorData as $row)
                            <option value="{{$row->id}}" @if(session('sessionFilterColorId') == $row->id)selected @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-outline-primary cursor-pointer btn-block" name="button_brand_filter">Find  <span id="ajax-loader"><i class="fa fa-spinner fa-1x fa-spin"></i></span></button>
                </div>
            </div>
    {!!Form::close()!!}
@endif