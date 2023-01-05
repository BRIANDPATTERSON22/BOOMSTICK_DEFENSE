@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

<ul class="nav nav-tabs">
    <li @if(Request::is('*reviews')) class="active" @endif>
        <a href="{{url('admin/reviews')}}"><i class="fa fa-list"></i> <span>Manage</span></a>
    </li>    <li class="dropdown @if(Request::is('*archive*')) active @endif">
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
                <li><a href="{{ url('admin/reviews/archive/'.$year) }}">Reviews created in the Year {{$year}}</a></li>
            @endforeach
        </ul>
    </li>
    <li class="@if(Request::is('*trash')) active @endif pull-right">
        <a href="{{url('admin/reviews/trash')}}"><i class="fa fa-trash-o"></i> <span>Deleted</span> @if(Request::is('admin/reviews')) ({{$deleteCount}}) @endif</a>
    </li>
    @yield('actions')
</ul>