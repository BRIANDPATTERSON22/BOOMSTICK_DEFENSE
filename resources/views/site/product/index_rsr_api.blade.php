@extends('site.layouts.default')

@section('htmlheader_title')
    Products
@endsection

@section('body_class')
    woocommerce woocommerce-page body_filled article_style_stretch scheme_original top_panel_show top_panel_above sidebar_show sidebar_left
@endsection

@section('page-style')
    <style>
    </style>
@endsection

@section('main-content')
  <div class="top_panel_title top_panel_style_1 title_present breadcrumbs_present scheme_original">
      <div class="top_panel_title_inner top_panel_inner_style_1">
          <div class="content_wrap">
              <h1 class="page_title">Products</h1>
              <div class="breadcrumbs">
                  <a class="breadcrumbs_item home" href="{{ url('/') }}">Home</a>
                  <span class="breadcrumbs_delimiter"></span>
                  <span class="breadcrumbs_item current">Products</span>
              </div>
          </div>
      </div>
  </div>

  <div class="page_content_wrap page_paddings_yes">
      <div class="content_wrap">
          <!-- Content -->
          <div class="content">
              <div class="list_products shop_mode_thumbs">
                  <div class="mode_buttons">
                      <a href="#" class="woocommerce_thumbs icon-th" title="Show products as thumbs"></a>
                      <a href="shop-list.html" class="woocommerce_list icon-th-list" title="Show products as list"></a>
                  </div>
                  <p class="woocommerce-result-count"> Showing 1&ndash;12 of 16 results</p>
                  <form class="woocommerce-ordering" method="get">
                      <select name="orderby" class="orderby">
                          <option value="menu_order" selected='selected'>Default sorting</option>
                          <option value="popularity">Sort by popularity</option>
                          <option value="rating">Sort by average rating</option>
                          <option value="date">Sort by newness</option>
                          <option value="price">Sort by price: low to high</option>
                          <option value="price-desc">Sort by price: high to low</option>
                      </select>
                  </form>

                  <!-- Products List -->
                  <ul class="products" id="rsr_products">
                    {{-- <li class="product column-1_3 first">
                        <div class="post_item_wrap">
                            <div class="post_featured">
                                <div class="post_thumb">
                                    <a href="product-single.html">
                                        <span class="onsale">Sale!</span>
                                        <img src="http://placehold.it/300x300.jpg" alt="" title="Product" />
                                    </a>
                                </div>
                            </div>
                            <div class="post_content">
                                <h2 class="woocommerce-loop-product__title">
                                    <a href="product-single.html">17HMR 17GR Varmint Tip 200RDS</a>
                                </h2>
                                <div class="star-rating" title="Rated 4.00 out of 5">
                                    <span class="width_80_per">
                                        <strong class="rating">4.00</strong> out of 5
                                    </span>
                                </div>
                                <span class="price">
                                    <del>
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                            583.00
                                        </span>
                                    </del>
                                    <ins>
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                            400.00
                                        </span>
                                    </ins>
                                </span>
                                <a href="#" class="button add_to_cart_button">Add to cart</a>
                            </div>
                        </div>
                    </li> --}}
                  </ul>
                  <!-- /Products List -->
                  <!-- Pagination -->
                  {{-- <nav class="pagination_wrap pagination_pages">
                      <span class="pager_current active">1</span>
                      <a href="#" class="">2</a>
                      <a href="#" class="pager_next ">&#8250;</a>
                      <a href="#" class="pager_last ">&raquo;</a>
                  </nav> --}}
                  <!-- /Pagination -->
              </div>
          </div>
          <!-- /Content -->

          <!-- Sidebar -->
          <div class="sidebar widget_area scheme_original">
              <div class="sidebar_inner widget_area_inner">
                  <aside class="widget woocommerce widget_product_categories">
                      <h5 class="widget_title">Categories</h5>
                      <ul class="product-categories">
                        @foreach ($rsrCategoriesData as $row)
                            <li>
                                <a href="{{url('category/'.$row->slug)}}">{{ $row->category_name }}</a>
                                {{-- @if($row->subCategories->isNotEmpty())
                                    <ul class='children'>
                                        @foreach ($row->subCategories as $subCategory)
                                            <li>
                                                <a href="{{url('category/'.$subCategory->slug)}}">{{ str_limit($subCategory->name, 100) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif --}}
                            </li>
                        @endforeach
                      </ul>
                  </aside>
              </div>
          </div>
          <!-- /Sidebar -->
      </div>
  </div>

@endsection

@section('page-script')
    <script>
        fetch('http://localhost/fmradiotamil.dev/public/api/posts')
        .then((res) => res.json())
        .then((data) => {
          let output = '';
          data.data.forEach(function(post){
            output += `
                <li class="product column-1_3">
                   <div class="post_item_wrap">
                       <div class="post_featured">
                           <div class="post_thumb">
                               <a href="product-single.html">
                                   <span class="onsale">Sale!</span>
                                   <img src="${post.image}" alt="" title="Product" />
                               </a>
                           </div>
                           <a href="#" class="button add_to_cart_button sc_button sc_button_size_small">Add to cart</a>
                       </div>
                       <div class="post_content">
                           <h2 class="woocommerce-loop-product__title">
                               <a href="product-single.html">${post.title}</a>
                           </h2>
                           <span class="price">
                               <del>
                                   <span class="woocommerce-Price-amount amount">
                                       <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                       583.00
                                   </span>
                               </del>
                               <ins>
                                   <span class="woocommerce-Price-amount amount">
                                       <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                       400.00
                                   </span>
                               </ins>
                           </span>
                           
                       </div>
                   </div>
               </li>
            `;
          });
          document.getElementById('rsr_products').innerHTML = output;
        })
    </script>
@endsection