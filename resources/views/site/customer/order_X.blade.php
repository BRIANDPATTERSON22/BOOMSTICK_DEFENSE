@extends('site.layouts.default')

@section('htmlheader_title')
  My Orders
@endsection

@section('main-content')
  <div class="breadcrumbs_area">
      <div class="container">   
          <div class="row">
              <div class="col-12">
                  <div class="breadcrumb_content">
                      <ul>
                          <li><a href="{{url('/')}}">home</a></li>
                          <li class="breadcrumb-item active">My Orders</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>         
  </div>

  <section class="shopping_cart_page">
     <div class="container">
        <div class="row">
           @include('site.customer.sidebar')
           <div class="col-lg-8 col-md-8 col-sm-7">
              <div class="widget inno_shadow p_15">
                 <div class="section-header">
                    <h5 class="heading-design-h5">
                       Order List
                    </h5>
                 </div>
                 {{--<div class="order-list-tabel-main">--}}
                    {{--<table class="datatabel table table-striped table-bordered order-list-tabel table-responsive" width="100%" cellspacing="0">--}}
                       {{--<thead>--}}
                          {{--<tr>--}}
                             {{--<th>Order #</th>--}}
                             {{--<th>Date Purchased</th>--}}
                             {{--<th>Status</th>--}}
                             {{--<th>Total</th>--}}
                             {{--<th>Action</th>--}}
                          {{--</tr>--}}
                       {{--</thead>--}}
                       {{--<tbody>--}}
                          {{--<tr>--}}
                             {{--<td>#243</td>--}}
                             {{--<td>August 08, 2017</td>--}}
                             {{--<td><span class="badge badge-danger">Canceled</span></td>--}}
                             {{--<td>$760.50</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#258</td>--}}
                             {{--<td>July 21, 2017</td>--}}
                             {{--<td><span class="badge badge-info">In Progress</span></td>--}}
                             {{--<td>$315.20</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#254</td>--}}
                             {{--<td>June 15, 2017</td>--}}
                             {{--<td><span class="badge badge-warning">Delayed</span></td>--}}
                             {{--<td>$1,264.00</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#293</td>--}}
                             {{--<td>May 19, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$198.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#266</td>--}}
                             {{--<td>April 04, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$598.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#277</td>--}}
                             {{--<td>March 30, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$98.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#243</td>--}}
                             {{--<td>August 08, 2017</td>--}}
                             {{--<td><span class="badge badge-danger">Canceled</span></td>--}}
                             {{--<td>$760.50</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#258</td>--}}
                             {{--<td>July 21, 2017</td>--}}
                             {{--<td><span class="badge badge-info">In Progress</span></td>--}}
                             {{--<td>$315.20</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#254</td>--}}
                             {{--<td>June 15, 2017</td>--}}
                             {{--<td><span class="badge badge-warning">Delayed</span></td>--}}
                             {{--<td>$1,264.00</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#293</td>--}}
                             {{--<td>May 19, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$198.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#266</td>--}}
                             {{--<td>April 04, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$598.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                          {{--<tr>--}}
                             {{--<td>#277</td>--}}
                             {{--<td>March 30, 2017</td>--}}
                             {{--<td><span class="badge badge-success">Delivered</span></td>--}}
                             {{--<td>$98.35</td>--}}
                             {{--<td><a data-toggle="tooltip" data-placement="top" title="" href="order-list.html#" data-original-title="View Detail" class="btn btn-theme-round btn-sm"><i class="icofont icofont-eye-alt"></i></a></td>--}}
                          {{--</tr>--}}
                       {{--</tbody>--}}
                    {{--</table>--}}
                 {{--</div>--}}
                  <div class="">
                      <div class="padding-top-2x mt-2 hidden-lg-up"></div>
                      <div class="table-responsive">
                          <table class="table mb-0">
                              <tbody>
                              @foreach($orders as $row)
                                  <tr>
                                      <th colspan="3">Order# {{$row->order_no}} placed on
                                          {{$row->created_at->format('d M, Y - h:s a')}}
                                      </th>
                                      {{-- <th colspan="0"> Order Status <br>
                                          @if($row->status == 1)
                                              <span class="label label-primary">Processing</span>
                                          @elseif($row->status == 2)
                                              <span class="label label-danger">Pending</span>
                                          @elseif($row->status == 3)
                                              <span class="label label-success">Paid</span>
                                          @elseif($row->status == 4)
                                              <span class="label label-success">Delivered</span>
                                          @elseif($row->status == 5)
                                              <span class="label label-danger">Process Not Completed/ Failed</span>
                                          @elseif($row->status == 6)
                                              <strike><span class="label label-danger">Cancelled by user</span></strike> 
                                          @endif
                                          @if($row->status == 1)
                                              <span class="badge badge-default">Process Not Completed</span>
                                          @elseif($row->status == 2)
                                              <strike><span class="badge badge-danger">Cancelled by user</span></strike> 
                                          @elseif($row->status == 3)
                                              <span class="badge badge-warning">Pending</span>
                                          @elseif($row->status == 4)
                                              <span class="badge badge-primary">Processing</span>
                                          @elseif($row->status == 5)
                                              <span class="badge badge-info">Dispatched</span>
                                          @elseif($row->status == 6)
                                              <span class="badge badge-success">Delivered</span>
                                          @endif
                                      </th> --}}
                                      {{-- <th>
                                        Payment Status <br>
                                        @if ($row->pay_status == 'PAID')
                                            <span class="badge badge-success">PAID</span>
                                        @else
                                            <span class="badge badge-danger">UNPAID</span>
                                        @endif
                                      </th> --}}
                                  </tr>
                                  @php $orderItems = $row->orderItems; @endphp

                                  @foreach($orderItems as $item)
                                      <tr>
                                          {{-- <td></td> --}}
                                          {{-- <td>{{$item->product->name}}</td> --}}
                                          <td> @if($item->product) {{$item->product->title}} @else   <span class="badge badge-danger">Product removed from store</span> @endif </td>
                                          <td class="text-right">{{$item->quantity}} x {{ $option->currency_symbol }}{{$item->price}}</td>
                                          <td class="text-right">{{ $option->currency_symbol }}{{number_format($item->quantity * $item->price, 2 )}}</td>
                                      </tr>
                                  @endforeach
                                  <tr style="background: #eee">
                                      <td colspan="2" class="text-right"> 
                                        {{-- You saved ({{ $option->currency_symbol }}{{number_format($row->total_discount, 2)}}) , --}}
                                        Sub Total ({{ $option->currency_symbol }}{{number_format($row->amount, 2)}})
                                        + Shipping ({{ $option->currency_symbol }}{{number_format($row->shipping, 2)}})
                                        {{-- + VAT ({{ $option->currency_symbol }}{{number_format($row->vat, 2)}}) --}}
                                        
                                        {{-- @if($row->coupon_amount || $row->order_value_discount)
                                          @if($row->coupon_amount)
                                            ({{ $option->currency_symbol }}{{number_format($row->coupon_amount, 2)}})
                                          @endif
                                          @if($row->order_value_discount)
                                            ({{ $option->currency_symbol }}{{number_format($row->order_value_discount, 2)}})
                                          @endif
                                        @else
                                        {{ $option->currency_symbol }}0.00
                                        @endif --}}
                                      </td>
                                      {{-- @if($row->coupon_amount || $row->order_value_discount)
                                        @if($row->coupon_amount)
                                         <th class="text-right"><span>{{ $option->currency_symbol }}{{number_format($row->amount + $row->shipping + $row->vat - $row->coupon_amount, 2)}}</span></th>
                                        @endif
                                        @if($row->order_value_discount)
                                         <th class="text-right"><span>{{ $option->currency_symbol }}{{number_format($row->amount + $row->shipping + $row->vat - $row->order_value_discount, 2)}}</span></th>
                                        @endif
                                      @else
                                          <th class="text-right"><span>{{ $option->currency_symbol }}{{number_format($row->amount + $row->shipping + $row->vat, 2)}}</span></th>
                                      @endif --}}
                                     <th class="text-right"><span>{{ $option->currency_symbol }}{{number_format($row->grand_total, 2)}}</span></th>

                                  </tr>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                      <hr>
                      <!-- Pagination-->
                      <nav class="pagination" style="margin-top: 15px">
                          <div class="column">
                              {{$orders->links()}}
                          </div>
                      </nav>
                  </div>

              </div>
           </div>
        </div>
     </div>
  </section>



  {{--<div class="container padding-bottom-3x mb-2">--}}
    {{--<div class="row">--}}
      {{--<div class="col-lg-4">--}}
        {{--<aside class="user-info-wrapper">--}}
          {{--<div class="user-cover" style="background-image: url({{asset('site/img/user-bg.jpg')}});">--}}

          {{--</div>--}}
          {{--<div class="user-info">--}}
            {{--<div class="user-avatar"><a class="edit-avatar" href="#"></a>--}}
              {{--<img src="{{asset('site/img/default.png')}}" alt="User"></div>--}}
            {{--<div class="user-data">--}}
              {{--<h4 class="h5">{{$customer->first_name}} {{$customer->last_name}}</h4><span>Joined {{$customer->created_at->format('d M, Y')}}</span>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</aside>--}}
        {{--<nav class="list-group">--}}
          {{--<a class="list-group-item" href="{{url('my-account')}}"><i class="icon-user"></i>My Account</a>--}}
          {{--<a class="list-group-item with-badge active" href="{{url('my-orders')}}"><i class="icon-shopping-bag"></i>My Orders<span class="badge badge-default badge-pill">{{count($orders)}}</span></a>--}}
          {{--<a class="list-group-item" href="{{url('change-password')}}"><i class="icon-lock"></i>Change Password</a>--}}
        {{--</nav>--}}
      {{--</div>--}}
      {{--<div class="col-lg-8">--}}
        {{--<div class="padding-top-2x mt-2 hidden-lg-up"></div>--}}
        {{--<div class="table-responsive">--}}
          {{--<table class="table mb-0">--}}
            {{--<tbody>--}}
            {{--@foreach($orders as $row)--}}
              {{--<tr>--}}
                {{--<th colspan="2">Order# {{$row->order_no}} placed on--}}
                  {{--{{$row->created_at->format('d M, Y - h:s a')}}--}}
                {{--</th>--}}
                {{--<th colspan="2"> Status:--}}
                  {{--@if($row->status = 1)--}}
                    {{--<span class="text-warning">Processing</span>--}}
                  {{--@elseif($row->status = 2)--}}
                    {{--<span class="text-danger">Pending</span>--}}
                  {{--@elseif($row->status = 3)--}}
                    {{--<span class="text-success">Paid</span>--}}
                  {{--@elseif($row->status = 4)--}}
                    {{--<span class="text-success">Delivered</span>--}}
                  {{--@endif--}}
                {{--</th>--}}
              {{--</tr>--}}
              {{--@php $orderItems = $row->orderItems; @endphp--}}

              {{--@foreach($orderItems as $item)--}}
                {{--<tr>--}}
                  {{--<td></td>--}}
                  {{--<td>{{$item->product->name}}</td>--}}
                  {{--<td class="text-right">{{$item->quantity}} x {{$item->price}}</td>--}}
                  {{--<td class="text-right">{{number_format($item->quantity * $item->price, 2 )}}</td>--}}
                {{--</tr>--}}
              {{--@endforeach--}}
            {{--<tr style="background: #eee">--}}
              {{--<td colspan="3" class="text-right"> Shipping (${{number_format($row->shipping, 2)}}) + Tax (${{number_format($row->tax, 2)}})</td>--}}
              {{--<th class="text-right"><span>${{number_format($row->amount + $row->shipping + $row->tax, 2)}}</span></th>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
          {{--</table>--}}
        {{--</div>--}}
        {{--<hr>--}}
        {{--<!-- Pagination-->--}}
        {{--<nav class="pagination" style="margin-top: 15px">--}}
          {{--<div class="column">--}}
            {{--{{$orders->links()}}--}}
          {{--</div>--}}
        {{--</nav>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
@endsection