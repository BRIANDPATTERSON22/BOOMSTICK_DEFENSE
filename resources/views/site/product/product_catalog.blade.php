@extends('site.layouts.default')

@section('htmlheader_title')
    {{$singleData->name}} | Products
@endsection

@section('page-style')
    <link href="{{ asset('/plugins/lightGallery-master/dist/css/lightgallery.css')}}" rel="stylesheet">
    <style>
        .xzoom-thumbs {
            margin-top: 5px;
            padding-top: 10px;
        }
        .xzoom-lens {
            border: 1px solid #555;
            -webkit-box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06);
             box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06);
             border-radius: 10px;
        }
        .xzoom-preview {
            border: 1px solid #888;
            background: #2f4f4f;
            /*box-shadow: 0px 0px 10px rgba(0,0,0,0.50);*/
            box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.06);
            border-radius: 10px;
        }
        .product_info_button ul li a.active {
            color: #81d742;
            border-bottom: 5px solid #81d742;
        }
    </style>
@endsection

@section('main-content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">home</a></li>
                            <li><a href="{{url('products')}}">Products</a></li>
                            <li class="breadcrumb-item active">{{$singleData->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
    
    <!--product details start-->
    <div class="product_details mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab ">
                        {{-- 1 --}}
                        {{-- <div id="img-1" class="zoomWrapper single-zoom">
                            @foreach($photos->slice(0,1) as $img)
                                <a>
                                    <img id="zoom1" src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" data-zoom-image="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="big-1">
                                </a>
                            @endforeach
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @foreach($photos as $img)
                                    <li>
                                        <a href="product-details.html#" class="elevatezoom-gallery active" data-update="" data-image="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" data-zoom-image="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}">
                                            <img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}
                        {{-- 1 --}}

                        {{-- 2 --}}
                        @foreach($photos->slice(0,1) as $img)
                            <img class="xzoom inno_shadow b_t_r_10" src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" xoriginal="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" />
                        @endforeach

                        <div class="xzoom-thumbs inno_shadow b_b_r_10">
                            @foreach($photos as $img)
                                <a href="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}">
                                    <img style="border-radius: 5px;" class="xzoom-gallery" width="61" src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}"  xpreview="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}">
                                </a>
                            @endforeach
                        </div>
                        {{-- 2 --}}
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right inno_shadow p_30">
                       {!!Form::open(['url'=> $singleData->id.'/item', 'autocomplete'=>'off'])!!}
                       {!!csrf_field()!!}
                            <h1 class="inno_title_1">{{ $singleData->title }}</h1>
                            {{-- <div class="section_title_footer title_footer">
                                <h3>{{ $singleData->title }}</h3>
                            </div> --}}
                            <div class="product_nav">
                                <ul>
                                    @if($previouProducts)
                                        <li class="prev"><a href="{{ url('/product/'.$previouProducts->slug) }}" title="Previous Product"><i class="fa fa-angle-left"></i></a></li>
                                    @endif

                                    @if($nextProduct)
                                        <li class="next"><a href="{{ url('/product/'.$nextProduct->slug) }}" title="Next Product"><i class="fa fa-angle-right"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                           {{--  <div class=" product_ratting">
                                <ul>
                                    <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                    <li class="review"><a href="product-details.html#"> (customer review ) </a></li>
                                </ul>
                            </div> --}}
                            <div class="price_box">
                                @if($singleData->is_retail_price_display == 1)
                                    <span class="old_price"> {{ $option->currency_symbol }}{{ $singleData->retail_price }}</span>
                                    <span class="current_price"> {{ $option->currency_symbol }}{{ $singleData->sale_price }}</span>
                                @endif
                            </div>

                            <div class="price_box">
                                @if($singleData->is_sale_price_display == 1)
                                    <span class="current_price" style="font-size: 14px;"> MSRP Sale Price - </span>
                                    <span class="current_price" style="font-size: 14px;"> {{ $option->currency_symbol }}{{ $singleData->dicounted_price }}</span>
                                @endif
                            </div>
                            <div class="contact_message content mt-10">
                               {{--  <div class="section_title_footer title_footer">
                                  <h3>contact info</h3>
                                </div> --}}
                                  <ul>
                                      <li>
                                        <i class="fa fa-barcode"></i> SKU - {{ $singleData->upc }} 
                                        <div class="float-right">
                                            @if($singleData->qty > 0)
                                                <i class="fa fa-check-circle"></i>Instock
                                            @else
                                                <i class="fa fa-times-circle"></i>Out Of Stock
                                            @endif
                                        </div>
                                      </li>

                                    @if($singleData->brand_id)
                                        <li>
                                            <i class="fa fa-server"></i> 
                                            {{-- <a href="{{url('category/'.$singleData->category->slug)}}"> Category - {{$singleData->category->name}}</a> --}}
                                            Brand - {{$singleData->brand->name}}
                                        </li>
                                    @endif

                                    @if($singleData->model_id)
                                        <li>
                                            <i class="fa fa-sun-o"></i> 
                                            {{-- <a href="{{url('category/'.$singleData->category->slug)}}"> Category - {{$singleData->category->name}}</a> --}}
                                            Model - {{$singleData->model->name}}
                                        </li>
                                    @endif
                                  </ul>             
                              </div>

                            @if($singleData->is_purchase_enabled == 1)
                              <hr>
                              <div class="product_variant quantity inno_shadow p_10">
                                  <label class="font_8 rotate_90">quantity</label>
                                  <input class="b_r_42" type="number" value="1" min="1" max="{{$singleData->quantity}}" step="1" name="qty" id="ajax-qty" />
                                  <button class="button btn-block b_r_42" type="submit">add to cart</button>  
                              </div>
                            @endif
                            <div class="product_desc">
                                <hr>
                                <p>{!! $singleData->content !!}</p>
                            </div>
                           {{--  <div class="product_variant color">
                                <h3>Available Options</h3>
                                <label>color</label>
                                <ul>
                                    <li class="color1"><a href="product-details.html#"></a></li>
                                    <li class="color2"><a href="product-details.html#"></a></li>
                                    <li class="color3"><a href="product-details.html#"></a></li>
                                    <li class="color4"><a href="product-details.html#"></a></li>
                                </ul>
                            </div> --}}
                           
                            {{-- <div class=" product_d_action">
                               <ul>
                                   <li><a href="product-details.html#" title="Add to wishlist">+ Add to Wishlist</a></li>
                                   <li><a href="product-details.html#" title="Add to wishlist">+ Compare</a></li>
                               </ul>
                            </div> --}}
                            {{-- <div class="product_meta">
                                <span>Category: <a href="{{url('category/'.$singleData->category->slug)}}"> {{$singleData->category->name}}</a></span>
                            </div> --}}
                            
                        {!! Form::close() !!}
                       {{--  <div class="priduct_social">
                            <ul>
                                <li><a class="facebook" href="product-details.html#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>           
                                <li><a class="twitter" href="product-details.html#" title="twitter"><i class="fa fa-twitter"></i> tweet</a></li>           
                                <li><a class="pinterest" href="product-details.html#" title="pinterest"><i class="fa fa-pinterest"></i> save</a></li>           
                                <li><a class="google-plus" href="product-details.html#" title="google +"><i class="fa fa-google-plus"></i> share</a></li>        
                                <li><a class="linkedin" href="product-details.html#" title="linkedin"><i class="fa fa-linkedin"></i> linked</a></li>        
                            </ul>      
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!--product details end-->
    
    <!--product info start-->
    <div class="product_d_info mb-58">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner inno_shadow">   
                        <div class="product_info_button m_b_15">    
                            <ul class="nav" role="tablist">
                                <li >
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Available Stores</a>
                                </li>
                                <li>
                                     <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a>
                                </li>
                                {{-- <li>
                                   <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews (1)</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">

                                    @if (!$storesCategoryData->isEmpty())
                                     <!--Accordion area-->
                                    <div class="accordion_area p_b_0">
                                        <div id="accordion" class="card__accordion">
                                            @foreach($storesCategoryData as $row)
                                                <div class="card  card_dipult">
                                                    <div class="card-header card_accor" id="headingTwo">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $row->id }}" aria-expanded="false" aria-controls="collapse{{ $row->id }}">
                                                        Division - {{ $row->title }} 
                                                            <i class="fa fa-plus"></i>
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                  <div id="collapse{{ $row->id }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="contact_message content">
                                                            <ul>
                                                                @foreach ($singleData->store_products_data as $storeRow)
                                                                    @if ($storeRow->store->storeCategory->id == $row->id)
                                                                        <li> 
                                                                            <i class="fa fa-hashtag"></i> {{  $storeRow->store->banner }} - {{ $storeRow->store->store_id }}
                                                                            <div class="float-right_"><i class="fa fa-map-marker"></i> {{ $storeRow->store->address_1 }}</div>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>         
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!--Accordion area end-->
                                    @else
                                        <p>No Data!</p>
                                    @endif
                                </div>    
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel" >
                                <div class="product_d_table">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="first_child">Weight</td>
                                                    <td>{{ $singleData->weight ?? '---' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Length</td>
                                                    <td>{{ $singleData->length ?? '---' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Width</td>
                                                    <td>{{ $singleData->width ?? '---' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Height</td>
                                                    <td>{{ $singleData->height ?? '---' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Color</td>
                                                    <td>{{ $singleData->color_id ? $singleData->colorData->name : '---' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Warranty</td>
                                                    <td>{{ $singleData->warranty ?? '---'}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                                <div class="product_info_content">
                                    <p></p>
                                </div>    
                            </div>

                            {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" >
                                <div class="reviews_wrapper">
                                    <h2>1 review for Donec eu furniture</h2>
                                    <div class="reviews_comment_box">
                                        <div class="comment_thmb">
                                            <img src="assets/img/blog/comment2.jpg" alt="">
                                        </div>
                                        <div class="comment_text">
                                            <div class="reviews_meta">
                                                <div class="star_rating">
                                                    <ul>
                                                        <li><a href="product-details.html#"><i class="ion-ios-star"></i></a></li>
                                                        <li><a href="product-details.html#"><i class="ion-ios-star"></i></a></li>
                                                        <li><a href="product-details.html#"><i class="ion-ios-star"></i></a></li>
                                                        <li><a href="product-details.html#"><i class="ion-ios-star"></i></a></li>
                                                        <li><a href="product-details.html#"><i class="ion-ios-star"></i></a></li>
                                                    </ul>   
                                                </div>
                                                <p><strong>admin </strong>- September 12, 2018</p>
                                                <span>roadthemes</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="comment_title">
                                        <h2>Add a review </h2>
                                        <p>Your email address will not be published.  Required fields are marked </p>
                                    </div>
                                    <div class="product_ratting mb-10">
                                       <h3>Your rating</h3>
                                        <ul>
                                            <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="product-details.html#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product_review_form">
                                        <form action="product-details.html#">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="review_comment">Your review </label>
                                                    <textarea name="comment" id="review_comment" ></textarea>
                                                </div> 
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="author">Name</label>
                                                    <input id="author"  type="text">

                                                </div> 
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="email">Email </label>
                                                    <input id="email"  type="text">
                                                </div>  
                                            </div>
                                            <button type="submit">Submit</button>
                                         </form>   
                                    </div> 
                                </div>     
                            </div> --}}
                        </div>
                    </div>     
                </div>
            </div>
        </div>    
    </div>  
    <!--product info end-->
    
    <!--product area start-->
    <section class="product_area related_products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="product_carousel product_column4 owl-carousel">
                    @foreach($otherData as $row)
                        @include('site.product.product_loop')
                    @endforeach
                </div> 
            </div>  
        </div>
    </section>
    <!--product area end-->
@endsection

@section('page-script')
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

    <script>
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
    </script>

    <script>
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
    </script>

    <script>
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
    </script>
    
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
    
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function() {
                // $(".xzoom, .xzoom-gallery").xzoom();
                $(".xzoom, .xzoom-gallery").xzoom({tint: '#fff', Xoffset: 15, mposition: 'inside',});
            });
        })(jQuery);
    </script>
@endsection