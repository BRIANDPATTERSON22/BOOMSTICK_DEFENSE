@extends('site.layouts.default')

@section('htmlheader_title')
  My Wish List
@endsection

@section('page-style')
  <style>
    .product-item-body h4 a {
        color: #343a40;
        font-size: 11px;
        font-weight: 600;
    }
  </style>
@endsection

@section('main-content')

  <div class="container">
    @if (count($errors) > 0)
      <div class="alert alert-danger" style="margin-top: 15px">
        <strong>Whoops!</strong>
        There were some problems with your input.
      </div><br>
    @endif
  </div>

  <div class="osahan-breadcrumb">
     <div class="container">
        <div class="row">
           <div class="col-lg-12 col-md-12">
              <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icofont icofont-ui-home"></i> Home</a></li>
                 <li class="breadcrumb-item active">My Wish List</li>
              </ol>
           </div>
        </div>
     </div>
  </div>

  <section class="shopping_cart_page">
     <div class="container">
        <div class="row">
           @include('site.customer.sidebar')
           <div class="col-lg-8 col-md-8 col-sm-7">
              <div class="widget">
                 <div class="section-header">
                    <h5 class="heading-design-h5">
                       My Wishlist
                    </h5>
                 </div>
                 <div class="row">
                  @foreach($wishListsData as $row)
                    <div class="col-lg-3 col-md-3">
                       <div class="h-100">
                          <div class="product-item">
                             <div class="product-item-image">
                                <span class="like-icon"><a href="{{url('wish-list/'.$row->product_id.'/remove')}}"> <i class="icofont icofont-close-circled"></i></a></span>
                                <a href="{{url('/product/'.$row->product->slug)}}"><img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->product->main_image)}}" alt=""></a>
                             </div>
                             <div class="product-item-body">
                                <h4 class="card-title"><a href="{{url('/product/'.$row->product->slug)}}">{{str_limit($row->product->name,30)}}</a></h4>

                                {{-- <h5>
                                   <span class="product-desc-price">$329.00</span>
                                   <span class="product-price">$201.00</span>
                                   <span class="product-discount">10% Off</span>
                                </h5> --}}
                                <p>
                               {{--     <a class="btn btn-outline-warning btn-round" href="{{url($row->product->id.'/item')}}"><i class="icofont icofont-shopping-cart"></i> Add To Cart</a> --}}
                                </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    @endforeach
                 </div>
                 <br>
                 <div class="row">
                  <div class="col-md-12">
                    {{ $wishListsData->links() }}
                  </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </section>

@endsection