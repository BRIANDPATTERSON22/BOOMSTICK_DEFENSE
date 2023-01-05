@extends('site.layouts.default')

@section('htmlheader_title')
    Photo Gallery
@endsection

@section('page-style')
    <style>

        .gallery-thumb-main {
            background-size: cover;
            background-position: top;
            height: 250px;
        }
    </style>
@endsection

@section('main-content')
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>Photo Gallery</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}}">Home</a>
                    </li>
                    <li class="separator">&nbsp;</li>
                    <li>Photo Gallery</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container padding-bottom-3x mb-1">
        @if(count($allData)>0)
            <div class="row">
                <div class="col-lg-12 col-md-8 order-md-2">
                    <div class="gallery-wrapper-no-popup">
                        <div class="row">
                            @foreach($allData as $row)
                                <div class="col-md-3 col-sm-6">
                                    <div class="gallery-item">
                                        <a href="{{url('photo/'.$row->id)}}" style="border-radius:0px !important;">
                                            <div class="gallery-thumb-main" style="background-image:url('{{asset('storage/photos/'.$row->id.'/'.$row->image)}}" alt="{{$row->title}}')"> </div>
                                        </a>
                                        <span class="caption">{{$row->title}}</span>
                                    </div>
                                    <div style="background-color: #e6e6e6;padding: 12px;margin-top: -30px;">
                                        {{str_limit($row->title,30)}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pagination-->
            <nav class="pagination">
                <div class="column">
                    {{$allData->links()}}
                </div>
            </nav>
        @else
            <h3> No data found</h3>
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