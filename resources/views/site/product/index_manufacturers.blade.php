@extends('site.layouts.default')

@section('htmlheader_title')
    Manufactures
@endsection

@section('body_class')
@endsection

@section('page-style')
    <style>
        .product .product-box .product-detail.detail-center .detail-title .detail-right .price { margin-left: 0px; color: #9e9e9e;}
        /*.filterbox-overflow{max-height:200px; overflow-x: overlay;}*/
        .form_sort_by{display: contents;}
        /* width */
        .filter-box::-webkit-scrollbar {width: 8px;}
        /* Track */
        .filter-box::-webkit-scrollbar-track {box-shadow: inset 0 0 9px grey; border-radius: 0px;}
        /* Handle */
        .filter-box::-webkit-scrollbar-thumb {background: black; border-radius: 0px;}
        /* Handle on hover */
        .filter-box::-webkit-scrollbar-thumb:hover {background: #b30000; }
    </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          {{-- <h2>Products</h2> --}}
                          <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="{{ url('main-categories') }}">Manufactures</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a>{{ request()->slug}}</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <section class="section-big-pt-space ratio_asos bg-light">
      <div class="collection-wrapper">
          <div class="custom-container">
              <div class="row">
                  
                  <div class="collection-content col">
                      <div class="page-main-content">
                          <div class="row">
                              <div class="col-sm-12">
                                
                                  <div class="collection-product-wrapper">

                                    @if($rsrProductsData->isNotEmpty())
                                      <div class="product-top-filter">
                                          <div class="row">
                                              <div class="col-xl-12">
                                                  <div class="filter-main-btn"><span class="filter-btn  "><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-12">
                                                  <div class="product-filter-content">
                                                      <div class="search-count">
                                                          <h5>Showing Products {{ $rsrProductsData->firstItem() }} - {{ $rsrProductsData->lastItem() }} of {{ $rsrProductsData->total()}} Result</h5>
                                                      </div>

                                                      <div class="collection-view">
                                                          <ul>
                                                              <li><i class="fa fa-th grid-layout-view"></i></li>
                                                              <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                          </ul>
                                                      </div>

                                                      <div class="collection-grid-view">
                                                          <ul>
                                                              <li><img src="{{ asset('site/images/category/icon/2.png') }}" alt="" class="product-2-layout-view"></li>
                                                              <li><img src="{{ asset('site/images/category/icon/3.png') }}" alt="" class="product-3-layout-view"></li>
                                                              <li><img src="{{ asset('site/images/category/icon/4.png') }}" alt="" class="product-4-layout-view"></li>
                                                              <li><img src="{{ asset('site/images/category/icon/6.png') }}" alt="" class="product-6-layout-view"></li>
                                                          </ul>
                                                      </div>

                                                      {!!Form::open(['autocomplete'=>'off', 'name' => 'form_sort_by', 'method' => 'get', 'id' => 'id_category_filter_forms', 'class' => 'form_sort_by'])!!}

                                                        @if(request()->calibers)
                                                          @foreach (request()->calibers as $caliber)
                                                            <input type="hidden" name="calibers[]" value="{{ $caliber }}">
                                                          @endforeach
                                                        @endif

                                                        @if(request()->barrel_lengths)
                                                          @foreach (request()->barrel_lengths as $barrel_length)
                                                            <input type="hidden" name="barrel_lengths[]" value="{{ $barrel_length }}">
                                                          @endforeach
                                                        @endif

                                                         {{-- <input type="hidden" name="calibers" value="{{ request()->calibers ?? null }}"> --}}
                                                         {{-- <input type="hidden" name="barrel_lengths" value="{{ request()->barrel_lengths ?? null }}"> --}}

                                                         <input type="hidden" name="stock_availability" value="{{ request()->stock_availability }}">
                                                         <input type="hidden" name="from_price" value="{{ request()->from_price }}">
                                                         <input type="hidden" name="to_price" value="{{ request()->to_price }}">

                                                          <div class="product-page-per-view">
                                                              <select name="products_per_page" onchange="this.form.submit()">
                                                                  {{-- <option value="12" @if(request()->products_per_page == 12) selected @endif>12 Products Per Page</option> --}}
                                                                  <option value="12" @if(request()->products_per_page == 12) selected @endif>12 Products Per Page</option>
                                                                  <option value="24" @if(request()->products_per_page == 24) selected @endif>24 Products Per Page</option>
                                                                  <option value="48" @if(request()->products_per_page == 48) selected @endif>48 Products Per Page</option>
                                                              </select>
                                                          </div>
                                                          <div class="product-page-filter">
                                                              <select name="sort_by" onchange="this.form.submit()">
                                                                  {{-- <option value="featured_products">Featured Products</option> --}}
                                                                  {{-- <option value="boomstick_products">Boomstick Products</option> --}}
                                                                  <option value="item_name">Item Name (A-Z) </option>
                                                                  <option value="low_to_high" @if(request()->sort_by == "low_to_high") selected @endif>Item Price (Low to High)</option>
                                                                  <option value="high_to_low" @if(request()->sort_by == "high_to_low") selected @endif>Item Price (High to Low)</option>
                                                                  <option value="available_quantity" @if(request()->sort_by == "available_quantity") selected @endif>Available Quantitiy</option>
                                                              </select>
                                                          </div>
                                                      {{-- {!!csrf_field()!!} --}}
                                                      {!! Form::close() !!}
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    @endif

                                      <div class="product-wrapper-grid">
                                          <div class="row">
                                              @if($allData->isNotEmpty())
                                                @foreach($allData as $row)
                                                  <div class="col-xl-2 col-md-3 col-6  col-grid-box">
                                                      <a href="{{url('product/'.$row->slug)}}">
                                                      <div class="product">
                                                          <div class="product-box">
                                                              <div class="product-imgbox">
                                                                <div class="product-front">
                                                                    <a href="{{url('product/'.$row->slug)}}">
                                                                        @if($row->main_image)
                                                                            <img class="img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}">
                                                                        @else
                                                                             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <!--<div class="product-back">-->
                                                                <!--    <a href="{{url('product/'.$row->slug)}}">-->
                                                                <!--        @if($row->main_image)-->
                                                                <!--            <img class="img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}">-->
                                                                <!--        @else-->
                                                                <!--             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">-->
                                                                <!--        @endif-->
                                                                <!--    </a>-->
                                                                <!--</div>-->
                                                              </div>

                                                              <div class="product-detail detail-center">
                                                                  <div class="detail-title" style="pointer-events:none;opacity:2 !important">
                                                                      <div class="detail-left">
                                                                          {{-- <div class="rating-star">
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                          </div>
                                                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p> --}}
                                                                          <a href="category-page(left-sidebar).html">
                                                                              <h6 class="price-title">
                                                                                  {{ $row->title }}
                                                                              </h6>
                                                                          </a>
                                                                      </div>
                                                                      <div class="detail-right">
                                                                          {{-- <div class="check-price">
                                                                              $ 56.21
                                                                          </div> --}}
                                                                          @if($row->is_retail_price_enabled == 1)
                                                                            <div class="price">
                                                                                <div class="price">
                                                                                   {{ $option->currency_symbol }}{{ number_format($row->retail_price, 2) }}
                                                                                </div>
                                                                            </div>
                                                                          @endif
                                                                      </div>
                                                                  </div>
                                                                  <!--<div class="icon-detail">-->
                                                                  <!--    {{-- <button data-toggle="modal" data-target="#addtocart" title="Add to cart">-->
                                                                  <!--        <i class="ti-bag" ></i>-->
                                                                  <!--    </button>-->
                                                                  <!--    <a href="javascript:void(0)" title="Add to Wishlist">-->
                                                                  <!--        <i class="ti-heart" aria-hidden="true"></i>-->
                                                                  <!--    </a>-->
                                                                  <!--    <a href="category-page(left-sidebar).html#" data-toggle="modal" data-target="#quick-view" title="Quick View">-->
                                                                  <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                                                  <!--    </a>-->
                                                                  <!--    <a href="compare.html" title="Compare">-->
                                                                  <!--        <i class="fa fa-exchange" aria-hidden="true"></i>-->
                                                                  <!--    </a> --}}-->
                                                                  <!--    @if($row->is_in_stock())-->
                                                                  <!--      {!!Form::open(['url'=> $row->slug.'/item', 'autocomplete'=>'off'])!!}-->
                                                                  <!--      {{-- {!!Form::open(['url'=> $row->id.'/item', 'autocomplete'=>'off'])!!} --}}-->
                                                                  <!--      {!!csrf_field()!!}-->
                                                                  <!--        <input type="hidden" name="type" value="0">-->
                                                                  <!--        <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>-->
                                                                  <!--      {!! Form::close() !!}-->
                                                                  <!--    @endif-->
                                                                  <!--    <a href="{{url('product/'.$row->slug)}}" title="View Product">-->
                                                                  <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                                                  <!--    </a>-->
                                                                  <!--</div>-->
                                                              </div>
                                                          </div>
                                                      </div>
                                                      </a>
                                                  </div>
                                                @endforeach
                                              @endif

                                            @if($rsrProductsData->isNotEmpty())
                                              @foreach($rsrProductsData as $row)
                                                  <div class="col-xl-2 col-md-3 col-6  col-grid-box">
                                                      <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                                      <div class="product">
                                                          <div class="product-box">
                                                              <div class="product-imgbox">
                                                                <div class="product-front">
                                                                        @if($row->image_name)
                                                                          @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                                            <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">
                                                                          @else
                                                                            <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                                          @endif
                                                                        @else
                                                                             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                                        @endif
                                                                </div>
                                                                <!--<div class="product-back">-->
                                                                <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}">-->
                                                                <!--        @if($row->image_name)-->
                                                                <!--          @if (Storage::exists($row->get_hr_image_storage_path_by_category()))-->
                                                                <!--            <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">-->
                                                                <!--          @else-->
                                                                <!--            <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">-->
                                                                <!--          @endif-->
                                                                <!--        @else-->
                                                                <!--             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">-->
                                                                <!--        @endif-->
                                                                <!--    </a>-->
                                                                <!--</div>-->
                                                              </div>
                                                              
                                                              <div class="product-detail detail-center">
                                                                  <div class="detail-title" style="pointer-events:none;opacity:2 !important">
                                                                      <div class="detail-left">
                                                                          {{-- <div class="rating-star">
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                              <i class="fa fa-star"></i>
                                                                          </div> --}}
                                                                          {{-- <p>xxxx</p> --}}
                                                                              <h6 class="price-title">{{ $row->product_description }} </h6>
                                                                      </div>
                                                                      <div class="detail-right">
                                                                          {{-- <div class="check-price">
                                                                              {{ $option->currency_symbol }} {{ $row->retail_price }}
                                                                          </div> --}}
                                                                          <div class="price">
                                                                              {{-- <div class="price">{{ $option->currency_symbol }} {{ number_format($row->retail_price, 2) }}</div> --}}

                                                                              <div class="price">{{ $option->currency_symbol }}{{ number_format($row->get_rsr_retail_price(), 2) }}</div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <!--<div class="icon-detail">-->
                                                                  <!--    {{-- <button data-toggle="modal" data-target="#addtocart" title="Add to cart">-->
                                                                  <!--        <i class="ti-bag" ></i>-->
                                                                  <!--    </button> --}}-->
                                                                  <!--    {{-- <a href="javascript:void(0)" title="Add to Wishlist">-->
                                                                  <!--        <i class="ti-heart" aria-hidden="true"></i>-->
                                                                  <!--    </a> --}}-->
                                                                  <!--    {{-- <a href="category-page(left-sidebar).html#" data-toggle="modal" data-target="#quick-view" title="Quick View">-->
                                                                  <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                                                  <!--    </a> --}}-->
                                                                  <!--    {{-- <button title="Add to cart"><i class="ti-bag" ></i></button> --}}-->

                                                                  <!--    @if($row->is_in_stock())-->
                                                                  <!--      {!!Form::open(['url'=> $row->rsr_stock_number.'/item', 'autocomplete'=>'off'])!!}-->
                                                                  <!--      {!!csrf_field()!!}-->
                                                                  <!--        <input type="hidden" name="type" value="1">-->
                                                                  <!--        <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>-->
                                                                  <!--      {!! Form::close() !!}-->
                                                                  <!--    @endif-->
                                                                  <!--    {{-- <a href="compare.html" title="Compare">-->
                                                                  <!--        <i class="ti-bag" ></i>-->
                                                                  <!--    </a> --}}-->
                                                                  <!--    {{-- <a href="{{url('product/'.$row->rsr_stock_number)}}" title="View Product">-->
                                                                  <!--        <i class="ti-bag" ></i>-->
                                                                  <!--    </a> --}}-->
                                                                  <!--    <a href="{{url('product/'.$row->rsr_stock_number)}}" title="View Product">-->
                                                                  <!--        <i class="ti-search" aria-hidden="true"></i>-->
                                                                  <!--    </a>-->
                                                                  <!--</div>-->
                                                              </div>
                                                          </div>
                                                      </div>
                                                      </a>
                                                  </div>
                                                @endforeach
                                              @endif
                                          </div>
                                      </div>

                                      <div class="product-pagination">
                                          <div class="theme-paggination-block">
                                            @if($rsrProductsData->isNotEmpty())
                                              {{ $rsrProductsData->links() }}
                                            @endif
                                              {{-- <div class="row">
                                                  <div class="col-xl-6 col-md-6 col-sm-12">
                                                      <nav aria-label="Page navigation">
                                                          <ul class="pagination">
                                                              <li class="page-item"><a class="page-link" href="category-page(left-sidebar).html#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> <span class="sr-only">Previous</span></a></li>
                                                              <li class="page-item active"><a class="page-link" href="category-page(left-sidebar).html#">1</a></li>
                                                              <li class="page-item"><a class="page-link" href="category-page(left-sidebar).html#">2</a></li>
                                                              <li class="page-item"><a class="page-link" href="category-page(left-sidebar).html#">3</a></li>
                                                              <li class="page-item"><a class="page-link" href="category-page(left-sidebar).html#" aria-label="Next"><span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Next</span></a></li>
                                                          </ul>
                                                      </nav>
                                                  </div>
                                                  <div class="col-xl-6 col-md-6 col-sm-12">
                                                      <div class="product-search-count-bottom">
                                                          <h5>Showing Products 1-24 of 10 Result</h5></div>
                                                  </div>
                                              </div> --}}
                                          </div>
                                      </div>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  @include('site.product.sidebar_manufacturer')

              </div>
          </div>
      </div>
  </section>
  <!-- section End -->

@endsection

@section('page-script')
    <script type="text/javascript">  
        $(function(){
            $(':checkbox').on('change',function(){
                $('#id_category_filter_form').submit();
            });
        });
    </script>
@endsection