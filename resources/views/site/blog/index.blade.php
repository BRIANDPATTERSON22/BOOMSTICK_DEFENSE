@extends('site.layouts.default')

@section('htmlheader_title')
    Blogs
@endsection

@section('pagebreadcrumb_title')

@endsection

@section('main-content')
    <section id="static-page">
        <div class="container">
            <div class="title text-center">
                <h1>Blogs</h1>
            </div>
            @if(count($allData)>0)
            <div class="row">
                @foreach($allData as $row)
                <div class="col-sm-6 col-md-4">
                    <div class="row-block">
                        <div class="img-block">
                            <a href="{{url('blog/'.$row->category->slug.'/'.$row->id)}}" >
                            @if($row->image)
                            <img class="img-responsive" src="{{asset('images/blogs/'.$row->id.'/'.$row->image)}}" alt="No Image Available">
                            @else<img class="img-responsive" src="{{asset('images/default.png')}}" alt="No Image Available">@endif
                            </a>
                        </div>
                        <h3>{{$row->title}}</h3>
                        <span>{{$row->created_at->format('d M, Y')}}</span>
                        <p>{{str_limit($row->summary, 200)}}</p>
                    </div>
                </div>@endforeach

                <div class="col-md-12">
                    {!!$allData->links()!!}
                </div>
            </div>
            @else <h3> No data found</h3> @endif
        </div>
</section>
@endsection