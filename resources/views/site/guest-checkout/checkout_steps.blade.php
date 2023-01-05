<section class="login-page section-big-py-space bg-light pb-0" style="margin-bottom: -30px;">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="checkout-step mb-40">
                        <ul>
                            @if(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() > 0 && Cart::instance('cart')->content()->where('options.is_firearm', 1)->count() > 0)
                                <li class="@if(Request::is('verification')) active @endif">
                                    <a href="{{ url('verification') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Age Verification</span>
                                    </a>
                                </li>

                                <li class="@if(Request::is('address')) active @endif">
                                    <a href="{{ url('address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">2</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('state-verification')) active @endif">
                                     <a href="{{ url('state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('ffl-dealers')) active @endif">
                                     <a href="{{ url('ffl-dealers') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>FFL Dealers</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('shipping-methods')) active @endif">
                                     <a href="{{ url('shipping-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">5</div>
                                     </div>
                                     <span>Shipping Methods</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('payment-methods')) active @endif">
                                     <a href="{{ url('payment-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">6</div>
                                     </div>
                                     <span>Payment Methods</span>
                                     </a>
                                 </li>
                                 
                                 
                                 <li class="@if(Request::is('order-review')) active @endif">
                                     <a href="{{ url('order-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 
                                 <li class="@if(Request::is('order-completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">8</div>
                                     </div>
                                     <span>Complete</span>
                                     </a>
                                 </li>
                            @elseif(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() > 0)
                                <li class="@if(Request::is('verification')) active @endif">
                                    <a href="{{ url('verification') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Age Verification</span>
                                    </a>
                                </li>

                                <li class="@if(Request::is('address')) active @endif">
                                    <a href="{{ url('address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">2</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('state-verification')) active @endif">
                                     <a href="{{ url('state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('shipping-methods')) active @endif">
                                     <a href="{{ url('shipping-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>Shipping Methods</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('payment-methods')) active @endif">
                                     <a href="{{ url('payment-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">5</div>
                                     </div>
                                     <span>Payment Methods</span>
                                     </a>
                                 </li>
                            
                                 <li class="@if(Request::is('order-review')) active @endif">
                                     <a href="{{ url('order-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">6</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('order-completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Completed</span>
                                     </a>
                                 </li>
                            @elseif(Cart::instance('cart')->content()->where('options.is_firearm', 1)->count() > 0)
                                <li class="@if(Request::is('address')) active @endif">
                                    <a href="{{ url('address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('state-verification')) active @endif">
                                     <a href="{{ url('state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">2</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('ffl-dealers')) active @endif">
                                     <a href="{{ url('ffl-dealers') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>FFL Dealers</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('shipping-methods')) active @endif">
                                     <a href="{{ url('shipping-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">4</div>
                                     </div>
                                     <span>Shipping Methods</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('payment-methods')) active @endif">
                                     <a href="{{ url('payment-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">5</div>
                                     </div>
                                     <span>Payment Methods</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('order-review')) active @endif">
                                     <a href="{{ url('order-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">6</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('order-completed')) active @endif">
                                     <a>
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">7</div>
                                     </div>
                                     <span>Completed</span>
                                     </a>
                                 </li>
                            @else
                                <li class="@if(Request::is('address')) active @endif">
                                    <a href="{{ url('address') }}">
                                    <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                    </div>
                                    <span>Address</span>
                                    </a>
                                </li>

                                 <li class="@if(Request::is('state-verification')) active @endif">
                                     <a href="{{ url('state-verification') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">2</div>
                                     </div>
                                     <span>State verification</span>
                                     </a>
                                 </li>

                                 <li class="@if(Request::is('shipping-methods')) active @endif">
                                     <a href="{{ url('shipping-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">3</div>
                                     </div>
                                     <span>Shipping Methods</span>
                                     </a>
                                 </li> 

                                 <li class="@if(Request::is('payment-methods')) active @endif">
                                     <a href="{{ url('payment-methods') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                      <div class="circle">4</div>
                                     </div>
                                     <span>Payment Methods</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('order-review')) active @endif">
                                     <a href="{{ url('order-review') }}">
                                     <div class="step">
                                     <div class="line"></div>
                                     <div class="circle">5</div>
                                     </div>
                                     <span>Order Overview</span>
                                     </a>
                                 </li>
                                 
                                 <li class="@if(Request::is('order-completed')) active @endif">
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