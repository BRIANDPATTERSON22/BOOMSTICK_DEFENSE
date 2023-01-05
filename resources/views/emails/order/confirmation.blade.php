<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} | Order Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #000000; color: #fff; font-size: 18px;">
        Order Confirmation - {{$option->name}}
        <span style="float: right;">Your Order No #{{ $order->order_no }}</span>
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #f9f9f9; border: 1px solid #FAFAFA; font-size: 12px; border-bottom: 5px solid #000000;">
        Dear <strong>{{$order->customer->first_name}},</strong><br/><br/>
        Thank you for placing an order with us at {{ $option->name }}. <br>if you have any questions please email us at {{ $option->email }}.<br/><br/>

        <strong><u>Order Information</u></strong><br/><br/>
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 100%">
                <thead style="background: #eee">
                <tr>
                    <th>Product</th>
                    {{-- <th>Store</th> --}}
                    {{-- <th>SKU/ UPC</th> --}}
                    {{-- <th>Brand</th> --}}
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Price({{ $option->currency_symbol }})</th>
                    {{-- <th style="text-align: right;">VAT({{ $option->currency_symbol }})</th> --}}
                    {{-- <th style="text-align: right;">Line NET ({{ $option->currency_symbol }})</th> --}}
                </tr>
                </thead>
                <tbody>
                <?php $count = 0;?>
                @foreach ($orderItems as $row)
                    <?php $count++;?>
                    <tr>
                        <td>{{$row->product_name}}</td>
                        {{-- <td> @if($row->hasStore) {{ $row->hasStore->banner }} - {{ $row->hasStore->store_id }} @else --- @endif </td> --}}
                       {{--  <td>
                            @if($row->product->sku)
                                {{$row->product->sku}}
                            @endif
                            @if($row->product->upc)
                                {{$row->product->upc}}
                            @endif
                        </td> --}}
                        {{-- <td>
                            @if($row->product->brand_id)
                                {{$row->product->brand->name}}
                           @endif
                        </td> --}}
                        <td style="text-align: right;">{{ $row->quantity }}</td>
                        <td style="text-align: right;">{{number_format($row->price, 2)}}</td>
                        {{-- <td style="text-align: right;">{{number_format($row->vat, 2)}}</td> --}}
                        {{-- <td style="text-align: right;">{{number_format($row->price * $row->quantity, 2)}}</td> --}}
                    </tr>
                @endforeach
                </tbody>
                <tfoot style="background: #eee">
                    <tr>
                        <td colspan="2" style="text-align: right;">Sub Total</td>
                        <td style="text-align: right;">{{number_format($order->sub_total,2)}}</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="6" style="text-align: right;">You saved</td>
                        <td style="text-align: right;">{{number_format($order->total_discount,2)}}</td>
                    </tr> --}}
                    <tr>
                        <td colspan="2" style="text-align: right;">Shipping</td>
                        <td style="text-align: right;">{{number_format($order->shipping_amount, 2)}}</td>
                    </tr>
                   {{--  <tr>
                        <td colspan="6" style="text-align: right;">VAT</td>
                        <td style="text-align: right;">{{number_format($order->vat,2)}}</td>
                    </tr> --}}
                    <tr>
                        <th colspan="2" style="text-align: right;">Grand Total</th>
                        <th style="text-align: right;">{{number_format($order->grand_total, 2)}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <br/>
        <p>
            Thanks for choosing us.<br/>
            {{$option->name}}
        </p>
    </div>
</body>
</html>