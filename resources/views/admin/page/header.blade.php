@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*'.$module.'s')) class="active" @endif><a href="{{url('admin/'.$module.'s')}}"><i class="fa fa-list"></i> <span>Manage</span></a></li>
    <li @if(Request::is('*add')) class="active" @endif><a href="{{url('admin/'.$module.'/add')}}"><i class="fa fa-plus"></i> <span>Add</span></a></li>
    <li><a target="_blank" href="{{url('admin/media')}}"><i class="fa fa-medium"></i> <span>Media</span></a></li>
    @yield('actions')
    <li class="@if(Request::is('*trash')) active @endif pull-right"><a href="{{url('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted {{$module}}(s)"><i class="fa fa-trash-o"></i> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif</a></li>
</ul>