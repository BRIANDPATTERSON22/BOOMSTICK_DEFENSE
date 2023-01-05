@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('admin/product-notifications')) class="active" @endif>
        <a href="{{url('admin/product-notifications')}}"><i class="fa fa-list"></i> <span>Manage</span></a>
    </li>

    {{-- <li class="dropdown @if(Request::is('*archive*')) active @endif">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="fa fa-archive"></i> Archive <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @php
                $years = null;
                for($i= 2016; $i<date('Y'); $i++){
                    $years [] = $i;
                }
            @endphp
            @foreach($years as $year)
                <li><a href="{{ url('admin/subscribes/archive/'.$year) }}">Subscribers created in the Year {{$year}}</a></li>
            @endforeach
        </ul>
    </li> --}}

    {{-- <li @if(Request::is('admin/subscribes/export/csv')) class="active" @endif>
        <a href="{{url('admin/subscribes/export/csv')}}"><i class="fa fa-file-excel-o"></i> <span>Export</span></a>
    </li> --}}
    
    <li class="@if(Request::is('*trash')) active @endif pull-right">
        <a href="{{url('admin/product-notifications/trash')}}"><i class="fa fa-trash-o"></i> <span>Deleted</span> @if(Request::is('admin/product-notifications')) ({{$deleteCount}}) @endif</a>
    </li>
    @yield('actions')
</ul>