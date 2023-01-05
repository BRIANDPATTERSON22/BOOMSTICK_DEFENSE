@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif
@if(count($errors)>0)
    <div class="alert alert-danger" style="border-radius: 0px;margin-bottom: 0px;"><strong>Whoops!</strong> There
        were some problems with your input!
        @foreach ($errors->all() as $error)
            <strong>[ {{ $error }} ]</strong>
        @endforeach
    </div>
@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*'.$module.'s')) class="active" @endif><a href="{{url('admin/'.$module.'s')}}"><i class="fa fa-cog"></i> <span>Site Settings</span></a></li>

    {{-- <li @if(Request::is('*'.'theme-settings')) class="active" @endif><a href="{{url('admin/theme-settings')}}"><i class="fa fa-paint-brush"></i> <span>Theme Settings</span></a></li> --}}

    <li @if(Request::is('*'.'product-settings')) class="active" @endif><a href="{{url('admin/product-settings')}}"><i class="fa fa-cubes"></i> <span>Product Settings</span></a></li>

    @yield('actions')
    {{-- <li class="@if(Request::is('*trash')) active @endif pull-right"><a href="{{url('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted {{$module}}(s)"><i class="fa fa-trash-o"></i> <span>Deleted</span> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif</a></li> --}}
</ul>