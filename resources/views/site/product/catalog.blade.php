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
                            {{-- <li><a href="{{url('products')}}">Products</a></li> --}}
                            <li><a href="{{url('products')}}">Catalog</a></li>
                            <li class="breadcrumb-item active">{{$singleData->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->



    <!--banner area start-->
    <div class="banner_area mb-46_ mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="single_banner mb-15">
                        <div class="banner_thumb">
                            <a href="{{ url('product/'.$singleData->slug) }}">
                                @if ($singleData->banner_image)
                                    <img src="{{ asset('storage/products/banner-images/'.$singleData->banner_image) }}" alt="" width="100%">
                                @else
                                    <img src="{{ asset('site/img/coming-soon.png') }}" alt="" width="100%">
                                @endif
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--product area start-->
    <div class="product_area product_style3 mb-75_ mb-15">
        <div class="container">
           {{--  <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                       <h2>featured products</h2>
                    </div>
                </div>
            </div> 
 --}}            <div class="row no-gutters inno_shadow">
                <div class="product_carousel product_column4 owl-carousel light-gallery-selector">
                    @foreach($photos as $img)
                        <div class="col-lg-3">
                            <article class="single_product" style="border-right: 1px solid #f5f5f5;">
                                    <figure>
                                        <div class="product_thumbx">
                                            <a href="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}">
                                                <img src="{{asset('storage/products/photos/'.$img->product_id.'/'.$img->image)}}" alt="">
                                            </a>
                                        </div>
                                    </figure>
                                </article>
                        </div>
                    @endforeach         
                </div> 
            </div>
        </div>
    </div>
    <!--product area end-->

    <!--product area start-->
    {{-- <div class="product_area mb-75">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                       <h2>New arrivals</h2>
                    </div>
                </div>
            </div> 
            <div class="product_container product_reverse">
                <div class="row">
                    <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-0">
                        <div class="product_right">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="product-details.html"><img src="{{ asset('site/img/product/productbig1.jpg')}}" alt=""></a>
                                        <div class="label_product">
                                            <span class="label_new">new</span>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart"><a href="cart.html" title="Add to cart"><i class="pe-7s-cart"></i></a></li>
                                                <li class="quick_button"><a href="index-2.html#" data-toggle="modal" data-target="#modal_box"  title="quick view"> <i class="pe-7s-search"></i></a></li>
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="pe-7s-like"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="featured_name"><a href="product-details.html">Driven Backpack12</a></h4>
                                        <div class="price_box"> 
                                            <span class="old_price">$86.00</span> 
                                            <span class="current_price">$79.00</span>
                                        </div>
                                        <div class="product_rating">
                                           <ul>
                                               <li><a href="index-2.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                               <li><a href="index-2.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                               <li><a href="index-2.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                               <li><a href="index-2.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                               <li><a href="index-2.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                           </ul>
                                       </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                       <div class="product_left">
                           <div class="row">
                             {!! $singleData->content !!}
                            </div> 
                       </div>
                        
                    </div>
                </div>
            </div>
              
        </div>
    </div> --}}
    <!--product area end-->

    <!--banner area start-->
    <div class="banner_area">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner box_1 mb-15">
                        <div class="banner_thumb inno_shadow">
                            <a href="{{ url('product/'.$singleData->slug) }}">
                                <img src="{{ asset('storage/products/images/'.$singleData->main_image) }}" alt="{{ $singleData->title }}" width="100%"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner box_2">
                        <div class="banner_thumb inno_shadow p_15">
                            {{-- <a href="shop.html"><img src="{{ asset('site/img/bg/banner2.jpg') }}" alt=""></a> --}}
                            <div class="section_title title_style2">
                               <h2>Description</h2>
                            </div>
                            {!! $singleData->content !!}
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--banner area start-->
    @if ($singleData->video_code)
        <div class="banner_area mb-15">
            <div class="container">
                <div class="row no-gutters">
                   {{--  <div class="col-lg-6 col-md-6">
                        <figure class="single_banner box_1 mb-15">
                            <div class="banner_thumb inno_shadow">
                                <a href="shop.html"><img src="{{ asset('site/img/bg/banner1.jpg') }}" alt=""></a>
                            </div>
                        </figure>
                    </div> --}}
                    <div class="col-lg-12 col-md-12">
                        <figure class="single_banner box_1 inno_shadow">
                            <div class="banner_thumb" id="video-gallery">
                                <a href="https://www.youtube.com/watch?v={{$singleData->video_code}}" data-poster="http://img.youtube.com/vi/{{$singleData->video_code}}/maxresdefault.jpg" >
                                    {{-- <img src="https://via.placeholder.com/944x647?text=Video" /> --}}
                                    <img width="100%" src="http://img.youtube.com/vi/{{$singleData->video_code}}/maxresdefault.jpg" />
                                </a>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--banner area end-->

    <!--banner area start-->
    {{-- <div class="banner_area mb-46">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner mb-30">
                        <div class="banner_thumb">
                            <a href="shop.html"><img src="{{ asset('site//img/bg/banner6.jpg') }}" alt=""></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner mb-30">
                        <div class="banner_thumb">
                            <a href="shop.html"><img src="{{ asset('site//img/bg/banner7.jpg') }}" alt=""></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner mb-30">
                        <div class="banner_thumb">
                            <a href="shop.html"><img src="{{ asset('site//img/bg/banner8.jpg') }}" alt=""></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div> --}}
    <!--banner area end-->
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/lib/jquery.mousewheel.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.light-gallery-selector').lightGallery(
                    {
                        selector: 'a',
                        share: 0,
                        thumbnail:true,
                            animateThumb: true,
                            showThumbByDefault: true
                    }
                );


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
    </script>
    
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function() {
                // $(".xzoom, .xzoom-gallery").xzoom();
                $(".xzoom, .xzoom-gallery").xzoom({tint: '#fff', Xoffset: 15, mposition: 'inside',});
            });
        })(jQuery);
    </script>
@endsection