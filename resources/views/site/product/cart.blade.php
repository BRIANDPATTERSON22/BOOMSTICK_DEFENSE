@if(Cart::instance('cart')->count() > 0)
    <div id="cart_side" class=" add_to_cart left">
        <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
        <div class="cart-inner">
            <div class="cart_top">
                <h3>my cart</h3>
                <div class="close-cart">
                    <a href="javascript:void(0)" onclick="closeCart()">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="cart_media">
                <ul class="cart_product">
                    @foreach(Cart::instance('cart')->content() as $item)
                        <li>
                            <div class="media">
                                <a href="{{url('product/'.$item->options['slug'])}}">
                                    @if ($item->options['type'] == 0)
                                        @if($item->options['image'])
                                            <img class="mr-2" src="{{asset('storage/products/images/'.$item->options['image'])}}" alt="{{$item->name}}">
                                        @else
                                            <img class="mr-2" src="{{asset('site/img/default.png')}}" alt="{{$item->name}}">
                                        @endif
                                    @else
                                        <img class="img-fluid" src="{{asset($item->options['image'])}}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <a href="{{url('product/'.$item->options['slug'])}}">
                                        <h5>{{str_limit($item->name, 15)}}</h5>
                                    </a>
                                    <h4>
                                        <span>{{$item->qty}} x {{ $option->currency_symbol }}{{number_format($item->price,2)}}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="close-circle">
                                <a href="{{url('item/'.$item->rowId.'/remove')}}">
                                    <i class="ti-trash" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <ul class="cart_total">
                    <li>
                        <div class="total">
                            <h5>subtotal : <span>{{ $option->currency_symbol }} {{Cart::subtotal()}}</span></h5>
                        </div>
                    </li>
                    
                    <li>
                        <div class="buttons">
                            <a href="{{ url('cart') }}" class="btn btn-normal btn-xs view-cart btn-block text-uppercase">view cart</a>
                            {{-- <a href="{{ url('checkout-address') }}" class="btn btn-normal btn-xs checkout">checkout</a> --}}
                        </div>
                    </li>

                    <li>
                        <div class="buttons">
                            @if (Auth::check())
                                <a href="{{ url('checkout-age-verification') }}" class="btn btn-normal btn-xs view-cart text-uppercase btn-block">Checkout</a>
                            @else
                                <a href="{{ url('login') }}" class="btn btn-normal btn-xs view-cart text-uppercase btn-block">Login & Checkout</a>
                                {{-- <a href="{{ url('address') }}" class="btn btn-normal btn-xs checkout text-uppercase btn-block">checkout as guest</a> --}}
                                <a href="{{ url('verification') }}" class="btn btn-normal btn-xs checkout text-uppercase btn-block">checkout as guest</a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@else
    <div id="cart_side" class=" add_to_cart left">
        <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
        <div class="cart-inner">
            <div class="cart_top">
                <h3>my cart</h3>
                <div class="close-cart">
                    <a href="javascript:void(0)" onclick="closeCart()">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="cart_media">
                <ul class="cart_total">
                    <li>
                        <div class="total">
                            <h5>Your Cart is Empty!</h5>
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <a href="{{ url('products') }}" class="btn btn-normal btn-xs view-cart btn-block">Start Shopping Now!</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif