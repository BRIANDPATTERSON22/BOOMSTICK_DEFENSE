@extends('site.layouts.default')

@section('htmlheader_title')
    Payment process Completed!
@endsection

@section('page-style')

@endsection

@section('main-content')
   </nav>
   <div class="osahan-breadcrumb">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icofont icofont-ui-home"></i> Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Cake time club</a></li>
                  <li class="breadcrumb-item active">Payment Success</li>
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
	              <ul>
	                 <li>
	                    <a href=" #">
	                       <div class="step">
	                          <div class="line"></div>
	                          <div class="circle">1</div>
	                       </div>
	                       <span>Registration</span>
	                    </a>
	                 </li>
	                 <li>
	                    <a href="#">
	                       <div class="step">
	                          <div class="line"></div>
	                          <div class="circle">2</div>
	                       </div>
	                       <span>Account Verification</span>
	                    </a>
	                 </li>
	                 <li>
	                    <a href="#">
	                       <div class="step">
	                          <div class="line"></div>
	                          <div class="circle">3</div>
	                       </div>
	                       <span>Payment</span>
	                    </a>
	                 </li>
	                 <li class="active">
	                    <a href="#">
	                       <div class="step">
	                          <div class="line"></div>
	                          <div class="circle">4</div>
	                       </div>
	                       <span>Complete</span>
	                    </a>
	                 </li>
	              </ul>
	           </div>
	        </div>
	         <div class="col-lg-8 col-md-8 mx-auto">
	            <div class="widget">
	               <div class="order-detail-form text-center">
	                  <div class="col-lg-10 col-md-10 mx-auto order-done">
	                     <i class="icofont icofont-check-circled"></i>
	                     <h2 class="text-success">Congrats! Payment Successful.</h2>
	                     <p>
                     	 	@if(Auth::user()->customer->membership_type == 1)
	                     		Thank you for your Membership to Guy Paul & Co.Ltd. Your 6 month membership is now active.
	                     	@else
	                     		Thank you for your Membership to Guy Paul & Co.Ltd. Your 12 month membership is now active.
	                     	@endif
	                     </p>
	                  </div>
	                  <div class="cart_navigation text-center">
	                     <a href="{{ url('products') }}" class="btn btn-theme-round">Return to store</a> 
	                     <a href="{{ url('my-account') }}" class="btn btn-theme-round">My Account</a>
	                  </div>
	               </div>
	            </div>
	         </div>
	      </div>
	   </div>
	</section>
@endsection

@section('page-script')
    
@endsection