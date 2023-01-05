<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    <head>
        @include('admin.partials.htmlheader')
    </head>
@show

<body class="
    @if(Auth::user()) 
        @role('super-admin')  @if($option->sidebar_skin_color) {{ $option->sidebar_skin_color }} @else skin-red-light  @endif @endrole
        @role('admin') skin-purple-light @endrole
        @role('manager') skin-yellow-light @endrole
    @endif 
    sidebar-mini 
    @if($option->is_sidebar_collapsed == 1) sidebar-collapse @endif ">
    <!--<body class="skin-red-light sidebar-mini">-->
<div class="wrapper">

@include('admin.partials.mainheader')

@include('admin.partials.sidebar')

    <div class="content-wrapper">

    @include('admin.partials.contentheader')

        <section class="content">

            @yield('main-content')
        </section>
    </div>

    @include('admin.partials.controlsidebar')

    @include('admin.partials.footer')

</div>

@section('scripts')
    @include('admin.partials.scripts')
@show

</body>
</html>