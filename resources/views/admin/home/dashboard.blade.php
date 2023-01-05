@extends('admin.layouts.app')

@section('htmlheader_title')
    Dashboard
@endsection

@section('contentheader_title')
    Dashboard
@endsection

@section('contentheader_description')
    Control panel
@endsection

@section('breadcrumb_title')
@endsection

@section('page-style')
    <style>
        .small-box:hover{cursor: pointer;}
    </style>
@endsection

@section('main-content')
    <section id="dashboard" class="content_">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="row">
            @can('view products')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-blue-active" onclick="location.href = '{{ url('admin/products') }}';">
                        <div class="inner">
                            <h3>{{$products}}</h3>
                            <h4>Products</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <a href="{{ url('admin/products') }}" class="small-box-footer">Manage Products <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan

            {{-- @role('admin') --}}
            @can('view customers')
                 <div class="col-md-3 col-sm-6">
                     <div class="small-box bg-green-active" onclick="location.href = '{{ url('admin/customers/all') }}';">
                         <div class="inner">
                             <h3>{{$customers}}</h3>
                             <h4>Customers</h4>
                         </div>
                         <div class="icon">
                             <i class="fa fa-users"></i>
                         </div>
                         <a href="{{ url('admin/customers/all') }}" class="small-box-footer">Manage Customers <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
             @endcan
             {{-- @endrole --}}

             {{-- @can('view pages')
                 <div class="col-md-3 col-sm-6">
                     <div class="small-box bg-light-blue">
                         <div class="inner">
                             <h3>{{$storeCount}}</h3>
                             <h4>Stores</h4>
                         </div>
                         <div class="icon">
                             <i class="fa fa-building"></i>
                         </div>
                         <a href="{{ url('admin/stores') }}" class="small-box-footer">Manage Stores <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
             @endcan --}}

             @can('view orders')
                 <div class="col-md-3 col-sm-6">
                     <div class="small-box bg-yellow-gradient" onclick="location.href = '{{ url('admin/orders') }}';">
                         <div class="inner">
                             <h3>{{$orders}}</h3>
                             <h4>Orders</h4>
                         </div>
                         <div class="icon">
                             <i class="fa fa-shopping-cart"></i>
                         </div>
                         <a href="{{ url('admin/orders') }}" class="small-box-footer">Manage Orders <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
             @endcan




            @can('view categories')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-blue" onclick="location.href = '{{ url('admin/products-category') }}';">
                        <div class="inner">
                            <h3>{{$categories}}</h3>
                            <h4>Categories</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <a href="{{ url('admin/products-category') }}" class="small-box-footer">Manage Product Categories <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
           {{--  @can('view brands')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-light-blue-gradient">
                        <div class="inner">
                            <h3>{{$brands}}</h3>
                            <h4>Brands</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hdd-o"></i>
                        </div>
                        <a href="{{ url('admin/products-brand') }}" class="small-box-footer">Manage Brands <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            {{-- @can('view models')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-fuchsia">
                        <div class="inner">
                            <h3>{{$models}}</h3>
                            <h4>Models</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-sun-o"></i>
                        </div>
                        <a href="{{ url('admin/products-model') }}" class="small-box-footer">Manage Models <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            {{-- @can('view stores')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{ $storeProductCount }}</h3>
                            <h4>Store Products</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <a href="{{ url('admin/store-products') }}" class="small-box-footer"> Manage Store Products <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>{{ $salesPersonsCount }}</h3>
                            <h4>Sales persons</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <a href="{{ url('admin/sales-person') }}" class="small-box-footer"> Manage Sales Person <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

             
    
            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$contactCount}}</h3>
                            <h4>Pending Inquiries</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <a href="{{ url('admin/contacts') }}" class="small-box-footer">Manage Inquiries <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

           {{--  @can('view models')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-light-blue">
                        <div class="inner">
                            <h3>{{$models}}</h3>
                            <h1>Models</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hdd-o"></i>
                        </div>
                        <a href="{{ url('admin/products-model') }}" class="small-box-footer">Manage Models <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}
        </div>

        <div class="row">

            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <h3>{{ $storeManagersCount }}</h3>
                            <h4>Store Manager</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="{{ url('admin/store-manager') }}" class="small-box-footer"> Manage Store Managers <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}
            

            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3>{{$storeCategoryCount}}</h3>
                            <h4>Stores Divisions</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-sitemap"></i>
                        </div>
                        <a href="{{ url('admin/stores-category') }}" class="small-box-footer">Manage Stores <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{$storeCompaniesCount}}</h3>
                            <h4>Where to find us</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="{{ url('admin/companies') }}" class="small-box-footer">Manage where to find us <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            @can('view products')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-maroon" onclick="location.href = '{{ url('admin/rsr-products') }}';">
                        <div class="inner">
                            <h3>{{$rsrProductCount}}</h3>
                            <h4>RSR Products</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <a href="{{ url('admin/rsr-products') }}" class="small-box-footer">Manage RSR Products <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan

            @can('view categories')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-blue" onclick="location.href = '{{ url('admin/rsr-main-categories') }}';">
                        <div class="inner">
                            <h3>{{$rsrMainCategoryCount}}</h3>
                            <h4>RSR Main Categories</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <a href="{{ url('admin/rsr-main-categories') }}" class="small-box-footer">Manage RSR Main Categories <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan

            {{-- @can('view categories')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-purple" onclick="location.href = '{{ url('admin/rsr-sub-categories') }}';">
                        <div class="inner">
                            <h3>{{$rsrSubCategoryCount}}</h3>
                            <h4>RSR Sub Categories</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <a href="{{ url('admin/rsr-sub-categories') }}" class="small-box-footer">Manage RSR Sub Categories <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}

            @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-red" onclick="location.href = '{{ url('admin/contacts') }}';">
                        <div class="inner">
                            <h3>{{$contactCount}}</h3>
                            <h4>Pending Inquiries</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <a href="{{ url('admin/contacts') }}" class="small-box-footer">Manage Inquiries <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="row">
          {{--   @can('view products')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>0</h3>
                            <h1>Import</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-download"></i>
                        </div>
                        <a href="{{ url('admin/products/xlsx-import') }}" class="small-box-footer">Import Products <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}
          
          
        </div>

        {{-- <div class="row">
            @can('view events')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$events}}</h3>
                            <h1>Events</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <a href="{{ url('admin/events') }}" class="small-box-footer">Manage Events <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
            @can('view photos')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3>{{$photos}}</h3>
                            <h1>Photos</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-picture-o"></i>
                        </div>
                        <a href="{{ url('admin/photos') }}" class="small-box-footer">Manage Photos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan

            @can('view videos')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$videos}}</h3>
                            <h1>Videos</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-video-camera"></i>
                        </div>
                        <a href="{{ url('admin/videos') }}" class="small-box-footer">Manage Videos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan

            @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>{{$mediaLibrary}}</h3>
                            <h1>Media Library</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-link"></i>
                        </div>
                        <a href="{{ url('admin/media') }}" class="small-box-footer">Manage Videos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
        </div> --}}

        {{-- <div class="row">
            @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{$pages}}</h3>
                            <h1>Pages</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-leaf"></i>
                        </div>
                        <a href="{{ url('admin/pages') }}" class="small-box-footer">Manage Pages <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
            @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-gray-active">
                        <div class="inner">
                            <h3>{{$blocks}}</h3>
                            <h1>Blocks</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-th-large"></i>
                        </div>
                        <a href="{{ url('admin/blocks') }}" class="small-box-footer">Manage Slider <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
            @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3 style="visibility: hidden;">{{$blocks}}</h3>
                            <h1>Theme</h1>
                        </div>
                        <div class="icon">
                            <i class="fa fa-font"></i>
                        </div>
                        <a href="{{ url('admin/theme-settings') }}" class="small-box-footer">Manage Color/ Blocks <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan
        </div> --}}
        
        <div class="row">
            {{-- @can('view pages')
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$contactCount}}</h3>
                            <h4>Pending Inquiries</h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <a href="{{ url('admin/contacts') }}" class="small-box-footer">Manage Inquiries <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endcan --}}
        </div>
    </section>
@endsection