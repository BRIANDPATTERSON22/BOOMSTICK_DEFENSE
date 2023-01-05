@extends('site.layouts.default')

@section('htmlheader_title')
    All Categories
@endsection

@section('main-content')
    {{-- <div style="background: #000; padding:20px 30px">
        <div class="container">
            @include('site.partials.filter')
        </div>
    </div> --}}

{{--     <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>
                    @if(Request::is('*category*'))
                        {{$category->name}} Products
                    @elseif(Request::is('*search*'))
                        Search Result for <u>{{session('searchText')}}</u>
                    @elseif(Request::is('*filter/*/*/*'))
                        Filter Result for Year: <u>{{session('filterYear')}}</u>, Brand: <u>{{session('filterBrandName')}}</u> & Mode: <u>{{session('filterModelName')}}</u>
                    @elseif(Request::is('*filter/y-*/b-*'))
                        Filter Result for Year: <u>{{session('filterYear')}}</u> & Brand: <u>{{session('filterBrandName')}}</u>
                    @elseif(Request::is('*filter/y-*/m-*'))
                        Filter Result for Year: <u>{{session('filterYear')}}</u> & Model: <u>{{session('filterModelName')}}</u>
                    @elseif(Request::is('*filter/b-*/m-*'))
                        Filter Result for Brand: <u>{{session('filterBrandName')}}</u> & Model: <u>{{session('filterModelName')}}</u>
                    @elseif(Request::is('*filter/y-*'))
                        Filter Result for Year: <u>{{session('filterYear')}}</u>
                    @elseif(Request::is('*filter/b-*'))
                        Filter Result for Brand: <u>{{session('filterBrandName')}}</u>
                    @elseif(Request::is('*filter/m-*'))
                        Filter Result for Model: <u>{{session('filterModelName')}}</u>
                    @elseif(Request::is('*sort/*'))
                        All Products Sort by: <u>{{session('sortBy')}}</u>
                    @else
                        All Products
                    @endif
                </h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}">Home</a></li>
                    @if(Request::is('*category*'))
                        <li class="separator">&nbsp;</li>
                        <li><a href="{{url('products')}}">Shop</a></li>
                        <li class="separator">&nbsp;</li>
                        <li>{{$category->name}}</li>
                    @elseif(Request::is('*search*'))
                        <li class="separator">&nbsp;</li>
                        <li><a href="{{url('products')}}">Shop</a></li>
                        <li class="separator">&nbsp;</li>
                        <li>Search</li>
                    @elseif(Request::is('*filter*'))
                        <li class="separator">&nbsp;</li>
                        <li><a href="{{url('products')}}">Shop</a></li>
                        <li class="separator">&nbsp;</li>
                        <li>Filter</li>
                    @else
                        <li class="separator">&nbsp;</li>
                        <li>Shop</li>
                    @endif
                </ul>
            </div>
        </div>
    </div> --}}

    <div class="osahan-breadcrumb">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12">
                <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icofont icofont-ui-home"></i> Home</a></li>
                   <li class="breadcrumb-item"><a href="{{url('products')}}">Products</a></li>
                   <li class="breadcrumb-item"><a href="{{url('products/categories')}}">Categories</a></li>
                   <li class="breadcrumb-item active">Sub Categories</li>
                </ol>
             </div>
          </div>
       </div>
    </div>


    <section class="products_page">
       <div class="container">
          <div class="row">
            @if(count($allData)>0)
             <div class="col-lg-12 col-md-12">
               {{--  <div class="osahan_products_top_filter row">
                   <div class="col-lg-6 col-md-6 tags-action">
                      <span>Clothing <a href="shop-grid-full.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
                      <span>John Players <a href="shop-grid-full.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
                      <span>X - Small <a href="shop-grid-full.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
                   </div>
                   <div class="col-lg-6 col-md-6 sort-by-btn pull-right">
                      <div class="view-mode pull-right">
                         <a class="active" href="shop-grid-left-sidebar.html"> <i class="fa fa-th-large"></i> </a><a href="shop-list-left-sidebar.html"> <i class="fa fa-th-list"></i> </a>
                      </div>
                      <div class="dropdown pull-right">
                         <button class="btn btn-primary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="icofont icofont-filter"></i> Sort by 
                         </button>
                         <div class="dropdown-menu pull-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Popularity </a>
                            <a class="dropdown-item" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> New </a>
                            <a class="dropdown-item" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Discount </a>
                            <a class="dropdown-item" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Price: Low to High </a>
                            <a class="dropdown-item" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Price: High to Low </a>
                         </div>
                      </div>
                   </div>
                </div> --}}
                <div class="row products_page_list">
                   <div class="clearfix"></div>
                    @foreach($allData as $row)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="item">
                         <div class="h-100">
                            <div class="product-item">
                               {{-- <span class="badge badge-danger offer-badge">HOT</span>   --}}
                               <div class="product-item-image">
                                  {{-- <span class="like-icon"><a href="shop-grid-full.html#"> <i class="icofont icofont-heart"></i></a></span> --}}
                                   @if($row->image)
                                  <a href="{{url('category/'.$row->slug)}}"><img class="card-img-top img-fluid" src="{{asset('storage/category-sub/'.$row->image)}}" alt=""></a>
                                  @else
                                   <a href="{{url('category/'.$row->slug)}}"><img class="card-img-top img-fluid" src="{{asset('site/images/default.png')}}" alt=""></a>
                                  @endif
                               </div>
                               <div class="product-item-body">
                                  <div class="product-item-action">
                                     {{-- <a data-toggle="tooltip" data-placement="top" title="" class="btn btn-theme-round btn-sm" href="{{url($row->id.'/item')}}" data-original-title="Add To Cart"><i class="icofont icofont-shopping-cart"></i></a> --}}
                                     <a data-toggle="tooltip" data-placement="top" title="" class="btn btn-theme-round btn-lg" href="{{url('category/'.$row->slug)}}" data-original-title="View Detail"><i class="icofont icofont-search-alt-2"></i></a>
                                  </div>
                                  <h4 class="card-title"><a href="#">{{str_limit($row->name, 22)}}</a></h4>
                                  <h5>
                                     {{-- <span class="product-desc-price">{{ count($row->subCategories) }}</span> --}}
                                     {{-- <span class="product-price">$10</span> --}}
                                     <span class="product-discount">{{ count($row->products) }} product(s)</span>
                                  </h5>
                               </div>
                               {{-- <div class="product-item-footer">
                                  <div class="product-item-size">
                                     <strong>Size</strong> <span>S</span> <span>M</span> <span>L</span> <span> XL</span> <span> 2XL</span>
                                  </div>
                                  <div class="stars-rating">
                                     <i class="icofont icofont-star active"></i>
                                     <i class="icofont icofont-star active"></i>
                                     <i class="icofont icofont-star active"></i>
                                     <i class="icofont icofont-star"></i>
                                     <i class="icofont icofont-star"></i> <span>(415)</span>
                                  </div>
                               </div> --}}
                            </div>
                         </div>
                        </div>
                        </div>
                    @endforeach
                </div>
                {{-- <nav aria-label="Page navigation example">
                   <ul class="pagination justify-content-center">
                      <li class="page-item disabled"><a class="page-link" href="shop-grid-full.html#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                      <li class="page-item active"><a class="page-link" href="shop-grid-full.html#">1</a></li>
                      <li class="page-item"><a class="page-link" href="shop-grid-full.html#">2</a></li>
                      <li class="page-item"><a class="page-link" href="shop-grid-full.html#">3</a></li>
                      <li class="page-item"><a class="page-link" href="shop-grid-full.html#">4</a></li>
                      <li class="page-item"><a class="page-link" href="shop-grid-full.html#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                   </ul>
                </nav> --}}
               {{--  <nav class="pagination">
                    <div class="column">
                        {{$allData->links()}}
                    </div>
                </nav> --}}
                {{$allData->links()}}
             </div>
             @else
                 <h3 class="text-center">No data found! We wil update soon!</h3>
             @endif

          </div>
       </div>
       </div>
    </section>
@endsection

@section('page-script')
@endsection