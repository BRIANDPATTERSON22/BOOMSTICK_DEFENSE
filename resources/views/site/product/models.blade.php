@extends('site.layouts.default')

@section('htmlheader_title')
    All Models
@endsection

@section('main-content')
  <!--breadcrumbs area start-->
  <div class="breadcrumbs_area">
      <div class="container">   
          <div class="row">
              <div class="col-12">
                  <div class="breadcrumb_content">
                      <ul>
                          <li class=""><a href="{{ url('/') }}"><i class="icofont icofont-ui-home"></i> Home</a></li>
                          <li class=""><a href="{{url('products')}}">Products</a></li>
                          <li class="active">All Models</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>         
  </div>
  <!--breadcrumbs area end-->
  
  <!--services img area-->
  <div class="services_gallery mt-60">
      <div class="container">  
          <div class="row">
              @foreach($allData as $row)
                <div class="col-lg-4 col-md-6">
                    <div class="single_services inno_shadow_2">
                        <div class="services_thumb mb-0">
                          @if($row->image)
                            <a href="{{url('products/models/'.$row->slug.'/all')}}">
                              <img class="card-img-top img-fluid" src="{{ asset('storage/models/'.$row->image) }}" alt="">
                            </a>
                          @else
                            <a href="{{url('brand/'.$row->slug)}}">
                              <img class="card-img-top img-fluid" src="{{asset('site/default/default.png')}}" alt="">
                            </a>
                          @endif
                        </div>
                        <div class="services_content inno_content_box">
                           <h3>{{str_limit($row->name, 20)}}</h3>
                           {{-- <p>{{ count($row->products) }} Product(s)</p> --}}
                        </div>
                    </div>
                </div>
             @endforeach
          </div>
      </div>     
  </div>
   <!--services img end-->
@endsection

@section('page-script')
@endsection