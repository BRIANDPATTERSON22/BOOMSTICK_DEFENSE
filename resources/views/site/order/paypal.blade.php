@extends('site.layouts.default')

@section('htmlheader_title')
  Paypal | Shop
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
                          <li><a href="{{ url('payment-methods') }}">Payment Methods</a></li>
                          <li><i class="fa fa-angle-double-right"></i></li>
                          <li><a>Pay with PayPal</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>


<section class="login-page section-big-py-space bg-light">
    <div class="container">   
        <div class="row">
            <div class="col-lg-8 col-md-8 mx-auto">
                <div class="error_form inno_shadow p_30">
                    <div class="col-md-12">
                        <!-- Set up a container element for the button -->
                        <div id="paypal-button-container"></div>

                        <!-- Include the PayPal JavaScript SDK -->

                        <script src="https://www.paypal.com/sdk/js?client-id=Aez54TiXwVIB_1vbikyk5UDkUDq1ZEA9uaPp5GphbSB2IJzR2AwL6kwLrqZ4k-qWzlI4hqRyzeLmbtXs&currency=USD"></script>

                        <script>
                            var APP_URL = {!! json_encode(url('/')) !!};

                            // Render the PayPal button into #paypal-button-container
                            paypal.Buttons({

                                // Set up the transaction
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{  
                                            amount: {
                                                value: {{ $grandTotal }},
                                            }
                                        }],

                                        application_context: {
                                          shipping_preference: 'NO_SHIPPING',
                                      },
                                      
                                    });
                                },

                                // Finalize the transaction
                                onApprove: function(data, actions) {
                                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                    return actions.order.capture().then(function(details) {
                                        // Show a success message to the buyer
                                        // alert('Transaction completed by ' + details.payer.name.given_name + '!');
                                        console.log(data);
                                        console.log(details);
                                        console.log(details.status);

                                        

                                        if(details.status == 'COMPLETED'){
                                            return fetch(APP_URL + '/status', {
                                                  method: 'post',
                                                  headers: {
                                                      'content-type': 'application/json',
                                                      "Accept": "application/json, text-plain, */*",
                                                      "X-Requested-With": "XMLHttpRequest",
                                                      "X-CSRF-TOKEN": token
                                                  },
                                                  body: JSON.stringify({
                                                      orderId     : data.orderID,
                                                      payerID : data.payerID,
                                                      status: details.status,
                                                      // pay_status : 'PAID',
                                                      // package_id : packageId,
                                                      // payerEmail: details.payer.email_address,
                                                  })
                                              })

                                              .then(status)

                                              .then(function(response){
                                                  // redirect to the completed page if paid
                                                  console.log(response);
                                                  window.location.href = APP_URL + '/completed';
                                              })

                                              .catch(function(error) {
                                                console.log(error);
                                                  // redirect to failed page if internal error occurs
                                                  window.location.href = APP_URL + '/cancelled?reason=internalFailure';
                                              });
                                          }else{
                                              window.location.href = APP_URL + '/cancelled?reason=failedToCapture';
                                          }
                                    });
                                },

                                onCancel: function (data) {
                                   // Show a cancel page, or return to cart
                                   console.log(data); // {orderID: "2W828204CW520064L"}
                                   window.location = APP_URL + '/cart'; //Package selection page
                                 },

                                 // onError: function (err) {
                                 //   // Show an error page here, when an error occurs
                                 // },

                            }).render('#paypal-button-container');

                            function status(res) {
                                if (!res.ok) {
                                    throw new Error(res.statusText);
                                }
                                return res;
                              } 
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection