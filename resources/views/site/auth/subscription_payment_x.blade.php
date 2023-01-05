@extends('site.layouts.default')

@section('htmlheader_title')
    Payment
@endsection

@section('page-style')
	<style>
		.display-none{display: none;}
		.sage-pay-logo{
		    border: 1px solid #cccccc;
		    background-color: #fdfdfd;
		    padding: 5px 5px 1px 5px;
		    border-radius: 8px;
		    margin-top: -7px;
		}
	</style>
@endsection

@section('main-content')

{{--    <div class="osahan-breadcrumb">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icofont icofont-ui-home"></i> Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Cake time club Account</a></li>
                  <li class="breadcrumb-item active">Payment</li>
               </ol>
            </div>
         </div>
      </div>
   </div> --}}

   <section class="shopping_cart_page">
      <div class="container">
         <div class="row">
         	@if($customerData->is_paid == 0)
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
	                     <li class="active">
	                        <a href="#">
	                           <div class="step">
	                              <div class="line"></div>
	                              <div class="circle">3</div>
	                           </div>
	                           <span>Payment</span>
	                        </a>
	                     </li>
	                     <li>
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
	                  <div class="section-header section-header-center text-center">
	                     <h3 class="heading-design-center-h3">
	                        {{-- Select a payment method --}}
	                        Payment Type
	                     </h3>
	                  </div>
	                  <form class="col-lg-8 col-md-8 mx-auto">
	                     <div class="payment-menthod text-center">
	                        <ul>
                    			<li><a href="#" style="background-color: white;"> <img class="sage-pay-logo" src="{{ asset('site/images/payment-gateway/SagePay.png') }}" alt="guypaul_SagePay" width="100px"></a></li>
								<li><a class="active" href="#"><i class="icofont icofont-paypal-alt"></i></a></li>
								<li><a href="#"><i class="icofont icofont-visa-alt"></i></a></li>
								<li><a href="#"><i class="icofont icofont-mastercard-alt"></i></a></li>
								<li><a href="#"><i class="icofont icofont-american-express-alt"></i></a></li>
								<div>
									<hr>
			                           <script src="https://www.paypalobjects.com/api/checkout.js"></script>
			                           <div id="paypal-button-container"></div>
			                           <script>
											paypal.Button.render({
											  env: '{{env('PAYPAL_MODE')}}', // sandbox | production
											    client: {
											      sandbox:    '{{env('PAYPAL_CLIENT_ID')}}',
											      production: '{{env('PAYPAL_CLIENT_ID')}}'
											    },
											  // Show the buyer a 'Pay Now' button in the checkout flow
											  commit: true,
											  // payment() is called when the button is clicked
											  payment: function(data, actions) {
											    // Make a call to the REST API to set up the payment
											    return actions.payment.create({
											      payment: {
											        transactions: [
											          {
											            amount: { total: '{{ $option->cake_time_club_amount }}', currency: '{{ $option->currency_code }}' }        
											          }
											        ],
											        redirect_urls: {
											          return_url: '{{ url('cake-time-club-payment-status') }}',
											          cancel_url: '{{ url('cake-time-club-payment-cancel')}}'
											        }
											      }
											    });
											  },

											  // onAuthorize() is called when the buyer approves the payment
											  onAuthorize: function(data, actions) {

											    // Make a call to the REST API to execute the payment
											    return actions.payment.execute().then(function() {
											      actions.redirect();
											      }
											    );
											  },

											  onCancel: function(data, actions) {
											    actions.redirect();
											    }

											}, '#paypal-button-container');
			                           </script>
		                           <hr>
								</div>

								<div>
									<br>
									<script src="https://pi-test.sagepay.com/api/v1/js/sagepay.js"></script>
									<?php
									$curl = curl_init();
									curl_setopt_array($curl, array(
									  CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/merchant-session-keys",
									  CURLOPT_RETURNTRANSFER => true,
									  CURLOPT_CUSTOMREQUEST => "POST",
									  CURLOPT_POSTFIELDS => '{ "vendorName": "guypaulcompany" }',
									  CURLOPT_HTTPHEADER => array(
									    "Authorization: Basic MEhIbll1UlRpVTZsSlppWFVPcVg1cXNpNTRJbXB2RWZwNkdhd0I5c1lnRlRTaG9VZTM6V3NnM2pvQW9NdnZIWldwOFNadFlzbWttMWU0eUFkZmlxYlB1T1VVdnpBdkE5YU9rdGpNRldNYU5MY1E3QjVkRTk=",
									    "Cache-Control: no-cache",
									    "Content-Type: application/json"
									  ),
									));
									$response = curl_exec($curl);
									$response = json_decode($response, true);
									session()->put('ms', $response['merchantSessionKey']);
									
									$err = curl_error($curl);
									curl_close($curl);
									?>
									<div id="main">
									      <form>
									      		  {{ csrf_field() }}

									        <h3>Pay with SagePay</h3>
									        <div id="sp-container"></div>
									        <div id="submit-container">
									         <input type="submit"/>
									        </div>
									        {{-- <script>window.location = "http://localhost/guypaul.dev/public/pctcsp";</script> --}}
									      </form>
									    </div>
									    <script>
								    	 	sagepayCheckout({ merchantSessionKey: '<?php echo $response['merchantSessionKey']; ?>' }).form();
							          	
								        </script>
								        <?php
				        					print_r(request()->all());
								        ?>
									<hr>
								</div>
	                        </ul>
	                     </div>

							{{-- {!!Form::open(['url'=> 'sage-session', 'autocomplete'=>'off'])!!}
							                     <button name="dddddddddddddd"  class="btn btn-square btn-secondary btn-block" type="submit">SEND</button>
						 {!!Form::close()!!} --}}
						
						    
						

	                     {{-- <div class="form-group">
	                        <label class="control-label">Card Number</label>
	                        <input class="form-control border-form-control" value="" placeholder="0000 0000 0000 0000" type="text">
	                     </div>
	                     <div class="row">
	                        <div class="col-sm-3">
	                           <div class="form-group">
	                              <label class="control-label">Month</label>
	                              <input class="form-control border-form-control" value="" placeholder="01" type="text">
	                           </div>
	                        </div>
	                        <div class="col-sm-3">
	                           <div class="form-group">
	                              <label class="control-label">Year</label>
	                              <input class="form-control border-form-control" value="" placeholder="15" type="text">
	                           </div>
	                        </div>
	                        <div class="col-sm-3">
	                        </div>
	                        <div class="col-sm-3">
	                           <div class="form-group">
	                              <label class="control-label">CVV</label>
	                              <input class="form-control border-form-control" value="" placeholder="135" type="text">
	                           </div>
	                        </div>
	                     </div> --}}
	                   {{--   <hr>
	                     <label class="custom-control custom-radio">
	                     <input id="radioStacked3" name="radio-stacked" class="custom-control-input" type="radio">
	                     <span class="custom-control-indicator"></span>
	                     <span class="custom-control-description"><strong>Would you like to pay by Cash on Delivery?</strong></span>
	                     </label> --}}
	               {{--       <p>Vestibulum semper accumsan nisi, at blandit tortor maxi'mus in phasellus malesuada sodales odio, at dapibus libero malesuada quis.</p>
	                     <button  type="submit" name="caketimeclub_paypal" class="btn btn-theme-round btn-lg pull-right">NEXT</button> --}}
	                  </form>

					
	    
	               </div>
	            </div>
            @else
				@role('trade_customer')
					<div class="col-lg-8 col-md-8 mx-auto">
		               <div class="widget">
		                  <div class="section-header section-header-center text-center">
		                     <h3 class="heading-design-center-h3">
		                        Hi {{ Auth::user()->customer->first_name }}, WELCOME TO TRADE SHOPPING!.
		                     </h3>
		                  </div>
		                  <hr>
		                  {{-- <form class="col-lg-8 col-md-8 mx-auto">
		                     <div class="payment-menthod text-center">
		                        <ul>
		                           <li><a class="active" href="cart_checkout.html#"><i class="icofont icofont-paypal-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-visa-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-mastercard-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-google-wallet-alt-1"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-american-express-alt"></i></a>
		                           </li>
		                        </ul>
		                     </div>
		                     <div class="form-group">
		                        <label class="control-label">Card Number</label>
		                        <input class="form-control border-form-control" value="" placeholder="0000 0000 0000 0000" type="text">
		                     </div>
		                     <div class="row">
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">Month</label>
		                              <input class="form-control border-form-control" value="" placeholder="01" type="text">
		                           </div>
		                        </div>
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">Year</label>
		                              <input class="form-control border-form-control" value="" placeholder="15" type="text">
		                           </div>
		                        </div>
		                        <div class="col-sm-3">
		                        </div>
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">CVV</label>
		                              <input class="form-control border-form-control" value="" placeholder="135" type="text">
		                           </div>
		                        </div>
		                     </div>
		                     <hr>
		                     <label class="custom-control custom-radio">
		                     <input id="radioStacked3" name="radio-stacked" class="custom-control-input" type="radio">
		                     <span class="custom-control-indicator"></span>
		                     <span class="custom-control-description"><strong>Would you like to pay by Cash on Delivery?</strong></span>
		                     </label>
		                     <p>Vestibulum semper accumsan nisi, at blandit tortor maxi'mus in phasellus malesuada sodales odio, at dapibus libero malesuada quis.</p>
		                     <a href="cart_done.html" class="btn btn-theme-round btn-lg pull-right">NEXT</a>
		                  </form> --}}

		                  <div class="order-detail-form text-center">
		                     <div class="col-lg-10 col-md-10 mx-auto order-done">
		                        <i class="icofont icofont-check-circled"></i>
		                        <h2 class="text-success">Congrats! <br> Your account activated!</h2>
		                        <p>
		                           You can now place your orders.
		                        </p>
		                     </div>
		                     <div class="cart_navigation text-center">
		                        <a href="{{ url('products') }}" class="btn btn-theme-round">Go to store</a> 
		                        <a href="{{ url('my-account') }}" class="btn btn-theme-round">My Account</a>
		                     </div>
		                  </div>
		               </div>
		            </div>
	            @endrole
				@role('cake_time_club')
					<div class="col-lg-8 col-md-8 mx-auto">
		               <div class="widget">
		                  <div class="section-header section-header-center text-center">
		                     <h3 class="heading-design-center-h3">
		                        Hi {{ Auth::user()->customer->first_name }}, WELCOME TO OUR CAKE TIME CLUB.
		                     </h3>
		                  </div>
		                  <hr>
		                  {{-- <form class="col-lg-8 col-md-8 mx-auto">
		                     <div class="payment-menthod text-center">
		                        <ul>
		                           <li><a class="active" href="cart_checkout.html#"><i class="icofont icofont-paypal-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-visa-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-mastercard-alt"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-google-wallet-alt-1"></i></a>
		                           </li>
		                           <li><a href="cart_checkout.html#"><i class="icofont icofont-american-express-alt"></i></a>
		                           </li>
		                        </ul>
		                     </div>
		                     <div class="form-group">
		                        <label class="control-label">Card Number</label>
		                        <input class="form-control border-form-control" value="" placeholder="0000 0000 0000 0000" type="text">
		                     </div>
		                     <div class="row">
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">Month</label>
		                              <input class="form-control border-form-control" value="" placeholder="01" type="text">
		                           </div>
		                        </div>
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">Year</label>
		                              <input class="form-control border-form-control" value="" placeholder="15" type="text">
		                           </div>
		                        </div>
		                        <div class="col-sm-3">
		                        </div>
		                        <div class="col-sm-3">
		                           <div class="form-group">
		                              <label class="control-label">CVV</label>
		                              <input class="form-control border-form-control" value="" placeholder="135" type="text">
		                           </div>
		                        </div>
		                     </div>
		                     <hr>
		                     <label class="custom-control custom-radio">
		                     <input id="radioStacked3" name="radio-stacked" class="custom-control-input" type="radio">
		                     <span class="custom-control-indicator"></span>
		                     <span class="custom-control-description"><strong>Would you like to pay by Cash on Delivery?</strong></span>
		                     </label>
		                     <p>Vestibulum semper accumsan nisi, at blandit tortor maxi'mus in phasellus malesuada sodales odio, at dapibus libero malesuada quis.</p>
		                     <a href="cart_done.html" class="btn btn-theme-round btn-lg pull-right">NEXT</a>
		                  </form> --}}

		                  <div class="order-detail-form text-center">
		                     <div class="col-lg-10 col-md-10 mx-auto order-done">
		                        <i class="icofont icofont-check-circled"></i>
		                        <h2 class="text-success">Congrats! <br> Your account activated!</h2>
		                        <p>
		                           You can now place your orders.
		                        </p>
		                     </div>
		                     <div class="cart_navigation text-center">
		                        <a href="{{ url('products') }}" class="btn btn-theme-round">Go to store</a> 
		                        <a href="{{ url('my-account') }}" class="btn btn-theme-round">My Account</a>
		                     </div>
		                  </div>
		               </div>
		            </div>
	            @endrole
            @endif
         </div>
      </div>
   </section>
@endsection

@section('page-script')
    <script>
	    $( "#clickme" ).click(function() {
	      $( "#paypal-button-container" ).hidden( "slow", function() {
	        // Animation complete.
	      });
	    });
    </script>
@endsection