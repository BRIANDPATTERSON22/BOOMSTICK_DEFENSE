<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <title>{{$option->name}} | Invoice #{{$singleData->order_no}}</title> --}}
    <title>{{$option->name}} | Invoice #{{ str_replace("ORDGP0","INVGP0", $singleData->order_no) }}</title>

    <style>
        /*body {color: #100E0C; font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif; font-size: 12px;}*/
       /* a {color: #333; text-decoration: none;}
        @page { margin: 60px; }
        address {font-style:normal;}
        h3, h4 {padding: 5px 0; margin: 0;}
        table {border:0;}
        table th {padding: 3px;}
        table td {padding: 3px;}
        table tr:nth-child(even) {background: #F9F9F9;}
        .total-warp td, .total-warp th {padding: 0;}
        .table-total tr {background: none;}
        .table-total td, .table-total th {padding: 3px;}
        .text-left {text-align: left;}
        .text-right {text-align: right;}
        .text-center {text-align: center;}
        .invoice {}
        .box {border-spacing:0;}
        .label {background-color: #eee; padding: 1px 6px; border-radius: 5px; border: 1px solid #bbb; font-size: 10px;}
        .page-number:before  {content: counter(page);}
        .page-break {page-break-after: always;}
        .nowrap{white-space: nowrap;}*/
        .b-0{border: 0px !important}
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 3px !important;

          }

    </style>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="{{ asset('admin/css/innovay-admin.css') }}" rel="stylesheet" type="text/css" />
</head>

<body onload="window.print();">

    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">

