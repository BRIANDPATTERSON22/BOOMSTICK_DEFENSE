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
    <li @if(Request::is('*'.$module.'s')) class="active" @endif><a href="{{URL::to('admin/'.$module.'s')}}"><i class="fa fa-list"></i> <span>Manage</span></a></li>
    <li @if(Request::is('*category*')) class="active" @endif><a href="{{URL::to('admin/'.$module.'s/category')}}"><i class="fa fa-cubes"></i> <span>Category</span></a></li>
    <li @if(Request::is('*add')) class="active" @endif><a href="{{URL::to('admin/'.$module.'/add')}}"><i class="fa fa-plus"></i> <span>Add</span></a></li>
    @yield('actions')
    <li class="@if(Request::is('*trash')) active @endif pull-right"><a href="{{URL::to('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted {{$module}}(s)"><i class="fa fa-trash-o"></i> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif</a></li>
</ul>