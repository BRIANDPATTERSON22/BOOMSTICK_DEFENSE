@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->order_no}} | Orders
@endsection

@section('contentheader_title')
    ORDER#: {{$singleData->order_no}}
{{--     , STATUS:
    @if($singleData->status == 1)
        <span class="label label-warning">Processing</span>
    @elseif($singleData->status == 2)
        <span class="label label-danger">Pending</span>
    @elseif($singleData->status == 3)
        <span class="label label-success">Paid</span> by
        @if($singleData->payment_id == 1)
            <span class="label label-info">Pay on Delivery</span>
        @elseif($singleData->payment_id == 2)
            <span class="label label-info">Pay with PayPal</span>
        @elseif($singleData->payment_id == 3)
            <span class="label label-info">Pay to Bank</span>
        @elseif($singleData->payment_id == 4)
            <span class="label label-info">Pay with Credit Card</span>
        @elseif($singleData->payment_id == 5)
            <span class="label label-info">Sage Pay</span>
        @endif
    @elseif($singleData->status == 4)
        <span class="label label-info">Delivered</span>
    @endif --}}
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->order_no}} {{$singleData->last_name}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('page-style')
    <style>
        /*.w-100{width: 100% !important}*/
        .select2-container { width: 100% !important;}
    </style>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg_ @endif">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <table class="table">
                                <tbody>
                                {{-- <tr>
                                    <th>Customer Type</th>
                                    <td>: 
                                        @if($singleData->customer->role_id == 2)
                                            <span class="label label-info">Default</span>
                                        @elseif($singleData->customer->role_id == 3)
                                            <span class="label label-warning">Trade</span>
                                        @elseif($singleData->customer->role_id == 4)
                                            <span class="label label-success"> Cake time Club</span>
                                        @endif
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>Ordered Date</th>
                                    <td>: <span class="label label-warning">{{ Carbon\Carbon::parse(date($singleData->created_at), 'UTC')->setTimezone($singleData->timezone_identifier)->format('Y-m-d h:i:s A') }} ({{ $singleData->timezone_identifier }})</span></td>
                                </tr>
                               {{--  <tr>
                                    <th>Payment Status</th>
                                    <td>: 
                                        @if ($singleData->pay_status == 'PAID')
                                            <span class="label label-success">PAID</span>
                                        @else
                                            <span class="label label-danger">UNPAID</span>
                                        @endif
                                    </td>
                                </tr> --}}
                               {{--  <tr>
                                    <th>Order Status</th>
                                    <td>: 
                                        @if($singleData->status == 1)
                                            <span class="label label-default">Process Not Completed</span>
                                        @elseif($singleData->status == 2)
                                            <strike><span class="label label-danger">Cancelled by user</span></strike> 
                                        @elseif($singleData->status == 3)
                                            <span class="label label-warning">Pending</span>
                                        @elseif($singleData->status == 4)
                                            <span class="label label-primary">Processing</span>
                                        @elseif($singleData->status == 5)
                                            <span class="label label-info">Dispatched</span>
                                        @elseif($singleData->status == 6)
                                            <span class="label label-success">Delivered</span>
                                        @endif
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>Name</th>
                                    <td>: <a href="{{ url('admin/customer/'.$singleData->customer_id.'/view') }}" target="_blank">{{$singleData->customer->first_name}} {{$singleData->customer->last_name}}</a></td>
                                </tr>

                                <tr>
                                    <th>Phone</th>
                                    <td>: {{$singleData->customer->mobile_no}} {{$singleData->customer->phone_no}}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>: {{$singleData->customer->email}} {{$singleData->customer->phone}}</td>
                                </tr>

                                {{-- <tr>
                                    <th>Sales Person</th>
                                    <td>: {{ $singleData->sales_person_id ? $singleData->salesPerson->title : '---' }}</td>
                                </tr> --}}

                                @if($singleData->paymentMethod)
                                    <tr>
                                        <th>Payment method</th>
                                        <td>: {{$singleData->paymentMethod->title}}</td>
                                    </tr>
                                @endif

                                @if($singleData->shippingMethod)
                                    <tr>
                                        <th>Shipping method</th>
                                        <td>: {{$singleData->shippingMethod->title}}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <th>FFL Dealer</th>
                                    <td>{{ $singleData->ffl_dealer_name }} </td>
                                </tr>

                                <tr>
                                    <th>FFL license</th>
                                    <td>{{ $singleData->ffl_licence }} </td>
                                </tr>

                                <tr>
                                    <th>Order Status</th>
                                    <td>
                                        <div class="form-group">
                                            {!!Form::select('order_status', config('default.orderStatusArray'), $singleData->order_status ,array('class' => 'form-control select2', 'data-order-id' => $singleData->id, 'placeholder' => 'Order Status'))!!}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Delivery Status</th>
                                    <td>
                                        <div class="form-group">
                                            {!!Form::select('delivery_status', config('default.deliveryStatusArray'), $singleData->delivery_status ,array('class' => 'form-control select2', 'data-order-id' => $singleData->id, 'placeholder' => 'Delivery Status'))!!}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Billing Info</th>
                                    <td>
                                        <strong>Address: </strong>{{$singleData->billing_address}} <br>
                                        <strong>City: </strong>{{$singleData->billing_city}} <br>
                                        <strong>state: </strong>{{$singleData->billing_state}}  <br>
                                        <strong>Post Code: </strong>{{$singleData->billing_postal_code}} <br>
                                        @if($singleData->hasOrderbillingCountry) 
                                            <strong>Country Code: </strong>{{$singleData->hasOrderbillingCountry->iso}}<br>
                                            <strong>Country Name: </strong>{{$singleData->hasOrderbillingCountry->nicename}} <br>
                                         @endif
                                    </td>
                                </tr>
                                

                                <tr>
                                    <th>Delivery Info</th>
                                    @if($singleData->is_same_as_billing == 0)
                                    <td>
                                        <strong>Address: </strong>{{$singleData->delivery_address}} <br>
                                        <strong>City: </strong>{{$singleData->delivery_city}} <br>
                                        <strong>state: </strong>{{$singleData->delivery_state}}  <br>
                                        <strong>Post Code: </strong>{{$singleData->delivery_postal_code}} <br>
                                        @if($singleData->hasOrderdeliveryCountry)
                                            <strong>Country Code: </strong>{{$singleData->hasOrderdeliveryCountry->iso}} <br>
                                            <strong>Country Name: </strong>{{$singleData->hasOrderdeliveryCountry->nicename}} <br>
                                        @endif
                                    </td>
                                    @else
                                    <td>
                                        <u>Delivery address same as billing Address.</u>
                                    </td>
                                    @endif
                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th> </th> --}}
                                        <th colspan="2">Product</th>
                                        {{-- <th>Store</th> --}}
                                        {{-- <th>Sales Person</th> --}}
                                        {{-- <th>SKU/ UPC</th> --}}
                                        {{-- <th>Brand</th> --}}
                                        <th class="text-center">Qty.</th>
                                        {{-- <th class="text-right">NET Price</th> --}}
                                        <th class="text-right">Price</th>
                                        {{-- <th class="text-right">VAT</th> --}}
                                        {{-- <th class="text-right">Line NET</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach($orderItems as $item)
                                    <?php $count++; ?>
                                        <tr>
                                            <td>{{$count}}</td>
                                           {{--  <td>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-product-edit-{{$item->id}}"><i class="fa fa-edit"></i></button>
                                            </td> --}}
                                            {{-- <td style="padding-left: 0px;">
                                                <a  href="{{url('admin/ordered-product/'.$item->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
                                            </td> --}}

                                            {{-- @if (count($orderItems) > 1)
                                                <td style="padding-left: 0px;">
                                                    <a  href="{{url('admin/ordered-product/'.$item->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
                                                </td>
                                            @else
                                                <td style="padding-left: 0px;">
                                                    <a disabled href="{{url('admin/ordered-product/'.$item->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
                                                </td>
                                            @endif --}}
                                            
                                            @if($item->product)
	                                            <td style="width: 80px"><img height="40" src="{{asset('storage/products/images/'.$item->product->main_image)}}"> </td>
	                                            <td>{{$item->product->title}}</td>
	                                          {{--   <td>
	                                                {{ $item->product->sku }}
	                                                <br>
	                                                {{ $item->product->upc }}
	                                            </td> --}}
	                                            {{-- <td>{{ $item->product->brand->name }}</td> --}}
                                            @else
                                            <td>{{$item->product_name }}</td>
                                            <td>{{$item->product_name }}</td>
                        						{{-- <td> <span class="label label-danger">Deleted</span> </td> --}}
                        						{{-- <td> <span class="label label-danger">Deleted</span> </td> --}}
                        						{{-- <td> <span class="label label-danger">Deleted</span> </td> --}}
                        						{{-- <td> <span class="label label-danger">Deleted</span> </td> --}}
                                            @endif

                                            {{-- <td>
                                                @if($item->hasStore) {{ $item->hasStore->banner }} - {{ $item->hasStore->store_id }} @else --- @endif
                                                {{ $item->hasStoreManager }}
                                            </td> --}}

                                            {{-- <td>
                                                @php
                                                    print_r($item->haveSalesPersons)
                                                @endphp

                                                @if ($item->haveSalesPersons->isNotEmpty())
                                                    @foreach ($item->haveSalesPersons as $haveSalesPerson)
                                                        <span class="label label-info"> {{ $haveSalesPerson->salesPerson->title }}</span>
                                                    @endforeach
                                                @else
                                                    --
                                                @endif
                                            </td> --}}
                                            
                                            <td class="text-center">{{$item->quantity}}</td>
                                            {{-- <td class="text-right">{{$option->currency_symbol}}{{number_format($item->price, 2)}}</td> --}}
                                            {{-- <td class="text-right">{{$option->currency_symbol}}{{number_format($item->vat, 2)}}</td> --}}
                                            {{-- <td class="text-right">{{$option->currency_symbol}}{{number_format($item->quantity * $item->price, 2)}}</td> --}}
                                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->price, 2)}}</td>
                                            <div class="modal fade" id="modal-product-edit-{{$item->id}}">
                                              <div class="modal-dialog">
                                                {!! Form::model($item, ['files' => true, 'url' => 'admin/ordered-product/'.$item->id.'/edit', 'autocomplete'=>'off']) !!}
                                                {{-- {!! Form::open(['files' => true, 'url' => 'admin/'.$singleData->id.'/volunteer/add', 'autocomplete'=>'off']) !!} --}}
                                                {{-- {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!} --}}
                                                {!!csrf_field()!!}
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Edit Ordered Items -Order #{{ $singleData->order_no }}</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                                            {!!Form::label("quantity")!!}
                                                            {!!Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter quantity', 'min' => '0', 'max' => $item->product ? $item->product->quantity : 1000 ])!!}
                                                            <em class="error-msg">{!!$errors->first('quantity')!!}</em>
                                                        </div>
                                                        <div class="col-sm-6 form-group {{ $errors->has('order_no') ? 'has-error' : '' }}">
                                                            {!!Form::label("price *")!!}
                                                            {!!Form::number('price', null, ['class' => 'form-control', 'placeholder' => 'Enter price', 'readonly', 'min' => '0'])!!}
                                                            <em class="error-msg">{!!$errors->first('price')!!}</em>
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            {!!Form::hidden('oid', $singleData->id, ['class' => 'form-control'])!!}
                                                        </div>
                                                       {{--  <div class="col-sm-6 form-group">
                                                            {!!Form::hidden('old_quantity', $item->quantity, ['class' => 'form-control'])!!}
                                                        </div> --}}
                                                    </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                   {{--  @if($singleData->id)
                                                        <div class="pull-left form-group">
                                                            <label class="switch">
                                                                <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    @endif --}}
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                                                    </button>
                                                    {{-- <a class="btn btn-default" href="{{url('admin/'.$module.'s')}}"><i class="fa fa-times-circle-o"></i> Cancel </a> --}}
                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                  </div>
                                                </div>
                                                {!!Form::close()!!}
                                              </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="1">Sub total</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->sub_total,2)}}</th>
                                    </tr>

                                   {{--  <tr>
                                        <th colspan="6"></th>
                                        <th colspan="3">You Saved <br>
                                            @if ($singleData->total_discount == 0)
                                                <strike><span class="label label-danger ">No Discount!</span></strike>
                                            @else
                                                @if ($singleData->discount_type == 1)
                                                    <span class="label label-warning">Coupon Discount</span><br>
                                                @elseif($singleData->discount_type == 2)
                                                    <span class="label label-primary">Order Value Discount 50 - 100</span><br>
                                                @elseif($singleData->discount_type == 3)
                                                    <span class="label label-info">Order Value Discount over 100</span><br>
                                                @elseif($singleData->discount_type == 4)
                                                    <span class="label label-default">Normal Discount</span><br>
                                                @endif
                                            @endif
                                        </th>
                                        <th class="text-right">
                                            {{$option->currency_symbol}}{{ number_format($singleData->total_discount, 2)}}
                                        </th>
                                    </tr> --}}

                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="1">Shipping</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->shipping_amount,2)}}</th>
                                    </tr>
                                    
                                    {{-- <tr>
                                        <th colspan="6"></th>
                                        <th colspan="3">VAT</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->vat,2)}}</th>
                                    </tr> --}}

                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="1">Grand Total</th>
                                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->grand_total, 2)}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-12 no-padding">
                        <p class="pull-left">Created at {{$singleData->created_at}} & Updated at {{$singleData->updated_at}}</p>
                    </div>
                 
                    {{-- <a title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$singleData->id.'/delivered')}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-check-square"></i> Update</a>
                    <a title="Mark as Delivered" href="{{url('admin/'.$module.'/'.$singleData->id.'/delivered')}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-check-square"></i> Repeat </a> --}}
                  {{-- <a href="invoice-print.html" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a> --}}
                    
                  
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $('select').on('change', function() {
          var orderId = $(this).attr("data-order-id");
          var attributeName = $(this).attr('name')
          var statusId = $(this).val();
          var APP_URL = {!! json_encode(url('/')) !!};
          // var statusType = $(this).attr("data-status-type");
          // alert( this.value );
          console.log(attributeName);
          // alert(statusId);

          $.ajax({
                  type:'POST',
                  url: "{{ route('order.update_status') }}",
                  headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                  data: {
                      "attribute_name" : attributeName,
                      "status" :  statusId,
                      // "status_type" :  statusType,
                      "order_id" : orderId,
                  },
                  success: function(data){
                    if(data.message){
                      // console.log(data);
                    }
                  }
              });

        });
    </script>
@endsection