<header>
    <div class="mobile-fix-option"></div>

    <div class="top-header">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-5 col-md-7 col-sm-6">
                    <div class="top-header-left">
                        <div class="shpping-order">
                            <h6>{{ $option->email }} </h6>
                        </div>
                        {{-- <div class="app-link">
                            <h6>
                              Download aap
                            </h6>
                            <ul>
                              <li><a><i class="fa fa-apple" ></i></a></li>
                              <li><a><i class="fa fa-android" ></i></a></li>
                              <li><a><i class="fa fa-windows" ></i></a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-7 col-md-5 col-sm-6">
                    <div class="top-header-right">
            
                        <div class="top-menu-block">
                            <ul>
                                @if (Auth::check())
                                    @role('customer')
                                        <li><a href="{{ url('my-account') }}">Hi, {{ str_limit(Auth::user()->name, 15) }}</a></li>
                                        <li><a href="{{ url('logout') }}">Logout</a></li>
                                    @endrole
                                @else
                                    <li><a href="{{ url('register') }}">Register</a></li>
                                    <li><a href="{{ url('login') }}">Login</a></li>
                                @endif
                            </ul>
                        </div>
                        
                        @if (Auth::check())
                            <div class="language-block">
                                <div class="language-dropdown">
                                    <span  class="language-dropdown-click">
                                        My Account <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                    <ul class="language-dropdown-open">
                                        @if (Auth::check())
                                            @role('customer')
                                                <li><a href="{{ url('my-account') }}">Account</a></li>
                                                <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                                                <li><a href="{{ url('change-password') }}">Change Password</a></li>
                                                <li><a href="{{ url('logout') }}">Logout</a></li>
                                            @endrole
                                            @role('admin')
                                                <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                                <li><a href="{{ url('logout') }}">Logout</a></li>
                                            @endrole
                                        @else
                                            <li><a href="{{ url('register') }}">Register</a></li>
                                            <li><a href="{{ url('login') }}">Login</a></li>
                                        @endif
                                    </ul>
                                </div>
                                {{-- <div class="curroncy-dropdown">
                                    <span class="curroncy-dropdown-click">
                                        usd<i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                    <ul class="curroncy-dropdown-open">
                                        <li><a href="layout-5.html#"><i class="fa fa-inr"></i>inr</a></li>
                                        <li><a href="layout-5.html#"><i class="fa fa-usd"></i>usd</a></li>
                                        <li><a href="layout-5.html#"><i class="fa fa-eur"></i>eur</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="layout-header1 layout-header1-inverse">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-menu-block">
                        <div class="menu-left">
                            <div class="sm-nav-block">
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

                                    <li>
                                        <a href="{{ url('main-categories') }}">View All Categories <i class="fa fa-angle-down"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="brand-logo">
                                <a href="{{url('/')}}">
                                    @if($option->logo)
                                        <img src="{{asset('storage/options/'.$option->logo)}}" alt="{{$option->name}}"> 
                                    @else
                                        {{str_limit($option->name, 20)}}
                                    @endif
                                </a>
                            </div>
                        </div>
                        
                        <div class="menu-right">
                            <div class="toggle-block">
                                <nav id="main-nav">
                                    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                        <li>
                                            <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                        </li>

                                        <li> <a href="{{ url('/') }}">Home</a> </li>

                                        <!--<li> <a href="{{ url('products') }}">Products</a> </li>-->

                                        @foreach ($rsrMainMenuCategoriesComposerData->slice(0, 3) as $rsrMainMenuCategory)
                                            <li class="mega">
                                                <a href="#">{{ str_limit($rsrMainMenuCategory->category_name, 10) }}</a>
                                                <ul class="mega-menu full-mega-menu">
                                                    <li>
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach ($rsrMainMenuCategory->rsr_sub_categories as $rsrSubCategory)
                                                                    <div class="col-lg-4 mega-boxx">
                                                                        <div class="link-section">
                                                                            <div class="menu-title">
                                                                                <h5><a href="">{{ str_limit($rsrSubCategory->value, 50) }}</a></h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                {{-- <div class="col-lg-2 mega-box_">
                                                                    <div class="link-section">
                                                                        <div class="menu-title">
                                                                            <h5>
                                                                                <a class="text-uppercase" href="{{ url('main-categories') }}">View All Sub Categories</a>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endforeach

                                        <li class="mega"><a href="#">Categories
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
                                                                        {{-- <div class="menu-content">
                                                                            <ul>
                                                                                <li><a href="#l">{{ $rsrCategory->category_name }}</a></li>
                                                                            </ul>
                                                                        </div> --}}
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
                                                                    {{-- <div class="menu-content">
                                                                        <ul>
                                                                            <li><a href="#l">{{ $rsrCategory->category_name }}</a></li>
                                                                        </ul>
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="mega">
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
                                                                        {{-- <div class="menu-content">
                                                                            <ul>
                                                                                <li><a href="#l">{{ $rsrManufacture->manufacturer_id }}</a></li>
                                                                            </ul>
                                                                        </div> --}}
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
                                                                    {{-- <div class="menu-content">
                                                                        <ul>
                                                                            <li><a href="#l">{{ $rsrCategory->category_name }}</a></li>
                                                                        </ul>
                                                                    </div> --}}
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
                                    </ul>
                                </nav>
                            </div>

                            <div>
                                <div class="icon-nav">
                                    <ul>
                                        <li class="mobile-user onhover-dropdown" onclick="openAccount()"><a href="#"><i class="icon-user"></i></a>
                                        </li>

                                        <li class="mobile-wishlist d-lg-none d-xl-none d-md-none" onclick="openWishlist()"><a href="#"><i class="icon-heart"></i><div class="cart-item"><div>0 item<span>wishlist</span></div></div></a></li>
                                        
                                        <li class="mobile-search" onclick="openSearch()"><a href="#"><i class="icon-search"></i></a>
                                            <div class ="search-overlay">
                                                <div>
                                                    <span class="close-mobile-search">×</span>
                                                    <div class="overlay-content">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <form>
                                                                        <div class="form-group"><input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search a Product"></div>
                                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="mobile-setting mobile-setting-hover" onclick="openSetting()"><a href="#"><i class="icon-settings"></i></a>
                                            {{-- <div class="mobile-setting-show">
                                                <h6>language</h6>
                                                <ul>
                                                    <li><a href="layout-5.html#">english</a></li>
                                                    <li><a href="layout-5.html#">french</a></li>
                                                </ul>
                                                <h6 class="curroncy">currency</h6>
                                                <ul>
                                                    <li><a href="layout-5.html#">euro</a></li>
                                                    <li><a href="layout-5.html#">rupees</a></li>
                                                    <li><a href="layout-5.html#">pound</a></li>
                                                    <li><a href="layout-5.html#">doller</a></li>
                                                </ul>
                                            </div> --}}
                                        </li>
                                    </ul>
                                    <div class="cart-block mobile-cart cart-hover-div" onclick="openCart()">
                                        <a href="#">
                                            <span class="cart-product">@if(Cart::instance('cart')->count()>0) {{Cart::content()->count()}} @else 0 @endif</span>
                                            <i class="icon-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="category-header category-header-inverse">
        <div class="custom-container">
            <div class="row">
                <div class="col">
                    <div class="navbar-menu">
                        <div class="category-left">
                            <div class=" nav-block">
                                <div class="nav-left">
                                    <nav class="navbar" data-toggle="collapse" data-target="#navbarToggleExternalContent">
                                        <button class="navbar-toggler" type="button">
                                            <span class="navbar-icon"><i class="fa fa-arrow-down"></i></span>
                                        </button>
                                        <h5 class="mb-0 ml-3 text-white title-font">Shop by category</h5>
                                    </nav>
                                    <div class="collapse  nav-desk" id="navbarToggleExternalContent">
                                        <ul class="nav-cat title-font m-0">
                                            @foreach ($categoriesComposerData as $row)
                                                <li> <img src="{{ asset('site/images/layout-1/nav-img/01.png') }}" alt="category-banner"> <a href="{{url('main-category/'.$row->slug)}}">{{ $row->name }}</a></li>
                                            @endforeach
                                            <li> <img src="{{ asset('site/images/layout-1/nav-img/01.png') }}" alt="category-banner"> <a href="{{url('main-categories')}}">View All Categories</a></li>
                                            {{-- <li>
                                              <ul class="mor-slide-open">
                                                  <li> <img src="../assets/images/layout-1/nav-img/08.png" alt="category-banner"> <a>Sports</a></li>
                                                  <li> <img src="../assets/images/layout-1/nav-img/09.png" alt="category-banner"> <a>Bags, Luggage</a></li>
                                                  <li> <img src="../assets/images/layout-1/nav-img/10.png" alt="category-banner"> <a>Movies, Music </a></li>
                                                  <li> <img src="../assets/images/layout-1/nav-img/11.png" alt="category-banner"> <a>Video Games</a></li>
                                                  <li> <img src="../assets/images/layout-1/nav-img/12.png" alt="category-banner"> <a>Toys, Baby Products</a></li>
                                              </ul>
                                            </li>
                                            <li >
                                                <a class="mor-slide-click">View All Categories <i class="fa fa-angle-down pro-down"></i><i class="fa fa-angle-up pro-up"></i></a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="input-block">
                                <div class="input-box">
                                    <form class="big-deal-form">
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <span class="search"><i class="fa fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Search a Product" >
                                            {{-- <div class="input-group-prepend">
                                                <select>
                                                    <option>All Category</option>
                                                    <option>indurstrial</option>
                                                    <option>sports</option>
                                                </select>
                                            </div> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="category-right">
                            <div class="contact-block mr-2">
                                <div>
                                    <i class="fa fa-volume-control-phone"></i>
                                    <span>call us<span>{{ $option->phone }}</span></span>
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="gift-block" data-toggle="dropdown" >
                                    <div class="grif-icon">
                                        <i class="icon-gift"></i>
                                    </div>
                                    <div class="gift-offer">
                                        <p>Daily</p>
                                        <span>Deals</span>
                                    </div>
                                </div>
                                {{-- <div class="dropdown-menu gift-dropdown">
                                    <div class="media">
                                        <div  class="mr-3">
                                            <img src="../assets/images/icon/1.png" alt="Generic placeholder image">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0">Billion Days</h5>
                                            <p><img src="../assets/images/icon/currency.png" class="cash" alt="gift-block"> Flat Rs. 270 Rewards</p>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div  class="mr-3">
                                            <img src="../assets/images/icon/2.png" alt="Generic placeholder image">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0">Fashion Discount</h5>
                                            <p><img src="../assets/images/icon/fire.png"  class="fire" alt="gift">Extra 10% off (upto Rs. 10,000*) </p>
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
                                            <p><img src="../assets/images/icon/currency.png" class="cash" alt="gift"> Flat Rs. 270 Rewards</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


