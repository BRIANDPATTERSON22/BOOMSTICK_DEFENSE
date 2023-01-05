@extends('site.layouts.default')

@section('htmlheader_title')
    {{$singleData->name}} | Products
@endsection

@section('page-style')
    {{-- <link href="{{ asset('/plugins/lightGallery-master/dist/css/lightgallery.css')}}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('/plugins/lightGallery-master/dist/css/lightgallery-bundle.css')}}" rel="stylesheet"> --}}

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
        
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                          {{-- <h2>{{$singleData->product_description}}</h2> --}}
                          <ul>
                              <li><a href="{{ url('/') }}#">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a href="{{ url('products') }}">products</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>{{$singleData->product_description}}</a></li>
                              <li><a>{{ $singleData->rsr_gallery_lr_image_count() }}</a></li>
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
                @if ($singleData->haveRsrPhotos->isNotEmpty() || $singleData->rsr_gallery_hr_image_count() || $singleData->rsr_gallery_lr_image_count())
                  <div class="col-lg-1 col-sm-2 col-xs-12">
                      <div class="row">
                          <div class="col-12 p-0">
                              <div class="slider-right-nav">
                                  {{-- @if($singleData->image_name)
                                    @if (Storage::exists($singleData->get_hr_image_storage_path_by_category()))
                                      <div><img src="{{asset($singleData->get_hr_image_by_category())}}" alt="" class="img-fluid  image_zoom_cls-0"></div>
                                    @else
                                      <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                    @endif
                                  @else
                                       <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                  @endif --}}

                                @if ($singleData->rsr_gallery_hr_image_count())
                                    @foreach ($singleData->rsr_gallery_hr_images() as $key => $value)
                                        <div><img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $key }}"></div>
                                    @endforeach
                                    {{-- @for ($i = 1; $i < 5; $i++)
                                        <div><img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->rsr_gallery_hr_image($i)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $i }}"></div>
                                    @endfor --}}
                                @else
                                    @foreach ($singleData->rsr_gallery_lr_images() as $key => $value)
                                        <div><img src="{{ asset('storage/products/ftp_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $key }}"></div>
                                    @endforeach
                                @endif
                                 

                                  @foreach($singleData->haveRsrPhotos as $img)
                                      <div><img src="{{asset('storage/rsr-products/rsr-photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-{{ $img->id }}"></div>
                                  @endforeach

                                  {{-- <div><img src="../assets/images/product-sidebar/001.jpg" alt="" class="img-fluid  image_zoom_cls-0"></div> --}}
                                  {{-- <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                                  <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                                  <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div> --}}
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-sm-10 col-xs-12 order-up parent-container">
                      <div class="product-right-slick no-arrow">
                        {{-- @if($singleData->image_name)
                          @if (Storage::exists($singleData->get_hr_image_storage_path_by_category()))
                            <div><img src="{{asset($singleData->get_hr_image_by_category())}}" alt="" class="img-fluid  image_zoom_cls-0"></div> 
                          @else
                            <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                          @endif
                        @else
                             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                        @endif --}}

                        @if ($singleData->rsr_gallery_hr_image_count())
                            @foreach ($singleData->rsr_gallery_hr_images() as $key => $value)
                                <div>
                                    <a href="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}">
                                        <img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $key }}">
                                    </a>
                                </div>
                            @endforeach

                            {{-- @for ($i = 1; $i < 5; $i++)
                                <div><img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->rsr_gallery_hr_image($i)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $i }}"></div>
                            @endfor --}}
                        @else
                            @foreach ($singleData->rsr_gallery_lr_images() as $key => $value)
                                <div>
                                    <a href="{{ asset('storage/products/ftp_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}">
                                        <img src="{{ asset('storage/products/ftp_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->image_from_path($value)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $key }}">
                                    </a>
                                </div>
                            @endforeach
                        @endif

                        @foreach($singleData->haveRsrPhotos as $img)
                            <div>
                                <a href="{{asset('storage/rsr-products/rsr-photos/'.$img->product_id.'/'.$img->image)}}">
                                    <img src="{{asset('storage/rsr-products/rsr-photos/'.$img->product_id.'/'.$img->image)}}" alt="" class="img-fluid  image_zoom_cls-{{ $img->id }}">
                                </a>
                            </div>
                        @endforeach

                          {{-- <div><img src="../assets/images/product-sidebar/001.jpg" alt="" class="img-fluid  image_zoom_cls-0"></div> --}}
                          {{-- <div><img src="../assets/images/product-sidebar/002.jpg" alt="" class="img-fluid  image_zoom_cls-1"></div>
                          <div><img src="../assets/images/product-sidebar/003.jpg" alt="" class="img-fluid  image_zoom_cls-2"></div>
                          <div><img src="../assets/images/product-sidebar/004.jpg" alt="" class="img-fluid  image_zoom_cls-3"></div> --}}
                      </div>
                  </div>
                @else
                  <div class="col-lg-5 rtl-text">
                     @if($singleData->image_name)
                       @if (Storage::exists($singleData->get_hr_image_storage_path_by_category()))
                          <img class="img-fluid w-100" src="{{asset($singleData->get_hr_image_by_category())}}">
                       @else
                         <img class="img-fluid w-100" src="{{asset('site/defaults/image-coming-soon.png')}}">
                       @endif
                     @else
                          <img class="img-fluid w-100" src="{{asset('site/defaults/image-not-found.png')}}">
                     @endif
                  </div>
                @endif



                {{-- ++++++++++++++++++++++++++ --}}
                    {{-- <div class="col-lg-1 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-right-nav">
                                    @for ($i = 1; $i < 5; $i++)
                                        <div><img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->rsr_gallery_hr_image($i)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $i }}"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-10 col-xs-12 order-up">
                        <div class="product-right-slick no-arrow">
                            @for ($i = 1; $i < 5; $i++)
                                <div><img src="{{ asset('storage/products/ftp_highres_images/categories/'.str_slug($singleData->rsr_category->category_name) .'/'.$singleData->rsr_gallery_hr_image($i)) }}" alt="" class="img-fluid  image_zoom_cls-{{ $i }}"></div>
                            @endfor
                        </div>
                    </div> --}}
                {{-- +++++++++++++++++++++++++ --}}



                  <div class="col-lg-7 rtl-text">
                      <div class="product-right">
                          <h2>{{ $singleData->product_description }}</h2>

                          {{-- <h4><del>$459.00</del><span>55% off</span></h4> --}}
                          {{-- <h3>{{ $option->currency_symbol }}{{ number_format($singleData->retail_price, 2) }}</h3> --}}
                          <h3>{{ $option->currency_symbol }}{{ number_format($singleData->get_rsr_retail_price(), 2) }}</h3>

                          {{-- <ul class="color-variant">
                              <li class="bg-light0"></li>
                              <li class="bg-light1"></li>
                              <li class="bg-light2"></li>
                          </ul> --}}

                          {{-- {{ $singleData->is_out_of_stock() }} --}}

                          @if($singleData->is_in_stock())
                            {!!Form::open(['url'=> $singleData->rsr_stock_number.'/item', 'autocomplete'=>'off'])!!}
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
                                <div class="qty-box">
                                    <div class="input-group">
                                      <span class="input-group-prepend">
                                        <button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button>
                                      </span>
                                        <input type="text" name="qty" class="form-control input-number" value="1" min="1"  step="1">
                                        <span class="input-group-prepend">
                                          <button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button>
                                      </span>
                                    </div>
                                </div>
                            </div>
                          
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
                                  {!!Form::open(['url'=> 'product-notification/'.$singleData->rsr_stock_number, 'autocomplete'=>'off', 'class' => 'theme-form'])!!}
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
                                                @if($singleData->image_name)
                                                  @if (Storage::exists($singleData->get_hr_image_storage_path_by_category()))
                                                    <div><img src="{{asset($singleData->get_hr_image_by_category())}}" alt="" class="w-50"></div>
                                                  @else
                                                    <img src="{{asset('site/defaults/image-coming-soon.png')}}" class="w-50">
                                                  @endif
                                                @else
                                                     <img src="{{asset('site/defaults/image-not-found.png')}}" class="w-50">
                                                @endif
                                                <h5 class="mt-3">{{ $singleData->product_description }}</h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="text-center col-md-8 mx-auto text-light mb-2">Pleae Enter Your Email address we will notify you when the product is back in stock</div>
                                            {!! Form::hidden('store_type', '1') !!}
                                            {!! Form::hidden('title', $singleData->product_description) !!}
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

                          <div class="border-product pb-0 basic_info">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    UPC
                                    <span class="badge badge-dark badge-pill">{{ $singleData->upc_code ?? '---' }}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    RSR Stock #
                                    <span class="badge badge-dark badge-pill">{{ $singleData->rsr_stock_number ?? '---' }}</span>
                                  </li>
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
                                    <span class="badge badge-dark badge-pill">{{ $singleData->model ?? '---' }}</span>
                                  </li>
                                </ul>
                              {{-- <h6 class="product-title">product details</h6> --}}
                              {{-- <p>{{ $singleData->expanded_product_description }}</p> --}}

                              {{-- <table class="table table-borderless table-dark">

                                <tbody>
                                  <tr>
                                    <th scope="row">UPC</th>
                                    <td>{{ $singleData->upc_code ?? '---' }}</td>
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
                              </table> --}}
                          </div>

                          {{-- <div class="border-product">
                              <div class="product-icon">
                                  <ul class="product-social">
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-facebook"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-google-plus"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-twitter"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-instagram"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-rss"></i></a></li>
                                      <li><a href="product-page(left-image).html#"><i class="fa fa-exclamation-triangle" aria-hidden="true">Warning</i></a></li>
                                  </ul>
                                  <form class="d-inline-block">
                                      <button class="wishlist-btn"><i class="fa fa-heart"></i><span class="title-font">Add To WishList</span></button>
                                  </form>
                              </div>
                          </div> --}}

                          @if($singleData->rsr_message)
                              <div class="border-product">
                                    <button class="btn_warning mb-2" data-toggle="collapse" data-target="#collapseWarning" aria-expanded="false" aria-controls="collapseWarning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="title-font"> <u>Warning</u></span></button>
                                    <div class="collapse" id="collapseWarning">
                                        <div class="card card-body card_warning"><p>{{ $singleData->rsr_message->message_text }}</p></div>
                                    </div>
                              </div>
                          @endif

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
    <section class=" tab-product tab-exes mb-3">
        <div class="custom-container">
          <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="creative-card creative-inner mb-4">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Product Features</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                             <p class="p-2 mb-2"> {{ $singleData->expanded_product_description }}</p>
                             @if($singleData->rsr_sell_feature)
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            @if($singleData->rsr_sell_feature->sell_copy_feature_description)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->sell_copy_feature_description }}</li>@endif
                                            @if($singleData->rsr_sell_feature->feature_2)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_2 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_4)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_4 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_6)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_6 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_8)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_8 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_10)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_10 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_12)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_12 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_14)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_14 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_16)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_16 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_18)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_18 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_20)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_20 }} </li>@endif
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            @if($singleData->rsr_sell_feature->feature_1)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_1 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_3)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_3 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_5)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_5 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_7)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_7 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_9)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_9 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_13)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_13 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_15)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_15 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_17)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_17 }} </li>@endif
                                            @if($singleData->rsr_sell_feature->feature_19)<li class="list-group-item list-group-item-dark text-light"> <i class="fa fa-circle mr-2" aria-hidden="true"></i> {{ $singleData->rsr_sell_feature->feature_19 }} </li>@endif
                                        </ul>
                                    </div>
                                </div>
                             @endif
                        </div>
                    </div>
                </div>

                @if($singleData->rsr_sell_description)
                    <div class="creative-card creative-inner mb-4">
                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Product Description</a>
                                <div class="material-border"></div>
                            </li>
                        </ul>
                        <div class="tab-content nav-material" id="top-tabContent">
                            <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                 <p class="p-2 mb-2">{{ $singleData->rsr_sell_description ? $singleData->rsr_sell_description->sell_copy_feature_description : ""  }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="creative-card creative-inner">
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

                                            {{-- <tr>
                                                @if($singleData->rsr_attribute->manufacturer)
                                                    <th>manufacturer</th>
                                                    <td>{{ $singleData->rsr_attribute->manufacturer }}</td>
                                                @endif
                                                @if($singleData->rsr_attribute->manufacturer_part)
                                                    <th>manufacturer_part</th>
                                                    <td>{{ $singleData->rsr_attribute->manufacturer_part }}</td>
                                                @endif
                                            </tr> --}}

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
                                    </tbody>
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
  {{-- <section class="section-big-py-space  ratio_asos bg-light">
      <div class="custom-container">
          <div class="row">
              <div class="col-12 product-related">
                  <h2>related products</h2>
              </div>
          </div>
          <div class="row ">
                <div class="col-12 product">
                    <div class="product-8 no-arrow">
                        @foreach($otherData as $row)
                            <div>
                                <div class="product-box">
                                    <div class="product-imgbox">
                                        <div class="product-front">
                                          <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                              @if($row->image_name)
                                                @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                              @endif
                                          </a>
                                        </div>
                                        <div class="product-back">
                                            <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                              @if($row->image_name)
                                                @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                  <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">
                                                @else
                                                  <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                @endif
                                              @else
                                                   <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                              @endif
                                          </a>
                                        </div>
                                        <div class="product-icon icon-inline">
                                          @if($row->is_in_stock())
                                            {!!Form::open(['url'=> $row->rsr_stock_number.'/item', 'autocomplete'=>'off'])!!}
                                            {!!csrf_field()!!}
                                              <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>
                                            {!! Form::close() !!}
                                          @endif
                                            <a href="{{url('product/'.$row->slug)}}" title="View Product">
                                                <i class="ti-search" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-detail detail-inline">
                                        <div class="detail-title">
                                            <div class="detail-left">
                                                <div class="rating-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                                    <h6 class="price-title">{{ $row->product_description }} </h6>
                                                </a>
                                                <div class="border-top border-dark mt-2">
                                                    <strong>{{ $option->currency_symbol . number_format($row->retail_price, 2) }}</strong>
                                                    <strong>{{ $option->currency_symbol }}{{ number_format($row->get_rsr_retail_price(), 2) }}</strong>
                                                </div>
                                            </div>

                                            <div class="detail-right">
                                                <div class="check-price">
                                                    {{ $option->currency_symbol . $row->retail_price }}
                                                </div>
                                                <div class="price">
                                                    <div class="price">
                                                        <hr>
                                                        {{ $option->currency_symbol . $row->retail_price }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
              </div>
          </div>
      </div>
  </section> --}}
  <!-- related products -->


    {{-- @if ($singleData->rsr_related_products->isNotEmpty())
        <section class="section-big-py-space  ratio_asos bg-light pb-3 pt-4">
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 product-related">
                        <h2>Related Products</h2>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-12 product">
                        <div class="product-8 no-arrow">
                            @foreach($singleData->rsr_related_products as $relatedProduct)
                                @if ($relatedProduct->product)
                                    <div>
                                        <div class="product-box">
                                            <div class="product-imgbox">
                                                <div class="product-front">
                                                  <a href="{{url('product/'.$relatedProduct->product->rsr_stock_number)}}">
                                                      @if($relatedProduct->product->image_name)
                                                        @if (Storage::exists($relatedProduct->product->get_hr_image_storage_path_by_category()))
                                                          <img class="img-fluid" src="{{asset($relatedProduct->product->get_hr_image_by_category())}}">
                                                        @else
                                                          <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                        @endif
                                                      @else
                                                           <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                      @endif
                                                  </a>
                                                </div>
                                            </div>
                                            <div class="product-detail detail-inline">
                                                <div class="detail-title">
                                                    <div class="detail-left">
                                                        <a href="{{url('product/'.$relatedProduct->product->rsr_stock_number)}}">
                                                            <h6 class="price-title">{{ $relatedProduct->product->product_description }} </h6>
                                                        </a>
                                                        <div class="border-top border-dark mt-2">
                                                            <strong>{{ $option->currency_symbol }}{{ number_format($relatedProduct->product->get_rsr_retail_price(), 2) }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                  </div>
                </div>
            </div>
        </section>
    @endif --}}

    {{-- @php
        dump(count($singleData->related_products_by_main_category("2A-BRC16PML15BLK-2", "69")));
        dump($singleData->related_products_by_main_category("2A-BRC16PML15BLK-2", "69"));;
    @endphp --}}

    @if ($singleData->rsr_related_product_categories->isNotEmpty())
        @foreach ($singleData->rsr_related_product_categories as $category)
            @if ($category->main_category)
                {{-- @if($singleData->related_products_by_main_category($singleData->rsr_stock_number, $category->associated_department_numbe)->isNOtEmpty()) --}}
                    <section class="section-big-py-space  ratio_asos bg-light pb-3 pt-4">
                        <div class="custom-container">
                            {{-- @foreach($category->main_category->related_products_by_main_category($singleData->rsr_stock_number, $category->associated_department_number) as $relatedProduct) --}}
                                {{-- @if ($relatedProduct->rsr_related_product) --}}
                                    <div class="row">
                                        <div class="col-12 product-related">
                                            <h2>Related Products - {{ $category->main_category->category_name }} </h2>
                                        </div>
                                    </div>
                                {{-- @endif --}}
                            {{-- @endforeach --}}
                            
                            <div class="row ">
                                  <div class="col-12 product">
                                      <div class="product-8 no-arrow">
                                            @foreach($category->main_category->related_products_by_main_category($singleData->rsr_stock_number, $category->associated_department_number) as $relatedProduct)
                                                @if ($relatedProduct->rsr_related_product)
                                                    <div>
                                                        <div class="product-box">
                                                            <div class="product-imgbox">
                                                                <div class="product-front">
                                                                  <a href="{{url('product/'.$relatedProduct->rsr_related_product->rsr_stock_number)}}">
                                                                      {{-- @if($relatedProduct->rsr_related_product->image_name)
                                                                        @if (Storage::exists($relatedProduct->rsr_related_product->get_hr_image_storage_path_by_category()))
                                                                          <img class="img-fluid" src="{{asset($relatedProduct->rsr_related_product->get_hr_image_by_category())}}">
                                                                        @else
                                                                          <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                                        @endif
                                                                      @else
                                                                           <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                                      @endif --}}

                                                                      @if($relatedProduct->rsr_related_product->image_name)
                                                                        @if (Storage::exists($relatedProduct->rsr_related_product->get_lr_image_storage_path_by_category()))
                                                                          <img class="img-fluid" src="{{asset($relatedProduct->rsr_related_product->get_lr_image_by_category())}}">
                                                                        @else
                                                                          <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                                        @endif
                                                                      @else
                                                                           <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                                      @endif
                                                                  </a>
                                                                </div>
                                                            </div>
                                                            <div class="product-detail detail-inline">
                                                                <div class="detail-title">
                                                                    <div class="detail-left">
                                                                        <a href="{{url('product/'.$relatedProduct->rsr_related_product->rsr_stock_number)}}">
                                                                            <h6 class="price-title">{{ $relatedProduct->rsr_related_product->product_description }} </h6>
                                                                        </a>
                                                                        <div class="border-top border-dark mt-2">
                                                                            <strong>{{ $option->currency_symbol }}{{ number_format($relatedProduct->rsr_related_product->get_rsr_retail_price(), 2) }}</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                      </div>
                                </div>
                            </div>
                        </div>
                    </section>
                {{-- @endif  --}}
            @endif
        @endforeach
    @endif


{{-- @foreach ($rsrCategoriesData as $category)
    <section class="section-big-py-space  ratio_asos bg-light pb-3 pt-4">
        <div class="custom-container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>Related Products - {{ $category->category_name }}</h2>
                </div>
            </div>
            <div class="row ">
                  <div class="col-12 product">
                      <div class="product-8 no-arrow">
                            @php
                                @dump(count($category->related_products_by_category($singleData->rsr_stock_number, $category->department_id)));
                            @endphp
                        
                          @foreach($otherData as $row)
                              <div>
                                  <div class="product-box">
                                      <div class="product-imgbox">
                                          <div class="product-front">
                                            <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                                @if($row->image_name)
                                                  @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                    <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">
                                                  @else
                                                    <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                                  @endif
                                                @else
                                                     <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                                @endif
                                            </a>
                                          </div>
                                      </div>
                                      <div class="product-detail detail-inline">
                                          <div class="detail-title">
                                              <div class="detail-left">
                                                  <a href="{{url('product/'.$row->rsr_stock_number)}}">
                                                      <h6 class="price-title">{{ $row->product_description }} </h6>
                                                  </a>
                                                  <div class="border-top border-dark mt-2">
                                                      <strong>{{ $option->currency_symbol }}{{ number_format($row->get_rsr_retail_price(), 2) }}</strong>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                </div>
            </div>
        </div>
    </section>
@endforeach --}}


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

    {{-- <script>
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
                $(".xzoom, .xzoom-gallery").xzoom();
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

    {{-- <script src="{{ asset('plugins/lightGallery-master/dist/lightgallery.min.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/plugins/thumbnail/lg-thumbnail.umd.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/plugins/zoom/lg-zoom.umd.js')}}"></script>
    <script type="text/javascript">
        lightGallery(document.getElementById('selector1'), {
            plugins: [lgZoom, lgThumbnail],
            licenseKey: 'your_license_key'
            speed: 500,
            selector: '.item',
        });
    </script> --}}
@endsection