@extends('site.layouts.default')

@section('htmlheader_title')
    Server Error
@endsection

@section('main-content')
    <section class="fw-section margin-top-3x" style="background-image: url({{asset('site/img/404-bg.png')}});">
        <h1 class="display-404 text-center">404</h1>
    </section>
    <div class="container padding-bottom-3x mb-1">
        <div class="text-center">
            <h2>Server Error</h2>
            <p>It seems something wrong with the coding. or data not found <a href="{{url('/')}}">Go back to Homepage</a><br></p>
        </div>
    </div>
@endsection