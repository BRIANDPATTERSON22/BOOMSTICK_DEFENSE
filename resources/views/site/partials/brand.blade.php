<section class="top-brands">
   <div class="container">
      <div class="section-header">
         {{-- <h5 class="heading-design-h5">Top Brands <span class="badge badge-primary">{{ count($brandsData) }} Brands</span></h5> --}}
         <h5 class="heading-design-h5">Top Brands <a style="width: 120px;background-color: white !important; border:none; border-bottom: 3px solid #eb5080;" href="{{url('products/brands')}}" class="btn btn-warning pull-right">Show More  <i class="fa fa-arrow-right"></i></a></h5>
      </div>
      <div class="row text-center">
         @foreach($brandsDataComposer->slice(0, 12) as $brand)
         <div class="col-lg-2 col-md-2 col-sm-2 mb-30">
            <a href="{{ url('brand/'.$brand->slug) }}"><img class="img-responsive" src="{{asset('storage/brands/'.$brand->image)}}" alt=""></a>
         </div>
         @endforeach
      </div>
   </div>
</section>

{{-- <section class="top-brands">
   <div class="container">
      <div class="section-header">
         <h5 class="heading-design-h5">Top Brands <span class="badge badge-primary">200 Brands</span></h5>
      </div>
      <div class="owl-carousel owl-carousel-brands">
         @foreach($brandsDataComposer->slice(0, 12) as $brand)
            <div class="item">
               <a href="{{ url('brand/'.$brand->slug) }}"><img class="img-responsive" src="{{asset('storage/brands/'.$brand->image)}}" alt=""></a>
            </div>
         @endforeach
      </div>
   </div>
</section> --}}