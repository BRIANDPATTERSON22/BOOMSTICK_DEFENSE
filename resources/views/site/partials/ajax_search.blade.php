<div class="list-group">
      @foreach($products as $product)
          {{-- <li class="list-group-item" onclick="$('.search_form').submit()">
              <a href="javascript:" onmouseover="$('.search-bar-input-mobile').val('{{$i['name']}}');$('.search-bar-input').val('{{$i['name']}}');">
                  {{$i['name']}}
              </a>
          </li> --}}
          <a href="{{url('product/'.$product->rsr_stock_number)}}" class="list-group-item list-group-item-action"><strong>{{ $product->product_description }}</strong> - <small>{{ $product->rsr_stock_number }}</small></a>
      @endforeach
  </div>