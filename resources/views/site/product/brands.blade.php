@extends('site.layouts.default')

@section('htmlheader_title')
    All Brands
@endsection

@section('page-style')
  <style>
    .inno_shadow_2:hover{
      box-shadow: 0px 0px 20px 6px rgba(129, 215, 66, 0.06);
    }
    
    .inno_content_box h3{
      -webkit-transition: opacity 0.35s, -webkit-transform 0.45s;
       transition: opacity 0.35s, transform 0.45s;
     }

    .inno_content_box h3:hover{
      /*border-left: 5px solid #81d742;*/
      -webkit-transition: opacity 0.35s, -webkit-transform 0.45s;
        transition: opacity 0.35s, transform 0.45s;
        -webkit-transform: translate3d(20px,0,0);
        transform: translate3d(20px,0,0);
    }
  </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          {{-- <h2>Brands</h2> --}}
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>Brands</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <section class="ratio_landscape game-product  section-big-py-space">
      <div class="container">
          <div class="row">
              @foreach($rsrManufactures as $row)
                @if($row->full_manufacturer_name != "")
                <div class="col-md-3 pt-1 pb-1">
                        <a href="{{url('brands/'.$row->manufacturer_id)}}">
                            <h6 class="price-title">{{$row->full_manufacturer_name}}</h6>
                        </a>
                </div>
                @endif
              @endforeach
          </div>
          <!--<div class="row">-->
          <!--    @foreach($rsrManufactures as $row)-->
          <!--      <div class="col-md-3">-->
          <!--          <div class="product-4_ product-m product mb-5">-->
          <!--              <a href="{{url('brands/'.$row->manufacturer_id)}}">-->
          <!--                  <div class="product-box">-->
                                <!--<div class="product-imgbox">-->
                                <!--    <div class="product-front">-->
                                <!--        <a class="hover_icon hover_icon_link" href="{{url('brands/'.$row->manufacturer_id)}}">-->
                                <!--            @if($row->image)-->
                                <!--              <img class="img-fluid bg-img_" src="{{asset('storage/brands/'.$row->image)}}" alt="">-->
                                <!--            @else-->
                                <!--              <img class="img-fluid bg-img_" alt="" src="{{asset('site/defaults/image-not-found.png')}}">-->
                                <!--            @endif-->
                                <!--        </a>-->
                                <!--    </div>-->

                                <!--    <div class="product-icon icon-center">-->
                                <!--        <div>-->
                                <!--            <a href="{{url('brands/'.$row->manufacturer_id)}}" title="Quick View">-->
                                <!--                <i class="ti-search" aria-hidden="true"></i>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->

          <!--                      <div class="product-detail detail-inline ">-->
          <!--                          <div class="detail-title pt-0">-->
          <!--                              <div class="text-center">-->
          <!--                                      <h6 class="price-title">{{$row->full_manufacturer_name}}</h6>-->
          <!--                              </div>-->
          <!--                              {{-- <div class="detail-right">-->
          <!--                                  <div class="price">-->
          <!--                                      <div class="price">-->
          <!--                                          $ 24.05-->
          <!--                                      </div>-->
          <!--                                  </div>-->
          <!--                              </div> --}}-->
          <!--                          </div>-->
          <!--                      </div>-->
          <!--                  </div>-->
          <!--              </a>-->
          <!--          </div>-->
          <!--      </div>-->
          <!--    @endforeach-->
          <!--</div>-->

          <div class="row">
            <div class="col-md-12">
              <div class="product-pagination">
                  <div class="theme-paggination-block">
                    {{ $rsrManufactures->links() }}
                  </div>
              </div>
            </div>
          </div>
      </div>
  </section>
@endsection

@section('page-script')
  <script type="text/javascript" src="{{ asset('site/js/vendor/isotope/dist/isotope.pkgd.min.js') }}"></script>
@endsection