@extends('site.layouts.default')

@section('htmlheader_title')
  Order Cncelled | Shop
@endsection

@section('page-style')
  <style>
    .error_form h1 {
        font-size: 9em;
        font-weight: 700;
        color: #81d742;
        letter-spacing: 10px;
        line-height: 160px;
         margin: 0px; 
    }

    .p_30 {
        padding: 30px;
         border-bottom: 0px solid #81d742; 
         border-top: 5px solid #81d742; 
        border-radius: 50px;
    }

    .error_form a {
         margin-top: 0px; 
        border-radius: 20px;
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
                            <h2>Payment</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>>Order Failed</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="section-big-pt-space ratio_asos bg-light">
    <div class="container">   
        <div class="row">
            <div class="col-lg-8 col-md-8 mx-auto">
                <div class="error_form inno_shadow p_30">
                    <h1><i class="pe-7s-check"></i></h1>
                    <h2 class="font-weight-bold">Payment Failed</h2>
                    <p>
                      Your Order has been Cancelled.
                    </p>
                    <div class="cart_navigation text-center">
                       {{-- <a href="{{url('my-orders')}}" class="btn btn-theme-round">Track Orders</a> --}}
                       <a href="{{url('products')}}" class="btn btn-theme-round">Return to store</a>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection