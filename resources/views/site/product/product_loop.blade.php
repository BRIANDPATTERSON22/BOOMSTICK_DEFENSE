<div>
    <a href="{{url('product/'.$row->slug)}}">
    <div class="product-box">
        <div class="product-imgbox">
            <div class="product-front">
                    @if($row->main_image)
                        <img class="img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}" style="max-width:60%">
                    @else
                         <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}" style="max-width:60%">
                    @endif
            </div>
            <!--<div class="product-back">-->
            <!--    <a href="{{url('product/'.$row->slug)}}">-->
            <!--        @if($row->main_image)-->
            <!--            <img class="img-fluid" src="{{asset('storage/products/images/'.$row->main_image)}}">-->
            <!--        @else-->
            <!--             <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">-->
            <!--        @endif-->
            <!--    </a>-->
            <!--</div>-->
            <!--<div class="product-icon icon-inline">-->
            <!--    {{-- <button onclick="openCart()">-->
            <!--        <i class="ti-bag" ></i>-->
            <!--    </button> --}}-->
            <!--    {{-- <a href="javascript:void(0)" title="Add to Wishlist">-->
            <!--        <i class="ti-heart" aria-hidden="true"></i>-->
            <!--    </a> --}}-->
            <!--    {{-- <a href="layout-5.html#" data-toggle="modal" data-target="#quick-view" title="Quick View">-->
            <!--        <i class="ti-search" aria-hidden="true"></i>-->
            <!--    </a> --}}-->
            <!--    {{-- <a href="compare.html" title="Compare">-->
            <!--        <i class="fa fa-exchange" aria-hidden="true"></i>-->
            <!--    </a> --}}-->
            <!--    {{-- <a href="{{ url($row->id.'/item') }}" title="Add to Cart">-->
            <!--        <i class="icon-shopping-cart" aria-hidden="true"></i>-->
            <!--    </a> --}}-->
            <!--    {{-- <a href="{{url('product/'.$row->slug)}}" title="View Product">-->
            <!--        <i class="ti-search" aria-hidden="true"></i>-->
            <!--    </a> --}}-->
            <!--    @if($row->is_in_stock())-->
            <!--        {!!Form::open(['url'=> $row->slug.'/item', 'autocomplete'=>'off'])!!}-->
            <!--        {{-- {!!Form::open(['url'=> $row->id.'/item', 'autocomplete'=>'off'])!!} --}}-->
            <!--        {!!csrf_field()!!}-->
            <!--          <button type="submit" title="Add to cart"><i class="ti-bag" ></i></button>-->
            <!--        {!! Form::close() !!}-->
            <!--    @endif-->
            <!--    <a href="{{url('product/'.$row->slug)}}" title="View Product">-->
            <!--        <i class="ti-search" aria-hidden="true"></i>-->
            <!--    </a>-->
            <!--</div>-->
        </div>
        <div class="product-detail detail-inline">
            <div class="detail-title">
                <div class="detail-left">
                    {{-- <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div> --}}
                        <h6 class="price-title">
                            {{$row->title}}
                        </h6>
                    
                    @if($row->is_retail_price_enabled == 1)
                        <div class="border-top border-dark mt-2">
                            <strong>{{ $option->currency_symbol . number_format($row->retail_price, 2) }}</strong>
                        </div>
                    @endif
                </div>

                {{-- <div class="detail-right">
                    <div class="check-price">
                        {{ $option->currency_symbol . $row->retail_price }}
                    </div>
                    <div class="price">
                        <div class="price">
                            <hr>
                            {{ $option->currency_symbol . $row->retail_price }}
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    </a>
</div>