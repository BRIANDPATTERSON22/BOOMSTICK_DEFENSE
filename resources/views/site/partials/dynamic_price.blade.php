<span class="product-price text-success pull-right" style="display: none;" id="ajax-price-container">
    {{-- <i class="icofont icofont-price"></i> --}}
    <i class="fa fa-spinner fa-pulse fa-1x fa-fw" id="ajax-animation"></i>
    <span class="sr-only">Loading...</span>
    {{$option->currency_symbol}}
    <div id="ajax-calculated-price" style="display: inline-block;">
        {{ $singleData->discount_percentage ? $singleData->discount_price : $singleData->price}}
    </div>
</span>