<ul>
   <li @if(Request::is('checkout-address')) class="active" @endif>
      <a href="{{ url('checkout-address') }}">
         <div class="step">
            <div class="line"></div>
            <div class="circle">1</div>
         </div>
         <span>Shipping Address</span>
      </a>
   </li>
   <li @if(Request::is('checkout-shipping')) class="active" @endif>
      <a href="{{ url('checkout-shipping') }}">
         <div class="step">
            <div class="line"></div>
            <div class="circle">2</div>
         </div>
         <span>Shipping Methods</span>
      </a>
   </li>
   <li @if(Request::is('checkout-payment')) class="active" @endif>
      <a href="{{ url('checkout-payment') }}">
         <div class="step">
            <div class="line"></div>
            <div class="circle">3</div>
         </div>
         <span>Payment Method</span>
      </a>
   </li>
   <li @if(Request::is('checkout-review')) class="active" @endif>
      <a href="{{ url('checkout-review') }}">
         <div class="step">
            <div class="line"></div>
            <div class="circle">4</div>
         </div>
         <span>Checkout review</span>
      </a>
   </li>

   <li @if(Request::is('completed', 'cancelled')) class="active" @endif>
      @if(Request::is('completed'))
         <a href="{{ url('completed') }}">
            <div class="step">
               <div class="line"></div>
               <div class="circle">5</div>
            </div>
            <span>Completed</span>
         </a>
      @elseif(Request::is('cancelled'))
         <a href="{{ url('cancelled') }}">
            <div class="step">
               <div class="line"></div>
               <div class="circle">5</div>
            </div>
            <span>Order Failed</span>
         </a>
      @else
         <a href="#">
            <div class="step">
               <div class="line"></div>
               <div class="circle">5</div>
            </div>
            <span>Complete!</span>
         </a>
      @endif
   </li>
</ul>