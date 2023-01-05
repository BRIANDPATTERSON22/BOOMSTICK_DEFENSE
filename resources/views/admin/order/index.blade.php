@extends('admin.layouts.app')

@section('htmlheader_title')
    Orders
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) Created in the Year {{$year}} @endif</span>
@endsection

@section('contentheader_description')
    Manage orders of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
            <li class="text-capitalize active">Deleted {{$module}}(s)</li>
        @else
            <li class="text-capitalize active">{{$module}}(s)</li>
        @endif
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Order#</th>
                                <th>Customer</th>
                                <th>Sub Total</th>
                                <th>Shipping</th>
                                <th>Grand Total</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Delivery Status</th>
                                @if(Request::is('*trash'))<th>Deleted</th>@else<th>Created</th>@endif
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 0; ?>
                            @foreach ($allData as $row)
                                <?php $count++; ?>
                                <tr>
                                    <td>{{$count}}</td>
                                    @if(Request::is('*trash'))
                                        <td>{{ 'BSORD'.$row->order_no }}</td>
                                    @else
                                        <td>
                                            <a href="{{ url('admin/'.$module.'/'.$row->id.'/view')}}" class="clearfix">{{ 'BSORD'.$row->order_no }}</a>
                                        </td>
                                    @endif

                                    <td>
                                        @if($row->customer)
                                            <strong class="clearfix"><a href="{{ url('admin/customer/'.$row->customer_id.'/view') }}" target="__blank">{!!$row->customer->first_name!!} {!!$row->customer->last_name!!}</a></strong>
                                            <small style="white-space: nowrap;">{{$row->customer->mobile}}</small>
                                        @endif
                                    </td>

                                    <td>
                                        {{$option->currency_symbol}}{!!number_format($row->sub_total,2)!!}
                                    </td>

                                    <td>
                                        {{$option->currency_symbol}}{{number_format($row->shipping_amount,2)}}
                                        <u> 
                                            <small class="clearfix">{{ str_limit($row->shippingMethod ? $row->shippingMethod->title : '--', 50 )  }} / {{ $row->shipping_service_name }}</small>
                                        </u>
                                    </td>

                                    <td><strong>{{ $option->currency_symbol.$row->grand_total }}</strong></td>

                                    <td>
                                        {!!$row->getPaymentStatus() !!}
                                        <u> 
                                            <small class="clearfix">{{ str_limit($row->paymentMethod ? $row->paymentMethod->title : '--', 50 )  }} </small>
                                        </u>
                                    </td>

                                    <td>
                                        {!!$row->getOrderStatus() !!}
                                        {{-- <div class="form-group">
                                            {!!Form::select('order_status', config('default.orderStatusArray'), $row->order_status ,array('class' => 'form-control select2', 'data-order-id' => $row->id, 'placeholder' => 'Order Status',))!!}
                                        </div> --}}
                                     </td>

                                    <td>
                                        {!!$row->getDeliveryStatus() !!}
                                        {{-- <div class="form-group">
                                            {!!Form::select('delivery_status', config('default.deliveryStatusArray'), $row->delivery_status ,array('class' => 'form-control select2', 'data-order-id' => $row->id, 'placeholder' => 'Delivery Status',))!!}
                                        </div> --}}
                                    </td>

                                    {{-- @php
                                      dd(config('default.orderStatusArray'));
                                    @endphp --}}

                                    @if(Request::is('*trash'))
                                        <td class="text-nowrap"><small>{!!$row->deleted_at->format('d M, Y')!!}</small></td>
                                    @else
                                        <td class="text-nowrap"><small>{!!$row->created_at->format('d M, Y')!!}</small></td>
                                    @endif

                                    <td class="text-nowrap">
                                        @if(Request::is('*trash'))
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/restore')}}" class="btn btn-sm btn-success"> RESTORE </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/force-delete')}}" onclick="if(!confirm('Are you sure to delete this data permanently?')){return false;}" class="btn btn-sm btn-danger"> DELETE </a>
                                        @else
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/view')}}" class="btn btn-sm btn-success"> <i class="fa fa-search-plus"></i> </a>
                                            <a href="{{url('admin/'.$module.'/'.$row->id.'/soft-delete')}}" class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   {{--  @if ($allData)
                        {{ $allData->links() }}
                    @endif --}}
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