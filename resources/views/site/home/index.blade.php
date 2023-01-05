@extends('site.layouts.default')

@section('htmlheader_title')
    Welcome to {{$option->name}}
@endsection

@section('page-style')
    <style>
        .slick-prev::before, .slick-next::before {font-size:40px !important;}
        .slick-prev {z-index:1;top:25%;}
        .slick-next {right: 7px;opacity: 1 !important;top:25%;}
        .slick-prev::before, .slick-next::before{opacity: 1 !important;}
        .dark .slick-prev::before, .dark .slick-next::before {color: #d6d5d4 !important;}
        /*.slick-prev:before {content: "<";color: red;font-size: 30px;}*/
        /*.slick-next:before {content: ">";color: red;font-size: 30px;}*/
    </style>
@endsection

@section('main-content')
    @include('site.partials.slider_bootstrap')

    <!--title-start-->
    <div class="title1 section-my-space mt-0">
        <h4>FEATURED PRODUCTS</h4>
    </div>
    <!--title-end-->

    <!--product box start -->
    <section class=" ratio_asos product section-pb-space ">
    <div class="container-fluid">
        <div class="custom-container">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-6">
                        @foreach($rsrFeaturedData as $row)
                            {{-- @include('site.product.product_loop') --}}
                            <div>
                                <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                <div class="product-box">
                                    <div class="product-imgbox">
                                        <div class="product-front">
                                              {{-- @if($row->image_name)
                                                @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}" style="max-width:60%">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}" style="max-width:60%">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}" style="max-width:60%">
                                              @endif --}}

                                              @if($row->image_name)
                                                @if (Storage::exists($row->get_lr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_lr_image_by_category())}}" style="max-width:60%">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}" style="max-width:60%">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}" style="max-width:60%">
                                              @endif
                                        </div>
                                        <!--<div class="product-back">-->
                                        <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}">-->
                                        <!--      @if($row->image_name)-->
                                        <!--        @if (Storage::exists($row->get_hr_image_storage_path_by_category()))-->
                                        <!--          <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">-->
                                        <!--        @else-->
                                        <!--          <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">-->
                                        <!--        @endif-->
                                        <!--      @else-->
                                        <!--           <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">-->
                                        <!--      @endif-->
                                        <!--  </a>-->
                                        <!--</div>-->
                                        <!--<div class="product-icon icon-inline">-->
                                        <!--  @if($row->is_in_stock())-->
                                        <!--    {!!Form::open(['url'=> $row->rsr_stock_number.'/item', 'autocomplete'=>'off'])!!}-->
                                        <!--    {!!csrf_field()!!}-->
                                        <!--      <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>-->
                                        <!--    {!! Form::close() !!}-->
                                        <!--  @endif-->
                                        <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}" title="View Product">-->
                                        <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                        <!--    </a>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="product-detail detail-inline">
                                        <div class="detail-title">
                                            <div class="detail-left">
                                                {{-- <div class="rating-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div> --}}

                                                <h6 class="price-title">{{ $row->product_description }} </h6>

                                                <div class="border-top border-dark mt-2">
                                                    {{-- <strong>{{ $option->currency_symbol . number_format($row->retail_price, 2) }}</strong> --}}
                                                    <strong>{{ $option->currency_symbol }}{{ number_format($row->get_rsr_retail_price(), 2) }}</strong>
                                                </div>
                                            </div>

                                            {{-- <div class="detail-right">
                                                <div class="check-price">
                                                    {{ $option->currency_symbol . $row->retail_price }}
                                                </div>
                                                <div class="price">
                                                    <div class="price">
                                                        <hr>
                                                        {{ $option->currency_symbol . $row->retail_price }}
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach

                        @if($option->is_display_bs_products == 1)
                            @foreach($featuredProductsData as $row)
                                @include('site.product.product_loop')
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!--product box end-->


    <div class="title1 section-my-space mt-0">
        <h4>Categories</h4>
    </div>
    <div class="container-fluid">
    <section class="blog mt-4 mb-5">
        <div class="custom-container">
            <div class="row">
                @if($option->is_display_bs_products == 1)
                     @foreach($categoriesData as $row)
                        <div class="col-md-3 pt-1 pb-1">
                                <a href="{{url('main-categories/'.$row->slug)}}">{{ $row->name }}</a>
                        </div>
                      @endforeach
                @endif

                @foreach($rsrMaincategoriesData as $rsrCategory)
                    <div class="col-md-3 pt-1 pb-1">
                        <a href="{{ url('main-categories', $rsrCategory->department_id) }}">{{ $rsrCategory->category_name }}</a>
                    </div>
                @endforeach
            </div>

            
            <!--<div class="row">-->

            <!--  {{-- <div class="col-12">-->
            <!--      <div class="title3">-->
            <!--          <h4>Product Categories</h4>-->
            <!--      </div>-->
            <!--  </div> --}}-->
            <!--    <div class="col-12 pr-0">-->
            <!--        <div class="blog-slide-4">-->
            <!--            @foreach($categoriesData as $row)-->
            <!--                <div>-->
            <!--                    <div class="blog-contain">-->
            <!--                        <div class="blog-img">-->
            <!--                            <a href="{{url('main-categories/'.$row->slug)}}">-->
            <!--                                @if($row->image)-->
            <!--                                    <img class="img-fluid" src="{{asset('storage/categories/'.$row->image)}}" alt="">-->
            <!--                                @else-->
            <!--                                    <img class="img-fluid" src="{{asset('site/defaults/image-placeholder.png')}}" alt="">-->
            <!--                                @endif-->
            <!--                            </a>-->
            <!--                        </div>-->
            <!--                        <div class="blog-details">-->
            <!--                            <h4><a href="{{url('main-categories/'.$row->slug)}}">{{ str_limit($row->name, 35) }}</a></h4>-->
            <!--                            <p>{{ str_limit($row->description, 50) }}</p>-->
            <!--                            {{-- <span><a href="{{url('main-categories/'.$row->slug)}}">read more</a></span> --}}-->
            <!--                        </div>-->
            <!--                        {{-- <div class="blog-label">-->
            <!--                            <p>{{ date('F m Y', strtotime($row->created_at)) }}</p>-->
            <!--                        </div> --}}-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            @endforeach-->

            <!--            @foreach($rsrMaincategoriesData as $rsrCategory)-->
            <!--                <div>-->
            <!--                    <div class="blog-contain">-->
            <!--                        <div class="blog-img">-->
            <!--                            <a href="{{ url('main-categories', $rsrCategory->department_id) }}">-->
            <!--                                @if($rsrCategory->image)-->
            <!--                                    <img class="img-fluid" src="{{asset('storage/rsr-mian-categories/'.$rsrCategory->image)}}" alt="">-->
            <!--                                @else-->
            <!--                                    <img class="img-fluid" src="{{asset('site/defaults/image-placeholder.png')}}" alt="">-->
            <!--                                @endif-->
            <!--                            </a>-->
            <!--                        </div>-->
            <!--                        <div class="blog-details">-->
            <!--                            <h4><a href="{{ url('main-categories', $rsrCategory->department_id) }}">{{ $rsrCategory->category_name }}</a></h4>-->
            <!--                            {{-- <p>{{ str_limit($rsrCategory->description, 50) }}</p> --}}-->
            <!--                            {{-- <span><a href="{{url('main-categories/'.$rsrCategory->slug)}}">read more</a></span> --}}-->
            <!--                        </div>-->
            <!--                        {{-- <div class="blog-label">-->
            <!--                            <p>{{ date('F m Y', strtotime($rsrCategory->created_at)) }}</p>-->
            <!--                        </div> --}}-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            @endforeach-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </section>
    </div>

    <div class="title1 section-my-space mt-0">
        <h4>RECENT PRODUCTS</h4>
    </div>
    <div class="container-fluid">
    <section class=" ratio_asos product section-pb-space ">
        <div class="custom-container ">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-6">


                        @foreach($rsrProductsData as $row)
                            {{-- @include('site.product.product_loop') --}}
                            <div>
                                <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                <div class="product-box">
                                    <div class="product-imgbox">
                                        <div class="product-front">
                                              {{-- @if($row->image_name)
                                                @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}" style="max-width:60%">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}" style="max-width:60%">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}" style="max-width:60%">
                                              @endif --}}

                                              @if($row->image_name)
                                                @if (Storage::exists($row->get_lr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_lr_image_by_category())}}" style="max-width:60%">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}" style="max-width:60%">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}" style="max-width:60%">
                                              @endif
                                        </div>
                                        <!--<div class="product-back">-->
                                        <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}">-->
                                        <!--      @if($row->image_name)-->
                                        <!--        @if (Storage::exists($row->get_hr_image_storage_path_by_category()))-->
                                        <!--          <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">-->
                                        <!--        @else-->
                                        <!--          <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">-->
                                        <!--        @endif-->
                                        <!--      @else-->
                                        <!--           <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">-->
                                        <!--      @endif-->
                                        <!--  </a>-->
                                        <!--</div>-->
                                        <!--<div class="product-icon icon-inline">-->
                                        <!--  @if($row->is_in_stock())-->
                                        <!--    {!!Form::open(['url'=> $row->rsr_stock_number.'/item', 'autocomplete'=>'off'])!!}-->
                                        <!--    {!!csrf_field()!!}-->
                                        <!--      <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>-->
                                        <!--    {!! Form::close() !!}-->
                                        <!--  @endif-->
                                        <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}" title="View Product">-->
                                        <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                        <!--    </a>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="product-detail detail-inline">
                                        <div class="detail-title">
                                            <div class="detail-left">
                                                {{-- <div class="rating-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div> --}}

                                                    <h6 class="price-title">{{ $row->product_description }} </h6>

                                                <div class="border-top border-dark mt-2">
                                                    {{-- <strong>{{ $option->currency_symbol . number_format($row->retail_price, 2) }}</strong> --}}
                                                    <strong>{{ $option->currency_symbol }}{{ number_format($row->get_rsr_retail_price(), 2) }}</strong>
                                                </div>
                                            </div>

                                            {{-- <div class="detail-right">
                                                <div class="check-price">
                                                    {{ $option->currency_symbol . $row->retail_price }}
                                                </div>
                                                <div class="price">
                                                    <div class="price">
                                                        <hr>
                                                        {{ $option->currency_symbol . $row->retail_price }}
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach

                        @if($option->is_display_bs_products == 1)
                            @foreach($newProductsData as $row)
                                @include('site.product.product_loop')
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

    <!--contact banner start-->
    {{-- <section class="contact-banner">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="contact-banner-contain">
                        <div class="contact-banner-img"><img src="{{ asset('site/images/layout-1/call-img.png') }}" alt="call-banner"></div>
                        <div> <h3>if you have any question please call us</h3></div>
                        <div><h2>{{ $option->phone_no }}</h2></div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--contact banner end-->

@endsection

@section('page-script')
@endsection