@extends('site.layouts.default')

@section('htmlheader_title')
    Products Filter
@endsection

@section('main-content')
   <div class="osahan-breadcrumb">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="shop-grid-left-sidebar.html#"><i class="icofont icofont-ui-home"></i> Home</a></li>
                  <li class="breadcrumb-item"><a href="shop-grid-left-sidebar.html#">Pages</a></li>
                  <li class="breadcrumb-item active">Page Name</li>
               </ol>
            </div>
         </div>
      </div>
   </div>


   <section class="products_page">
      <div class="container">
      <div class="row">
      <div class="col-lg-3 col-md-4">
      <div class="widget">
      <div class="category_sidebar">
         <aside class="sidebar_widget">
            <div class="widget_title">
               <h5 class="heading-design-h5"><i class="icofont icofont-filter"></i> Categories</h5>
            </div>
              @foreach($categories as $row)
                  @if(count($row->subCategories) > 0)
                     <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card">
                           <div class="card-header" role="tab" id="headingOne">
                              <h5 class="mb-0">
                                 <a data-toggle="collapse" data-parent="#accordion" href="#{{ $row->id }}" aria-expanded="false" aria-controls="{{ $row->id }}">
                                 {{ $row->name }}
                                 <span><i class="fa fa-plus-square-o"></i></span>
                                 </a>
                              </h5>
                           </div>
                           <div id="{{ $row->id }}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                              <div class="card-block">
                                 <ul class="trends">
                                    @foreach($row->subCategories as $subCategory)
                                    <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                       <input type="checkbox" class="custom-control-input" >
                                       <span class="custom-control-indicator"></span>
                                       <span class="custom-control-description">{{$subCategory->name}}<span class="item-numbers">{{ count($subCategory->products) }}</span></span>
                                       </label>  
                                    </li>
                                    @endforeach
                                    <li><a href="{{ url('products/categories') }}"><strong>Show More </strong><i class="icofont icofont-bubble-right"></i></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endforeach
         </aside>
         <hr>
         <aside class="sidebar_widget">
            <div class="widget_title">
               <h5 class="heading-design-h5">Brand</h5>
            </div>
            <div class="card">
               <div class="collapse show">
                  <div class="card-block">
                     <ul class="trends">
                        @foreach($brands->slice(0,5) as $brand)
                        <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                           <input type="checkbox" class="custom-control-input">
                           <span class="custom-control-indicator"></span>
                           <span class="custom-control-description">{{ str_limit($brand->name, 20) }} <span class="item-numbers">{{ count($brand->products) }}</span></span>
                           </label>  
                        </li>
                        @endforeach
                        <li><a href="{{ url('products/brands') }}"><strong>+ {{ count($brands) }} more </strong><i class="icofont icofont-bubble-right"></i></a></li>
                     </ul>
                  </div>
               </div>
         </aside>
         <hr>
         <aside class="sidebar_widget">
         <div class="widget_title">
         <h5 class="heading-design-h5">Price</h5>
         </div>
         <div class="card">
         <div class="collapse show">
         <div class="card-block">
         <ul class="trends">
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">$68 to $659 <span class="item-numbers">365548</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input" checked>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">$660 to $1014 <span class="item-numbers">3658</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">$1015 to $1679 <span class="item-numbers">7845</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">$1680 to $1856 <span class="item-numbers">6548</span></span>
         </label>  </li>
         </ul>
         </div>
         </div>
         </aside>
         <hr>
         <aside class="sidebar_widget">
         <div class="widget_title">
         <h5 class="heading-design-h5">Colour</h5>
         </div>
         <div class="card">
         <div class="collapse show">
         <div class="card-block">
         <ul class="osahan-select-color">
         <li> <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-blue" href="shop-grid-left-sidebar.html#" data-original-title="Blue"></a> 
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-black" href="shop-grid-left-sidebar.html#" data-original-title="Black"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-white" href="shop-grid-left-sidebar.html#" data-original-title="white"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-grey" href="shop-grid-left-sidebar.html#" data-original-title="Grey"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-navy" href="shop-grid-left-sidebar.html#" data-original-title="Navy"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-red" href="shop-grid-left-sidebar.html#" data-original-title="Red"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-beige" href="shop-grid-left-sidebar.html#" data-original-title="Beige"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-maroon" href="shop-grid-left-sidebar.html#" data-original-title="Maroon"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-pink" href="shop-grid-left-sidebar.html#" data-original-title="Pink"></a>
         <a data-toggle="tooltip" data-placement="top" title="" class="color-bg bg-yellow" href="shop-grid-left-sidebar.html#" data-original-title="Yellow"></a>
         <a  title="" href="shop-grid-left-sidebar.html#">+ 37 more</a>
         </li>
         </ul>
         </div>
         </div>
         </aside>
         <hr>
         <aside class="sidebar_widget">
         <div class="widget_title">
         <h5 class="heading-design-h5">Size</h5>
         </div>
         <div class="card">
         <div class="collapse show">
         <div class="card-block">
         <ul class="trends">
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input" checked>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">X - Small <span class="item-numbers">203</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">Small <span class="item-numbers">16</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">Medium <span class="item-numbers">84</span></span>
         </label>  </li>
         <li><label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
         <input type="checkbox" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">Large <span class="item-numbers">95</span></span>
         </label>  </li>
         </ul>
         </div>
         </div>
         </aside>
         <hr>
         <aside class="sidebar_widget">
         <div class="widget_title">
         <h5 class="heading-design-h5">Discount</h5>
         </div>
         <div class="card">
         <div class="collapse show">
         <div class="card-block">
         <ul class="trends">
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input" checked>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">80% and above</span>
         </label></li><li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">70% and above</span>
         </label></li>
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">60% and above</span>
         </label></li>
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">50% and above</span>
         </label></li><li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">40% and above</span>
         </label></li>
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">30% and above</span>
         </label></li>
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">20% and above</span>
         </label></li>
         <li><label class="custom-control custom-radio">
         <input id="radio1" name="radio" type="radio" class="custom-control-input">
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">10% and above</span>
         </label></li>
         </ul>
         </div>
         </div>
         </aside>
         </div>
         </div>
         <hr>
         <a href="shop-grid-left-sidebar.html">
         <img class="rounded" src="images/women-top.png" alt="Bannar 1">
         </a>
         </div>
         <div class="col-lg-9 col-md-8">
         <div class="osahan-inner-slider">
         <div class="owl-carousel owl-carousel-slider">
            <div class="item">
            <a href="shop-grid-left-sidebar.html#"><img class="d-block img-fluid" src="{{asset('site/images/grid-slider/slider1.jpg')}}" alt="First slide"></a>
            </div>
            <div class="item">
            <a href="shop-grid-left-sidebar.html#"><img class="d-block img-fluid" src="{{asset('site/images/grid-slider/slider2.jpg')}}" alt="First slide"></a>
            </div>
            <div class="item">
            <a href="shop-grid-left-sidebar.html#"><img class="d-block img-fluid" src="{{asset('site/images/grid-slider/slider3.jpg')}}" alt="First slide"></a>
            </div>
         </div>  
         </div>
         <div class="osahan_products_top_filter row">
         <div class="col-lg-6 col-md-6 tags-action">
         <span>Clothing <a href="shop-grid-left-sidebar.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
         <span>John Players <a href="shop-grid-left-sidebar.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
         <span>X - Small <a href="shop-grid-left-sidebar.html#"><i class="icofont icofont-close-line-circled"></i></a></span>
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
         <a class="dropdown-item" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Popularity </a>
         <a class="dropdown-item" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> New </a>
         <a class="dropdown-item" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Discount </a>
         <a class="dropdown-item" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Price: Low to High </a>
         <a class="dropdown-item" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i> Price: High to Low </a>
         </div>
         </div>
         </div>
         </div>
         <div class="row products_page_list">
         <div class="clearfix"></div>
            @foreach($allData as $row)
            <div class="col-lg-3 col-md-6">
               <div class="item">
                  <div class="h-100">
                  <div class="product-item">
                  <span class="badge badge-info offer-badge">NEW</span> 
                  <div class="product-item-image">
                  <span class="like-icon"><a class="active" href="shop-grid-left-sidebar.html#"> <i class="icofont icofont-heart"></i></a></span>
                  <a href="{{url('product/'.$row->slug)}}"><img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" alt=""></a>
                  </div>
                  <div class="product-item-body">
                  <div class="product-item-action">
                  <a data-toggle="tooltip" data-placement="top" title="" class="btn btn-theme-round btn-sm" href="shop-grid-left-sidebar.html#" data-original-title="Add To Cart"><i class="icofont icofont-shopping-cart"></i></a>
                  <a data-toggle="tooltip" data-placement="top" title="" class="btn btn-theme-round btn-sm" href="shop-grid-left-sidebar.html#" data-original-title="View Detail"><i class="icofont icofont-search-alt-2"></i></a>
                  </div>
                  <h4 class="card-title"><a href="shop-grid-left-sidebar.html#">Ipsums Dolors Untra</a></h4>
                  <h5>
                  <span class="product-desc-price">$329.00</span>
                  <span class="product-price">$201.00</span>
                  <span class="product-discount">10% Off</span>
                  </h5>
                  </div>
                 {{--  <div class="product-item-footer">
                     <div class="product-item-size">
                     <strong>Size</strong> <span>S</span> <span>M</span> <span>L</span> <span> XL</span> <span> 2XL</span>
                     </div>
                     <div class="stars-rating">
                        <i class="icofont icofont-star active"></i>
                        <i class="icofont icofont-star active"></i>
                        <i class="icofont icofont-star"></i>
                        <i class="icofont icofont-star"></i>
                        <i class="icofont icofont-star"></i> <span>(613)</span>
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
               <li class="page-item disabled">
                  <a class="page-link" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
               </li>
               <li class="page-item active"><a class="page-link" href="shop-grid-left-sidebar.html#">1</a></li>
               <li class="page-item"><a class="page-link" href="shop-grid-left-sidebar.html#">2</a></li>
               <li class="page-item"><a class="page-link" href="shop-grid-left-sidebar.html#">3</a></li>
               <li class="page-item"><a class="page-link" href="shop-grid-left-sidebar.html#">4</a></li>
               <li class="page-item"><a class="page-link" href="shop-grid-left-sidebar.html#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
            </ul>
         </nav> --}}

         {{ $allData->links() }}

         </div>
         </div>
         </div>
      </div>
   </section>
@endsection

@section('page-script')

@endsection