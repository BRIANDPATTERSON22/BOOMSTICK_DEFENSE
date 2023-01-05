@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->title}} | Testimonials
@endsection

@section('contentheader_title')
    Testimonial ID: {{$singleData->id}}
@endsection

@section('contentheader_description')

@endsection

@section('pagebreadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('admin/testimonials')}}"> Testimonials</a></li>
        <li class="active">{{$singleData->title}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif>
        <a href="{{url('admin/testimonial/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a>
    </li>
    <li @if(Request::is('*view')) class="active" @endif>
        <a href="{{url('admin/testimonial/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a>
    </li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.testimonial.header')
        <div class="tab-content @if($singleData->status==0) disabledBg @endif">
            <div class="box-header">
                <a class="btn btn-sm btn-primary pull-right" href="{{url('testimonial/'.$singleData->slug)}}" target="_blank"><i class="fa fa-external-link"></i> Preview</a>
                <h3>{{$singleData->title}}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($singleData->image)
                            <div class="img-responsive">
                                {{-- <img src="{{asset('images/testimonials/'.$singleData->id.'/'.$singleData->image)}}" alt="No Image Available" class="img-thumbnail"/> --}}
                                <img src="{{ asset('storage/testimonials/'.$singleData->image) }}" alt="No Image Available" class="img-thumbnail"/>
                            </div>
                        @endif
                        @if($singleData->video)
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe src="https://www.youtube.com/embed/{{$singleData->video}}?rel=0&amp;controls=0&amp;showinfo=0" width="100%" frameborder="0" ></iframe>
                            </div>
                        @endif
                        @if($singleData->audio)
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{{$singleData->audio}}&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <em>{{$singleData->summary}}</em>
                        <hr>
                        {!! $singleData->content !!}
                    </div>
                </div>
                @if(count($photos))
                    <h3> Related Gallery</h3>
                    <div class="row">
                        @foreach($photos as $row)
                            <div class="col-md-3 img-responsive album-img-height">
                                <img src="{{asset('images/photo_albums/'.$row->album_id.'/'.$row->image)}}" alt="No Image Available" class="img-thumbnail"/>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="box-footer">
                <em>Created at {{$singleData->created_at}} and Updated at {{$singleData->updated_at}}</em>
            </div>
        </div>
    </div>
@endsection