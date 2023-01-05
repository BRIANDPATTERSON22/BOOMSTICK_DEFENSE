<section class="login-page section-big-py-space bg-light pb-0" style="margin-bottom: -30px;">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="checkout-step mb-40">
                        <ul>
                            @if(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() > 0 && Cart::instance('cart')->content()->where('options.is_firearm', 1)->count() > 0)
                                <li class="@if(Request::is('checkout-age-verification')) active @endif">
                                    <a href="{{ url('checkout-age-verification') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Age Verification</span>
                                    </a>
                                </li>

                                <li class="@if(Request::is('checkout-address')) active @endif">
                                    <a href="{{ url('checkout-address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">2</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('checkout-state-verification')) active @endif">
                                     <a href="{{ url('checkout-state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-ffl-dealers')) active @endif">
                                     <a href="{{ url('checkout-ffl-dealers') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>FFL Dealers</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-shipping')) active @endif">
                                     <a href="{{ url('checkout-shipping') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">5</div>
                                     </div>
                                     <span>Shipping</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('checkout-payment')) active @endif">
                                     <a href="{{ url('checkout-payment') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">6</div>
                                     </div>
                                     <span>Payment</span>
                                     </a>
                                 </li>
                                 
                                 
                                 <li class="@if(Request::is('checkout-review')) active @endif">
                                     <a href="{{ url('checkout-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 
                                 <li class="@if(Request::is('completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">8</div>
                                     </div>
                                     <span>Complete</span>
                                     </a>
                                 </li>
                            @elseif(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() > 0)
                                <li class="@if(Request::is('checkout-age-verification')) active @endif">
                                    <a href="{{ url('checkout-age-verification') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Age Verification</span>
                                    </a>
                                </li>

                                <li class="@if(Request::is('checkout-address')) active @endif">
                                    <a href="{{ url('checkout-address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">2</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('checkout-state-verification')) active @endif">
                                     <a href="{{ url('checkout-state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-shipping')) active @endif">
                                     <a href="{{ url('checkout-shipping') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>Shipping</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('checkout-payment')) active @endif">
                                     <a href="{{ url('checkout-payment') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">5</div>
                                     </div>
                                     <span>Payment</span>
                                     </a>
                                 </li>
                            
                                 <li class="@if(Request::is('checkout-review')) active @endif">
                                     <a href="{{ url('checkout-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">6</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Completed</span>
                                     </a>
                                 </li>
                            @elseif(Cart::instance('cart')->content()->where('options.is_firearm', 1)->count() > 0)
                                <li class="@if(Request::is('checkout-address')) active @endif">
                                    <a href="{{ url('checkout-address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('checkout-state-verification')) active @endif">
                                     <a href="{{ url('checkout-state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">2</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-ffl-dealers')) active @endif">
                                     <a href="{{ url('checkout-ffl-dealers') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>FFL Dealers</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-shipping')) active @endif">
                                     <a href="{{ url('checkout-shipping') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>Shipping</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('checkout-payment')) active @endif">
                                     <a href="{{ url('checkout-payment') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">5</div>
                                     </div>
                                     <span>Payment</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('checkout-review')) active @endif">
                                     <a href="{{ url('checkout-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">6</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Completed</span>
                                     </a>
                                 </li>
                            @else
                                <li class="@if(Request::is('checkout-address')) active @endif">
                                    <a href="{{ url('checkout-address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('checkout-state-verification')) active @endif">
                                     <a href="{{ url('checkout-state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">2</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('checkout-shipping')) active @endif">
                                     <a href="{{ url('checkout-shipping') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>Shipping</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('checkout-payment')) active @endif">
                                     <a href="{{ url('checkout-payment') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">4</div>
                                     </div>
                                     <span>Payment</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('checkout-review')) active @endif">
                                     <a href="{{ url('checkout-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">5</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">6</div>
                                     </div>
                                     <span>Completed</span>
                                     </a>
                                 </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>