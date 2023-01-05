@extends('site.layouts.default')

@section('htmlheader_title')
    @if($album->meta_title) {{$album->meta_title}} @else {{$album->title}} @endif | Photos
@endsection

@section('meta_keywords')
    @if($album->meta_keyword) {{$album->meta_keyword}} @else {{$album->title}} @endif
@endsection

@section('meta_description')
    @if($album->meta_description) {{$album->meta_description}} @else {{$album->title}} @endif
@endsection

@section('og_tags')
    <!-- Meta Tags need to place on the news detailed description at blade file of it -->
    <meta property="og:image" content="@if($album->image) {{asset('images/photos/'.$album->id.'/'.$album->image)}} @else {{asset('images/options/'.$option->logo)}} @endif" >
    <meta property="og:type" content="Photo" />
    <meta property="og:url" content="{{url('photo/'.$album->id)}}"  >
    <meta property="og:title" content="{{$album->title}}"  >
    <meta property="og:site_name" content="{{$option->name}}" />
    <meta property="og:description" content="{{str_limit($album->content, 100)}}" >
    <meta property="fb:app_id" content="328547797314364" >
@endsection

@section('pagebreadcrumb_title')

@endsection

@section('main-content')
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>{{str_limit($album->title,30)}}</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}}">Home</a>
                    </li>
                    <li class="separator">&nbsp;</li>
                    <li><a href="{{url('photos')}}">Photo Gallery</a></li>
                    <li class="separator">&nbsp;</li>
                    <li>{{str_limit($album->title,15)}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container padding-bottom-3x mb-1">
        @if(count($photos)>0)
            <div class="row">
                <div class="col-lg-12 col-md-8 order-md-2">
                    <div class="gallery-wrapper isotope-grid cols-3 grid-no-gap">
                        <div class="gutter-sizer"></div>
                        <div class="grid-sizer"></div>
                        @foreach($photos as $row)
                            <div class="grid-item gallery-item">
                                <a href="{{asset('storage/photos/'.$album->id.'/'.$row->image)}}" data-size="1000x667">
                                    <img src="{{asset('storage/photos/'.$album->id.'/'.$row->image)}}" alt="{{$row->title}}">
                                </a>
                                <span class="caption">{{$row->title}}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            No Gallery Found!
        @endif
    </div>

    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
@endsection