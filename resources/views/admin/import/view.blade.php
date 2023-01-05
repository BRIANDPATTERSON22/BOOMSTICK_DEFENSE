@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->name}} | Products
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}} </span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
                <div class="box-header">
                    <h3 class="box-title">{{$singleData->name}}</h3>
                    @if($singleData->quantity == 0) <span class="label label-danger">Out of Stock</span>@endif
                    @if($singleData->special_price) <span class="label label-success">Sale</span>@endif
                    @if($singleData->is_featured == 1) <span class="label label-info">Featured</span>@endif

                    <small class="pull-right">
                        <a class="btn btn-default" href="{{url('admin/'.$module.'/'.$singleData->id.'/featured')}}"><i class="fa fa-map-pin"></i> Featured</a>
                        <a class="btn btn-primary" href="{{url($module.'/'.$singleData->slug)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a>
                    </small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($singleData->main_image)
                                <img src="{{asset('storage/'.$module.'s/images/'.$singleData->main_image)}}" alt="{{$singleData->image}}" class="img-thumbnail">
                            @endif
                            @if($singleData->video_type == "youtube")
                                <div class="video-play mx-auto">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe src="https://www.youtube.com/embed/{{$singleData->video_code}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                                    </div>
                                </div><br/>
                            @endif
                            @if($singleData->video_type == "vimeo")
                                <div class="video-play mx-auto">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe src="https://player.vimeo.com/video/{{$singleData->video_code}}?color=ffffff&title=0&byline=0&portrait=0" width="100%" frameborder="0"></iframe>
                                    </div>
                                </div><br/>
                            @endif
                            @if($singleData->video_type == "smule")
                                <div class="video-play mx-auto">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe frameborder="0" width="100%" src="https://www.smule.com/recording/bette-midler-in-my-life/{{$singleData->video_code}}/frame"></iframe>
                                    </div>
                                </div><br/>
                            @elseif($singleData->video_type == "facebook")
                                <div class="fb-video" data-href="{{$singleData->video_code}}" data-width="500" data-allowfullscreen="true"></div>
                                <br/>
                            @endif
                            @if($singleData->video_type == "soundcloud")
                                <div class="video-play mx-auto">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{{$singleData->code}}&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true"></iframe>
                                    </div>
                                </div><br/>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="R5">
                                @foreach($photos as $row)
                                    <div class="col-xs-6 col-sm-4 P5">
                                        <div class="gallery-thumb" style="background-image: url('{{asset('storage/'.$module.'s/photos/'.$row->product_id.'/'.$row->image)}}')"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td> <strong>{{ $singleData->title }}</strong> <br> </td>
                        </tr>
                        <tr>
                            <th>UPC</th>
                            <td>{{$singleData->upc}}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td> @if($singleData->brand_id) {{$singleData->brand->name}} @endif </td>
                        </tr>

                        <tr>
                            <th>Model</th>
                            <td> @if($singleData->model_id) {{$singleData->model->name}} @else --- @endif </td>
                        </tr>

                       {{--  <tr>
                            <th style="white-space: nowrap;">Category/ Sub Category</th>
                            <td> @if($singleData->category_id) {{$singleData->category->mainCategory->name}}/ {{$singleData->category->name}}  @endif </td>
                        </tr> --}}
                      {{--   <tr>
                            <th>Price ($)</th>
                            <td> @if($singleData->special_price)  <strike>{{$singleData->price}}</strike> / @else {{$singleData->price}} @endif {{$singleData->special_price}}</td>
                            <td> <span class="badge bg-blue">{{$option->currency_symbol .' '. $singleData->price ?? '--' }}</span></td>
                        </tr> --}}
                        <tr>
                            <th>Retail Price ($)</th>
                            <td> <span class="badge bg-blue">{{$option->currency_symbol .' '. $singleData->retail_price ?? '--' }}</span></td>
                        </tr>

                        <tr>
                            <th>MSRP Sale Price ($)</th>
                            <td> <span class="badge bg-blue">{{$option->currency_symbol .' '. $singleData->sale_price ?? '--' }}</span></td>
                        </tr>
                        <tr>
                            <th>Discount Percentage</th>
                             <td> <span class="badge bg-orange">{{ $singleData->discount_percentage ?? '--' }}%</span></td>
                        </tr>
                        <tr>
                            <th>Discounted Price ($)</th>
                            <td> <span class="badge bg-teal">{{$option->currency_symbol .' '. $singleData->dicounted_price ?? '--' }}</span></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td> <span class="badge bg-black">{{$singleData->quantity}}</span></td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td>{{ $singleData->weight ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th>Length</th>
                            <td>{{ $singleData->length ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th>Width</th>
                            <td>{{ $singleData->width ?? '--' }}</td>
                        </tr>
                        <tr>
                            <th>Height</th>
                            <td>{{ $singleData->height ?? '--' }}</td>
                        </tr>
                        <tr>
                            <th>Colour</th>
                            <td>{{ $singleData->color_id ? $singleData->colorData->name  : '--'}}</td>
                        </tr>
                        <tr>
                            <th>Warranty</th>
                            <td>{{ $singleData->warranty ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th>Short Description</th>
                            <td>{{$singleData->short_description}}</td>
                        </tr>
                        <tr>
                            <th>Content</th>
                            <td class="text-justify">{!! $singleData->content !!}</td>
                        </tr>
                        <tr>
                            <th>Offer Started/Ended At</th>
                            <td> Offer starts at <u>{{$singleData->offer_started_at}}</u> and ends at <u>{{$singleData->offer_ended_at}}</u></td>
                        </tr>
                        <tr>
                            <th>Product Purchasing/ Shopping Cart</th>
                            <td>
                                @if($singleData->is_purchase_enabled == 0)
                                    <span class="badge bg-red">Disabled</span>
                                @else
                                    <span class="badge bg-green">Enabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($singleData->status == 0)
                                    <span class="badge bg-red">Disabled</span>
                                @else
                                    <span class="badge bg-green">Enabled</span>
                                @endif
                            </td>
                        </tr>


                        {{-- @foreach($singleDataColumns as $row)
                            <tr>
                                <th>{{ str_replace('_', ' ', ucwords($row)) }}</th>
                                @if($row == 'content')
                                    <td><span class="badge_ bg-grey text-justify">{!! $singleData->$row !!}</span></td>
                                @elseif($row == 'image')
                                    <td>
                                        @if($singleData->main_image)
                                            <img src="{{url('storage/'. $module. 's/images/' . $singleData->main_image)}}" width="100" height="100" alt="Image" class="img-circle">
                                        @else
                                            <img src="{{asset('admin/images/default.png')}}" width="100" alt="Image" class="img-circle">
                                        @endif
                                    </td>
                                @elseif($row == 'status')
                                    <td>
                                        @if($singleData->status == 0)
                                            <span class="badge bg-red">Disabled</span>
                                        @else
                                            <span class="badge bg-green">Enabled</span>
                                        @endif
                                    </td>
                                @else
                                    <td><span class="badge bg-grey">{{ $singleData->$row }}</span></td>
                                @endif
                            </tr>
                        @endforeach --}}
                    </table>
                </div>
                
                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} by {{$singleData->user->name}}</em>
                </div>
            </div>
        </div>
    </div>


    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">STORES <strong> ({{ count($storesData) }})</strong> </a></li>
        </ul>
        <div class="tab-content">
           {{--  <div class="tab-pane active" id="tab_1">
                {!! Form::open(['files' => true, 'url' => 'admin/'.$singleData->id.'/price/add', 'autocomplete'=>'off']) !!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-3 form-group {{ $errors->has('color_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Color")!!}
                                    {!!Form::select('color_id', $colors, null, ['class' => 'form-control', 'placeholder' => 'Select Product Color', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('color_id')!!}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Add @else Create @endif
                    </button>
                    <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                </div>
                {!!Form::close()!!}
            </div> <hr> --}}
            {{-- Ends add colour --}}
            
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Store Name</th>
                        <th>Image</th>
                        <th>Division</th>
                        <th>Banner</th>
                        <th>Legacy</th>
                        <th>Store ID</th>
                        <th>Address</th>
                        <th>
                            @if(Request::is('*trash'))
                                Deleted
                            @else
                                Created
                            @endif
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; ?>
                    @foreach ($storesData as $row)
                        <?php $count++; ?>
                        <tr class="@if($row->status == 0) bg-danger @endif">
                            <td>{{$count}}</td>
                            @if(Request::is('*trash'))
                                <td>{{ str_limit($row->title, 30) }}</td>
                            @else
                                <td><a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}">{{ str_limit($row->title, 30) }}</a></td>
                            @endif
                            <td>
                                @if($row->image)
                                    <img src="{{asset('storage/'.$module.'s/'.$row->image)}}" height="80px">
                                @else
                                    <img src="{{asset('admin/images/default.png')}}" height="50px">
                                @endif
                            </td>
                            <td>{{ $row->division }}</td>
                            <td>{{ $row->banner }}</td>
                            <td>{{ $row->legacy }}</td>
                            <td>{{ $row->store_id }}</td>
                            <td>
                                <u> {{ str_limit($row->address_1) }} </u>
                                <small class="center-block"> City -  {{ $row->city }} </small>
                                <small class="center-block"> State -  {{ $row->state }} </small>
                                <small class="center-block"> Zip -  {{ $row->zip }} </small>
                                <small class="center-block"> Phone -  {{ $row->phone_no }} </small>
                            </td>
                            <td>
                                <div class="clear-fix">
                                    @if($row->user_id) By {!!$row->user->name!!} @endif
                                </div>
                                @if(Request::is('*trash'))
                                    <small> {{ $row->deleted_at->format('d M, Y') }} </small>
                                @else
                                    {{-- <small>{{ $row->created_at->format('d M, Y') }}</small> --}}
                                @endif
                            </td>

                            <td style="white-space: nowrap;">
                                @if(Request::is('*trash'))
                                    <a href="{{url('admin/'.$moduleStore.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                    <a href="{{url('admin/'.$moduleStore.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                @else
                                    <a href="{{url('admin/'.$moduleStore.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                    <a href="{{url('admin/'.$moduleStore.'/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> </a>
                                    <a href="{{url('admin/'.$moduleStore.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="text-center">
                @if ($storesData)
                    {{ $storesData->links() }}
                @endif
            </div> --}}
        </div>
    </div>


    <div class="nav-tabs-custom" style="display: none;">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">PRODUT COLOR</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {!! Form::open(['files' => true, 'url' => 'admin/'.$singleData->id.'/price/add', 'autocomplete'=>'off']) !!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-3 form-group {{ $errors->has('color_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Color")!!}
                                    {!!Form::select('color_id', $colors, null, ['class' => 'form-control', 'placeholder' => 'Select Product Color', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('color_id')!!}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Add @else Create @endif
                    </button>
                    <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                </div>
                {!!Form::close()!!}
            </div> <hr>
            {{-- Ends add colour --}}

            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Created</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $count = 0; ?>
                        @foreach ($allData as $row)
                            <?php $count++; ?>
                            <tr class="@if($row->status==0) disabledBg @endif">
                                <td>{{$count}}</td>
                                <td>@if($row->product_id){{$row->product->name}}@endif</td>
                                <td><span class="label" style="background-color: {{$row->color->name}};">{{$row->color->name}}</span></td>
                                <td>{!!$row->created_at->format('d M, Y')!!}</td>
                                <td>
                                    <a href="{{url('admin/price/'.$row->id.'/view')}}" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view-{{$row->id}}"> <i class="fa fa-search-plus"></i> </a>
                                        <div class="modal fade" id="view-{{$row->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Product Name : {{$row->product->name}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="box">
                                                            <div class="box-header"></div>
                                                            <div class="box-body no-padding">
                                                                <table class="table table-striped">
                                                                    <tr><th style="width: 10px">#</th><th>attribute</th><th>Data</th></tr>
                                                                    <tr><th>1</th><th>Product</th><td>{{$row->product->name}}</td></tr>
                                                                    <tr><th>2</th><th>Color</th><td><span class="label" style="background-color: {{$row->color->name}};">{{$row->color->name}}</span></td></tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#{{$row->id}}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <div class="modal fade" id="{{$row->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title text-center">{{$row->product->name}}</h4>
                                                    </div>
                                                    {!! Form::open(['url'=>'admin/'.$singleData->id.'/price/'.$row->id.'/edit']) !!}
                                                    {!!csrf_field()!!}
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="box-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-3 form-group {{ $errors->has('color_id') ? 'has-error' : '' }}">
                                                                            {!!Form::label("Product Color")!!}
                                                                            {!!Form::select('color_id', $colors, $row->id ? $row->color_id : null, ['class' => 'form-control', 'placeholder' => 'Select Product Color'])!!}
                                                                            <em class="error-msg">{!!$errors->first('color_id')!!}</em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        @if($row->id)
                                                            <div class="pull-left form-group">
                                                                <label class="switch" title="@if($row->status == 1) Enabled @else Disabled @endif">
                                                                    <input type="checkbox" name="status" value="1" @if($row->status == 1) checked @endif >
                                                                    <div class="slider round"></div>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-success">UPDATE</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{url('admin/price/'.$row->id.'/force-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    {{-- Product Size --}}
    <div class="nav-tabs-custom" style="display: none;">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">PRODUT SIZES</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {!! Form::open(['files' => true, 'url' => 'admin/'.$singleData->id.'/size/add', 'autocomplete'=>'off']) !!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('size_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Size")!!}
                                    {!!Form::select('size_id', $sizes, null, ['class' => 'form-control', 'placeholder' => 'Select Product Size', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('size_id')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                    {!!Form::label("Product Size Price")!!}
                                    {!!Form::number('price', null, ['class' => 'form-control', 'placeholder' => 'Enter the product size price', 'step' => '0.1', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('price')!!}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success" name="btn-price-size">
                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Add @else Create @endif
                    </button>
                    <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                </div>
                {!!Form::close()!!}
            </div> <hr>
            {{-- Ends add size --}}

            <div class="table-responsive">
                <table id="dataTablePrice" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $count = 0; ?>
                        @foreach ($productSize as $row)
                            <?php $count++; ?>
                            <tr class="@if($row->status==0) disabledBg @endif">
                                <td>{{$count}}</td>
                                <td>@if($row->product_id){{$row->product->name}}@endif</td>
                                <td>{{$row->sku}}</td>
                                <td>{{$row->size->name}}</td>
                                <td><span class="label label-primary">{{ $option->currency_symbol }} {{$row->price}}</span></td>
                                <td>{!!$row->created_at->format('d M, Y')!!}</td>
                                <td> 
                                    <a href="{{url('admin/size/'.$row->id.'/view')}}" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view-size-{{$row->id}}"> <i class="fa fa-search-plus"></i> </a>
                                        <div class="modal fade" id="view-size-{{$row->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Product Name : {{$row->product->name}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="box">
                                                            <div class="box-header"></div>
                                                            <div class="box-body no-padding">
                                                                <table class="table table-striped">
                                                                    <tr><th style="width: 10px">#</th><th>attribute</th><th>Data</th></tr>
                                                                    <tr><th>1</th><th>Product</th><td>{{$row->product->name}}</td></tr>
                                                                    <tr><th>2</th><th>Size</th><td>{{$row->size->name}}</td></tr>
                                                                    <tr><th>3</th><th>Price</th><td><span class="label label-primary">{{ $option->currency_symbol }} {{$row->price}}</span></td></tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#size-{{$row->id}}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="size-{{$row->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title text-center">{{$row->product->name}}</h4>
                                                    </div>
                                                    {!! Form::open(['url'=>'admin/'.$singleData->id.'/size/'.$row->id.'/edit']) !!}
                                                    {!!csrf_field()!!}
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="box-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 form-group {{ $errors->has('size_id') ? 'has-error' : '' }}">
                                                                            {!!Form::label("Product Color")!!}
                                                                            {!!Form::select('size_id', $sizes, $row->id ? $row->size_id : null, ['class' => 'form-control', 'placeholder' => 'Select Product Color'])!!}
                                                                            <em class="error-msg">{!!$errors->first('size_id')!!}</em>
                                                                        </div>
                                                                        <div class="col-sm-6 form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                                                            {!!Form::label("Product Size Price")!!}
                                                                            {!!Form::text('price', $row->price, ['class' => 'form-control', 'placeholder' => 'Enter the product size price'])!!}
                                                                            <em class="error-msg">{!!$errors->first('price')!!}</em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        @if($row->id)
                                                            <div class="pull-left form-group">
                                                                <label class="switch" title="@if($row->status == 1) Enabled @else Disabled @endif">
                                                                    <input type="checkbox" name="status" value="1" @if($row->status == 1) checked @endif >
                                                                    <div class="slider round"></div>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-success">UPDATE</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{url('admin/size/'.$row->id.'/force-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection