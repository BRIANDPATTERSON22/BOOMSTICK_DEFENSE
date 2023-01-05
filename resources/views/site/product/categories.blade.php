@extends('site.layouts.default')

@section('htmlheader_title')
    All Categories
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          {{-- <h2>Categories</h2> --}}
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>Categories</a></li>
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
            @if($option->is_display_bs_products == 1)
              @foreach($categories as $category)
                <div class="col-md-3 pt-1 pb-1">
                  <a href="{{url('main-categories/'.$category->slug)}}"><h6 class="price-title">{{$category->name}}</h6></a>
                </div>
              @endforeach
            @endif

            @foreach($rsrCategories as $rsrCategory)
              <div class="col-md-3 pt-1 pb-1">
                <a href="{{ url('main-categories', $rsrCategory->department_id) }}"><h6 class="price-title">{{$rsrCategory->category_name}}</h6></a>
              </div>
            @endforeach
          </div>

          <!--<div class="row">-->
          <!--    @foreach($rsrCategories as $row)-->
          <!--      <div class="col-md-3">-->
          <!--          <div class="product-4_ product-m product mb-5">-->
          <!--              <a href="{{ url('main-categories', $row->department_id) }}">-->
          <!--                  <div class="product-box">-->
                                <!--<div class="product-imgbox">-->
                                <!--    <div class="product-front">-->
                                <!--        <a href="{{ url('main-categories', $row->department_id) }}">-->
                                <!--            @if($row->image)-->
                                <!--                <img class="img-fluid" src="{{asset('storage/rsr-mian-categories/'.$row->image)}}" alt="">-->
                                <!--            @else-->
                                <!--                <img class="img-fluid" src="{{asset('site/defaults/placeholder.png')}}" alt="">-->
                                <!--            @endif-->
                                <!--        </a>-->
                                <!--    </div>-->
                                <!--    <div class="product-icon icon-center">-->
                                <!--        <div>-->
                                <!--            <a href="{{ url('main-categories', $row->department_id) }}" title="View Product">-->
                                <!--                <i class="ti-search" aria-hidden="true"></i>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                
          <!--                      <div class="product-detail detail-inline ">-->
          <!--                          <div class="detail-title" style="padding-top:0px !important">-->
          <!--                              <div class="text-center">-->
          <!--                                      <h6 class="price-title">{{$row->department_name}}</h6>-->
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
                    {{ $rsrCategories->links() }}
                  </div>
              </div>
            </div>
          </div>

      </div>
  </section>
@endsection

@section('page-script')
@endsection