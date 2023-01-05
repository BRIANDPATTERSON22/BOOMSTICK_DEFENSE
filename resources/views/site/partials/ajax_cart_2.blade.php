                    @if(Cart::instance('cart')->count()>0)
                        @php $cartItems = Cart::instance('cart')->content() ;@endphp
                        @foreach($cartItems as $item)
                         <div class="dropdown-item">                        
                            <a class="pull-right" data-toggle="tooltip" data-placement="top" title="" href="{{url('item/'.$item->rowId.'/remove')}}" data-original-title="Remove">
                            <i class="fa fa-trash-o"></i>
                            </a>
                            <a href="{{url('product/'.$item->options['slug'])}}">
                            @if($item->options['image'])
                                <img class="img-fluid" src="{{asset('storage/products/images/'.$item->options['image'])}}" alt="{{$item->name}}">
                            @else
                                <img class="img-fluid" src="{{asset('site/images/defaults/no-image.png')}}" alt="{{$item->name}}">
                            @endif

                            <strong> {{ str_limit($item->name, 20)}} </strong>
                            <small>Qty : {{$item->qty}}</small>
                            {{-- <span class="product-desc-price">$529.99</span> --}}
                            <span class="product-price text-danger">{{$item->qty}} x {{ $option->currency_symbol }}{{number_format($item->price,2)}}</span>
                            </a>
                         </div>
                         @endforeach
                         <div class="dropdown-divider"></div>
                         <div class="dropdown-cart-footer text-center">
                            <h4> <strong>Subtotal</strong>: {{ $option->currency_symbol }}{{Cart::subtotal()}} </h4>
                            <a class="btn btn-sm btn-danger" href="{{ url('cart') }}"> <i class="icofont icofont-shopping-cart"></i> VIEW
                            CART </a> <a href="{{url('checkout-address')}}" class="btn btn-sm btn-primary"> CHECKOUT </a>
                         </div>
                    @endif
