@extends('site.layouts.default')

@section('htmlheader_title')
    @if($singleData->meta_title) {{$singleData->meta_title}} @else {{$singleData->title}} @endif
@endsection

@section('meta_keywords')
    @if($singleData->meta_keyword) {{$singleData->meta_keyword}} @else {{$singleData->title}} @endif
@endsection

@section('meta_description')
    @if($singleData->meta_description) {{$singleData->meta_description}} @else {{$singleData->title}} @endif
@endsection

@section('og_tags')
    <!-- Meta Tags need to place on the news detailed description at blade file of it -->
    <meta property="og:image" content="@if($singleData->image) {{asset('images/pages/'.$singleData->id.'/'.$singleData->image)}} @else {{asset('images/options/'.$option->logo)}} @endif" >
    <meta property="og:type" content="Page" />
    <meta property="og:url" content="{{ url($singleData->slug) }}"  >
    <meta property="og:title" content="{{$singleData->title}}"  >
    <meta property="og:site_name" content="{{$option->name}}" />
    <meta property="og:description" content="{{str_limit($singleData->summary, 100)}}" >
    <meta property="fb:app_id" content="1624258444534090" >
@endsection

@section('page-style')
  <style>
    .about_page {background: #f5f8fc none repeat scroll 0 0;}
    .font_30{font-size: 30px !important;}
  </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>{{ $singleData->title }}</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>{{ $singleData->title }}</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <section class="about-page section-big-py-space">
      <div class="custom-container">
          <div class="row">
              <div class="col-lg-8 mx-auto">
                  <div class="inno_shadow_dark p-4 br_20">
                    @if($singleData->image)
                      <div class="banner-section">
                        <img src="{{ asset('storage/pages/'.$singleData->image) }}" class="img-fluid w-100" alt="">
                      </div>
                    @endif

                    {!! $singleData->content !!}
                  </div>
              </div>
          </div>
      </div>
  </section>
@endsection