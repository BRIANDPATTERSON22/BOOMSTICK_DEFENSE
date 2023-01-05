@extends('site.layouts.default')

@section('htmlheader_title')
    Videos
@endsection

@section('main-content')
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>Video Gallery</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}}">Home</a>
                    </li>
                    <li class="separator">&nbsp;</li>
                    <li>Video Gallery</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container padding-bottom-3x mb-1">
        @if(count($allData)>0)
            <div class="row">
                @foreach($allData as $row)
                    <div class="col-sm-6 col-md-4">
                        <div class="row-block">
                            <div class="img-block">
                                <a href="{{url('video/'.$row->album->slug.'/'.$row->id)}}" >
                                    @if($row->type == "youtube")
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe src="https://www.youtube.com/embed/{{$row->code}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                                        </div>
                                    @elseif($row->type == "vimeo")
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe src="https://player.vimeo.com/video/{{$row->code}}?color=ffffff&title=0&byline=0&portrait=0" width="100%" height="320px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        </div>
                                    @elseif($row->type == "smule")
                                        <iframe frameborder="0" width="100%" src="https://www.smule.com/recording/bette-midler-in-my-life/{{$row->code}}/frame"></iframe>
                                    @elseif($row->type == "facebook")
                                        <div class="fb-video" data-href="{{$row->code}}" data-width="500" data-allowfullscreen="true"></div>
                                    @endif
                                </a>
                            </div>
                            <div style="background-color: #e6e6e6;padding: 12px;margin-bottom: 30px;">
                                <a href="{{url('video/'.$row->album->slug.'/'.$row->id)}}" >{{str_limit($row->title,40)}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
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
@endsection