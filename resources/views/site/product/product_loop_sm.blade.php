<li class="product">
    <div class="post_item_wrap">
        <div class="post_featured">
            <div class="post_thumb">
                <a href="{{url('product/'.$row->slug)}}">
                    <span class="onsale">Sale!</span>
                    @if($row->main_image)
                        <img class="card-img-top img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" alt="">
                    @else
                         <img class="card-img-top img-fluid" src="{{asset('site/defaults/product_placeholder.png')}}" alt="">
                    @endif
                </a>
            </div>
        </div>
        <div class="post_content">
            <h2 class="woocommerce-loop-product__title"><a href="{{url('product/'.$row->slug)}}">{{$row->title}}</a></h2>
            {{-- <div class="star-rating" title="Rated 5.00 out of 5">
                <span class="width_100_per">
                    <strong class="rating">5.00</strong> out of 5
                </span>
            </div> --}}
            <span class="price">
               {{--  @if ($row->is_retail_price_display == 1)
                    <div class="price_box">
                        <span class="old_price">{{ $option->currency_symbol . $row->retail_price }} </span> 
                        <span class="current_price"> {{ $option->currency_symbol . $row->dicounted_price }} </span>
                    </div>
                @endif --}}
                @if($row->dicounted_price)
                    <del>
                        <span class="woocommerce-Price-amount amount">
                            <span class="woocommerce-Price-currencySymbol">&#36;</span>{{ $row->dicounted_price }}
                        </span>
                    </del>
                @endif
                <ins>
                    <span class="woocommerce-Price-amount amount">
                        <span class="woocommerce-Price-currencySymbol">&#36;</span>{{ $row->dicounted_price }}
                    </span>
                </ins>
            </span>
            @if ($row->is_purchase_enabled   == 1)
              {{-- {!!Form::open(['url'=> $row->id.'/item', 'autocomplete'=>'off', 'id' => 'product_id_'.$row->id])!!}
              {!!csrf_field()!!} --}}
                <a  href="{{ url($row->id.'/item') }}" class="button product_type_simple add_to_cart_button">Add to cart</a>
                {{-- <a onclick="this.form.submit()" class="button product_type_simple add_to_cart_button">Add to cart</a> --}}
                  {{-- <button type="submit" class="button product_type_simple add_to_cart_button">Add to cart</button> --}}
              {{-- {!! Form::close() !!} --}}
            @endif
        </div>
    </div>
</li>