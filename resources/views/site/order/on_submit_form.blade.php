@extends('site.layouts.default')

@section('htmlheader_title')
    Payment Confirmation
@endsection

@section('main-content')
    <div class="osahan-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icofont icofont-ui-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('products')}}">Shop</a></li>
                        <li class="breadcrumb-item active">Checkout Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="shopping_cart_page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="checkout-step mb-40">
                        {{-- @include('site.order.progress_status') --}}
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 mx-auto">

                    <div class="widget">
                        <div class="section-header">
                            <h3 class="heading-design-h5">
                               Payment Confirmation
                            </h3>
                        </div>
                        @if(session('payment')['id'] == 5)
                            <div class="d-flex justify-content-between paddin-top-1x mt-4">
                                <a class="btn btn-theme-round btn-lg" href="{{url('checkout-payment')}}"><i class="icon-arrow-left"></i><span class="hidden-xs-down">&nbsp;Back</span></a>
                                @if(session('shipping') && session('payment'))
                                    <form method="POST" id="SagePayForm" action="https://live.sagepay.com/gateway/service/vspform-register.vsp" name="confirmation">
                                        <input type="hidden" name="VPSProtocol" value= "3.00">
                                        <input type="hidden" name="TxType" value= "PAYMENT">
                                        <input type="hidden" name="Vendor" value= "guypaulcompany">
                                        <input type="hidden" name="Crypt" value= "{{ $encrypted_code }}">
                                        <input class="btn btn-theme-round btn-lg pull-right cursor-pointer" type="submit" value="Confirm Your Order">
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-script')
	<script>
		window.onload = function(){
  			document.forms['confirmation'].submit();
		}
	</script>
@endsection