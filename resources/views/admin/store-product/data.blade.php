@php $count = 0; @endphp
                                 @foreach ($storesData as $store)
                                     @php $count++; @endphp
                                     <tr>
                                           <td>{{$count}}</td>
                                           <td style="white-space: nowrap_;">
                                               <a href="{{url('admin/store/'.$store->id.'/view')}}"> {{ $store->division }}/ {{ $store->banner }}/ {{ $store->store_id }} </a>
                                           </td>
                                           {{-- @php dump($store->products); @endphp --}}

                                           {{-- @for ($i = 0; $i < count($productsData); $i++) --}}
                                               @foreach ($productsData as $product)

                                                   <td class="text-center">
                                                     @php $isDataExist = $product->check_cell($product->id, $store->store_id); @endphp  
                                                   {{--     <input type="hidden" value="2" id="product_id">
                                                       <input type="hidden" value="192" id="store_id"> --}}
                                                     {{--   @if ($product->check_cell($product->id, $store->store_id))
                                                          <input name="status" value="1" type="checkbox" id="" data-product-id="{{ $product->id }}" data-store-id="{{ $store->store_id }}" checked>
                                                     {{ $product->title }}
                                                      @else
                                                           <input name="status" value="0" type="checkbox" id="" data-product-id="{{ $product->id }}" data-store-id="{{ $store->store_id }}">
                                                       @endif --}}

                                                        {{-- @if ($product->check_cell($product->id, $store->store_id)) --}}
                                                           <input name="status" 
                                                                   value="{{ $isDataExist ? 1 : 0 }}" 
                                                                   type="checkbox" 
                                                                   id="" 
                                                                   data-product-id="{{ $product->id }}" 
                                                                   data-store-id="{{ $store->store_id }}" 
                                                                   @if($isDataExist) checked @endif >
                                                    {{--    @else
                                                            <input name="status" value="0" type="checkbox" id="" data-product-id="{{ $product->id }}" data-store-id="{{ $store->store_id }}">
                                                        @endif --}}
                                                  </td>
                                              @endforeach 
                                           {{-- @endfor --}}

                                         {{--   @foreach ($store->products as $product)
                                           @php
                                                   dump($product->chreck_cell($product->product->id, $store->store_id));
                                               @endphp
                                               @if(
                                                   $product->chreck_cell($product->product_id, $store->store_id))
                                               
                                               <td class="text-center">
                                                   <input name="status" value="1" type="checkbox" id="" @if($product->status == 1) checked @endif>
                                                   {{ $product->product->title }}
                                               </td>
                                               @else
                                                   <td class="text-center">
                                                       <input name="status" value="1" type="checkbox" id="" @if($product->status == 1) checked @endif>
                                                       xxxx
                                                   </td>
                                               @endif
                                           @endforeach --}}
                                           
                                     </tr>
                                 @endforeach