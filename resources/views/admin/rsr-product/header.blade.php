@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif
{{-- @if(count($errors)>0)
    <div class="alert alert-danger" style="border-radius: 0px;margin-bottom: 0px;"><strong>Whoops!</strong> There
        were some problems with your input!
        @foreach ($errors->all() as $error)
            <strong>[ {{ $error }} ]</strong>
        @endforeach
    </div>
@endif --}}
<ul class="nav nav-tabs">
    <li @if(Request::is('*'.$module.'s')) class="active" @endif><a href="{{url('admin/'.$module.'s')}}"><i class="fa fa-list"></i> <span>Manage</span></a></li>
{{--     <li class="dropdown @if(Request::is('*archive*')) active @endif">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="fa fa-archive"></i> Archive <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @php $years = null; for($i= config('default.year'); $i<date('Y'); $i++){ $years [] = $i; } @endphp
            @foreach($years as $year)
                <li class="text-capitalize"><a href="{{ url('admin/'.$module.'s/archive/'.$year) }}"> {{$module}}(s) created in the Year {{$year}}</a></li>
            @endforeach
        </ul>
    </li> --}}
    {{-- <li @if(Request::is('*add')) class="active" @endif><a href="{{url('admin/'.$module.'/add')}}"><i class="fa fa-plus"></i> <span>Add</span></a></li> --}}

    {{-- <li class="dropdown @if(Request::is('*filter-by*')) active @endif">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="fa fa-filter"></i> Filter By <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
                <li class="text-capitalize"><a href="{{url('admin/'.$module.'s/filter-by/'.'disabled-cart')}}">Disabled Add to Cart</a></li>
                <li class="text-capitalize"><a href="{{url('admin/'.$module.'s/filter-by/'.'disabled-products')}}">Disabled Products</a></li>
        </ul>
    </li> --}}
    
    {{-- <li @if(Request::is('*products/xlsx-import')) class="active" @endif><a href="{{url('admin/'.$module.'s/xlsx-import')}}"><i class="fa fa-upload"></i> <span>Import</span></a></li> --}}

    <li @if(Request::is('admin/rsr-main-categories')) class="active" @endif><a href="{{url('admin/rsr-main-categories')}}"><i class="fa fa-sitemap" aria-hidden="true"></i><span>RSR Categories</span></a></li>

    @yield('actions')

    <li class="@if(Request::is('*trash')) active @endif pull-right"><a href="{{url('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted {{$module}}(s)"><i class="fa fa-trash-o"></i> <span>Deleted</span> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif</a></li>
</ul>