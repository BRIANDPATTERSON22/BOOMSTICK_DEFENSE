@extends('site.layouts.default')

@section('htmlheader_title')
    Events
@endsection

@section('main-content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>Events</h1>
            </div>
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="separator">&nbsp;</li>
                    <li>Events</li>
                </ul>
            </div>
        </div>
    </div>

    @if(count($allData)>0)
    <div class="container padding-bottom-3x mb-1">
        <div class="isotope-grid cols-3 mb-4">
            <div class="gutter-sizer"></div>
            <div class="grid-sizer"></div>
            @foreach($allData as $row)
                <div class="grid-item">
                    <div class="blog-post">
                        <a class="post-thumb" href="{{url('event/'.$row->id)}}" >
                            @if($row->image)
                                <img class="img-responsive" src="{{asset('storage/events/'.$row->image)}}" alt="{{$row->title}}">
                            @endif
                        </a>
                        <div class="post-body">
                            <ul class="post-meta">
                                <li><i class="icon-clock"></i>{{$row->date}} | {{$row->time}}</li>
                                <li><i class="icon-tag"></i>{{str_limit($row->venue,15)}}</li>
                            </ul>
                            <h3 class="post-title"><a href="{{url('event/'.$row->id)}}">{{$row->title}}</a></h3>
                            <p>{{str_limit($row->summary, 200)}} <a href="{{url('event/'.$row->id)}}">more info</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12">
                {!!$allData->links()!!}
            </div>
        </div>
    </div>
    @else
    <div class="container padding-bottom-3x mb-1">
        <h3> No Events found</h3>
    </div>
    @endif
@endsection