{{--         <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
               <img width="300px;" src="{{asset('storage/options/'.$option->logo)}}" alt="Logo" class="img-thumbnail b-0"/>
              <i class="fa fa-globe"></i> {{ $option->name }}
              <small class="pull-right">Date: {{ date("d/m/Y") }}</small>
            </h2>
          </div>
        </div> --}}

          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong>{{ $option->name }}</strong><br>
                {!! $option->address !!}
                Phone: {{ $option->phone }}<br>
                Email: {{ $option->email }}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <img width="300px;" src="{{asset('storage/options/'.$option->logo)}}" alt="Logo" class="img-thumbnail b-0"/>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col" style="text-align: right;">
              <div style="font-size: 40px; background-color: white; font-weight: bold;border-bottom:5px solid black; padding-bottom: 5px;">INVOICE</div>
{{--               <div style="margin:10px 0px;">
                <b>Invoice No:</b> {{substr(md5(microtime()),rand(0,26),10)}}<br>
                <b>Order No:</b> {{$singleData->order_no}}<br>
                <b>Date:</b> {{date("d/m/Y")}}
              </div> --}}
              
              <div style="margin:10px 0px;">
                <table style="width:100%" class="table">
                  <thead>
                        <tr>
                          <th>Invoice No :</th>
                          {{-- <th style="text-align: right;">{{substr(md5(microtime()),rand(0,26),10)}}</th>  --}}
                          {{-- <th style="text-align: right;">{{substr(md5(microtime()),rand(0,26),10)}}</th>  --}}
                          <th style="text-align: right;">{{ str_replace("ORDGP0","INVGP0", $singleData->order_no) }}</th> 
                        </tr>
                        <tr>
                          <th>Order No :</th>
                          <th style="text-align: right;">{{$singleData->order_no}}</th> 
                        </tr>
                        <tr>
                          <th>Date :</th>
                          <th style="text-align: right;">{{date("d/m/Y")}}</th> 
                        </tr>
                  </thead>
                </table>
              </div>

              
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->



          <hr>

        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <strong style="text-transform: uppercase;" >Bill To :</strong>
            {{-- <hr> --}}
            <address>
              <strong>Name: </strong>{{$singleData->customer->first_name}} {{$singleData->customer->last_name}} <br>
              <strong>Address: </strong>{{$singleData->customer->address1}} <br>
              <strong>City: </strong>{{$singleData->customer->city}} <br>
              <strong>County: </strong>{{$singleData->customer->state}}  <br>
              <strong>Post Code: </strong>{{$singleData->customer->postal_code}} <br>
              @if($singleData->customer->billing_country_id) 
              {{-- <strong>Country Code: </strong>{{$singleData->customer->billingCountry->iso}}<br> --}}
               <strong>Country Name: </strong>{{$singleData->customer->billingCountry->nicename}} <br>
               @endif
            </address>
          </div>

          <div class="col-sm-4 invoice-col">
            <strong style="text-transform: uppercase;" >Ship To :</strong>
            {{-- <hr> --}}
            <address>
              @if($singleData->customer->is_same_as_billing == 0)
              <td>
                  <strong>Name: </strong>{{$singleData->customer->first_name}} {{$singleData->customer->last_name}} <br>
                  <strong>Address: </strong>{{$singleData->customer->address2}} <br>
                  <strong>City: </strong>{{$singleData->customer->delivery_city}} <br>
                  <strong>County: </strong>{{$singleData->customer->delivery_state}}  <br>
                  <strong>Post Code: </strong>{{$singleData->customer->delivery_postel_code}} <br>
                  @if($singleData->customer->delivery_country_id)
                      {{-- <strong>Country Code: </strong>{{$singleData->customer->deliveryCountry->iso}} <br> --}}
                      <strong>Country Name: </strong>{{$singleData->customer->deliveryCountry->nicename}} <br>
                  @endif
              </td>
              @else
              <td>
                  <strong>Name: </strong>{{$singleData->customer->first_name}} {{$singleData->customer->last_name}} <br>
                  {{-- <u>Delivery address same as billing Address.</u> --}}
                  <strong>Address: </strong>{{$singleData->customer->address1}} <br>
                  <strong>City: </strong>{{$singleData->customer->city}} <br>
                  <strong>County: </strong>{{$singleData->customer->state}}  <br>
                  <strong>Post Code: </strong>{{$singleData->customer->postal_code}} <br>
                  @if($singleData->customer->billing_country_id) 
                  {{-- <strong>Country Code: </strong>{{$singleData->customer->billingCountry->iso}}<br> --}}
                   <strong>Country Name: </strong>{{$singleData->customer->billingCountry->nicename}} <br>
                   @endif
              </td>
              @endif
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <strong style="text-transform: uppercase;">Payment Method</strong> <br>
            {{ $singleData->paymentMethod->title }} <br>
            <strong style="text-transform: uppercase;"> Delivery Method</strong> <br>
            {{ $singleData->shippingMethod->title }}

            {{-- <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Payment Method</th>
                  <th>{{ $singleData->paymentMethod->title }}</th>
                </tr>
                <tr>
                  <th>Delivery Method</th>
                  <th>{{ $singleData->shippingMethod->title }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td> {{ $singleData->paymentMethod->title }}</td>
                  <td>{{ $singleData->shippingMethod->title }}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div> --}}
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
       {{--  <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Payment Method</th>
                <th>Delivery Method</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td> {{ $singleData->paymentMethod->title }}</td>
                <td>{{ $singleData->shippingMethod->title }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div> --}}
        <!-- /.row -->



        <div class="row">
{{--           <div class="col-xs-6">
            <p class="lead">Payment Method</p>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              {{ $singleData->paymentMethod->title }}
            </p>
          </div>
          <div class="col-xs-6">
            <p class="lead">Delivery Method</p>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              {{ $singleData->shippingMethod->title }}
            </p>
          </div> --}}


          <!-- /.col -->
          {{-- <div class="col-xs-6">
            <p class="lead">Amount Due 2/22/2014</p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>$250.30</td>
                </tr>
                <tr>
                  <th>Tax (9.3%)</th>
                  <td>$10.34</td>
                </tr>
                <tr>
                  <th>Shipping:</th>
                  <td>$5.80</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td>$265.24</td>
                </tr>
              </table>
            </div>
          </div> --}}

        </div>
        <!-- /.row -->

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU/ UPC</th>
                        <th>Brand</th>
                        <th class="text-center">Qty.</th>
                        <th class="text-right">NET Price</th>
                        <th class="text-right">VAT</th>
                        <th class="text-right">Line NET</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; ?>
                    @foreach($orderItems as $item)
                     <?php $count++; ?>
                        <tr>
                            <td>
                              {{ $count }}
                            </td>
                            <td>{{$item->product->name}}</td>
                            <td>
                              @if($item->product->sku)
                                {{ $item->product->sku }}
                              @endif

                               @if($item->product->upc)
                                {{ $item->product->upc }}
                                @endif
                            </td>
                            <td>{{ $item->product->brand->name }}</td>
                            <td class="text-center">{{$item->quantity}}</td>
                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->price, 2)}}</td>
                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->vat, 2)}}</td>
                            <td class="text-right">{{$option->currency_symbol}}{{number_format($item->quantity * $item->price, 2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="3">Sub total</th>
                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->amount,2)}}</th>
                    </tr>

                    <th colspan="4"></th>
                    <th colspan="3">You saved <br></th>
                    <th class="text-right">
                        {{$option->currency_symbol}}{{ number_format($singleData->total_discount, 2)}}
                    </th>

                    <tr>
                        <th colspan="4"></th>
                        <th colspan="3">Shipping</th>
                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->shipping,2)}}</th>
                    </tr>

                    <tr>
                        <th colspan="4"></th>
                        <th colspan="3">VAT</th>
                        <th class="text-right">{{$option->currency_symbol}}{{number_format($singleData->vat,2)}}</th>
                    </tr>

                    <tr >
                        <th colspan="4"></th>
                        <th colspan="3" style="border-bottom-style: double; border-bottom-color: #c5c5c5">Grand Total</th>
                        <th class="text-right" style="border-bottom-style: double; border-bottom-color: #c5c5c5">{{$option->currency_symbol}}{{number_format($singleData->grand_total, 2)}}</th>
                    </tr>
                </table>
            </div>
        </div>
        


      

        
      </section>
      <!-- /.content -->
    </div>
    <!-- ./wrapper -->
{{-- <section class="invoice">



</section> --}}
</body>
</html>