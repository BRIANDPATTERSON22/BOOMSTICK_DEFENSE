@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*'.$module.'s')) class="active" @endif>
        <a href="{{url('admin/'.$module.'s')}}">
            <i class="fa fa-list"></i> <span>Manage Slider</span>
        </a>
    </li>

{{--     <li @if(Request::is('*add')) class="active" @endif>
        <a href="{{url('admin/'.$module.'/add')}}">
            <i class="fa fa-plus"></i> <span>Add</span>
        </a>
    </li> --}}

{{--     <li @if(Request::is('admin/'.$module.'s-category', 'admin/'.$module.'s-category/*/edit')) class="active" @endif>
        <a href="{{url('admin/'.$module.'s-category')}}">
            <i class="fa fa-sitemap"></i> <span>{{ ucfirst($module) }} Categories</span>
        </a>
    </li> --}}

    @yield('actions')
    
    {{-- <li class="@if(Request::is('*trash')) active @endif pull-right">
        <a href="{{url('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted Items">
            <i class="fa fa-trash-o"></i> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif
        </a>
    </li> --}}
</ul>