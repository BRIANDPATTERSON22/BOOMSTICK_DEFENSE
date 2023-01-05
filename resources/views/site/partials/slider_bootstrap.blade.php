@if($sliderImage->isNotEmpty())
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($sliderImage as $row)
                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $row->id }}" class="{{ $loop->first ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($sliderImage as $row)
                <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                  <img src="{{asset('storage/sliders/'.$row->image)}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="bootstrap_slider_title mb-2">{{ str_limit($row->title, 45 ) }}</h5>
                        <p class="bootstrap_slider_des">{{ str_limit($row->description, 50 ) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@else
    <img src="{{asset('site/defaults/slider.png')}}" alt="slider" title="{{ $option->name }}" />
@endif