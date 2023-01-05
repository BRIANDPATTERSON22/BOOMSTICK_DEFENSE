@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*'.str_plural($module))) class="active" @endif>
        <a href="{{url('admin/'.str_plural($module))}}"><i class="fa fa-list"></i> <span>Manage</span></a>
    </li>
    <li @if(Request::is('*add')) class="active" @endif>
        <a href="{{url('admin/'.$module.'/add')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
    </li>
    @yield('actions')
    <li class="@if(Request::is('*trash')) active @endif pull-right">
        <a href="{{url('admin/'.str_plural($module).'/trash')}}" class="text-muted" title="Deleted Items">
            <i class="fa fa-trash-o"></i> @if(Request::is('*/'.str_plural($module))) ({{$deleteCount}}) @endif
        </a>
    </li>
</ul>