<footer class="footer-2">
  <div class="container ">
    <div class="row">
      <div class="col-12">
        <div class="footer-main-contian">
          <div class="row">
            <div class="col-lg-3 col-md-12 d-lg-flex justify-content-center align-items-center">
              <div class="footer-left pr-0">
                <div class="footer-logo mb-4">
                  <img class="img-fluid" src="{{asset('site/images/boomstick-defense-footer-logo.png')}}" alt="{{$option->name}}"> 
                  {{-- @if($option->logo)
                      <img class="img-fluid" width="240px" src="{{asset('storage/options/'.$option->logo)}}" alt="{{$option->name}}"> 
                      <img class="img-fluid" width="240px" src="{{asset('site/images/boomstick-defense-footer-logo.png')}}" alt="{{$option->name}}"> 
                  @else
                      {{str_limit($option->name, 20)}}
                  @endif --}}
                </div>
                <div class="footer-detail text-center">
                  {{-- <p>{{ $option->description }}</p> --}}
                  <ul class="paymant-bottom">
                    <li><a href="#"><img src="{{ asset('site/images/layout-1/pay/1.png') }}" class="img-fluid" alt="pay"></a></li>
                    <li><a href="#"><img src="{{ asset('site/images/layout-1/pay/2.png') }}" class="img-fluid" alt="pay"></a></li>
                    <li><a href="#"><img src="{{ asset('site/images/layout-1/pay/3.png') }}" class="img-fluid" alt="pay"></a></li>
                    {{-- <li><a href="#"><img src="{{ asset('site/images/layout-1/pay/4.png') }}" class="img-fluid" alt="pay"></a></li> --}}
                    {{-- <li><a href="#"><img src="{{ asset('site/images/layout-1/pay/5.png') }}" class="img-fluid" alt="pay"></a></li> --}}
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-9 col-md-12 ">
              <div class="footer-right">
                <div class="row">

                  <div class="col-md-12">
                    <div class="subscribe-section">
                      <div class="row">
                        <div class="col-md-12 ">
                          <div class="subscribe-block mb-4">
                            <div class="subscrib-contant justify-content-center">
                              <h4>sign up to get notified of <span class="text-light">Free</span> giveaways and special offers!</h4>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="subscribe-block">
                            <div class="subscrib-contant justify-content-center">
                               {!!Form::open(array('url' => 'subscribe'))!!}
                               {!! csrf_field() !!}
                                <div class="input-group" >
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" ><i class="fa fa-envelope-o" ></i></span>
                                  </div>
                                  <input type="email" class="form-control" placeholder="Enter your email" name="email">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text telly" >
                                      <button type="submit" class="btn btn-dark"><i class="fa fa-telegram" ></i> Subscribe</button>
                                    </span>
                                  </div>
                                </div>
                              {!!Form::close()!!}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="question p-4 text-center border_bottom">
                      <h4 class="text-bold text-uppercase">Questions? Need help? Call Us <a class="text-light" href="tel:{{ $option->phone_no }}">{{ $option->phone_no }}</a></h4>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class=account-right>
                      <div class="row">
                        <div class="col-md-2">
                          <div class="footer-box">
                            <div class="footer-title">
                              <h5>my account</h5>
                            </div>
                            <div class="footer-contant">
                              <ul>
                                @if (Auth::check())
                                  {{-- @role('customer')
                                      <li><a href="{{ url('my-account') }}">Account</a></li>
                                      <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                                      <li><a href="{{ url('change-password') }}">Change Password</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endrole
                                  
                                  @role('admin')
                                      <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endrole --}}

                                  @hasanyrole('super-admin|admin|manager')
                                      <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @else
                                      <li><a href="{{ url('my-account') }}">Account</a></li>
                                      <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                                      <li><a href="{{ url('change-password') }}">Change Password</a></li>
                                      <li><a href="{{ url('logout') }}">Logout</a></li>
                                  @endhasanyrole
                                @else
                                    <li><a href="{{ url('register') }}">Register</a></li>
                                    <li><a href="{{ url('login') }}">Login</a></li>
                                @endif
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="footer-box">
                            <div class="footer-title">
                              <h5>quick links</h5>
                            </div>
                            <div class="footer-contant">
                              <ul>
                                <li><a href="{{ url('cart') }}">Cart</a></li>
                                <li><a href="{{ url('products') }}">Products</a></li>
                                <li><a href="{{ url('main-categories') }}">Shop By Category</a></li>
                                <li><a href="{{ url('brands') }}">Shop BY Brand</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="footer-box">
                            <div class="footer-title">
                              <h5>Customer Service</h5>
                            </div>
                            <div class="footer-contant">
                              <ul>
                                <li><a href="{{ url('help-and-faqs') }}">Help & FAQs</a></li>
                                <li><a href="{{ url('terms-of-service') }}">Terms Of Service</a></li>
                                <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ url('return-policy') }}">Return Policy</a></li>
                                <li><a href="{{ url('customer-rebate-center') }}">Customer Rebate Center</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="footer-box footer-contact-box">
                            <div class="footer-title">
                              <h5>contact information</h5>
                            </div>
                            <div class="footer-contant">
                              <ul class="contact-list">
                                <li><i class="fa fa-map-marker"></i><span>{{ $option->address }} <br> <span> </span></span></li>
                                {{-- <li><i class="fa fa-phone"></i><span>call us: {{ $option->phone_no }}</span></li> --}}
                                {{-- <li><i class="fa fa-envelope-o"></i><span>email us: {{ $option->email }}</span></li> --}}
                                {{-- @if($option->fax_no) <li><i class="fa fa-fax"></i><span>fax {{ $option->fax_no }}</span></li> @endif --}}
                                <li><a class="btn bg_navy_blue br_20" href="{{ url('contact-us') }}">Email Us</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="app-link-block  bg-transparent">
    <div class="container">
      <div class="row">
        <div class="app-link-bloc-contain app-link-bloc-contain-1 border_bottom p-1">
          {{-- <div class="app-item-group">
            <div class="app-item">
              <img src="../assets/images/layout-1/app/1.png" class="img-fluid" alt="app-banner">
            </div>
            <div class="app-item">
              <img src="../assets/images/layout-1/app/2.png" class="img-fluid" alt="app-banner">
            </div>
          </div> --}}
          <div class="app-item-group ">
            <div class="sosiyal-block" >
              {{-- <h6>follow us</h6> --}}
              <ul class="sosiyal">
                @if($option->facebook)<li><a href="{{ $option->facebook }}" target="_blank"><i class="fa fa-facebook" ></i></a></li> @endif
                @if($option->twitter)<li><a href="{{ $option->twitter }}" target="_blank"><i class="fa fa-twitter" ></i></a></li> @endif
                @if($option->instagram)<li><a href="{{ $option->instagram }}" target="_blank"><i class="fa fa-instagram" ></i></a></li> @endif
                @if($option->youtube)<li><a href="{{ $option->youtube }}" target="_blank"><i class="fa fa-youtube" ></i></a></li> @endif
                @if($option->linkedin)<li><a href="{{ $option->linkedin }}" target="_blank"><i class="fa fa-linkedin" ></i></a></li> @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sub-footer">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="sub-footer-contain">
            <p>
              <span>{{ date('Y') }} </span>copy right by {{$option->title}} 
              @if($option->company_name)
                powered by <a href="" target="_blank">{{ $option->company_name }}</a>
              @endif
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>



 <!-- tap to top -->
 <div class="tap-top">
     <div>
         <i class="fa fa-angle-double-up"></i>
     </div>
 </div>
 <!-- tap to top End -->

   <!-- Add to cart modal popup start-->
   <div class="modal fade bd-example-modal-lg theme-modal cart-modal " id="addtocart" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
           <div class="modal-content">
               <div class="modal-body modal1 ">
                   <div class="container-fluid p-0">
                       <div class="row">
                           <div class="col-12">
                               <div class="modal-bg addtocart">
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                                   <div class="media">
                                       <a href="layout-5.html#">
                                           <img src="../assets/images/layout-4/product/3.jpg" alt="cart-image" class="img-fluids">
                                       </a>
                                       <div class="media-body align-self-center text-center">
                                           <a href="layout-5.html#">
                                               <h6>
                                                   <i class="fa fa-check"></i>Item
                                                   <span>men full sleeves</span>
                                                   <span> successfully added to your Cart</span>
                                               </h6>
                                           </a>
                                           <div class="buttons">
                                               <a href="layout-5.html#" class="view-cart btn btn-normal">Your cart</a>
                                               <a href="layout-5.html#" class="checkout btn btn-normal">Check out</a>
                                               <a href="layout-5.html#" class="continue btn btn-normal">Continue shopping</a>
                                           </div>

                                           <div class="upsell_payment">
                                               <img src="../assets/images/paymat.png" class="img-fluid " alt="cart-modal-popup">
                                           </div>
                                       </div>
                                   </div>
                                   <div class="product-section">
                                       <div class="col-12 product-upsell text-center">
                                           <h4>Customers who bought this item also.</h4>
                                       </div>
                                       <div class="row" id="upsell_product">
                                           <div class="product-box col-sm-3 col-6">
                                               <div class="img-wrapper">
                                                   <div class="front">
                                                       <a href="layout-5.html#">
                                                           <img src="../assets/images/layout-4/product/1.jpg" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                       </a>
                                                   </div>
                                                   <div class="product-detail">
                                                       <h6><a href="layout-5.html#"><span>cotton top</span></a></h6>
                                                       <h4><span>$25</span></h4>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="product-box col-sm-3 col-6">
                                               <div class="img-wrapper">
                                                   <div class="front">
                                                       <a href="layout-5.html#">
                                                           <img src="../assets/images/layout-4/product/2.jpg" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                       </a>
                                                   </div>
                                                   <div class="product-detail">
                                                       <h6><a href="layout-5.html#"><span>cotton top</span></a></h6>
                                                       <h4><span>$25</span></h4>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="product-box col-sm-3 col-6">
                                               <div class="img-wrapper">
                                                   <div class="front">
                                                       <a href="layout-5.html#">
                                                           <img src="../assets/images/layout-4/product/a1.jpg" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                       </a>
                                                   </div>
                                                   <div class="product-detail">
                                                       <h6><a href="layout-5.html#"><span>cotton top</span></a></h6>
                                                       <h4><span>$25</span></h4>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="product-box col-sm-3 col-6">
                                               <div class="img-wrapper">
                                                   <div class="front">
                                                       <a href="layout-5.html#">
                                                           <img src="../assets/images/layout-4/product/a2.jpg" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                       </a>
                                                   </div>
                                                   <div class="product-detail">
                                                       <h6><a href="layout-5.html#"><span>cotton top</span></a></h6>
                                                       <h4><span>$25</span></h4>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Add to cart modal popup end-->

   <!--Newsletter modal popup start-->
   {{-- <div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
           <div class="modal-content">
               <div class="modal-body">
                   <div class="news-latter">
                       <div class="modal-bg">
                           <div class="offer-content">
                               <div>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                   <h2>newsletter</h2>
                                   <p>Subscribe to our website mailling list <br> and get a Offer, Just for you!</p>
                                   <form action="https://pixelstrap.us19.list-manage.com/subscribe/post?u=5a128856334b598b395f1fc9b&amp;id=082f74cbda" class="auth-form needs-validation" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
                                       <div class="form-group mx-sm-3">
                                           <input type="email" class="form-control" name="EMAIL" id="mce-EMAIL" placeholder="Enter your email" required="required">
                                           <button type="submit" class="btn btn-theme btn-normal btn-sm " id="mc-submit">subscribe</button>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div> --}}
   <!--Newsletter Modal popup end-->

   <!-- Quick-view modal popup start-->
   <div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
           <div class="modal-content quick-view-modal">
               <div class="modal-body">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <div class="row">
                       <div class="col-lg-6 col-xs-12">
                           <div class="quick-view-img"><img src="../assets/images/layout-5/product/3.jpg" alt="quick" class="img-fluid "></div>
                       </div>
                       <div class="col-lg-6 rtl-text">
                           <div class="product-right">
                               <h2>Women Pink Shirt</h2>
                               <h3>$32.96</h3>
                               <ul class="color-variant">
                                   <li class="bg-light0"></li>
                                   <li class="bg-light1"></li>
                                   <li class="bg-light2"></li>
                               </ul>
                               <div class="border-product">
                                   <h6 class="product-title">product details</h6>
                                   <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
                               </div>
                               <div class="product-description border-product">
                                   <div class="size-box">
                                       <ul>
                                           <li class="active"><a href="layout-5.html#">s</a></li>
                                           <li><a href="layout-5.html#">m</a></li>
                                           <li><a href="layout-5.html#">l</a></li>
                                           <li><a href="layout-5.html#">xl</a></li>
                                       </ul>
                                   </div>
                                   <h6 class="product-title">quantity</h6>
                                   <div class="qty-box">
                                       <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                           <input type="text" name="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                                   </div>
                               </div>
                               <div class="product-buttons"><a href="layout-5.html#" class="btn btn-normal">add to cart</a> <a href="layout-5.html#" class="btn btn-normal">view detail</a></div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Quick-view modal popup end-->

   <!-- Add to cart bar -->
   @include('site.product.cart')
   <!-- Add to cart bar end-->

   <!-- My account bar start-->
   <div id="myAccount" class="add_to_cart right account-bar">
       <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
       <div class="cart-inner">
           <div class="cart_top">
             @if(Auth::check())
               <h3>Manage My Account</h3>
            @else
              <h3>Login</h3>
            @endif
               <div class="close-cart">
                   <a href="javascript:void(0)" onclick="closeAccount()">
                       <i class="fa fa-times" aria-hidden="true"></i>
                   </a>
               </div>
           </div>
           @if(!Auth::check())
             {!! Form::model(null,  array('url' => 'login', 'autocomplete' => 'off', 'class' => 'theme-form')) !!}
             {!!csrf_field()!!}
              <div class="form-group {{ $errors->has('login_email') ? 'has-error' : '' }}}">
                <label>Email <span>*</span></label>
                {!!Form::text('login_email', null, array('class' => 'form-control inno_shadow_', 'placeholder' => 'Enter username (Email)'))!!}
                  <em class="error-msg">{!!$errors->first('login_email')!!}</em>
              </div>
              <div class="form-group {{{ $errors->has('login_pass') ? 'has-error' : '' }}}">
                  <label>Passwords <span>*</span></label>
                  {!!Form::password('login_pass', array('class' => 'form-control', 'placeholder' => 'Enter password'))!!}
                  <em class="error-msg">{!!$errors->first('login_pass')!!}</em>
              </div>

              <div class="form-group {{{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}}">
                {!! Recaptcha::render() !!}
                <em class="error-msg">{!!$errors->first('g-recaptcha-response')!!}</em>
              </div>


                 {{-- <div class="form-group">
                     <label for="email">Email</label>
                     <input type="text" class="form-control" id="email" placeholder="Email" required="">
                 </div> --}}
                 {{-- <div class="form-group">
                     <label for="review">Password</label>
                     <input type="password" class="form-control" id="review" placeholder="Enter your password" required="">
                 </div> --}}
                 <div class="form-group">
                    <button class="btn btn-rounded btn-block" type="submit">login</button>
                     {{-- <a href="layout-5.html#" class="btn btn-rounded btn-block ">Login</a> --}}
                 </div>
                 <div>
                     <h5 class="forget-class"><a href="{{ url('register') }}" class="d-block">Create an account</a></h5>
                     <h6 class="forget-class"><a href="{{ url('forgot-password') }}" class="d-block">forget password?</a></h6>
                     {{-- <button class="btn btn-rounded btn-block" type="submit">Register</button> --}}
                 </div>
             {!! Form::close() !!}
           @endif

           @if (Auth::check())
            <div class="cart_media">
                 <ul class="cart_total">
                     <li>
                      @hasanyrole('super-admin|admin|manager')
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('admin/dashboard') }}" class="d-block">Dashboard</a></h5></div>
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('logout') }}" class="d-block">Logout</a></h5></div>
                      @else
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('my-account') }}" class="d-block">My Account</a></h5></div>
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('my-orders') }}" class="d-block">My Orders</a></h5></div>
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('change-password') }}" class="d-block">Change Password</a></h5></div>
                          <div class="total"> <h5 class="forget-class"><a href="{{ url('logout') }}" class="d-block">Logout</a></h5></div>
                      @endhasanyrole
                      
                        {{-- @role('customer')
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('my-account') }}" class="d-block">My Account</a></h5></div>
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('my-orders') }}" class="d-block">My Orders</a></h5></div>
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('change-password') }}" class="d-block">Change Password</a></h5></div>
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('logout') }}" class="d-block">Logout</a></h5></div>
                         @endrole --}}

                         {{-- @role('admin')
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('admin/dashboard') }}" class="d-block">Dashboard</a></h5></div>
                         <div class="total"> <h5 class="forget-class"><a href="{{ url('logout') }}" class="d-block">Logout</a></h5></div>
                         @endrole --}}
                     </li>
                 </ul>
             </div>
           @endif

       </div>
   </div>
   <!-- Add to account bar end-->

   <!-- Add to wishlist bar -->
   @include('site.product.wish_list')
   <!-- Add to wishlist bar end-->


   <div id="mySetting" class="add_to_cart right">
       <a href="javascript:void(0)" class="overlay" onclick="closeSetting()"></a>
       <div class="cart-inner">
           <div class="cart_top">
               <h3>Settings</h3>
               <div class="close-cart">
                   <a href="javascript:void(0)" onclick="closeSetting()">
                       <i class="fa fa-times" aria-hidden="true"></i>
                   </a>
               </div>
           </div>
           <div class="setting-block">
               <div>
                   {{-- <h5>Settings</h5> --}}
                   <ul>
                      @if (Auth::check())
                          <li><a href="{{ url('my-account') }}">My Account</a></li>
                          <li><a href="{{ url('my-orders') }}">My Orders</a></li>
                          <li><a href="{{ url('change-password') }}">Change Password</a></li>
                          <li><a href="{{ url('logout') }}">Logout</a></li>
                      @else
                          <li><a href="{{ url('register') }}">Register</a></li>
                          <li><a href="{{ url('login') }}">Login</a></li>
                      @endif
                   </ul>
               </div>
           </div>
       </div>
   </div>

<!-- notification product -->
{{--  <div class="product-notification" id="dismiss">
   <span  onclick="dismiss();" class="close" aria-hidden="true">×</span>
   <div class="media">
     <img class="mr-2" src="../assets/images/layout-1/product/5.jpg" alt="Generic placeholder image">
     <div class="media-body">
       <h5 class="mt-0 mb-1">Latest trending</h5>
       Cras sit amet nibh libero, in gravida nulla.
     </div>
   </div>
 </div> --}}
 <!-- notification product -->