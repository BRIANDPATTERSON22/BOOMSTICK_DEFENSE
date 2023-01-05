@extends('admin.layouts.app')

@section('htmlheader_title')
    RSR Products
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) of the Year {{-- {{$year}} --}} @endif </span>
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

@section('page-style')
    <style>
        .is_firearm{border-left: 10px solid red !important;}
    </style>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">

                <div class="box-body">
                    <div class="row">
                        {!!Form::open(['method'=>'get'])!!}  
                            <div class="col-md-9 form-group">
                                {!!Form::label("Search")!!}
                                <input type="text" class="form-control" placeholder="Search products..." aria-label="Search products" name="search" value="{{ request()->search }}">
                            </div>
                            <div class="col-md-3">
                                {!!Form::label(" .")!!}
                                <br>
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check-circle-o"></i> Search </button>
                            </div>
                        {!!Form::close()!!}
                    </div>
                    <hr>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTableProducts" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                {{-- <th>Manufacture</th> --}}
                                <th>Qty.</th>
                                <th>Rsr Pricing</th>
                                <th>Retail Price</th>
                                <th>Retail Price (Category)</th>
                                {{-- <th>Discounted Price</th> --}}
                                @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                                <th style="white-space: nowrap;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr class="@if($row->status==0) disabledBg @endif @if($row->blocked_from_dropship == "Y") bg-success @endif">
                                    <td>{{$count}}</td>
                                    <td>
                                        <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">
                                          {{-- @if($row->main_image)
                                              <img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" alt="{!!$row->product_description!!}"  height="40px">
                                          @else
                                               <img class="card-img-top img-fluid" src="{{asset('site/defaults/product_placeholder.png')}}" alt="{!!$row->product_description!!}"  height="40px">
                                          @endif --}}

                                          @if($row->image_name)
                                            @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                               <img class="card-img-top img-fluid" src="{{asset($row->get_hr_image_by_category())}}"  height="40px">
                                            @else
                                              <img class="card-img-top img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}"  height="40px">
                                            @endif
                                          @else
                                               <img class="card-img-top img-fluid" src="{{asset('site/defaults/image-not-found.png')}}"  height="40px">
                                          @endif
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <strong><a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}">{!!$row->name!!}</a></strong>  --}}
                                        <strong>{!!$row->product_description!!}</strong> <br/>
                                        @if ($row->upc_code)
                                            <u>UPC : {{ $row->upc_code }}</u> <br>
                                        @endif
                                       {{--  @if($row->category_id)
                                            <small style="white-space: nowrap;">{{$row->category->mainCategory->name}} / {{$row->category->name}}</small>
                                        @endif<br> --}}
                                        {{-- @if($row->is_featured == 1)
                                            <span class="label label-primary">Featured Product</span>
                                        @endif --}}

                                        @if($row->manufacturer_id)
                                            {{$row->manufacturer_id}}
                                        @endif

                                        @if($row->full_manufacturer_name)
                                            / {{$row->full_manufacturer_name}}
                                        @endif
                                    </td>

                                    <td> {{$row->rsr_category ? $row->rsr_category->department_name : "---"}} </td>

                                    {{-- <td>
                                        @if($row->manufacturer_id)
                                            {{$row->manufacturer_id}}
                                        @endif

                                        @if($row->full_manufacturer_name)
                                            / {{$row->full_manufacturer_name}}
                                        @endif
                                    </td> --}}
                                   
                                    {{-- <td>{!!date('Y', strtotime($row->year))!!}</td> --}}
                                    <td class="text-left">{{$row->inventory_quantity}}</td>
                                  {{--   <td class="text-left">
                                        @if($row->special_price) <strike>{{number_format($row->price,2)}}</strike> <br/> {{number_format($row->special_price, 2)}} @else {{number_format($row->price,2)}} @endif
                                        {{$option->currency_symbol}}{{number_format($row->price,2)}}
                                    </td> --}}

                                    <td class="text-left">
                                        {{$option->currency_symbol}}{{number_format($row->rsr_pricing,2)}}
                                    </td>
                                    <td class="text-left">
                                        {{$option->currency_symbol}}{{number_format($row->retail_price,2)}}
                                    </td>
                                    <td class="text-left">
                                        {{$option->currency_symbol}}{{number_format($row->get_rsr_retail_price
                                            (),2)}}
                                    </td>
                                    {{-- <td>{{$option->currency_symbol}}{{ $row->dicounted_price }} <br> <span class="label label-warning">{{ $row->discount_percentage }}% Off</span> </td> --}}
                                    {{-- <td>{{$option->currency_symbol}}{{ number_format($row->price - (($option->cake_time_club_gold_discount_percentage / 100) * $row->price),2)}}</td> --}}
                                    {{-- td>{{$option->currency_symbol}}{{ number_format($row->price - (($option->cake_time_club_gold_discount_percentage / 100) * $row->price),2)}}</td> --}}
                                    {{-- <td>{{$option->currency_symbol}}{{ number_format($row->price - (($option->cake_time_club_platinum_discount_percentage / 100) * $row->price),2) }}</td> --}}
                                    {{-- <td>{{$option->currency_symbol}}{{ number_format($row->price - (($option->trade_discount_percentage / 100) * $row->price),2) }}</td> --}}
                                   {{--  @if(Request::is('*trash'))
                                        <td>{!!$row->deleted_at->format('d M, Y')!!}</td>
                                    @else
                                        <td><a href="{{ url('product/'.$row->slug) }}" target="_blank">{!!$row->created_at->format('d M, Y')!!} </a></td>
                                    @endif --}}
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
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i>  </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i>  </a>
                                            {{-- <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a> --}}
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