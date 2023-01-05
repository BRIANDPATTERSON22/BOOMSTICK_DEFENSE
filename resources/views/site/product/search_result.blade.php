@extends('site.layouts.default')

@section('htmlheader_title')
    Products
@endsection

@section('page-style')
    <style>
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
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li>Products</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>         
  </div>
  <!--breadcrumbs area end-->
  
  <!--shop  area start-->
  <div class="shop_area shop_fullwidth mt-60 mb-60">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <!--shop wrapper start-->
                  <!--shop toolbar start-->
                  {{-- <div class="shop_toolbar_wrapper">
                      <div class="shop_toolbar_btn">

                          <button data-role="grid_3" type="button" class=" btn-grid-3" data-toggle="tooltip" title="3"></button>

                          <button data-role="grid_4" type="button"  class="active btn-grid-4" data-toggle="tooltip" title="4"></button>

                          <button data-role="grid_list" type="button"  class="btn-list" data-toggle="tooltip" title="List"></button>
                      </div>
                      <div class=" niceselect_option">
                          <form class="select_option" action="shop-fullwidth.html#">
                              <select name="orderby" id="short">

                                  <option selected value="1">Sort by average rating</option>
                                  <option  value="2">Sort by popularity</option>
                                  <option value="3">Sort by newness</option>
                                  <option value="4">Sort by price: low to high</option>
                                  <option value="5">Sort by price: high to low</option>
                                  <option value="6">Product Name: Z</option>
                              </select>
                          </form>
                      </div>
                      <div class="page_amount">
                          <p>Showing 1–9 of 21 results</p>
                      </div>
                  </div> --}}
                   <!--shop toolbar end-->
                   <div class="row shop_wrapper">
                     @foreach($allData as $row)
                          <div class="col-lg-2 col-md-4 col-6 p-1">
                              <article class="single_product inno_shadow_2">
                                  <figure>
                                      <div class="product_thumb">
                                          <a href="{{url('product/'.$row->slug)}}">
                                            @if($row->main_image)
                                                <img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" alt="">
                                            @else
                                                 <img class="card-img-top img-fluid" src="{{asset('site/defaults/product_placeholder.png')}}" alt="">
                                            @endif
                                          </a>
                                          <div class="action_links">
                                              <ul>
                                                {{-- @if ($row->is_purchase_enabled   == 1)
                                                  {!!Form::open(['url'=> $row->id.'/item', 'autocomplete'=>'off'])!!}
                                                  {!!csrf_field()!!}
                                                    <li class="add_to_cart">
                                                      <a href="{{ url($row->id.'/item') }}" title="Add to cart"><i class="pe-7s-cart"></i></a>
                                                    <button type="submit" class="btn_cart"><i class="pe-7s-cart"></i></button>
                                                    </li>
                                                  {!! Form::close() !!}
                                                @endif --}}
                                                @if ($row->is_purchase_enabled == 1 && $row->quantity > 0)
                                                {{-- @if ($row->is_purchase_enabled   == 1) --}}
                                                  {{-- @if (in_array(0, $row->store_products_data->pluck('store_id')->toArray()) || $row->is_wholesale_customer()) --}}
                                                  @if ($row->is_wholesale_customer())
                                                    {!!Form::open(['url'=> $row->id.'/item', 'autocomplete'=>'off'])!!}
                                                    {!!csrf_field()!!}
                                                      <input type="hidden" name="store_id" value="{{ request()->storeId }}">
                                                      <li class="add_to_cart">
                                                      <button type="submit" class="btn_cart"><i class="pe-7s-cart"></i></button>
                                                      </li>
                                                    {!! Form::close() !!}
                                                  @endif
                                                @endif

                                                  <li class="wishlist"><a href="{{url('product/'.$row->slug)}}" title="View Product"><i class="pe-7s-search"></i></a></li>
                                                  {{-- <li class="quick_button"><a href="{{url('product/'.$row->slug)}}" data-toggle="modal" data-target="#modal_box"  title="quick view"> <i class="pe-7s-search"></i></a></li> --}}
                                                  {{-- <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="pe-7s-like"></i></a></li> --}}
                                              </ul>
                                          </div>
                                      </div>
                                      <div class="product_content grid_content inno_content_box_2">
                                          <h4 class="featured_name"><a href="{{url('/product/'.$row->slug)}}">{{$row->title}}</a></h4>
                                         {{--  @if ($row->is_retail_price_display == 1)
                                              <div class="price_box">
                                                  <span class="old_price">{{ $option->currency_symbol . $row->retail_price }} </span> 
                                                  <span class="current_price"> {{ $option->currency_symbol . $row->dicounted_price }} </span>
                                              </div>
                                          @endif --}}
                                         {{--  <div class="product_rating">
                                             <ul>
                                                 <li><a href="{{url('brand/'.$row->brand->slug)}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{ $row->brand->name }}</a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                             </ul>
                                         </div> --}}
                                      </div>
                                      <div class="product_content list_content">
                                          <h4 class="product_name"><a href="{{url('/product/'.$row->slug)}}">{{$row->title}}</a></h4>
                                          @if ($row->is_retail_price_display == 1)
                                              <div class="price_box">
                                                  <span class="old_price">{{ $option->currency_symbol . $row->retail_price }} </span> 
                                                  <span class="current_price"> {{ $option->currency_symbol . $row->dicounted_price }} </span>
                                              </div>
                                          @endif
                                          {{-- <div class="product_rating">
                                             <ul>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                 <li><a href="shop-fullwidth.html#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                             </ul>
                                         </div> --}}
                                          <div class="product_desc">
                                              <p>{{ $row->short_description }}</p>
                                          </div>
                                      </div>
                                  </figure>
                              </article>
                          </div>
                      @endforeach
                  </div>

                  <div class="shop_toolbar t_bottom">
                      <div class="pagination">
                          {{$allData->links()}}
                          {{-- <ul>
                              <li class="current">1</li>
                              <li><a href="shop-fullwidth.html#">2</a></li>
                              <li><a href="shop-fullwidth.html#">3</a></li>
                              <li class="next"><a href="shop-fullwidth.html#">next</a></li>
                              <li><a href="shop-fullwidth.html#">>></a></li>
                          </ul> --}}
                      </div>
                  </div>
                  <!--shop toolbar end-->
                  <!--shop wrapper end-->
              </div>
          </div>
      </div>
  </div>
  <!--shop  area end-->
@endsection

@section('page-script')
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>-->
    <!--<script type="text/javascript">-->
    <!--    $('ul.pagination').hide();-->
    <!--    $(function() {-->
    <!--        $('.infinite-scroll').jscroll({-->
    <!--            autoTrigger: true,-->
    <!--            loadingHtml: '<img class="d-block mx-auto" src="{{asset('site/img/loading.gif')}}" alt="Loading..." />',-->
    <!--            padding: 0,-->
    <!--            nextSelector: '.pagination li.active + li a',-->
    <!--            contentSelector: 'div.infinite-scroll',-->
    <!--            callback: function() {-->
    <!--                $('ul.pagination').remove();-->
    <!--            }-->
    <!--        });-->
    <!--    });-->
    <!--</script>-->

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
@endsection