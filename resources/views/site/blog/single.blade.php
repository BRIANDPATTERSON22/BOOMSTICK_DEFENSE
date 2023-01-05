@extends('site.layouts.default')

@section('htmlheader_title')
    @if($singleData->meta_title) {{$singleData->meta_title}} @else {{$singleData->title}} @endif | Blogs
@endsection

@section('meta_keywords')
    @if($singleData->meta_keyword) {{$singleData->meta_keyword}} @else {{$singleData->title}} @endif
@endsection

@section('meta_description')
    @if($singleData->meta_description) {{$singleData->meta_description}} @else {{$singleData->title}} @endif
@endsection

@section('og_tags')
    <!-- Meta Tags need to place on the news detailed description at blade file of it -->
   {{--  <meta property="og:image" content="@if($singleData->image) {{asset('images/blogs/'.$singleData->id.'/'.$singleData->image)}} @else {{asset('images/options/'.$option->logo)}} @endif" >
    <meta property="og:type" content="Blog" />
    <meta property="og:url" content="{{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}"  >
    <meta property="og:title" content="{{$singleData->title}}"  >
    <meta property="og:site_name" content="{{$option->name}}" />
    <meta property="og:description" content="{{str_limit($singleData->summary, 100)}}" >
    <meta property="fb:app_id" content="328547797314364" > --}}

    <meta property="og:url"           content="{{ url('blog/'. $singleData->category->slug. '/' .$singleData->id)}}" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="{{$singleData->title}}" />
    <meta property="og:description"   content="{{str_limit($singleData->summary, 300)}}" />
    <meta property="og:image"         content="{{asset('storage/blogs/'.$singleData->id.'/'.$singleData->image)}}" />
@endsection

@section('pagebreadcrumb_title')

@endsection

@section('main-content')
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>{{$singleData->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>

    <div class="blog_details mt-57">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="blog_wrapper inno_shadow">
                        <article class="single_blog">
                            <figure>
                               <div class="post_header">
                                   <h3 class="post_title pt-4 pl-3 text-center">{{$singleData->title}}</h3>
                                    {{-- <div class="blog_meta">                                        
                                        <span class="author">Posted by : <a href="blog-details.html#">admin</a> / </span>
                                        <span class="meta_date">On : <a href="blog-details.html#">April 10, 2019</a> /</span>
                                        <span class="post_category">{{ $singleData->summary }}</span>
                                    </div> --}}
                                    <p class="p-3 text-center">{{ $singleData->summary }}</p>
                                </div>
                                <div class="blog_thumb">
                                   <a @if($singleData->link) href="{{ $singleData->link }}" @endif>
                                        @if($singleData->image)
                                            <img src="{{asset('storage/blogs/'.$singleData->id.'/'.$singleData->image)}}" alt="{{ $singleData->title }}" class="w-100">
                                        @else
                                            <img src="{{ asset('site/defaults/product_placeholder.png') }}" alt="{{ $singleData->title }}" class="w-100">
                                        @endif
                                    </a>
                               </div>
                               <figcaption class="blog_content">
                                    <div class="post_content">
                                        {!! $singleData->content !!}
                                        {{-- <blockquote>
                                            {!! $singleData->content !!}
                                        </blockquote> --}}
                                    </div>
                                    <div class="entry_content border-top">
                                        <div class="post_meta">
                                            {{-- <span>Tags: </span>
                                            <span><a href="blog-details.html#">, fashion</a></span>
                                            <span><a href="blog-details.html#">, t-shirt</a></span>
                                            <span><a href="blog-details.html#">, white</a></span> --}}
                                        </div>

                                        <div class="social_sharing">
                                            <p>share this zompers spotlight</p>
                                            <ul>
                                                <div class="fb-share-button" 
                                                data-href="{{ url('blog/'. $singleData->category->slug. '/' .$singleData->id)}}" 
                                                data-layout="button">
                                                </div>

                                                {{-- <li><a href="" title="facebook"><i class="fa fa-facebook"></i></a></li> --}}
                                                {{-- <li><a href="blog-details.html#" title="twitter"><i class="fa fa-twitter"></i></a></li> --}}
                                                {{-- <li><a href="blog-details.html#" title="pinterest"><i class="fa fa-pinterest"></i></a></li> --}}
                                                {{-- <li><a href="blog-details.html#" title="linkedin"><i class="fa fa-linkedin"></i></a></li> --}}
                                                <li>
                                                    <a title="email" href="mailto:?subject={{$singleData->title}}&amp;body={{$singleData->summary}} <br/> Check out this here : {{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}" title="{{$option->name}} : {{$singleData->title}}">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                               </figcaption>
                            </figure>
                        </article> 
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <div class="blog_sidebar_widget">
                        <div class="widget_list widget_post">
                            <div class="widget_title">
                                <h3>ZOMPERS SPOTLIGHT</h3>
                            </div>
                            @foreach($otherData as $row)
                                <div class="post_wrapper">
                                    <div class="post_thumb">
                                        <a href="{{url('blog/'.$row->category->slug.'/'.$row->id)}}">
                                            @if($row->image)
                                                <img src="{{ asset('storage/blogs/'.$row->id.'/'.$row->image) }}" alt="{{ $row->title }}">
                                            @else
                                                <img src="{{ asset('site/defaults/product_placeholder.png') }}" alt="{{ $row->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post_info">
                                        <h4><a href="{{url('blog/'.$row->category->slug.'/'.$row->id)}}">{{ $row->title }}</a></h4>
                                        <span>{{ date('F d Y',  strtotime($row->created_at)) }} </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



{{-- <section id="static-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                
                <div class="about-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                    @if($singleData->video)
                        <div class="embed-responsive embed-responsive-16by9">
                             <iframe src="https://www.youtube.com/embed/{{$singleData->video}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" height="320px" frameborder="0" ></iframe>
                         </div>
                    @endif
                    @if($singleData->audio)
                        <div class="embed-responsive embed-responsive-16by9">
                              <iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{{$singleData->audio}}&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true"></iframe>
                        </div>
                    @endif
                    @if($singleData->image)
                        <img class="img-responsive" src="{{asset('images/blogs/'.$singleData->id.'/'.$singleData->image)}}">
                    @endif
                </div>
                <div class="our-skills wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <p>{!! $singleData->content !!}</p>
                </div>

       
                <div class="social-share-section">
                    <div class="share-button-block">
                        <div class="fb-share-button" data-href="{{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a>
                        </div>
                    </div>
                    <div class="share-button-block">
                        <div class="g-plus" data-action="share" data-annotation="none" data-href="{{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}"></div>
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                    </div>
                    <div class="share-button-block">
                        <a href="{{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}" class="twitter-share-button" data-show-count="true" data-size="small">Tweet</a>
                        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                    <div class="share-button-block">
                        <a href="mailto:?subject={{$singleData->title}}&amp;body={{$singleData->summary}} <br/> Check out this here : {{url('audio/'.$singleData->category->slug.'/'.$singleData->id)}}" title="{{$option->name}} : {{$singleData->title}}">
                            <div class="email-share-button"><i class="fa fa-paper-plane fa-lg right-margin-5" aria-hidden="true"></i> Email</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection