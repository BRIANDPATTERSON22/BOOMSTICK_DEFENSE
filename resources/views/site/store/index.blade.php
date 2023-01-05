@extends('site.layouts.default')

@section('htmlheader_title')
    Products
@endsection

@section('page-style')
    <style>
      .blog_content h4::before {
          content: "";
          position: absolute;
          display: block;
          width: 32px;
          height: 3px;
          background: #e9ecef;
          left: 0;
          bottom :0;
        }

        .widget_search input {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('main-content')
  <!--breadcrumbs area start-->
  <div class="breadcrumbs_area">
      <div class="container">   
          <div class="row">
              <div class="col-12">
                  <div class="breadcrumb_content">
                      <ul class="d-inline">
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li>Store Locator</li>
                      </ul>
                      {{-- @if ($allData) --}}
                        {{-- <span class="float-right">Search Result for - <strong>{{ Session::get('searchText') }}</strong></span> --}}
                     {{--  @else
                        <span class="float-right">No Data for - {{ Session::get('searchText') }}</span> --}}
                      {{-- @endif --}}
                  </div>
              </div>
          </div>
      </div>         
  </div>
  <!--breadcrumbs area end-->


  <!--blog area start-->
  <div class="blog_page_section blog_reverse mt-57 mb-60">
      <div class="container">
          <div class="row">
              <div class="col-lg-4 col-md-12 ">
                  <div class="blog_sidebar_widget inno_shadow" style="padding: 15px; border-top: 5px solid black; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                      <div class="widget_list widget_search">
                            <div class="widget_title">
                                <h3>Search Stores</h3>
                            </div>
                            {!!Form::open(['url'=>'store-locator', 'id' => 'form_store_locator'])!!} 
                            {!!csrf_field()!!} 
                                <input name="search_text" placeholder="Search By Division, Zip, City and State" type="text" value="{{ session('searchText') }}">
                                <div class="text-danger">{!!$errors->first('search_text')!!}</div>
                                <button  class="btn btn-block" type="submit">Find Stores</button>
                            {!!Form::close()!!}
                      </div>
                    
                      {{-- <div class="widget_list widget_categories">
                          <div class="widget_title">
                              <h3>Available Stores</h3>
                          </div>
                          <ul>
                              <li><a href="blog-sidebar.html#">NW</a></li>
                              <li><a href="blog-sidebar.html#">Boston</a></li>
                          </ul>
                      </div> --}}
                  </div>
              </div>

              @if(count($allData) > 0)
                <div class="col-lg-8 col-md-12">
                    <div class="blog_wrapper blog_wrapper_sidebar">
                        <div class="row">
                            <div class="col-lg-12">
                                <article class="single_blog inno_shadow" style="border-top: 5px solid #81d742; border-radius: 5px;">
                                    <figure>
                                        <figcaption class="blog_content">
                                            @if(session('storesByProduct_Session'))
                                                <h5 class="text-muted">Available stores for product - <strong> {{ session('storesByProduct_Session') }} </strong> </h5>
                                            @endif
                                            @if(session('searchText'))
                                                <h5 class="text-muted">Available stores for -  <strong> {{ session('searchText') }} </strong> </h5>
                                            @endif
                                        </figcaption>
                                    </figure>
                                </article>
                            </div>
                  
                            @foreach ($allData as $row)
                                <div class="col-lg-12">
                                    <article class="single_blog inno_shadow">
                                        <figure>
                                           {{--  <div class="blog_thumb">
                                                <a href="blog-details.html"><img src="assets/img/blog/blog5.jpg" alt=""></a>
                                                <div class="post_date">
                                                    <span class="day_time">24</span>
                                                    <span class=moth_time>Aug</span>
                                                </div>
                                            </div> --}}
                                              <figcaption class="blog_content">
                                                 <h4 class="post_title text-muted"><a href="#">{{ $row->division }} - {{ $row->banner }}</a> 
                                                  <a class="float-right">{{-- legacy - {{ $row->legacy }} -  --}}Store id - {{ $row->store_id }}</a>
                                                </h4>
                                                  <p class="post_desc"> {{ $row->address_1 }} | {{ $row->city }} | {{ $row->state }} | {{ $row->zip }}</p>
                                                  <hr>
                                                  <footer class="btn_more">
                                                      <a href="{{ url('store-locator/' . $row->store_id . '/products') }}"> View All Products <i class="fa fa-angle-double-right"></i></a>
                                                  </footer>
                                              </figcaption>
                                        </figure>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                    @if(session('error'))
                        <div class="col-lg-8 col-md-12">
                            <div class="blog_wrapper blog_wrapper_sidebar">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <article class="single_blog inno_shadow" style="border-top: 5px solid red; border-radius: 5px;">
                                            <figure>
                                                <figcaption class="blog_content">
                                                    <h5 class="text-muted"> No data found for your search keyword : {{ session('searchText') }} </h5>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
          </div>
      </div>
  </div>

  <div class="blog_pagination">
      <div class="container">
          <div class="row">
              <div class="col-12">
                    
                    @if ($allData)
                    {!! $allData->links() !!}
                    @endif
                  {{-- <div class="pagination">
                      <ul>
                          <li class="current">1</li>
                          <li><a href="blog-sidebar.html#">2</a></li>
                          <li><a href="blog-sidebar.html#">3</a></li>
                          <li class="next"><a href="blog-sidebar.html#">next</a></li>
                          <li><a href="blog-sidebar.html#">>></a></li>
                      </ul>
                  </div> --}}
              </div>
          </div>
      </div>
  </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#form_store_locator').validate({
                rules: {
                    search_text: {
                        required: true
                    }
                },
                messages: {
                    search_text: "Please enter the search term",
                },
                // errorElement : 'em',
                errorLabelContainer: '.text-danger',
                highlight: function(element) {
                    $(element).css('background', '#ffdddd');
                },
                unhighlight: function(element) {
                    $(element).css('background', '#ffffff');
                }
            });
        });
    </script>
@endsection