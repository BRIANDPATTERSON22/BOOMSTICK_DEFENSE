@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*'.$module.'s')) class="active" @endif><a href="{{url('admin/'.$module.'s')}}"><i class="fa fa-list"></i> <span>Manage</span></a></li>
    <li class="dropdown @if(Request::is('*archive*')) active @endif">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="fa fa-archive"></i> Archive <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @php $years = null; for($i= config('default.year'); $i<date('Y'); $i++){ $years [] = $i; } @endphp
            @foreach($years as $year)
                <li class="text-capitalize"><a href="{{ url('admin/'.$module.'s/archive/'.$year) }}"> {{$module}}(s) created in the Year {{$year}}</a></li>
            @endforeach
        </ul>
    </li>
    {{-- <li @if(Request::is('*add')) class="active" @endif><a href="{{url('admin/'.$module.'/add')}}"><i class="fa fa-plus"></i> <span>Add</span></a></li> --}}
    @yield('actions')
    <li class="@if(Request::is('*trash')) active @endif pull-right"><a href="{{url('admin/'.$module.'s/trash')}}" class="text-muted" title="Deleted Items"><i class="fa fa-trash-o"></i> @if(Request::is('*/'.$module.'s')) ({{$deleteCount}}) @endif</a></li>
</ul>