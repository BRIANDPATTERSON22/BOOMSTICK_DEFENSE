<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="{{(Request::is('*dashboard') ? 'active' : '')}}"><a href="{{ url('admin/dashboard') }}"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>

            <li class="header uppercase">SHOP MANAGEMENT</li>
            
            
            
          {{--   @can('view brands')
                <li class="{{(Request::is('admin/products-brand') ? 'active' : '')}}"><a href="{{ url('admin/products-brand') }}"><i class='fa fa-star'></i> Brands</a></li>
            @endcan
 --}}
            <!-- Product -->
            @can('view products')
                <li class="treeview {{(Request::is('admin/product**', '*coupon*', '*sales-person', '*category-group*') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-cubes'></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view products')
                            <li class="{{(Request::is('admin/products', 'admin/product/*/edit', 'admin/product/*/view') ? 'active' : '')}}"><a href="{{ url('admin/products') }}"><i class='fa fa-chevron-right'></i>Manage Products</a></li>
                        @endcan
                        @can('view products')
                            <li class="{{(Request::is('**product/add*') ? 'active' : '')}}"><a href="{{ url('admin/product/add') }}"><i class='fa fa-chevron-right'></i>Add Product</a></li>
                        @endcan
                        @can('view categories')
                            <li class="{{(Request::is('*products-category','*products-category/*/*') ? 'active' : '')}}"><a href="{{ url('admin/products-category') }}"><i class='fa fa-chevron-right'></i>Manage Categories</a></li>
                        @endcan
                        @can('view categories')
                            <li class="{{(Request::is('*category-sub*') ? 'active' : '')}}"><a href="{{ url('admin/products-category-sub') }}"><i class='fa fa-chevron-right'></i>Sub Categories</a></li>
                        @endcan
                      {{--   @can('view brands')
                            <li class="{{(Request::is('*products-category-type*') ? 'active' : '')}}"><a href="{{ url('admin/products-category-type') }}"><i class='fa fa-chevron-right'></i>Category Type</a></li>
                        @endcan --}}
                        @can('view brands')
                            <li class="{{(Request::is('*brand*') ? 'active' : '')}}"><a href="{{ url('admin/products-brand') }}"><i class='fa fa-chevron-right'></i>Manage Brands</a></li>
                        @endcan
                        {{-- @can('view brands')
                            <li class="{{(Request::is('*sales-person*') ? 'active' : '')}}"><a href="{{ url('admin/sales-person') }}"><i class='fa fa-chevron-right'></i>Manage Sales Persons</a></li>
                        @endcan --}}
                        @can('view models')
                            <li class="{{(Request::is('*model*') ? 'active' : '')}}"><a href="{{ url('admin/products-model') }}"><i class='fa fa-chevron-right'></i>Manage Model</a></li>
                        @endcan
                        @can('view brands')
                            <li class="{{(Request::is('*color*') ? 'active' : '')}}"><a href="{{ url('admin/products-color') }}"><i class='fa fa-chevron-right'></i>Manage Colors</a></li>
                        @endcan
                      {{--   @can('view brands')
                            <li class="{{(Request::is('*size*') ? 'active' : '')}}"><a href="{{ url('admin/products-size') }}"><i class='fa fa-chevron-right'></i>Manage Sizes</a></li>
                        @endcan --}}
                      {{--   @can('view brands')
                            <li class="{{(Request::is('*occasion-product*') ? 'active' : '')}}"><a href="{{ url('admin/occasion-product') }}"><i class='fa fa-chevron-right'></i>Occasion products</a></li>
                        @endcan --}}
                      {{--   @can('view brands')
                            <li class="{{(Request::is('*coupon*') ? 'active' : '')}}"><a href="{{ url('admin/coupons') }}"><i class='fa fa-ticket'></i> <span>Coupons</span></a></li>
                        @endcan --}}
                   {{--      @can('view products')
                            <li class="{{(Request::is('*imports*') ? 'active' : '')}}"><a href="{{ url('admin/products/xlsx-import') }}"><i class='fa fa-chevron-right'></i>Import Products</a></li>
                        @endcan --}}

                        @can('view categories')
                            <li class="{{(Request::is('*category-group*','*category-group/*/*') ? 'active' : '')}}"><a href="{{ url('admin/category-groups') }}"><i class='fa fa-chevron-right'></i>Category Groups</a></li>
                        @endcan

                        @can('view sliders')
                           <li class="{{(Request::is('*display-type/featured') ? 'active' : '')}}"><a href="{{ url('admin/display-type/featured') }}"><i class="fa fa-chevron-right"></i> <span>Featured Products</span></a></li>
                        @endcan

                        @can('view sliders')
                           <li class="{{(Request::is('*display-type/new') ? 'active' : '')}}"><a href="{{ url('admin/display-type/new') }}"><i class="fa fa-chevron-right"></i> <span>New Arrivals</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('view products')
                <li class="treeview {{(Request::is('admin/rsr-*') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-cubes'></i> <span>RSR Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view products')
                            <li class="{{(Request::is('admin/rsr-products', 'admin/rsr-product/*/edit', 'admin/rsr-product/*/view') ? 'active' : '')}}"><a href="{{ url('admin/rsr-products') }}"><i class='fa fa-chevron-right'></i>RSR Products</a></li>
                        @endcan

                        @can('view categories')
                            <li class="{{(Request::is('*rsr-main-categories','*rsr-main-category/*/*') ? 'active' : '')}}"><a href="{{ url('admin/rsr-main-categories') }}"><i class='fa fa-chevron-right'></i>RSR Main Categories</a></li>
                        @endcan

                        {{-- @can('view categories')
                            <li class="{{(Request::is('*rsr-sub-categories*') ? 'active' : '')}}"><a href="{{ url('admin/rsr-sub-categories') }}"><i class='fa fa-chevron-right'></i>RSR Sub Categories</a></li>
                        @endcan --}}

                        @can('view categories')
                            <li class="{{(Request::is('*rsr-category-group*','*rsr-category-group/*/*') ? 'active' : '')}}"><a href="{{ url('admin/rsr-category-groups') }}"><i class='fa fa-chevron-right'></i>RSR Category Groups</a></li>
                        @endcan

                        @can('view categories')
                            <li class="{{(Request::is('*rsr-retail-markup') ? 'active' : '')}}"><a href="{{ url('admin/rsr-retail-markup') }}"><i class='fa fa-chevron-right'></i>RSR Retail Markup</a></li>
                        @endcan

                        @can('view categories')
                            <li class="{{(Request::is('*rsr-main-category-filter-attributes') ? 'active' : '')}}"><a href="{{ url('admin/rsr-main-category-filter-attributes') }}"><i class='fa fa-chevron-right'></i>RSR Category Attributes</a></li>
                        @endcan

                        @can('view sliders')
                           <li class="{{(Request::is('*rsr-display-type/featured') ? 'active' : '')}}"><a href="{{ url('admin/rsr-display-type/featured') }}"><i class="fa fa-chevron-right"></i> <span>RSR Featured Products</span></a></li>
                        @endcan

                        @can('view sliders')
                           <li class="{{(Request::is('*rsr-display-type/new') ? 'active' : '')}}"><a href="{{ url('admin/rsr-display-type/new') }}"><i class="fa fa-chevron-right"></i> <span>RSR New Arrivals</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- @role('admin') --}}
                @can('view customers')
                    {{-- <li class="{{(Request::is('*customer*') ? 'active' : '')}}"><a href="{{ url('admin/customers') }}"><i class='fa fa-users'></i> <span>Customers</span></a></li> --}}
                    <li class="treeview {{(Request::is('*customer*') ? 'active' : '')}}">
                        <a href="#"><i class='fa fa-users'></i> <span>Customers</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @can('view customers')
                                <li class="{{(Request::is('*customers/all*') ? 'active' : '')}}"><a href="{{ url('admin/customers/all') }}"><i class='fa fa-chevron-right'></i> <span>All Customers</span></a>
                            @endcan
                            {{-- @can('view customers')
                                <li class="{{(Request::is('*customers/normal-customers*') ? 'active' : '')}}"><a href="{{ url('admin/customers/normal-customers') }}"><i class='fa fa-chevron-right'></i> <span>Normal Customers</span></a>
                            @endcan --}}
                            {{-- @can('view customers')
                                <li class="{{(Request::is('*customers/cake-time-club*') ? 'active' : '')}}"><a href="{{ url('admin/customers/cake-time-club') }}"><i class='fa fa-chevron-right'></i> <span>Club Customers</span></a>
                            @endcan --}}
                            {{-- @can('view customers')
                                <li class="{{(Request::is('*customers/trade*') ? 'active' : '')}}"><a href="{{ url('admin/customers/trade') }}"><i class='fa fa-chevron-right'></i> <span>Trade Customers</span></a>
                            @endcan --}}
                            {{-- @can('view customers')
                                <li class="{{(Request::is('*customers/wholesale*') ? 'active' : '')}}"><a href="{{ url('admin/customers/wholesale') }}"><i class='fa fa-chevron-right'></i> <span>Wholesale Customers</span></a>
                            @endcan --}}
                        </ul>
                    </li>
                @endcan
            {{-- @endrole --}}


            {{-- Store --}}
            {{-- @can('view products')
                <li class="{{(Request::is('*store') ? 'active' : '')}}"><a href="{{ url('admin/stores') }}"><i class='fa fa-building'></i> <span>Stores</span></a></li>
            @endcan --}}

           


            {{-- @can('view products')
                <li class="treeview {{(Request::is('*store*', '*admin/store-products') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-building'></i> <span>Stores</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view sliders')
                            <li class="{{(Request::is('*stores', '*store/*/edit', '*store/*/view') ? 'active' : '')}}"><a href="{{ url('admin/stores') }}"><i class='fa fa-chevron-right'></i> <span>Manage Store</span></a></li>
                            <li class="{{(Request::is('*store/add') ? 'active' : '')}}"><a href="{{ url('admin/store/add') }}"><i class='fa fa-chevron-right'></i> <span>Add</span></a></li>
                            <li class="{{(Request::is('*admin/store-products') ? 'active' : '')}}"><a href="{{ url('admin/store-products') }}"><i class='fa fa-database'></i> <span>Products In Store</span></a></li>
                            <li class="{{(Request::is('*admin/store-manager') ? 'active' : '')}}"><a href="{{ url('admin/store-manager') }}"><i class='fa fa-user'></i> <span>Store Manager</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}

            {{-- Producs in Store --}}
           {{--  @can('view stores')
                <li class="{{(Request::is('admin/store-products') ? 'active' : '')}}"><a href="{{ url('admin/store-products') }}"><i class='fa fa-database'></i> <span> Products In Store </span></a></li>
            @endcan --}}


            {{-- @can('view orders')
                <li class="{{(Request::is('*order*') ? 'active' : '')}}"><a href="{{ url('admin/orders') }}"><i class='fa fa-shopping-cart'></i> <span>Orders</span></a></li>
            @endcan

            @can('view shipping methods', 'view payment methods')
                @can('view shipping methods')
                    <li class="{{(Request::is('*shipping*') ? 'active' : '')}}"><a href="{{ url('admin/shippings') }}"><i class='fa fa-truck'></i> <span>Shipping Methods</span></a></li>
                @endcan

                @can('view payment methods')
                    <li class="{{(Request::is('*payment*') ? 'active' : '')}}"><a href="{{ url('admin/payments') }}"><i class='fa fa-credit-card'></i> <span>Payment Methods</span></a></li>
                @endcan
                 <li class="{{(Request::is('*coupon*') ? 'active' : '')}}"><a href="{{ url('admin/coupons') }}"><i class='fa fa-ticket'></i> <span>Coupons</span></a></li>
            @endcan --}}



            {{-- <li class="header">SITE MANAGEMENT</li> --}}
            

            @can(['view photos', 'view videos'])
                <!-- <li class="treeview {{(Request::is('*video*','*audio*','*photo*') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-camera-retro'></i> <span>Gallery</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view photos')
                            <li class="{{(Request::is('*photo*') ? 'active' : '')}}"><a href="{{ url('admin/photos') }}"><i class='fa fa-chevron-right'></i> Photo Albums</a></li>
                        @endcan
                        @can('view videos')
                            <li class="{{(Request::is('*video*') ? 'active' : '')}}"><a href="{{ url('admin/videos') }}"><i class='fa fa-chevron-right'></i> Video Albums</a></li>
                    @endcan
                    </ul>
                </li> -->

               {{--  <li class="treeview {{(Request::is('*sliders','*home-slider*') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-sliders'></i> <span>Sliders</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view sliders')
                            <li class="{{(Request::is('*/sliders') ? 'active' : '')}}"><a href="{{ url('admin/sliders') }}"><i class="fa fa-chevron-right"></i> <span>Home Page Slider</span></a></li>
                            <li class="{{(Request::is('*home-slider*') ? 'active' : '')}}"><a href="{{ url('admin/home-sliders') }}"><i class="fa fa-chevron-right"></i> <span>Category Slider</span></a></li>
                        @endcan
                    </ul>
                </li> --}}
            @endcan

            {{-- @can('view products')
                <li class="treeview {{(Request::is('admin/import/split', 'admin/import/category', 'admin/import/product') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-download'></i> <span>RSR Import</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view products')
                            <li class="{{(Request::is('admin/import/split') ? 'active' : '')}}"><a href="{{ url('admin/import/split') }}"><i class='fa fa-chevron-right'></i> <span>RSR Split</span></a></li>

                            <li class="{{(Request::is('admin/import/category') ? 'active' : '')}}"><a href="{{ url('admin/import/category') }}"><i class='fa fa-chevron-right'></i> <span>RSR Categories</span></a></li>

                            <li class="{{(Request::is('admin/import/product') ? 'active' : '')}}"><a href="{{ url('admin/import/product') }}"><i class='fa fa-chevron-right'></i> <span>RSR Product</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}



            {{-- @hasanyrole('super-admin|admin') --}}
                <li class="header uppercase">SITE MANAGEMENT</li>
            {{-- @endhasanyrole --}}

            @can('view sliders')
                {{-- <li class="{{(Request::is('*block*') ? 'active' : '')}}"><a href="{{ url('admin/blocks') }}"><i class="fa fa-th-large"></i> <span>Blocks/Widgets</span></a></li> --}}
               <li class="{{(Request::is('*slider*') ? 'active' : '')}}"><a href="{{ url('admin/sliders') }}"><i class="fa fa-sliders"></i> <span>Home page Banners</span></a></li>
            @endcan
            
            {{-- @can('view sliders')
               <li class="{{(Request::is('*display-type/featured') ? 'active' : '')}}"><a href="{{ url('admin/display-type/featured') }}"><i class="fa fa-bookmark"></i> <span>Featured Products</span></a></li>
            @endcan --}}

            {{-- @can('view sliders')
               <li class="{{(Request::is('*display-type/new') ? 'active' : '')}}"><a href="{{ url('admin/display-type/new') }}"><i class="fa fa-cube"></i> <span>New Arrivals</span></a></li>
            @endcan --}}

            {{-- @can('view brands')
                <li class="{{(Request::is('admin/compan*') ? 'active' : '')}}"><a href="{{ url('admin/companies') }}"><i class='fa fa-star'></i> <span>Where To Find Us</span> </a></li>
            @endcan --}}

            {{-- @can('view pages')
                <li class="{{(Request::is('*option*') ? 'active' : '')}}"><a href="{{ url('admin/options') }}"><i class='fa fa-cog'></i> <span>Manage Footer</span></a></li>
            @endcan --}}

{{--             @can('view pages')
                <li class="{{(Request::is('*product-notification*') ? 'active' : '')}}"><a href="{{ url('admin/product-notifications') }}"><i class='fa fa-bell'></i> <span>Product Notifications</span></a></li>
            @endcan --}}

           {{--  @can('view pages')
                <li class="{{(Request::is('*review*') ? 'active' : '')}}"><a href="{{ url('admin/reviews') }}"><i class="fa fa-comment-o"></i> <span>Reviews</span></a></li>
            @endcan --}}

           {{--  @can('view events')
                <li class="treeview {{(Request::is('*event','*blog*') ? 'active' : '')}}">
                    <a href="#"><i class='fa fa-newspaper-o'></i> <span>Blog</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @can('view sliders')
                            <li class="{{(Request::is('*blog*') ? 'active' : '')}}"><a href="{{ url('admin/blogs') }}"><i class='fa fa-newspaper-o'></i> <span>Manage Posts</span></a></li>
                            <li class="{{(Request::is('*blog*') ? 'active' : '')}}"><a href="{{ url('admin/blog/add') }}"><i class='fa fa-newspaper-o'></i> <span>Add</span></a></li>
                            <li class="{{(Request::is('*event*') ? 'active' : '')}}"><a href="{{ url('admin/events') }}"><i class='fa fa-calendar'></i> <span>Events</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}

            @can('view pages')
                <li class="{{(Request::is('*product-notification*') ? 'active' : '')}}"><a href="{{ url('admin/product-notifications') }}"><i class='fa fa-bell'></i> <span>Product Notifications</span></a></li>
            @endcan
            
            @can('view pages')
                <li class="{{(Request::is('*subscribes*') ? 'active' : '')}}"><a href="{{ url('admin/subscribes') }}"><i class='fa fa-rss'></i> <span>Subscribers</span></a></li>
            @endcan

        </ul>
    </section>
</aside>