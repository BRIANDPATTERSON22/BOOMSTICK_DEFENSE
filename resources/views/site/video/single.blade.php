@extends('site.layouts.default')

@section('htmlheader_title')
    @if($singleData->meta_title) {{$singleData->meta_title}} @else {{$singleData->title}} @endif | Videos
@endsection

@section('meta_keywords')
    @if($singleData->meta_keyword) {{$singleData->meta_keyword}} @else {{$singleData->title}} @endif
@endsection

@section('meta_description')
    @if($singleData->meta_description) {{$singleData->meta_description}} @else {{$singleData->title}} @endif
@endsection

@section('og_tags')
    <!-- Meta Tags need to place on the news detailed description at blade file of it -->
    <meta property="og:image" content="@if($singleData->image) {{asset('images/videos/'.$singleData->id.'/'.$singleData->image)}} @else {{asset('images/options/'.$option->logo)}} @endif" >
    <meta property="og:type" content="Video" />
    <meta property="og:url" content="{{url('video/'.$singleData->album->slug.'/'.$singleData->id)}}"  >
    <meta property="og:title" content="{{$singleData->title}}"  >
    <meta property="og:site_name" content="{{$option->name}}" />
    <meta property="og:description" content="{{str_limit($singleData->summary, 100)}}" >
    <meta property="fb:app_id" content="328547797314364" >
@endsection

@section('pagebreadcrumb_title')

@endsection

@section('main-content')
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>{{str_limit($singleData->title,30)}}</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}}">Home</a>
                    </li>
                    <li class="separator">&nbsp;</li>
                    <li><a href="{{url('videos')}}">Video Gallery</a></li>
                    <li class="separator"> </li>
                    <li>{{str_limit($singleData->title,15)}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container padding-bottom-3x mb-2">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="gallery-wrapper">
                    <div style="max-width: 540px; text-align: center">
                        <div style="margin: auto">
                            @if($singleData->type == "youtube")
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="https://www.youtube.com/embed/{{$singleData->code}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                                </div>
                            @elseif($singleData->type == "vimeo")
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="https://player.vimeo.com/video/{{$singleData->code}}?color=ffffff&title=0&byline=0&portrait=0" width="100%" height="320px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            @elseif($singleData->type == "smule")
                                <iframe frameborder="0" width="100%" src="https://www.smule.com/recording/bette-midler-in-my-life/{{$singleData->code}}/frame"></iframe>
                            @elseif($singleData->type == "facebook")
                                <div class="fb-video" data-href="{{$singleData->code}}" data-width="500" data-allowfullscreen="true"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <h3 class="pt-4">{{$singleData->title}}</h3>
                <hr>
                <p>{!! $singleData->content !!}</p>
            </div>

            <div class="col-xl-3 col-lg-4">
                @if(count($otherData)>0)
                    <div class="sidebar-toggle position-left"><i class="icon-filter"></i></div>
                    <aside class="sidebar sidebar-offcanvas position-left"><span class="sidebar-close"><i class="icon-x"></i></span>
                        <section class="widget widget-categories">
                            <h3 class="widget-title">Other Videos</h3>
                            <ul>
                                @foreach($otherData as $row)
                                    <li><a href="{{url('video/'.$row->album->slug.'/'.$row->id)}}">{{str_limit($row->title, 30)}}</a></li>
                                @endforeach
                            </ul>
                        </section>
                    </aside>
                @endif
            </div>
        </div>
    </div>
@endsection