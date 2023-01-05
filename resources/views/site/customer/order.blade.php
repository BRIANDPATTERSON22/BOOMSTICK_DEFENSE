@extends('site.layouts.default')

@section('htmlheader_title')
  My Orders
@endsection

@section('page-style')
  <style>
    .modal-content {background-color: #292929;}
  </style>
@endsection

@section('main-content')
  <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>My Orders</h2>
                          <ul>
                              <li><a href="{{ url('/') }}">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a>My Orders</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <section class="shopping_cart_page">
      <div class="container">
          <div class="row">

              @include('site.customer.sidebar')

              <div class="main-col col-md-8 col-sm-8 col-xs-8">
                  <ul class="blog-article-list-1">
                      <li>
                          <article class="entry-item no-thumb">
                              <div class="entry-content">
                                  <h4 class="entry-title">My Orders</h4>
                                  <div class="widget">
                                    @if(count($orders) > 0)
                                        <div class="table-responsive ordered_table">
                                            <table class="table">
                                                <thead>
                                                  <tr>
                                                      <th>#</th>
                                                      <th>Order#</th>
                                                      <th>Ordered At</th>
                                                      <th>Order Status</th>
                                                      <th>Payment Status</th>
                                                      <th>Total</th>
                                                      <th>Details</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count_id = 0; ?>
                                                    @foreach($orders as $row)
                                                     <?php $count_id++; ?>
                                                        <tr>
                                                            <td>{{ $count_id }}</td>
                                                            <td> <strong> #{{$row->order_no}} </strong></td>
                                                            <td class="text-nowrap"> {{ Carbon\Carbon::parse(date($row->created_at), 'UTC')->setTimezone('Asia/Colombo')->format('Y-m-d h:i:s A') }} </td>
                                                             <td class="text-left_">
                                                                 @if($row->status == 1)
                                                                     <span class="badge badge-info">Approval pending</span>
                                                                 @elseif($row->status == 2)
                                                                     <span class="badge badge-warning">Order Approved</span>
                                                                 @elseif($row->status == 3)
                                                                     <strike><span class="badge badge-danger">Order Rejected</span></strike> 
                                                                 @elseif($row->status == 4)
                                                                     <span class="badge badge-primary">Dispatched</span>
                                                                 @elseif($row->status == 5)
                                                                     <span class="badge badge-success">Delivered</span>
                                                                 @endif
                                                             </td>
                                                            <td class="text-left_">
                                                                @if ($row->pay_status == 'PAID')
                                                                    <span class="badge badge-success">PAID</span>
                                                                @elseif($row->pay_status == 'UNPAID')
                                                                    <span class="badge badge-warning">UNPAID</span>
                                                                @elseif($row->pay_status == 'INCOMPLETED')
                                                                    <span class="badge badge-dark">INCOMPLETED</span>
                                                                @elseif($row->pay_status == 'FAILED')
                                                                    <strike> <span class="badge badge-danger">FAILED</span> </strike>
                                                                @else
                                                                    <span class="badge badge-danger">ERROR</span>
                                                                @endif
                                                                {{-- <div class="clearfix small"><u>{{ str_limit($row->paymentMethod->title, 50 ) }}</u></div> --}}
                                                            </td>
                                                            <td>{{ $option->currency_symbol }}{{number_format($row->grand_total, 2)}}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-success btn-sm btn-pill border_radious_20" data-toggle="modal" data-target="#order_{{ $row->id }}">View</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="inno_shadow_ p_30">
                                          <div class="section_title_footer title_footer text-center">
                                            <h2>You have no orders</h2>
                                          </div>
                                          <div class="priceing_list text-center">
                                              <a href="{{ url('products') }}">Start Shopping Now! </a>
                                            </div>
                                        </div>  
                                    @endif

                                    <nav class="pagination" style="margin-top: 15px">
                                        <div class="column">
                                            {{$orders->links()}}
                                        </div>
                                    </nav>
                                  </div>
                              </div>
                          </article>
                      </li>
                  </ul>
              </div>

          </div>
      </div>
  </section>

    @yield('profile_model')
    @foreach($orders as $row)
      <div class="modal" id="order_{{ $row->id }}">
          <div class="modal-dialog modal-md">
              <div class="modal-content b_t_5">
                  <div class="modal-header">
                      <h4 class="modal-title"><span class="font-weight-light ">ORDER# </span>{{ $row->order_no }}</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      {{-- Billing Address --}}
                      <div class="table-responsive table-sm">
                          <table class="table table-condensed">
                              <thead class="thead-dark">
                              <tr>
                                  <th colspan="2">Billing Info</th>
                              </tr>
                              </thead>
                            <tbody>
                              <tr>
                                <td class="text-left">Address</td>
                                <td class="text-left">{{$row->delivery_address ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Billing country</td>
                                <td class="text-left">{{ $row->hasOrderbillingCountry ? $row->hasOrderbillingCountry->nicename : '---'  }}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Billing city</td>
                                <td class="text-left">{{ $row->delivery_city ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Billing state</td>
                                <td class="text-left">{{ $row->delivery_state ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Billing postal code</td>
                                <td class="text-left">{{ $row->delivery_postal_code ?? "---"}}</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>

                      {{-- Delivery Address --}}
                      <div class="table-responsive table-sm">
                          <table class="table table-condensed">
                              <thead class="thead-dark">
                              <tr>
                                  <th colspan="2">Delivery Info</th>
                              </tr>
                              </thead>
                            <tbody>
                              <tr>
                                <td class="text-left">Address</td>
                                <td class="text-left">{{$row->delivery_address ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Delivery country</td>
                                <td class="text-left">{{ $row->hasOrderdeliveryCountry ? $row->hasOrderdeliveryCountry->nicename : '---'  }}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Delivery city</td>
                                <td class="text-left">{{ $row->delivery_city ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Delivery state</td>
                                <td class="text-left">{{ $row->delivery_state ?? "---"}}</td>
                              </tr>
                              <tr>
                                <td class="text-left">Delivery postal code</td>
                                <td class="text-left">{{ $row->delivery_postal_code ?? "---"}}</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>


                      {{-- Payemnt and shipping --}}
                      <div class="table-responsive table-sm">
                          <table class="table table-condensed">
                              <thead class="thead-dark">
                                  <tr>
                                      <th colspan="2">Payment and Shipping Info</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="text-left">Payment Method</td>
                                      <td class="text-left">{{$row->paymentMethod ? $row->paymentMethod->title : '---'}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left">Shpping Method</td>
                                      <td class="text-left">{{$row->shippingMethod ? $row->shippingMethod->title : '---'}}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>


                      {{-- ordes --}}
                      <div class="table-responsive">
                          <table class="table table-striped table-sm">
                             <thead class="thead-dark">
                              <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php $count = 0; ?>
                              @foreach ($row->orderItems as $item)
                                   <?php $count++; ?>
                                  <tr>
                                      <td>{{ $count }}</td>
                                      <td class="text-left text-nowrap">
                                          {{$item->product_name}}
                                      </td>
                                      <td class="text-right text-nowrap">
                                          {{$item->quantity}} x {{ $option->currency_symbol }}{{$item->price}}
                                      </td>
                                      <td class="text-right">
                                          {{ $option->currency_symbol }}{{number_format($item->quantity * $item->price, 2 )}}
                                      </td>
                                  </tr>
                              @endforeach
                                  <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Sub Total</td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->sub_total, 2)}}</td>
                                  </tr>
                                  <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Shipping </td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->shipping_amount, 2)}}</td>
                                  </tr>
                                  {{-- <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Service Charge </td>
                                      <td class="text-right font-weight-bold">{{ $option->currency_symbol }}{{number_format($row->dp_transaction_amount, 2)}}</td>
                                  </tr> --}}
                                  <tr class="table-active">
                                      <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                                      <td class="text-right font-weight-bold"><strong>{{ $option->currency_symbol }}{{number_format($row->grand_total, 2)}}</strong></td>
                                  </tr>
                            </tbody>
                          </table>
                      </div>
                  </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger btn_pill_2" data-dismiss="modal">Close</button>
                      </div>
                  </div>
          </div>
      </div>
    @endforeach
@endsection