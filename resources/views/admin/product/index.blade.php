@extends('admin.layouts.app')

@section('htmlheader_title')
    Products
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) of the Year {{$year}} @endif </span>
@endsection

@section('contentheader_description')
    Manage products of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
            <li class="text-capitalize active">Deleted {{$module}}(s)</li>
        @else
            <li class="text-capitalize active">{{$module}}(s)</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {{-- <div class="box-body">
                    {!!Form::open(['url'=>'admin/filter', 'class'=>'', 'autocomplete' => 'off'])!!}  
                    {!!csrf_field()!!}
                        <div class="row">
                            <div class="col-sm-3 form-group {{ $errors->has('category_main_id') ? 'has-error' : '' }}">
                                {!!Form::label("Category")!!}
                                {!! Form::select('category_main_id', $categories, old('category_main_id'), ['class'=>'form-control pro-cat-name select2', 'onchange'=>"select_category_menu('".url('/')."')", 'placeholder'=>'Select category']) !!}
                                <em class="error-msg">{!!$errors->first('category_main_id')!!}</em>
                            </div>
                            <div class="col-sm-3 form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                {!!Form::label("Sub Category")!!}
                                {!! Form::select('category_id', $categorySubs, null, ['class'=>'form-control pro-cat-sub-name pro-sub-cat-type-name select2', 'placeholder'=>'Select sub category', 'onchange'=>"select_sub_category_type_menu('".url('/')."')"]) !!}
                                <em class="error-msg">{!!$errors->first('category_id')!!}</em>
                            </div>
                            <div class="col-sm-3 form-group {{ $errors->has('sub_category_type_id') ? 'has-error' : '' }}">
                                {!!Form::label("Sub category type")!!}
                                {!! Form::select('sub_category_type_id', $categoryTypes, null, ['class'=>'form-control pro-cat-type-name select2', 'placeholder'=>'Select a category type']) !!}
                                <em class="error-msg">{!!$errors->first('sub_category_type_id')!!}</em>
                            </div>
                            <div class="col-sm-3 form-group">
                                {!!Form::label(" .")!!}
                                <br>
                                <button type="submit" name="products_categorry_search" class="btn btn-success btn-block"><i class="fa fa-check-circle-o"></i> Search By Category</button>
                            </div>
                        </div> <hr>
                    {!!Form::close()!!}
                </div> --}}

                <div class="box-body">
                        <div class="row">
                            {!!Form::open(['url'=>'admin/products/brand', 'class'=>'', 'autocomplete' => 'off'])!!} 
                            {!!csrf_field()!!}
                                <div class="col-sm-4 form-group">
                                    {!!Form::label("Brand")!!}
                                    {!!Form::select('brand_id', $brand, session('filterBrand') ? session('filterBrand') : null, ['class' => 'form-control select2', 'placeholder' => 'Select Brand'])!!}
                                    <em class="error-msg">{!!$errors->first('brand_id')!!}</em>
                                </div>
                                <div class="col-sm-2 form-group">
                                    {!!Form::label(" .")!!}
                                    <br>
                                    <button type="submit" name="products_brands" class="btn btn-success btn-block"><i class="fa fa-check-circle-o"></i> Search By Brand</button>
                                </div>
                           {!!Form::close()!!}

                            {!!Form::open(['url'=>'admin/products/search-by-word', 'class'=>''])!!}  
                                <div class="col-md-4 form-group">
                                    {!!Form::label("Search all products")!!}
                                      <input class="form-control" placeholder="Search products & brands" aria-label="Search products" type="search" name="searchText" value="{{ session('searchText') ? session('searchText') : null}}">
                                </div>
                                <div class="col-md-2">
                                    {!!Form::label(" .")!!}
                                    <br>
                                    <button type="submit" name="search-by-word" class="btn btn-success btn-block"><i class="fa fa-check-circle-o"></i> Search </button>
                                </div>
                            {!!Form::close()!!}
                        </div>
                        <hr>
             
                </div>
                
{{--                 @if (session('searchBrandName') || session('searchText') || session('searchBrandName'))
                    <div class="box-body">
                        <div class="alert alert-success">
                            @if (session('searchBrandName'))
                                <h5>
                                    <i class="icon fa fa-search-plus"></i> Search result for Brand <strong>" {{ session('searchBrandName') }} "</strong>
                                </h5>
                            @endif
                            @if (session('searchText'))
                                <h5>
                                    <i class="icon fa fa-search-plus"></i> Search result for product <strong>" {{ session('searchText') }} "</strong>
                                </h5>
                            @endif
                        </div>
                    </div>
                @endif --}}

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTableProducts" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category/ Sub Category</th>
                                <th>Brand/ Model</th>
                                <th>Qty.</th>
                                <th>Retail Price</th>
                                {{-- <th>MSRP Sale Price</th> --}}
                                <th>Discounted Price</th>
                                @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                                <th style="white-space: nowrap;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr class="@if($row->status==0) disabledBg @endif">
                                    <td>{{$count}}</td>
                                    <td>
                                        {{-- @if($row->main_image != 'image-coming-soon.jpg')
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">
                                                <img src="{{asset('storage/products/images/'.$row->main_image)}}" height="50px">
                                            </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">
                                                <img src="{{asset('site/images/defaults/no-image-word.png')}}" height="50px">
                                            </a>
                                        @endif --}}

                                        <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">
                                          @if($row->main_image)
                                              <img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" alt="{!!$row->title!!}"  height="40px">
                                          @else
                                               <img class="card-img-top img-fluid" src="{{asset('site/defaults/product_placeholder.png')}}" alt="{!!$row->title!!}"  height="40px">
                                          @endif
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <strong><a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">{!!$row->name!!}</a></strong>  --}}
                                        <strong>{!!$row->title!!}</strong> <br/>
                                        @if ($row->upc)
                                            <u>UPC : {{ $row->upc }}</u> <br>
                                        @endif
                                       {{--  @if($row->category_id)
                                            <small style="white-space: nowrap;">{{$row->category->mainCategory->name}} / {{$row->category->name}}</small>
                                        @endif<br> --}}
                                        @if($row->is_featured == 1)
                                            <span class="label label-primary">Featured Product</span>
                                        @endif
                                    </td>

                                    <td>
                                        <small class="text-nowrap_">
                                           
                                                {{ $row->rel_main_category ? $row->rel_main_category->name : "---" }} / {{ $row->sub_category ? $row->sub_category->name : "---" }}
                                            
                                        </small>
                                    </td>

                                    <td>
                                        @if($row->brand)
                                            {{$row->brand->name}}
                                        @endif

                                        @if($row->model)
                                            / {{$row->model->name}}
                                        @endif
                                    </td>

                                    <td class="text-left">{{ number_format($row->quantity, 0) }}</td>

                                    <td class="text-left">
                                        <strong>{{$option->currency_symbol}}{{number_format($row->retail_price,2)}}</strong>
                                    </td>

                                    <td>
                                        @if($row->discount_percentage)
                                            <strong>{{$option->currency_symbol}}{{ $row->dicounted_price }} </strong>
                                            <small class="clearfix">{{ $row->discount_percentage }}% Off</small> 
                                        @else
                                            ---
                                        @endif
                                    </td>

                                    <td>
                                        <div class="clear-fix">
                                            @if($row->user_id) By {!!$row->user->name!!} @endif
                                        </div>
                                        @if(Request::is('*trash'))
                                            <small> {{ $row->deleted_at->format('d M, Y') }} </small>
                                        @else
                                            <small>{{ $row->created_at->format('d M, Y') }}</small>
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @if(Request::is('*trash'))
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($allData)
                        {{ $allData->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection