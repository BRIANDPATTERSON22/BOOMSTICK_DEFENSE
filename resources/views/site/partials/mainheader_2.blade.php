<header>
  <div class="mobile-fix-option"></div>
  <div class="layout-header2" style="background-image:url({{ asset('site/images/metal_background.webp') }});background-position: center;background-repeat: no-repeat;background-size: cover;">
    <div class="container">
      <div class="col-md-12">
        <div class="main-menu-block">
          {{-- <div class="sm-nav-block">
            <span class="sm-nav-btn"><i class="fa fa-bars"></i></span>
            <ul class="nav-slide">
              <li>
                <div class="nav-sm-back">
                  back <i class="fa fa-angle-right pl-2"></i>
                </div>
              </li>

              @foreach ($rsrCategoriesComposerData as $rsrCategory)
                  <li><a href="{{ url('main-categories', $rsrCategory->department_id) }}">{{ $rsrCategory->category_name }}</a></li>
              @endforeach

              <li class="mor-slide-open">
                <ul>
                  <li><a href="index.html#">Bags, Luggage</a></li>
                  <li><a href="index.html#">Movies, Music </a></li>
                  <li><a href="index.html#">Video Games</a></li>
                  <li><a href="index.html#">Toys, Baby Products</a></li>
                </ul>
              </li>
              <li>
                <a class="mor-slide-click">
                  mor category
                  <i class="fa fa-angle-down pro-down" ></i>
                  <i class="fa fa-angle-up pro-up" ></i>
                </a>
              </li>
            </ul>
          </div> --}}
          
          <div class="logo-block">
            <a href="{{url('/')}}">
                @if($option->logo)
                    <img src="{{asset('storage/options/'.$option->logo)}}" alt="{{$option->name}}" class="img-fluid" style="height:auto"> 
                @else
                    {{str_limit($option->name, 20)}}
                @endif
            </a>
          </div>
          <div class="input-block">
            <div class="input-box">
              {!! Form::open(['url' => 'products', 'class' => 'big-deal-form', 'method' => 'get']) !!}
              {!! csrf_field() !!}
                <div class="input-group ">
                  {{-- <div class="input-group-prepend">
                    <span class="search"><i class="fa fa-search"></i></span>
                  </div> --}}
                  <input type="text" class="form-control text-white search-bar-input" placeholder="Search a Product" name="q" value="{{ request()->q }}" autocomplete="off" style="border:0px !important">
                  <div class="input-group-prepend">
                    {{-- <span class="search"><i class="fa fa-search"></i></span> --}}
                    <button type="submit" class="search btn btn-dark" style="background-color:#1b1b1b !important"> <span class="search"><i class="fa fa-search"></i></span></button>
                  </div>
                  {{-- <button type="submit" class="btn btn-dark"> <span class="search"><i class="fa fa-search"></i></span></button> --}}
                  {{-- <div class="input-group-prepend">
                    <select>
                      <option>All Category</option>
                      <option>indurstrial</option>
                      <option>sports</option>
                    </select>
                  </div> --}}
                </div>
              {!! Form::close() !!}
            </div>


            <div class="search-box-container" style="position:relative; display: none;">
                <div class="search-result-box" style="position: absolute; left:0px; right:0px; overflow: auto; overflow-x: hidden; max-height: 400px;">
                </div>
            </div>

          </div>

          <div class="cart-block cart-hover-div " onclick="openCart()">
            <div class="cart ">
              <span class="cart-product">@if(Cart::instance('cart')->count()>0) {{Cart::content()->count()}} @else 0 @endif</span>
              <ul>
                <li class="mobile-cart  ">
                  <a href="#">
                    <i class="icon-shopping-cart"></i>
                  </a>
                </li>
                <h5 class="d-none d-md-block d-lg-block d-xl-block">Cart</h5>
              </ul>
            </div>
            {{-- <div class="cart-item">
              <h5>shopping</h5>
              <h5>cart</h5>
            </div> --}}
          </div>

          {{-- <div style="border-left: 1px solid red; width: 1px;"></div> --}}

          <div class="cart-block cart-hover-div d-none d-md-block d-lg-block d-xl-block" onclick="openAccount()">
            <div class="cart ">
              <ul>
                <li class="mobile-user onhover-dropdown  ">
                  <a href="#">
                    <i class="icon-user "></i>
                  </a>
                  @if (Auth::check())
                    <h5 class="d-block">Logout</h5>
                  @else
                    <h5 class="d-block">Login</h5>
                  @endif
                </li>
              </ul>
            </div>
            {{-- <div class="cart-item">
              <h5>Login</h5>
              <h5>cart</h5>
            </div> --}}
          </div>

          <div class="menu-nav">
              <span class="toggle-nav">
                <i class="fa fa-bars "></i>
              </span>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="category-header-2" style="top: 110px !important;margin-bottom: 110px !important;">
    <div class="custom-container">
      <div class="row">
        <div class="col">
          <div class="navbar-menu" style="justify-content: center;">
            <div class="category-left">
              {{-- <div class="nav-block">
                <div class="nav-left" >
                  <nav class="navbar" data-toggle="collapse" data-target="#navbarToggleExternalContent">
                    <button class="navbar-toggler" type="button">
                      <span class="navbar-icon"><i class="fa fa-arrow-down"></i></span>
                    </button>
                    <h5 class="mb-0  text-white title-font">Shop by category</h5>
                  </nav>
                  <div class="collapse  nav-desk" id="navbarToggleExternalContent">
                    <ul class="nav-cat title-font">
                      <li> <img src="../assets/images/layout-1/nav-img/01.png" alt="category-product"> <a href="index.html#">western ware</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/02.png" alt="category-product"> <a href="index.html#">TV, Appliances</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/03.png" alt="category-product"> <a href="index.html#">Pets Products</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/04.png" alt="category-product"> <a href="index.html#">Car, Motorbike</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/05.png" alt="category-product"> <a href="index.html#">Industrial Products</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/06.png" alt="category-product"> <a href="index.html#">Beauty, Health Products</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/07.png" alt="category-product"> <a href="index.html#">Grocery Products </a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/08.png" alt="category-product"> <a href="index.html#">Sports</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/09.png" alt="category-product"> <a href="index.html#">Bags, Luggage</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/10.png" alt="category-product"> <a href="index.html#">Movies, Music </a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/11.png" alt="category-product"> <a href="index.html#">Video Games</a></li>
                      <li> <img src="../assets/images/layout-1/nav-img/12.png" alt="category-product"> <a href="index.html#">Toys, Baby Products</a></li>
                      <li>
                        <ul class="mor-slide-open">
                          <li> <img src="../assets/images/layout-1/nav-img/08.png" alt="category-product"> <a>Sports</a></li>
                          <li> <img src="../assets/images/layout-1/nav-img/09.png" alt="category-product"> <a>Bags, Luggage</a></li>
                          <li> <img src="../assets/images/layout-1/nav-img/10.png" alt="category-product"> <a>Movies, Music </a></li>
                          <li> <img src="../assets/images/layout-1/nav-img/11.png" alt="category-product"> <a>Video Games</a></li>
                          <li> <img src="../assets/images/layout-1/nav-img/12.png" alt="category-product"> <a>Toys, Baby Products</a></li>
                        </ul>
                      </li>
                      <li>
                        <a class="mor-slide-click">mor category <i class="fa fa-angle-down pro-down"></i><i class="fa fa-angle-up pro-up"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div> --}}

              <div class="menu-block">
                <nav id="main-nav">
                  <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>


                  <ul id="main-menu" class="sm pixelstrap sm-horizontal custom_menu">
                      <li>
                          <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                      </li>

                      <li> <a href="{{ url('/') }}">Home</a> </li>

                      <!--<li> <a href="{{ url('products') }}">Products</a> </li>-->

                    @foreach ($mainMenuCategoriesComposerData as $mainMenuCategory)
                      <li class="mega">
                          {{-- @if($mainMenuCategory->subCategories->isNotEmpty())
                            <a href="#">{{ $mainMenuCategory->name }}</a>
                          @else
                            <a href="{{ url('main-categories', $mainMenuCategory->slug) }}">{{ $mainMenuCategory->name }}</a>
                          @endif --}}

                          <a href="{{ url('main-categories', $mainMenuCategory->slug) }}">{{ $mainMenuCategory->name }}</a>
                          
                          {{-- @if($mainMenuCategory->subCategories->isNotEmpty())
                            <ul class="mega-menu full-mega-menu">
                                <li>
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($mainMenuCategory->subCategories as $subCategory)
                                                <div class="col-lg-4 mega-boxx">
                                                    <div class="link-section">
                                                        <div class="menu-title">
                                                          <h5>
                                                            <a href="{{ url('sub-categories/'.$subCategory->slug) }}">{{ str_limit($subCategory->name, 50) }}</a>
                                                          </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            </ul>
                          @endif --}}
                      </li>
                    @endforeach

                    @foreach ($rsrMainMenuCategoriesComposerData as $rsrMainMenuCategory)
                      <li class="mega">
                          <a href="{{ url('main-categories', $rsrMainMenuCategory->department_id) }}">{{ $rsrMainMenuCategory->category_name }}</a>
                          {{-- <a href="#">{{ str_limit($rsrMainMenuCategory->category_name, 30) }}</a> --}}
                          {{-- <ul class="mega-menu full-mega-menu">
                              <li>
                                  <div class="container">
                                      <div class="row">
                                          @foreach ($rsrMainMenuCategory->rsr_sub_categories as $rsrSubCategory)
                                              <div class="col-lg-4 mega-boxx">
                                                  <div class="link-section">
                                                      <div class="menu-title">
                                                        <h5>
                                                          <a href="{{ url('sub-categories/'.$rsrSubCategory->value) }}">{{ str_limit($rsrSubCategory->value, 50) }}</a>
                                                        </h5>
                                                      </div>
                                                  </div>
                                              </div>
                                          @endforeach

                                          <div class="col-lg-2 mega-box_">
                                              <div class="link-section">
                                                  <div class="menu-title">
                                                      <h5>
                                                          <a class="text-uppercase" href="{{ url('main-categories') }}">View All Sub Categories</a>
                                                      </h5>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                          </ul> --}}
                      </li>
                    @endforeach

                      {{-- <li class="mega"><a href="#">Shop By Category
                      </a>
                          <ul class="mega-menu full-mega-menu">
                              <li>
                                  <div class="container">
                                      <div class="row">
                                          @foreach ($rsrCategoriesComposerData as $rsrCategory)
                                              <div class="col-lg-2 mega-box">
                                                  <div class="link-section">
                                                      <div class="menu-title">
                                                          <h5>
                                                              <a class="text-uppercase" href="{{ url('main-categories', $rsrCategory->department_id) }}">
                                                              {{ str_limit($rsrCategory->category_name, 15) }}</a>
                                                          </h5>
                                                      </div>
                                                  </div>
                                              </div>
                                          @endforeach

                                          <div class="col-lg-2 mega-box_">
                                              <div class="link-section">
                                                  <div class="menu-title">
                                                      <h5>
                                                          <a class="text-uppercase" href="{{ url('main-categories') }}">View All Categories</a>
                                                      </h5>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                      </li> --}}

                      {{-- <li class="mega">
                          <a href="#">Shop By Brand</a>
                          <ul class="mega-menu full-mega-menu">
                              <li>
                                  <div class="container">
                                      <div class="row">
                                          @foreach ($rsrManufacturesComposerData as $rsrManufacture)
                                              <div class="col-lg-2 mega-boxx">
                                                  <div class="link-section">
                                                      <div class="menu-title">
                                                          <h5><a href="{{ url('brands/'.$rsrManufacture->manufacturer_id) }}">{{ str_limit($rsrManufacture->full_manufacturer_name, 15) }}</a></h5>
                                                      </div>
                                                  </div>
                                              </div>
                                          @endforeach

                                          <div class="col-lg-2 mega-box_">
                                              <div class="link-section">
                                                  <div class="menu-title">
                                                      <h5>
                                                          <a class="text-uppercase" href="{{ url('brands') }}">View All Brands</a>
                                                      </h5>
                                                  </div>

                                              </div>
                                          </div>
                                      </div>

                                      <div class="row menu-banner">
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <div>
                                                  <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                              </li>
                          </ul>
                      </li> --}}

                      {{-- <li>
                        <a href="#" class="dark-menu-item">Shop By Brand</a>
                        <ul>
                          @foreach ($rsrManufacturesComposerData->slice(0, 10) as $rsrManufacture)
                            <li><a href="{{ url('brands/'.$rsrManufacture->manufacturer_id) }}">{{ str_limit($rsrManufacture->full_manufacturer_name, 15) }}</a></li>
                          @endforeach
                          <li><a href="{{ url('brands') }}">View All Brands</a></li>
                        </ul>
                      </li> --}}


                      @foreach ($categoryGroupsComposerData as $categoryGroup)
                        <li class="mega">
                            <a href="#">{{ $categoryGroup->title }}</a>
                            <ul class="mega-menu full-mega-menu">
                                <li>
                                    <div class="container">
                                        <div class="row d-lg-none">
                                            @foreach ($categoryGroup->have_main_categories as $mainCategory)
                                                @if($mainCategory->has_main_category)
                                                    <div class="col-lg-2 mega-boxx">
                                                        <div class="link-section">
                                                            <div class="menu-title">
                                                                <h5>
                                                                  <a href="{{ url('main-categories/'.$mainCategory->has_main_category->slug) }}">{{ str_limit($mainCategory->has_main_category->name, 15) }}</a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="row menu-banner">
                                            @foreach ($categoryGroup->have_main_categories as $mainCategory)
                                                @if($mainCategory->has_main_category)
                                                    <div class="col-lg-2">
                                                        <div>
                                                            <a href="{{ url('main-categories/'.$mainCategory->has_main_category->slug) }}">
                                                                @if ($mainCategory->has_main_category->image)
                                                                    <img src="{{ asset('storage/categories/'.$mainCategory->has_main_category->image) }}" alt="{{ $option->title }}" class="img-fluid">
                                                                @else
                                                                    <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                                                @endif
                                                            </a>
                                                            <div class="link-section mt-2">
                                                                <div class="menu-title">
                                                                    <h5>
                                                                      <a href="{{ url('main-categories/'.$mainCategory->has_main_category->slug) }}">{{ str_limit($mainCategory->has_main_category->name, 15) }}</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </li>
                      @endforeach


                      @foreach ($rsrCategoryGroupsComposerData as $rsrCategoryGroup)
                        <li class="mega">
                            <a href="#">{{ $rsrCategoryGroup->title }}</a>
                            <ul class="mega-menu full-mega-menu">
                                <li>
                                    <div class="container">
                                        <div class="row d-lg-none">
                                            @foreach ($rsrCategoryGroup->have_rsr_main_categories as $rsrMainCategory)
                                                @if($rsrMainCategory->has_rsr_main_category)
                                                    <div class="col-lg-2 mega-boxx">
                                                        <div class="link-section">
                                                            <div class="menu-title">
                                                                <h5>
                                                                  <a href="{{ url('main-categories/'.$rsrMainCategory->has_rsr_main_category->department_id) }}">{{ str_limit($rsrMainCategory->has_rsr_main_category->department_name, 15) }}</a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="row menu-banner">
                                            @foreach ($rsrCategoryGroup->have_rsr_main_categories as $rsrMainCategory)
                                                @if($rsrMainCategory->has_rsr_main_category)
                                                    <div class="col-lg-2">
                                                        <div>
                                                            <a href="{{ url('main-categories/'.$rsrMainCategory->has_rsr_main_category->department_id) }}">
                                                                @if ($rsrMainCategory->has_rsr_main_category->image)
                                                                    <img src="{{ asset('storage/rsr-mian-categories/'.$rsrMainCategory->has_rsr_main_category->image) }}" alt="{{ $option->title }}" class="img-fluid">
                                                                @else
                                                                    <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                                                @endif
                                                            </a>
                                                            <div class="link-section mt-2">
                                                                <div class="menu-title">
                                                                    <h5>
                                                                      <a href="{{ url('main-categories/'.$rsrMainCategory->has_rsr_main_category->department_id) }}">{{ str_limit($rsrMainCategory->has_rsr_main_category->department_name, 15) }}</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </li>
                      @endforeach


                      <li>
                        <a href="#" class="dark-menu-item">Shop By</a>
                        <ul class="p-0" style="max-width: 10em;">
                          <li style="padding-left:0px !important"><div class="link-section"><div class="menu-title"><h5 style="margin-bottom:0px !important"> <a href="{{ url('main-categories') }}">Category</a></h5></div></div></li>
                          <li style="padding-left:0px !important"><div class="link-section"><div class="menu-title"><h5><a href="{{ url('brands') }}">Brand</a></h5></div></div></li>
                        </ul>
                      </li>
                      
                        <!--<li class="mega">-->
                        <!--      <a href="#">Shop By</a>-->
                        <!--      <ul class="mega-menu full-mega-menu">-->
                        <!--          <li>-->
                        <!--                              <div class="link-section">-->
                        <!--                                  <div class="menu-title">-->
                        <!--                                    <h5>-->
                        <!--                                      <a href="{{ url('main-categories') }}">Category</a>-->
                        <!--                                    </h5>-->
                        <!--                                  </div>-->
                        <!--                              </div>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                              <div class="link-section">-->
                        <!--                                  <div class="menu-title">-->
                        <!--                                    <h5>-->
                        <!--                                      <a href="{{ url('brands') }}">Brand</a>-->
                        <!--                                    </h5>-->
                        <!--                                  </div>-->
                        <!--                        </div>-->
                        <!--          </li>-->
                        <!--      </ul>-->
                        <!--</li>-->

                      @if (Auth::check())
                          <li>
                              <a href="#" class="dark-menu-item"> My Account</a>
                              <ul>
                                  {{-- @role('customer')
                                      <li><a href="{{ url('my-account') }}">Account</a></li>
                                      <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                                      <li><a href="{{ url('change-password') }}">Change Password</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endrole --}}

                                  {{-- @role('admin')
                                      <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endrole --}}

                                  @hasanyrole('super-admin|admin|manager')
                                      <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @else
                                      <li><a href="{{ url('my-account') }}">Account</a></li>
                                      <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                                      <li><a href="{{ url('change-password') }}">Change Password</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endhasanyrole
                              </ul>
                          </li>
                      @endif
                  </ul>


                  {{-- <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                    <li>
                      <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                    </li>

                    <li><a href="{{ url('/') }}" class="dark-menu-item">Home</a></li>
                    <li><a href="{{ url('products') }}" class="dark-menu-item">Products</a></li>

                    <li class="mega"><a href="#" class="dark-menu-item">Shop By Brand
                    </a>
                      <ul class="mega-menu full-mega-menu ">
                        <li>
                          <div class="container">
                            <div class="row">
                              @foreach ($rsrManufacturesComposerData->slice(0, 35) as $rsrManufacture)
                                  <div class="col-lg-2 mega-boxx">
                                      <div class="link-section">
                                          <div class="menu-title">
                                              <h5><a href="{{ url('brands/'.$rsrManufacture->manufacturer_id) }}">{{ str_limit($rsrManufacture->full_manufacturer_name, 15) }}</a></h5>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach

                              <div class="col-lg-2 mega-box_">
                                  <div class="link-section">
                                      <div class="menu-title">
                                          <h5>
                                              <a class="text-uppercase" href="{{ url('brands') }}">View All Brands</a>
                                          </h5>
                                      </div>

                                  </div>
                              </div>


                            </div>
                            <div class="row menu-banner">
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <img src="{{ asset('site/images/menu-banner1.jpg') }}" alt="menu-banner" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                  </ul> --}}


                </nav>
              </div>


              <div class="icon-block">
                <ul>
                  {{-- <li class="mobile-user onhover-dropdown"  onclick="openAccount()">
                    <a href="#"><i class="icon-user"></i>
                    </a>
                  </li> --}}

                {{--   <li class="mobile-wishlist" onclick="openWishlist()">
                    <a ><i class="icon-heart"></i><div class="cart-item"><div>0 item<span>wishlist</span></div></div></a></li> --}}

                  <li class="mobile-search"><a href="#"><i class="icon-search"></i></a>
                    <div class ="search-overlay">
                      <div>
                        <span class="close-mobile-search">×</span>
                        <div class="overlay-content">
                          <div class="container">
                            <div class="row">
                              <div class="col-xl-12">
                                {!! Form::open(['url' => 'products', 'method' => 'get']) !!}
                                {!! csrf_field() !!}
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search a Product" name="q"></div>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                                {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="mobile-setting mobile-setting-hover" onclick="openSetting()"><a href="#"><i class="icon-settings"></i></a>
                  </li>
                </ul>
              </div>


            </div>

            <div class="category-right">

              {{-- <div class="contact-block">
                <div>
                  <i class="fa fa-volume-control-phone"></i>
                  <span>call us<span>{{ $option->phone }}</span></span>
                </div>
              </div> --}}

              {{-- <div class="btn-group">
                <div  class="gift-block" data-toggle="dropdown">
                  <div class="grif-icon">
                    <i class="icon-gift"></i>
                  </div>
                  <div class="gift-offer">
                    <p>gift box</p>
                    <span>Festivel Offer</span>
                  </div>
                </div>
                <div class="dropdown-menu gift-dropdown">
                  <div class="media">
                    <div  class="mr-3">
                      <img src="../assets/images/icon/1.png" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                      <h5 class="mt-0">Billion Days</h5>
                      <p><img src="../assets/images/icon/currency.png" class="cash" alt="curancy"> Flat Rs. 270 Rewards</p>
                    </div>
                  </div>
                  <div class="media">
                    <div  class="mr-3">
                      <img src="../assets/images/icon/2.png" alt="Generic placeholder image" class="gift-bloc">
                    </div>
                    <div class="media-body">
                      <h5 class="mt-0">Fashion Discount</h5>
                      <p><img src="../assets/images/icon/fire.png"  class="fire" alt="fire">Extra 10% off (upto Rs. 10,000*) </p>
                    </div>
                  </div>
                  <div class="media">
                    <div  class="mr-3">
                      <img src="../assets/images/icon/3.png" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                      <h5 class="mt-0">75% off Store</h5>
                      <p>No coupon code is required.</p>
                    </div>
                  </div>
                  <div class="media">
                    <div  class="mr-3">
                      <img src="../assets/images/icon/6.png" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                      <h5 class="mt-0">Upto 50% off</h5>
                      <p>Buy popular phones under Rs.20.</p>
                    </div>
                  </div>
                  <div class="media">
                    <div  class="mr-3">
                      <img src="../assets/images/icon/5.png" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                      <h5 class="mt-0">Beauty store</h5>
                      <p><img src="../assets/images/icon/currency.png" class="cash" alt="curancy" > Flat Rs. 270 Rewards</p>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</header>