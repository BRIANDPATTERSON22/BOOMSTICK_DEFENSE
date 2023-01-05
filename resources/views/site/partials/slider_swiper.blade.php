<div class="swiper-container">
  <div class="swiper-wrapper">
  @foreach($sliderImage  as $row)
    <div class="swiper-slide page-titlez">
      <a href="@if($row->link1) {{ url($row->link1 ?? '/') }} @endif">
        <img class="slider-img" src="{{asset('storage/sliders/'.$row->image)}}" alt="{{ $option->name }}">
      </a>
            {{-- <div class="container_r" style="position: absolute; top: 0px; z-index: 2; padding-top: 50px;">
                      <div class="row">
                          <div class="col-md-8" style="margin: 0px auto">
                              <div class="slider-content slider-content-2 text-center">
                                  <div class="tm-sc section-title section-title-style1">
                                    <div class="title-wrapper">
                                      <h4 class="">We Teach the Ensuing Skills</h4>
                                      <div class="title-seperator-line"></div>
                                    </div>
                                  </div>
                                  <div class="tm-sc section-title section-title-style1">
                                    <div class="title-wrapper">
                                      <h2 class="font-size-50">Become a Member</h2>
                                      <div class="title-seperator-line"></div>
                                    </div>
                                  </div>
                                  <p class="lead">Podcasting operational change management inside of workflows to establish a framework. Taking seamless key performance indicators offline to maximise the long tail.</p>
                                  <div class="box-hover-effect play-video-button tm-sc tm-sc-video-popup tm-sc-video-popup-button-with-text-right">
                                    <div class="effect-wrapper d-flex align-items-center">
                                      <div class="tm-sc tm-sc-button mt-15"> <a href="#" target="_self" class="btn btn-outline-theme-colored1 btn-outline btn-round"> Apply Now </a></div>
                                      
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div> --}}

    </div>  
  @endforeach
  </div>
  <!-- Add Pagination -->
  {{-- <div class="swiper-pagination"></div> --}}
  <!-- Add Pagination -->
  <div class="swiper-button-next swiper-button-white" style="z-index:8"></div>
  <div class="swiper-button-prev swiper-button-white" style="z-index:8"></div>
</div>