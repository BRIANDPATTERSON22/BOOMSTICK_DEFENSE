@extends('site.layouts.default')

@section('htmlheader_title')
    @if($singleData->meta_title) {{$singleData->meta_title}} @else {{$singleData->title}} @endif | Events
@endsection

@section('meta_keywords')
    @if($singleData->meta_keyword) {{$singleData->meta_keyword}} @else {{$singleData->title}} @endif
@endsection

@section('meta_description')
    @if($singleData->meta_description) {{$singleData->meta_description}} @else {{$singleData->title}} @endif
@endsection

@section('og_tags')
    <!-- Meta Tags need to place on the news detailed description at blade file of it -->
    <meta property="og:image" content="@if($singleData->image) {{asset('images/events/'.$singleData->id.'/'.$singleData->image)}} @else {{asset('images/options/'.$option->logo)}} @endif" >
    <meta property="og:type" content="Event" />
    <meta property="og:url" content="{{url('event/'.$singleData->id)}}"  >
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
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="separator">&nbsp;</li>
                    <li><a href="{{url('events')}}">Events</a></li>
                    <li class="separator">&nbsp;</li>
                    <li>{{str_limit($singleData->title,10)}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container padding-bottom-3x mb-2">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <ul class="post-meta mb-4">
                    <li><i class="icon-clock"></i>{{$singleData->date}} | {{$singleData->time}}</li>
                    <li><i class="icon-map-pin"></i>{{str_limit($singleData->venue, 40)}}</li>
                </ul>
                <div class="gallery-wrapper">
                    <div class="">
                        <a href="{{asset('storage/events/'.$singleData->image)}}">
                            @if($singleData->image)
                                <img class="img-responsive" src="{{asset('storage/events/'.$singleData->image)}}">
                            @endif
                        </a>
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
                        <!-- Widget Featured Posts-->
                        <section class="widget widget-featured-posts">
                            <h3 class="widget-title">Other Events</h3>
                            <!-- Entry-->
                            @foreach($otherData as $row)
                                <div class="entry">
                                    <div class="entry-thumb">
                                        <a href="{{url('event/'.$row->id)}}">
                                            @if($row->image)
                                                <img class="img-responsive" src="{{asset('storage/events/'.$row->image)}}" alt="{{$row->title}}">
                                            @else
                                                <img class="img-responsive" src="{{asset('site/img/default.png')}}" alt="{{$row->title}}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="entry-content">
                                        <h4 class="entry-title"><a href="{{url('event/'.$row->id)}}">{{str_limit($row->title, 40)}}</a></h4><span class="entry-meta">{{$row->date}} at {{str_limit($row->venue, 10)}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </aside>
                @endif
            </div>
        </div>
    </div>
@endsection