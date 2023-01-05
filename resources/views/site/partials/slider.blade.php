<section class="theme-slider layout-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="slide-1 no-arrow">
                  @foreach($sliderImage  as $row)
                    <div>
                        <div class="slider-banner slide-banner-4">
                            <div class="slider-img">
                                <ul class="layout5-slide-1">
                                    <li id="img-1"><img src="{{asset('storage/sliders/'.$row->image)}}" class="img-fluid" alt="slider"></li>
                                </ul>
                            </div>
                            <div class="slider-banner-contain">
                                <div>
                                    <h3>bigest sale</h3>
                                    <h1>home appliances</h1>
                                    <h2>50% off on all selected product</h2>
                                    <a class="btn btn-normal">
                                        shop now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</section>