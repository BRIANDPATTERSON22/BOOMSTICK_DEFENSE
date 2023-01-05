<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    @section('htmlheader')
        @include('site.partials.htmlheader')
    @show
  </head>
  <body class="bg-light dark">
    
    <div class="loader-wrapper" style="display: none;">
        <div>
            <img src="{{ asset('site/images/search.gif') }}" alt="loader">
        </div>
    </div>

    {{-- @include('site.partials.mainheader') --}}
    @include('site.partials.mainheader_2')

    @yield('main-content')

    @include('site.partials.footer')
    {{-- @include('site.partials.footer_2') --}}

    @section('scripts')
        @include('site.partials.scripts')
    @show
  </body>
</html>
