<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} | Order Received</title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #f44336; color: #fff; font-size: 18px;">
        Order Received - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; border: 1px solid #FAFAFA; font-size: 12px;">
        Dear Admin, <br/><br/>
        You've received an enquiry from {{$option->name}}. The details are as follows,<br/><br/>

        <strong><u>Order Information</u></strong><br/><br/>
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 100%">
                <thead style="background: #eee">
                <tr>
                    <th>Product</th>
                    <th>Color</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right;">Total ($)</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 0;?>
                @foreach ($orderItems as $row)
                    <?php $count++;?>
                    <tr>
                        <td>{{$row->product->name}} (x) <strong> {{$row->quantity}} </strong></td>
                        @if($row->color_id)
                            <td style="text-align: left;">{{$row->color->name}}</td>
                        @else
                            <td style="text-align: left;">No Product Color</td>
                        @endif
                        <td style="text-align: right;">{{number_format($row->price, 2)}}</td>
                        <td style="text-align: right;">{{number_format($row->price * $row->quantity, 2)}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot style="background: #eee">
                <tr>
                    <td colspan="3" style="text-align: right;">Sub Total</td>
                    <td style="text-align: right;">{{number_format($order->amount)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Shipping</td>
                    <td style="text-align: right;">+ {{number_format($order->shipping, 2)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Tax</td>
                    <td style="text-align: right;">+ {{Cart::instance('cart')->tax()}}</td>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: right;">Grand Total</th>
                    <th style="text-align: right;">{{number_format($order->amount + $order->shipping + $order->tax, 2 )}}</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <br/>
        <p>
            Thank you for your trust in our solutions, <br/>
            The {{$option->name}} Team
        </p>
    </div>
    </body>
</html>