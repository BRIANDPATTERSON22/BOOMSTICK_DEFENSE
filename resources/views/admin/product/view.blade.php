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
                    {{-- <table class="table">
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

                        <tr>
                            <th style="white-space: nowrap;">Category/ Sub Category</th>
                            <td> @if($singleData->category_id) {{$singleData->category->mainCategory->name}}/ {{$singleData->category->name}}  @endif </td>
                        </tr>
                        <tr>
                            <th>Price ($)</th>
                            <td> @if($singleData->special_price)  <strike>{{$singleData->price}}</strike> / @else {{$singleData->price}} @endif {{$singleData->special_price}}</td>
                            <td> <span class="badge bg-blue">{{$option->currency_symbol .' '. $singleData->price ?? '--' }}</span></td>
                        </tr>
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
                    </table> --}}

                    <table class="table table-condensed">
                      <tbody>
                        {{-- <tr>
                            <th>Task</th>
                            <th style="width: 40px">Label</th>
                        </tr> --}}
                        @foreach($singleDataColumns as $row)
                            <tr>
                                <td><strong>{{ str_replace('_', ' ', Illuminate\Support\Str::title($row)) }}</strong></td>
                                @if($row == 'content')
                                    <td><span class="badge_ bg-grey text-justify">{!! $singleData->$row !!}</span></td>
                                @elseif($row == 'image')
                                    <td>
                                        @if($singleData->image)
                                            <img src="{{url('storage/'. $module. 's/' . $singleData->image)}}" width="100" height="100" alt="Image" class="img-circle">
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
                                    <td>{{ $singleData->$row }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
                
                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} by {{$singleData->user->name}}</em>
                </div>
            </div>
        </div>
    </div>
@endsection