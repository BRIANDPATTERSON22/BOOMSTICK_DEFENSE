<h5>
    @if (Auth::user())
        @if (Auth::user()->hasRole('trade_customer'))
            @if (Auth::user()->customer->discount_percentage)
                @if (Auth::user()->customer->discount_percentage >= $row->discount_percentage)
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - ((Auth::user()->customer->discount_percentage / 100) * $row->price), 2) }}</span>
                @else
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price) , 2) }}</span>
                @endif
            @else
                @if ($option->trade_discount_percentage >= $row->discount_percentage)
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($option->trade_discount_percentage / 100) * $row->price),2) }}</span>
                @else
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price),2) }}</span>
                @endif
            @endif
        @elseif (Auth::user()->hasRole('cake_time_club'))
            @if (Auth::user()->customer->is_paid == 1)
                @if (Auth::user()->customer->membership_type == 1)
                    @if (Auth::user()->customer->discount_percentage)
                        @if (Auth::user()->customer->discount_percentage >= $row->discount_percentage)
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - ((Auth::user()->customer->discount_percentage / 100) * $row->price),2)}}</span>
                        @else
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price),2)}}</span>
                        @endif
                    @else
                        @if ($option->cake_time_club_gold_discount_percentage >= $row->discount_percentage)
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($option->cake_time_club_gold_discount_percentage / 100) * $row->price),2)}}</span>
                        @else
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}} {{ number_format($row->price - (($row->discount_percentage / 100) * $row->price),2)}}</span>
                        @endif
                    @endif
                @elseif(Auth::user()->customer->membership_type == 2)
                    @if (Auth::user()->customer->discount_percentage)        
                        @if (Auth::user()->customer->discount_percentage >= $row->discount_percentage)
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - ((Auth::user()->customer->discount_percentage / 100) * $row->price), 2) }}</span>
                        @else
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price), 2)}}</span>
                        @endif
                    @else
                        @if ($option->cake_time_club_platinum_discount_percentage >= $row->discount_percentage)
                            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                            <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($option->cake_time_club_platinum_discount_percentage / 100) * $row->price),2) }}</span>
                        @else
                             <span class="product-desc-price">a{{$option->currency_symbol}}{{$row->price}}</span>
                             <span class="product-price">{{$option->currency_symbol}}{{$row->price - (($row->discount_percentage / 100) * $row->price)}}</span>
                        @endif
                    @endif
                @endif
            @else
                @if (Auth::user()->customer->discount_percentage)
                    @if (Auth::user()->customer->discount_percentage >= $row->discount_percentage)
                         <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                         <span class="product-price">{{$option->currency_symbol}}{{number_format($row->price - ((Auth::user()->customer->discount_percentage / 100) * $row->price),2)}}</span>
                    @else
                         <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                         <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price) , 2) }}</span>
                    @endif
                @else 
                    @if ($row->discount_percentage)
                         <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                         <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price), 2)}}</span>
                     @else
                         <span class="product-price">{{$option->currency_symbol}}{{number_format($row->price,2)}}</span>
                     @endif
                @endif
            @endif
        @elseif (Auth::user()->hasRole('customer'))
           @if (Auth::user()->customer->discount_percentage)
               @if (Auth::user()->customer->discount_percentage >= $row->discount_percentage)
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{number_format($row->price - ((Auth::user()->customer->discount_percentage / 100) * $row->price),2)}}</span>
               @else
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}} {{ number_format($row->price - (($row->discount_percentage / 100) * $row->price) , 2) }}</span>
               @endif
           @else 
               @if ($row->discount_percentage)
                    <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                    <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price), 2)}}</span>
                @else
                    <span class="product-price">{{$option->currency_symbol}}{{number_format($row->price,2)}}</span>
                @endif
           @endif
       @elseif(Auth::user()->hasRole('admin'))
            @if ($row->discount_percentage)
                <span class="product-price font-12">Starter Price</span>
                <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
                <span class="product-price">{{$option->currency_symbol}}{{ number_format($row->price - (($row->discount_percentage / 100) * $row->price), 2) }}</span>
             @else
                <span class="product-price font-12">Starter Price</span>
                <span class="product-price">{{$option->currency_symbol}}{{$row->price}}</span>
             @endif
       @endif
    @else
        @if($row->discount_percentage)
            <span class="product-desc-price">{{$option->currency_symbol}}{{$row->price}}</span>
        @endif
        <span class="product-price">{{$option->currency_symbol}}{{ $row->discount_percentage ? $row->discount_price : $row->price}}</span>
    @endif   
</h5>