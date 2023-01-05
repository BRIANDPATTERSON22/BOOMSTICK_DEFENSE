@if(Cart::instance('cart')->count()>0)
    <div class="mini_cart inno_shadow_2">
        <div class="cart_gallery">
            @php $cartItems = Cart::instance('cart')->content() ;@endphp
            @foreach($cartItems as $item)
                <div class="cart_item">
                   <div class="cart_img">
                        <a href="{{url('product/'.$item->options['slug'])}}">
                            @if($item->options['image'])
                                <img class="img-fluid" src="{{asset('storage/products/images/'.$item->options['image'])}}" alt="{{$item->name}}">
                            @else
                                <img class="img-fluid" src="{{asset('site/images/defaults/no-image.png')}}" alt="{{$item->name}}">
                            @endif
                        </a>
                   </div>
                    <div class="cart_info">
                        <a href="{{url('product/'.$item->options['slug'])}}">{{ str_limit($item->name, 20)}}</a>
                        <p>Qty: {{$item->qty}} X <span> {{ $option->currency_symbol }}{{number_format($item->price,2)}} </span></p>    
                    </div>
                    <div class="cart_remove">
                        <a href="{{url('item/'.$item->rowId.'/remove')}}"><i class="ion-android-close"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mini_cart_table">
            <div class="cart_table_border">
                <div class="cart_total">
                    <span>Sub total:</span>
                    <span class="price">{{ $option->currency_symbol }}{{Cart::subtotal()}}</span>
                </div>
               {{--  <div class="cart_total mt-10">
                    <span>total:</span>
                    <span class="price">{{ $option->currency_symbol }}{{Cart::total() }} </span>
                </div> --}}
            </div>
        </div>
        <div class="mini_cart_footer">
           <div class="cart_button" style="width: 45%; float: left">
                <a href="{{ url('cart') }}">View cart</a>
            </div>
            <div class="cart_button" style="width: 45%; float: right">
                @if (Auth::user())
                    @role('wholesale_customer')
                        <a href="{{url('checkout-address')}}"> Checkout</a>
                    @endrole
                @else
                    <a href="{{url('checkout')}}"> Checkout</a>
                @endif
            </div>

        </div>
    </div>
@else
    <div class="mini_cart inno_shadow_2">
        <div class="cart_gallery">
           <h4 class="text-center"> <strong>Hi, Your Cart is Empty!</strong></h4>
        </div>
        {{-- <div class="mini_cart_table">
            <div class="cart_table_border">
                <div class="cart_total_">
                     <h6 class="text-center">Your Cart empty</h6>
                </div>
            </div>
        </div> --}}
        <hr>
        <div class="mini_cart_footer">
           <div class="cart_button">
                <a href="{{ url('products') }}">Start Shopping Now!</a>
            </div>
        </div>
    </div>
@endif