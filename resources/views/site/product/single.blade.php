@extends('site.layouts.default')

@section('htmlheader_title')
    {{$singleData->name}} | Products
@endsection

@section('body_class')
@endsection

@section('body_inner_class')
@endsection

{{-- @section('page-style-2')
  <link rel="stylesheet" href="{{ asset('site/js/vendor/photoswipe/css/photoswipe.css') }}" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('site/js/vendor/photoswipe/css/default-skin/default-skin.css') }}" type="text/css" media="all" />
@endsection --}}

@section('page-style')
    {{-- <link href="{{ asset('/plugins/lightGallery-master/dist/css/lightgallery.css')}}" rel="stylesheet"> --}}
    <style>
       .xzoom-thumbs {margin-top: 5px; padding-top: 10px;}
       .xzoom-lens {border: 1px solid #555; -webkit-box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06); box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06); border-radius: 10px;}
       .xzoom-preview {border: 1px solid #888;background: #2f4f4f;/*box-shadow: 0px 0px 10px rgba(0,0,0,0.50);*/box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06);border-radius: 10px;}
       .product_info_button ul li a.active {color: #81d742;border-bottom: 5px solid #81d742;}
       #video-gallery {position: absolute;right: 35px;top: 21px;z-index: 1;}
       #video-gallery a {background: #81d742 none repeat scroll 0 0;border-radius: 22px;color: #ffffff;padding: 6px 10px;font-weight: 600;}
       .dark .tab-product .nav-material.nav-tabs .nav-item .nav-link.active {color: #2690e4;}
       .tab-product .nav-material.nav-tabs .nav-item .material-border, .product-full-tab .nav-material.nav-tabs .nav-item .material-border {border-bottom: 2px solid #2690e4;opacity: 0;}
       .modal-header {border-bottom: 1px solid #1a1d20;}
       .modal-footer {border-top: 1px solid #1a1d20;}
       .table th, .table td {padding: 0.3rem 1rem;vertical-align: middle;}
       .list-group-item-dark {background-color: #262626;}
       .btn_add_to_cart{padding: 10px 40px;}
       .btn_warning{background-color: #ffd626; border-radius: 10px; border: none; font-size: 12px;}
       /*.table-dark {color: #fff;background-color: #1b1b1b;}*/
       .card_warning{background: #262626;border: 2px dashed #ffd626;color: #f1f2ec;border-radius: 10px;}
       .basic_info .list-group-item {padding: 0.25rem 0rem;/*margin-bottom: -1px;*/background-color: #1b1b1b;border: 1px solid rgba(0,0,0,0.125);font-weight: 900;}
       .basic_info .badge {font-size: 100%;}
       .table-dark {color: #fff;background-color: #262626;}
       .table_attribute th{background-color: #1b1b1b;}
       .list-group-item {padding: 0.4rem 0.5rem;}

       /* padding-bottom and top for image */
      /* .mfp-no-margins img.mfp-img {
           padding: 0;
       }*/
       /* position of shadow behind the image */
      /* .mfp-no-margins .mfp-figure:after {
           top: 0;
           bottom: 0;
       }*/
       /* padding for main container */
       /*.mfp-no-margins .mfp-container {
           padding: 0;
       }*/
       .mfp-with-zoom .mfp-container,
       .mfp-with-zoom.mfp-bg {
           opacity: 0;
           -webkit-backface-visibility: hidden;
           -webkit-transition: all 0.3s ease-out; 
           -moz-transition: all 0.3s ease-out; 
           -o-transition: all 0.3s ease-out; 
           transition: all 0.3s ease-out;
       }

       .mfp-with-zoom.mfp-ready .mfp-container {
               opacity: 1;
       }
       .mfp-with-zoom.mfp-ready.mfp-bg {
               opacity: 0.8;
       }

       .mfp-with-zoom.mfp-removing .mfp-container, 
       .mfp-with-zoom.mfp-removing.mfp-bg {
           opacity: 0;
       }

       .is_disclaimer_agreement_enabled{background-color: #1b1b1b; border: 1px dashed #ff0000; border-radius: 10px;}
       .is_warning_enabled{background-color: #1b1b1b; border: 1px dashed #f0c107; border-radius: 10px;}
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                          <h2>{{$singleData->title}}</h2>
                          <ul>
                              <li><a href="{{ url('/') }}#">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a href="{{ url('products') }}#">products</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a href="product-page(left-image).html#">{{$singleData->title}}</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- section start -->
  <section class="section-big-pt-space bg-light">
      <div class="collection-wrapper">
          <div class="custom-container">
              <div class="row">
                @if ($photos->isNotEmpty())
                  <div class="col-lg-1 col-sm-2 col-xs-12">
                      <div class="row">
                          <div class="col-12 p-0">
                              <div class="slider-right-nav">
                                  @foreach($photos as $img)
                                      <div><img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-{{ $img->id }}"></div>
                                  @endforeach

                                  {{-- <div><img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-0"></div> --}}
                                  {{-- <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                                  <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                                  <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div> --}}
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-5 col-sm-10 col-xs-12 order-up parent-container">
                      <div class="product-right-slick no-arrow">
                          @foreach($photos as $img)
                              <div>
                                <a href="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}">
                                  <img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-{{ $img->id }}">
                                </a>
                              </div>
                          @endforeach
                          {{-- <div><img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-0"></div> --}}
                          {{-- <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                          <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                          <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div> --}}
                      </div>
                  </div>
                @else
                  <div class="col-lg-6 rtl-text parent-container_">
                     @if($singleData->main_image)
                      {{-- <a href="{{asset('storage/products/images/'.$singleData->main_image)}}"> --}}
                        <img class="img-fluid w-100" src="{{asset('storage/products/images/'.$singleData->main_image)}}" alt="{{ $singleData->title }}">
                      {{-- </a> --}}
                     @else
                          <img class="img-fluid w-100" src="{{asset('site/defaults/image-not-found.png')}}" alt="{{ $singleData->title }}">
                     @endif
                  </div>
                @endif
                
                  {{-- <div class="col-lg-1 col-sm-2 col-xs-12">
                      <div class="row">
                          <div class="col-12 p-0">
                              <div class="slider-right-nav">
                                  <div><img src="../assets/images/product-sidebar/001.jpg" alt="" class="img-fluid  image_zoom_cls-0"></div>
                                  <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                                  <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                                  <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div>
                              </div>
                          </div>
                      </div>
                  </div> --}}
                  {{-- <div class="col-lg-5 col-sm-10 col-xs-12 order-up">
                      <div class="product-right-slick no-arrow">
                          <div><img src="../assets/images/product-sidebar/001.jpg" alt="" class="img-fluid  image_zoom_cls-0"></div>
                          <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                          <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                          <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div>
                      </div>
                  </div> --}}
                  <div class="col-lg-6 rtl-text">
                      <div class="product-right">
                          <h2>{{ $singleData->title }}</h2>
                          {{-- <h4><del>$459.00</del><span>55% off</span></h4> --}}
                          @if($singleData->is_retail_price_enabled == 1)
                            <h3>{{ $option->currency_symbol }}{{ number_format($singleData->retail_price, 2) }}</h3>
                          @endif

                          {{-- <ul class="color-variant">
                              <li class="bg-light0"></li>
                              <li class="bg-light1"></li>
                              <li class="bg-light2"></li>
                          </ul> --}}

                          @if($singleData->is_in_stock())
                            {{-- {!!Form::open(['url'=> $singleData->id.'/item', 'autocomplete'=>'off'])!!} --}}
                            {!!Form::open(['url'=> $singleData->slug.'/item', 'autocomplete'=>'off'])!!}
                            {!!csrf_field()!!}
                            <input type="hidden" name="type" value="0">
                              <div class="product-description border-product">
                                  {{-- <h6 class="product-title size-text">select size <span><a href="product-page(left-image).html" data-toggle="modal" data-target="#sizemodal">size chart</a></span></h6>
                                  <div class="modal fade" id="sizemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Sheer Straight Kurta</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              </div>
                                              <div class="modal-body"><img src="../assets/images/size-chart.jpg" alt="" class="img-fluid "></div>
                                          </div>
                                      </div>
                                  </div> --}}
                                  {{-- <div class="size-box">
                                      <ul>
                                          <li class="active"><a href="product-page(left-image).html#">s</a></li>
                                          <li><a href="product-page(left-image).html#">m</a></li>
                                          <li><a href="product-page(left-image).html#">l</a></li>
                                          <li><a href="product-page(left-image).html#">xl</a></li>
                                      </ul>
                                  </div> --}}
                                  <h6 class="product-title">quantity</h6>
                                  {{-- <div class="qty-box">
                                      <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                          <input type="text" name="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                                  </div> --}}

                                  <div class="qty-box">
                                      <div class="input-group">
                                        <span class="input-group-prepend">
                                          <button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button>
                                        </span>
                                          <input type="text" name="qty" class="form-control input-number"  step="1" value="1" min="1" max="{{$singleData->availableQuantity()}}">
                                          <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button>
                                        </span>
                                      </div>
                                  </div>
                              </div>
                            

                            {{-- <div class="product-buttons">
                              <a href="product-page(left-image).html#" data-toggle="modal" data-target="#addtocart" class="btn btn-normal">add to cart</a> 
                              <a href="product-page(left-image).html#" class="btn btn-normal">buy now</a>
                            </div> --}}

                            <div class="product-buttons">
                              {{-- <a href="#" data-toggle="modal" data-target="#addtocart" class="btn btn-normal">add to cart</a>  --}}
                              {{-- <a href="#" class="btn btn-normal">buy now</a> --}}

                              {{-- <input class="b_r_42" type="number" value="1" min="1" max="{{$singleData->availableQuantity()}}" step="1" name="qty" id="ajax-qty" /> --}}
                              <button class="btn btn-normal btn_add_to_cart" type="submit">Add to Cart</button>  
                            </div>

                            {!! Form::close() !!}
                          @endif

                          @if(!$singleData->is_in_stock())
                              <div class="product-description border-product">
                                <button type="button" class="btn btn-normal" data-toggle="modal" data-target="#notifyMe"> NOTIFY WHEN IN STOCK</button>
                                <div class="modal fade" id="notifyMe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    {!!Form::open(['url'=> 'product-notification/'.$singleData->id, 'autocomplete'=>'off', 'class' => 'theme-form'])!!}
                                    {!!csrf_field()!!}
                                    <div class="modal-content bg-dark-2">
                                      <div class="modal-header">
                                        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Back in stock notification</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="mb-5">
                                              <div class="text-center">
                                                  @if($singleData->main_image)
                                                      <img class="img-fluid w-50" src="{{asset('storage/products/images/'.$singleData->main_image)}}" alt="{{ $singleData->title }}">
                                                  @else
                                                       <img class="img-fluid w-50" src="{{asset('site/defaults/image-not-found.png')}}" alt="{{ $singleData->title }}">
                                                  @endif
                                                  <h5 class="mt-3">{{ $singleData->product_description }}</h5>
                                              </div>
                                          </div>

                                          <div class="row">
                                              <div class="text-center col-md-8 mx-auto text-light mb-2">Pleae Enter Your Email address we will notify you when the product is back in stock</div>
                                              {!! Form::hidden('store_type', '0') !!}
                                              {!! Form::hidden('title', $singleData->title) !!}
                                              <div class="form-group col-md-12 {{ $errors->has('notification_email') ? 'has-error' : '' }}}">
                                                {{-- <label>Pleae Enter Your Email address we will notify you when the product is back in stock <span>*</span></label> --}}
                                                {!!Form::text('notification_email', null, array('class' => 'form-control br_20', 'placeholder' => 'Email', 'required'))!!}
                                                <em class="error-msg">{!!$errors->first('notification_email')!!}</em>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary br_20" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary br_20">Notify Me</button>
                                      </div>
                                    </div>
                                    {!! Form::close() !!}
                                  </div>
                                </div>
                              </div>
                          @endif

                          {{-- <div class="border-product">
                              <h6 class="product-title">product details</h6>
                              <p>{!! $singleData->content !!}</p>

                              <table class="table table-borderless table-dark">

                                <tbody>
                                  <tr>
                                    <th scope="row">UPC</th>
                                    <td>{{ $singleData->upc ?? '---' }}</td>
                                  </tr>

                                  <tr>
                                    <th scope="row">Manufacturer</th>
                                    <td>{{ $singleData->full_manufacturer_name ?? '---' }}</td>
                                  </tr>

                                  <tr>
                                    <th scope="row">Manufacturer Part Number</th>
                                    <td>{{ $singleData->manufacturer_part_number ?? '---' }}</td>
                                  </tr>

                                  <tr>
                                    <th scope="row">Model</th>
                                    <td>{{ $singleData->model ?? '---' }}</td>
                                  </tr>
                                </tbody>
                              </table>
                          </div> --}}


                          <div class="border-product pb-0 basic_info">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    UPC
                                    <span class="badge badge-dark badge-pill">{{ $singleData->upc ?? '---' }}</span>
                                  </li>
                                  {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                    RSR Stock #
                                    <span class="badge badge-dark badge-pill">{{ $singleData->rsr_stock_number ?? '---' }}</span>
                                  </li> --}}
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                   Manufacturer
                                    <span class="badge badge-dark badge-pill">{{ $singleData->full_manufacturer_name ?? '---' }}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Manufacturer Part Number
                                    <span class="badge badge-dark badge-pill">{{ $singleData->manufacturer_part_number ?? '---' }}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                   Model
                                    <span class="badge badge-dark badge-pill">{{  $singleData->has_model ? $singleData->has_model->name : "---" }}</span>
                                  </li>
                                </ul>
                          </div>



                          <div class="border-product">
                              @if($singleData->is_disclaimer_agreement_enabled == 1)
                                <div class="alert alert-danger is_disclaimer_agreement_enabled text-danger" role="alert">
                                  <h4 class="alert-heading text-danger">Disclaimer Agreement</h4>
                                  {{ $option->disclaimer_agreement_message }}
                                </div>
                              @endif

                              @if($singleData->is_warning_enabled ==1)
                                <div class="alert alert-warning is_warning_enabled text-warning" role="alert">
                                  <h4 class="alert-heading text-warning">Warning</h4>
                                  {{ $option->warning_message }}
                                </div>
                              @endif
                          </div>

                          {{-- <div class="border-product">
                              <div class="product-icon">
                                  <ul class="product-social">
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-facebook"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-google-plus"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-twitter"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-instagram"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-rss"></i></a></li>
                                  </ul>
                                  <form class="d-inline-block">
                                      <button class="wishlist-btn"><i class="fa fa-heart"></i><span class="title-font">Add To WishList</span></button>
                                  </form>
                              </div>
                          </div> --}}

                          {{-- <div class="border-product pb-0">
                              <h6 class="product-title">Time Reminder</h6>
                              <div class="timer">
                                  <p id="demo"><span>25 <span class="padding-l">:</span> <span class="timer-cal">Days</span> </span><span>22 <span class="padding-l">:</span> <span class="timer-cal">Hrs</span> </span><span>13 <span class="padding-l">:</span> <span class="timer-cal">Min</span> </span><span>57 <span class="timer-cal">Sec</span></span>
                                  </p>
                              </div>
                          </div> --}}

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- Section ends -->

  <!-- product-tab starts -->
  <section class=" tab-product tab-exes">
      <div class="custom-container">
          <div class="row">
              <div class="col-sm-12 col-lg-12">
                  <div class="creative-card creative-inner  mb-4">
                      <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                          <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Product Details</a>
                              <div class="material-border"></div>
                          </li>
                      </ul>
                      <div class="tab-content nav-material" id="top-tabContent">
                          <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                            {!! $singleData->content !!}
                          </div>
                          <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                              <div class="single-product-tables">
                                <table class="table table-dark table-striped_ w-100">
                                    <tbody>
                                      <tr>
                                        <th> RSR Stock Number </th>
                                        <td>{{ $singleData->rsr_stock_number ?? '---' }}</td>
                                        <th> UPC Code </th>
                                        <td>{{ $singleData->upc_code ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Product Description </th>
                                        <td>{{ $singleData->product_description ?? '---' }}</td>
                                        <th> Department Number </th>
                                        <td>{{ $singleData->department_number ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Manufacturer Id</th>
                                        <td>{{ $singleData->manufacturer_id ?? '---' }}</td>
                                        <th>Retail Price</th>
                                        <td>{{ $singleData->retail_price ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>RSR Pricing </th>
                                        <td>{{ $singleData->rsr_pricing ?? '---' }}</td>
                                        <th>Product Weight</th>
                                        <td>{{ $singleData->product_weight ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Inventory Quantity</th>
                                        <td>{{ $singleData->inventory_quantity ?? '---' }}</td>
                                        <th>Model</th>
                                        <td>{{ $singleData->model ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Full Manufacturer Name</th>
                                        <td>{{ $singleData->full_manufacturer_name ?? '---' }}</td>
                                        <th>Manufacturer Part Number</th>
                                        <td>{{ $singleData->manufacturer_part_number ?? '---' }}</td>
                                      </tr>

                                      {{-- <tr>
                                        <th>Allocated/Closeout/Deleted</th>
                                        <td>{{ $singleData->allocated_closeout_deleted }}</td>
                                        <th>Expanded Product Description</th>
                                        <td>{{ $singleData->expanded_product_description }}</td>
                                      </tr> --}}

                                      <tr>
                                        <th>Ground Shipments Only</th>
                                        <td>{{ $singleData->ground_shipments_only ?? '---' }}</td>
                                        <th>Adult Signature Required</th>
                                        <td>{{ $singleData->adult_signature_required ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Blocked from Drop Ship</th>
                                        <td>{{ $singleData->blocked_from_dropship ?? '---' }}</td>
                                        <th>Date Entered</th>
                                        <td>{{ $singleData->date_entered ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Retail MAP</th>
                                        <td>{{ $singleData->retail_map ?? '---' }}</td>
                                        <th>Image Disclaimer</th>
                                        <td>{{ $singleData->image_disclaimer ?? '---' }}</td>
                                      </tr>

                                      <tr>
                                        <th>Shipping Length</th>
                                        <td>{{ $singleData->shipping_length ?? '---' }}</td>
                                        <th>Shipping Width</th>
                                        <td>{{ $singleData->shipping_width ?? '---' }}</td>
                                      </tr>

                                      {{-- <tr>
                                        <th>Shipping Height</th>
                                        <td>{{ $singleData->shipping_height ?? '---' }}</td>
                                        <th>prop_65</th>
                                        <td>{{ $singleData->prop_65 ?? '---' }}</td>
                                      </tr> --}}

                                      {{-- <tr>
                                        <th>Vendor Approval Required</th>
                                        <td>{{ $singleData->vendor_approval_required ?? '---' }}</td>
                                      </tr> --}}


                                      {{-- <tr>
                                        <th>xxx</th>
                                        <td>{{ $singleData->rsr_stock_number }}</td>
                                        <th>xxx</th>
                                        <td>{{ $singleData->rsr_stock_number }}</td>
                                      </tr> --}}

                                      

                                    {{-- <tr>
                                        <td> RSR Stock Number </td>
                                        <td> UPC Code</td>
                                        <td> Manufacturer Id</td>
                                        <td> Column 3</td>
                                    </tr> --}}
                                   
                                   
                                    </tbody>
                                </table>

                                  {{-- <table>
                                      <tbody>
                                      <tr>
                                          <td>Febric</td>
                                          <td>Chiffon</td>
                                      </tr>
                                      <tr>
                                          <td>Color</td>
                                          <td>Red</td>
                                      </tr>
                                      <tr>
                                          <td>Material</td>
                                          <td>Crepe printed</td>
                                      </tr>
                                      </tbody>
                                  </table> --}}
                                  {{-- <table>
                                      <tbody>
                                      <tr>
                                          <td>Length</td>
                                          <td>50 Inches</td>
                                      </tr>
                                      <tr>
                                          <td>Size</td>
                                          <td>S, M, L .XXL</td>
                                      </tr>
                                      </tbody>
                                  </table> --}}
                              </div>

                            {{--   <div class="single-product-tables">
                                  <table>
                                      <tbody>
                                      <tr>
                                          <td>Febric</td>
                                          <td>Chiffon</td>
                                      </tr>
                                      <tr>
                                          <td>Color</td>
                                          <td>Red</td>
                                      </tr>
                                      <tr>
                                          <td>Material</td>
                                          <td>Crepe printed</td>
                                      </tr>
                                      </tbody>
                                  </table>
                                  <table>
                                      <tbody>
                                      <tr>
                                          <td>Length</td>
                                          <td>50 Inches</td>
                                      </tr>
                                      <tr>
                                          <td>Size</td>
                                          <td>S, M, L .XXL</td>
                                      </tr>
                                      </tbody>
                                  </table>
                              </div> --}}
                          </div>
                      </div>
                  </div>

                  <div class="creative-card creative-inner  mb-4">
                      <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                          <li class="nav-item"><a class="nav-link active" id="profile-top-tab" data-toggle="tab" href="#top-profile" role="tab" aria-selected="false">Specification</a>
                              <div class="material-border"></div>
                          </li>
                      </ul>
                      <div class="tab-content nav-material" id="top-tabContent">
                          <div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <div class="table-responsive mt-3 table_attribute">
                                <table class="table table-dark mb-0">
                                  <tbody>
                                        <tr>
                                            <th> UPC </th>
                                            <td>{{ $singleData->upc ?? '---' }}</td>
                                            <th>Manufacturer</th>
                                            <td>{{ $singleData->full_manufacturer_name ?? '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Manufacturer Part #</th>
                                            <td>{{ $singleData->manufacturer_part_number ?? '---' }}</td>
                                            <th>Model</th>
                                            <td>{{ $singleData->has_model ? $singleData->has_model->name : '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Product Weight</th>
                                            <td>{{ $singleData->weight ?? '---' }}</td>
                                            <th>Shipping Height</th>
                                            <td>{{ $singleData->height ?? '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Shipping Length</th>
                                            <td>{{ $singleData->length ?? '---' }}</td>
                                            <th>Shipping Width</th>
                                            <td>{{ $singleData->width ?? '---' }}</td>
                                        </tr>

                                        
                                            <tr>
                                                @if($singleData->accessories)
                                                    <th>Accessories</th>
                                                    <td>{{ $singleData->accessories }}</td>
                                                @endif
                                                @if($singleData->action)
                                                    <th>Action</th>
                                                    <td>{{ $singleData->action }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->type_of_barrel)
                                                    <th>Type of barrel</th>
                                                    <td>{{ $singleData->type_of_barrel }}</td>
                                                @endif
                                                @if($singleData->barrel_length)
                                                    <th>Barrel Length</th>
                                                    <td>{{ $singleData->barrel_length }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                               @if($singleData->catalog_code)
                                                   <th>Catalog Code</th>
                                                   <td>{{ $singleData->catalog_code }}</td>
                                               @endif
                                               @if($singleData->chamber)
                                                   <th>Chamber</th>
                                                   <td>{{ $singleData->chamber }}</td>
                                               @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->chokes)
                                                    <th>Chokes</th>
                                                    <td>{{ $singleData->chokes }}</td>
                                                @endif
                                                @if($singleData->condition)
                                                    <th>Condition</th>
                                                    <td>{{ $singleData->condition }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->capacity)
                                                    <th>Capacity</th>
                                                    <td>{{ $singleData->capacity }}</td>
                                                @endif
                                                @if($singleData->description)
                                                    <th>Description</th>
                                                    <td>{{ $singleData->description }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                              @if($singleData->dram)
                                                  <th>Dram</th>
                                                  <td>{{ $singleData->dram }}</td>
                                              @endif
                                              @if($singleData->edge)
                                                  <th>Edge</th>
                                                  <td>{{ $singleData->edge }}</td>
                                              @endif  
                                            </tr>

                                            <tr>
                                                @if($singleData->firing_casing)
                                                    <th>Firing Casing</th>
                                                    <td>{{ $singleData->firing_casing }}</td>
                                                @endif
                                                @if($singleData->finish)
                                                    <th>Finish</th>
                                                    <td>{{ $singleData->finish }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->fit)
                                                    <th>Fit</th>
                                                    <td>{{ $singleData->fit }}</td>
                                                @endif
                                                @if($singleData->fit_2)
                                                    <th>Fit 2</th>
                                                    <td>{{ $singleData->fit_2 }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->feet_per_second)
                                                    <th>Feet per second</th>
                                                    <td>{{ $singleData->feet_per_second }}</td>
                                                @endif
                                                @if($singleData->frame)
                                                    <th>Frame</th>
                                                    <td>{{ $singleData->frame }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->caliber)
                                                    <th>Caliber</th>
                                                    <td>{{ $singleData->caliber }}</td>
                                                @endif
                                                @if($singleData->caliber_2)
                                                    <th>Caliber 2</th>
                                                    <td>{{ $singleData->caliber_2 }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->grain_weight)
                                                    <th>Grain Weight</th>
                                                    <td>{{ $singleData->grain_weight }}</td>
                                                @endif
                                                @if($singleData->grips)
                                                    <th>Grip</th>
                                                    <td>{{ $singleData->grips }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->hand)
                                                    <th>Hand</th>
                                                    <td>{{ $singleData->hand }}</td>
                                                @endif
                                                @if($singleData->manufacturer_weight)
                                                    <th>Manufacturer Weight</th>
                                                    <td>{{ $singleData->manufacturer_weight }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->moa)
                                                    <th>Moa</th>
                                                    <td>{{ $singleData->moa }}</td>
                                                @endif
                                                @if($singleData->model)
                                                    <th>Model</th>
                                                    <td>{{ $singleData->model }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->model_1)
                                                    <th>Model 1</th>
                                                    <td>{{ $singleData->model_1 }}</td>
                                                @endif
                                                @if($singleData->new_stock)
                                                    <th>New Stock</th>
                                                    <td>{{ $singleData->new_stock }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->nsn)
                                                    <th>NSN</th>
                                                    <td>{{ $singleData->nsn }}</td>
                                                @endif
                                                @if($singleData->objective)
                                                    <th>Objective</th>
                                                    <td>{{ $singleData->objective }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->ounce_of_shot)
                                                    <th>Ounce of shot</th>
                                                    <td>{{ $singleData->ounce_of_shot }}</td>
                                                @endif
                                                @if($singleData->packaging)
                                                    <th>Packaging</th>
                                                    <td>{{ $singleData->packaging }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->power)
                                                    <th>Power</th>
                                                    <td>{{ $singleData->power }}</td>
                                                @endif
                                                @if($singleData->reticle)
                                                    <th>Reticle</th>
                                                    <td>{{ $singleData->reticle }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->safety)
                                                    <th>Safety</th>
                                                    <td>{{ $singleData->safety }}</td>
                                                @endif
                                                @if($singleData->sights)
                                                    <th>Sights</th>
                                                    <td>{{ $singleData->sights }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->size)
                                                    <th>Size</th>
                                                    <td>{{ $singleData->size }}</td>
                                                @endif
                                                @if($singleData->type)
                                                    <th>Type</th>
                                                    <td>{{ $singleData->type }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->units_per_box)
                                                    <th>Units per box</th>
                                                    <td>{{ $singleData->units_per_box }}</td>
                                                @endif
                                                @if($singleData->units_per_case)
                                                    <th>Units per case</th>
                                                    <td>{{ $singleData->units_per_case }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->wt_characteristics)
                                                    <th>WT Characteristics</th>
                                                    <td>{{ $singleData->wt_characteristics }}</td>
                                                @endif
                                                {{-- @if($singleData->sub_category)
                                                    <th>Sub Category</th>
                                                    <td>{{ $singleData->sub_category }}</td>
                                                @endif --}}
                                            </tr>

                                            <tr>
                                                @if($singleData->diameter)
                                                    <th>Diameter</th>
                                                    <td>{{ $singleData->diameter }}</td>
                                                @endif
                                                @if($singleData->color)
                                                    <th>Color</th>
                                                    <td>{{ $singleData->color }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->material)
                                                    <th>Material</th>
                                                    <td>{{ $singleData->material }}</td>
                                                @endif
                                                @if($singleData->stock)
                                                    <th>Stock</th>
                                                    <td>{{ $singleData->stock }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->lens_color)
                                                    <th>Lens Color</th>
                                                    <td>{{ $singleData->lens_color }}</td>
                                                @endif
                                                @if(!empty(trim($singleData->handle_color)))
                                                    <th>Handle Color</th>
                                                    <td>{{ $singleData->handle_color }}</td>
                                                @endif
                                            </tr>
                                       
                                    </tbody>
                                    {{-- <tbody>
                                        <tr>
                                            <th> UPC </th>
                                            <td>{{ $singleData->upc_code ?? '---' }}</td>
                                            <th>Manufacturer</th>
                                            <td>{{ $singleData->full_manufacturer_name ?? '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Manufacturer Part #</th>
                                            <td>{{ $singleData->manufacturer_part_number ?? '---' }}</td>
                                            <th>Model</th>
                                            <td>{{ $singleData->model ?? '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Product Weight</th>
                                            <td>{{ $singleData->product_weight ?? '---' }}</td>
                                            <th>Shipping Height</th>
                                            <td>{{ $singleData->shipping_height ?? '---' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Shipping Length</th>
                                            <td>{{ $singleData->shipping_length ?? '---' }}</td>
                                            <th>Shipping Width</th>
                                            <td>{{ $singleData->shipping_width ?? '---' }}</td>
                                        </tr>

                                        @if($singleData->rsr_attribute)
                                            <tr>
                                                @if($singleData->rsr_attribute->accessories)
                                                    <th>Accessories</th>
                                                    <td>{{ $singleData->rsr_attribute->accessories }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->action)
                                                    <th>Action</th>
                                                    <td>{{ $singleData->rsr_attribute->action }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->type_of_barrel)
                                                    <th>Type of barrel</th>
                                                    <td>{{ $singleData->rsr_attribute->type_of_barrel }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->barrel_length)
                                                    <th>Barrel Length</th>
                                                    <td>{{ $singleData->rsr_attribute->barrel_length }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                               @if($singleData->rsr_attribute->catalog_code)
                                                   <th>Catalog Code</th>
                                                   <td>{{ $singleData->rsr_attribute->catalog_code }}</td>
                                               @endif
                                               @if($singleData->rsr_attribute->chamber)
                                                   <th>Chamber</th>
                                                   <td>{{ $singleData->rsr_attribute->chamber }}</td>
                                               @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->chokes)
                                                    <th>Chokes</th>
                                                    <td>{{ $singleData->rsr_attribute->chokes }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->condition)
                                                    <th>Condition</th>
                                                    <td>{{ $singleData->rsr_attribute->condition }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->capacity)
                                                    <th>Capacity</th>
                                                    <td>{{ $singleData->rsr_attribute->capacity }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->description)
                                                    <th>Description</th>
                                                    <td>{{ $singleData->rsr_attribute->description }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                              @if($singleData->rsr_attribute->dram)
                                                  <th>Dram</th>
                                                  <td>{{ $singleData->rsr_attribute->dram }}</td>
                                              @endif
                                              @if($singleData->rsr_attribute->edge)
                                                  <th>Edge</th>
                                                  <td>{{ $singleData->rsr_attribute->edge }}</td>
                                              @endif  
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->firing_casing)
                                                    <th>Firing Casing</th>
                                                    <td>{{ $singleData->rsr_attribute->firing_casing }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->finish)
                                                    <th>Finish</th>
                                                    <td>{{ $singleData->rsr_attribute->finish }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->fit)
                                                    <th>Fit</th>
                                                    <td>{{ $singleData->rsr_attribute->fit }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->fit_2)
                                                    <th>Fit 2</th>
                                                    <td>{{ $singleData->rsr_attribute->fit_2 }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->feet_per_second)
                                                    <th>Feet per second</th>
                                                    <td>{{ $singleData->rsr_attribute->feet_per_second }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->frame)
                                                    <th>Frame</th>
                                                    <td>{{ $singleData->rsr_attribute->frame }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->caliber)
                                                    <th>Caliber</th>
                                                    <td>{{ $singleData->rsr_attribute->caliber }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->caliber_2)
                                                    <th>Caliber 2</th>
                                                    <td>{{ $singleData->rsr_attribute->caliber_2 }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->grain_weight)
                                                    <th>Grain Weight</th>
                                                    <td>{{ $singleData->rsr_attribute->grain_weight }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->grips)
                                                    <th>Grip</th>
                                                    <td>{{ $singleData->rsr_attribute->grips }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->hand)
                                                    <th>Hand</th>
                                                    <td>{{ $singleData->rsr_attribute->hand }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->manufacturer_weight)
                                                    <th>Manufacturer Weight</th>
                                                    <td>{{ $singleData->rsr_attribute->manufacturer_weight }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->moa)
                                                    <th>Moa</th>
                                                    <td>{{ $singleData->rsr_attribute->moa }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->model)
                                                    <th>Model</th>
                                                    <td>{{ $singleData->rsr_attribute->model }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->model_1)
                                                    <th>Model 1</th>
                                                    <td>{{ $singleData->rsr_attribute->model_1 }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->new_stock)
                                                    <th>New Stock</th>
                                                    <td>{{ $singleData->rsr_attribute->new_stock }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->nsn)
                                                    <th>NSN</th>
                                                    <td>{{ $singleData->rsr_attribute->nsn }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->objective)
                                                    <th>Objective</th>
                                                    <td>{{ $singleData->rsr_attribute->objective }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->ounce_of_shot)
                                                    <th>Ounce of shot</th>
                                                    <td>{{ $singleData->rsr_attribute->ounce_of_shot }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->packaging)
                                                    <th>Packaging</th>
                                                    <td>{{ $singleData->rsr_attribute->packaging }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->power)
                                                    <th>Power</th>
                                                    <td>{{ $singleData->rsr_attribute->power }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->reticle)
                                                    <th>Reticle</th>
                                                    <td>{{ $singleData->rsr_attribute->reticle }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->safety)
                                                    <th>Safety</th>
                                                    <td>{{ $singleData->rsr_attribute->safety }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->sights)
                                                    <th>Sights</th>
                                                    <td>{{ $singleData->rsr_attribute->sights }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->size)
                                                    <th>Size</th>
                                                    <td>{{ $singleData->rsr_attribute->size }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->type)
                                                    <th>Type</th>
                                                    <td>{{ $singleData->rsr_attribute->type }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->units_per_box)
                                                    <th>Units per box</th>
                                                    <td>{{ $singleData->rsr_attribute->units_per_box }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->units_per_case)
                                                    <th>Units per case</th>
                                                    <td>{{ $singleData->rsr_attribute->units_per_case }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->wt_characteristics)
                                                    <th>WT Characteristics</th>
                                                    <td>{{ $singleData->rsr_attribute->wt_characteristics }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->sub_category)
                                                    <th>Sub Category</th>
                                                    <td>{{ $singleData->rsr_attribute->sub_category }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->diameter)
                                                    <th>Diameter</th>
                                                    <td>{{ $singleData->rsr_attribute->diameter }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->color)
                                                    <th>Color</th>
                                                    <td>{{ $singleData->rsr_attribute->color }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->material)
                                                    <th>Material</th>
                                                    <td>{{ $singleData->rsr_attribute->material }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->stock)
                                                    <th>Stock</th>
                                                    <td>{{ $singleData->rsr_attribute->stock }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if($singleData->rsr_attribute->lens_color)
                                                    <th>Lens Color</th>
                                                    <td>{{ $singleData->rsr_attribute->lens_color }}</td>
                                                @endif
                                                @if(!empty(trim($singleData->rsr_attribute->handle_color)))
                                                    <th>Handle Color</th>
                                                    <td>{{ $singleData->rsr_attribute->handle_color }}</td>
                                                @endif
                                            </tr>
                                        @endif
                                    </tbody> --}}
                                </table>
                            </div>

                          </div>
                          
                          
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- product-tab ends -->

  <!-- related products -->
  <section class="section-big-py-space  ratio_asos bg-light">
      <div class="custom-container">
          <div class="row">
              <div class="col-12 product-related">
                  <h2>related products</h2>
              </div>
          </div>
          <div class="row ">
                <div class="col-12 product">
                    <div class="product-slide-6 no-arrow">
                        @foreach($otherData as $row)
                            @include('site.product.product_loop')
                        @endforeach
                    </div>
              </div>
          </div>
      </div>
  </section>
  <!-- related products -->

@endsection

@section('page-script')
  <link rel="stylesheet" href="{{ asset('plugins/Magnific-Popup-master/dist/magnific-popup.css') }}">
  <script src="{{ asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup.js') }}"></script>
  <script>
      $(document).ready(function() {
          // $('.image-link').magnificPopup({type:'image'});
          $('.parent-container').magnificPopup({
              delegate: 'a',
              type: 'image',
              gallery:{
                  enabled:true
              },
              closeOnContentClick: true,
              closeBtnInside: false,
              fixedContentPos: true,
              mainClass: 'mfp-no-margins mfp-with-zoom',
              image: {
                  verticalFit: true
              },
              zoom: {
                  enabled: true,
                  duration: 300 // don't foget to change the duration also in CSS
              }
          });
      });
  </script>


    {{-- <script>
        $("input[type='number']").inputSpinner()
    </script> --}}

    {{-- <script>
        $(document).ready(function () {
            $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
                // disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        });
    </script> --}}

    {{-- <script>
        //Add to Cart
        function wall_like(id) {
            console.log(id);
            var splits = id.split("_");
            var wid = splits[1];  // WallId
            var base_url = $('#url').data("field-id");
            var APP_URL = {!! json_encode(url('/')) !!};
            // alert(APP_URL);

            // AJAX Request
            $.ajax({
                url: APP_URL+'/'+wid+'/item',
                type: 'GET',
                data: {wid:wid},
                dataType: 'json',
                success: function(data){
                    toastr.success(data.cart.name + ' ' +'Product has been added to your basket.');
                    $( ".cart-value" ).text(data.cartItems.count);
                    // $( "#ajax-show" ).addClass("show");
                    // $( "#ajax-show2" ).addClass("show");
                    $('#ajax-show2').empty();
                    $('#ajax-show2').html(data.contents);
                }
            });
        }
    </script> --}}

    {{-- <script>
        $( ".btn-increment,.btn-decrement" ).click(function() {
            $("#ajax-price-container").css("display","");
            $('#ajax-animation').fadeIn('slow', function(){
               $('#ajax-animation').delay(100).fadeOut(); 
            });
            var ajaxPrice = $('#ajax-price').text();
            var trimmedPrice = ajaxPrice.substring(1);
            var ajaxQty = $('#ajax-qty').val();
            // var fid = $(this).attr("href");
            var totalProductPrice = trimmedPrice * ajaxQty;
            $('#ajax-calculated-price').empty();
            $('#ajax-calculated-price').html(totalProductPrice.toFixed(2));
          // alert( totalProductPrice );
        });
    </script> --}}

   {{--  <script>
        $("input[type=text]").keyup(function(){
            // $("input").css("background-color", "pink");
              $("#ajax-price-container").css("display","");
              $('#ajax-animation').fadeIn('slow', function(){
                 $('#ajax-animation').delay(100).fadeOut(); 
              });
              var ajaxPrice = $('#ajax-price').text();
              var trimmedPrice = ajaxPrice.substring(1);
              // var ajaxQty = $('#ajax-qty').val('');
               var ajaxQty = $('#ajax-qty').val();
               var ajaxQtyMax = $('#ajax-qty').attr('max');
               // if (ajaxQty > ajaxQtyMax) {
               //  alert('f88');
               //      $('#ajax-qty').val(ajaxQtyMax);
               // }
              console.log(ajaxQtyMax);
              // var fid = $(this).attr("href");
              var totalProductPrice = trimmedPrice * ajaxQty;
              $('#ajax-calculated-price').empty();
              $('#ajax-calculated-price').html(totalProductPrice.toFixed(2));
            // alert( totalProductPrice );
          });
    </script> --}}
    
   {{--  <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/lib/jquery.mousewheel.min.js')}}"></script> --}}
    {{-- <script type="text/javascript">
        // $(document).ready(function(){
        //     $('#sync1').lightGallery(
        //             {
        //                 selector: '.light-gallery-selector',
        //                 share: 0
        //             }
        //         );
        // });
    </script> --}}
    
    {{-- <script type="text/javascript">
        (function ($) {
            $(document).ready(function() {
                // $(".xzoom, .xzoom-gallery").xzoom();
                $(".xzoom, .xzoom-gallery").xzoom({tint: '#fff', Xoffset: 15, mposition: 'inside',});
            });
        })(jQuery);
    </script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/lib/jquery.mousewheel.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#video-gallery').lightGallery({
                youtubePlayerParams: {
                    autoplayFirstVideo : false,
                    loadYoutubeThumbnail: true,
                    youtubeThumbSize: 'default',
                    modestbranding: 1,
                    showinfo: 0,
                    rel: 0,
                    controls: 1
                    },
            }); 
        });
    </script> --}}
@endsection