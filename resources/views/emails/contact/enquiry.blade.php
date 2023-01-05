<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} | Contact Enquiry</title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #f44336; color: #fff; font-size: 18px;">
        Contact Enquiry - {{config('default.contactReason')[$contactReason]}} - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; border: 1px solid #FAFAFA; font-size: 12px;">
        Dear Admin, <br/><br/>
        You've received an enquiry from {{$option->name}}. The details are as follows,<br/><br/>

        <strong><u>Enquiry Information</u></strong><br/><br/>
        <div style="font-size: 11px; color: #666666;">
            <div style="width: 70px; float: left;">Name</div><div style="width: auto; float: left;">: {{$name}}</div><br/>
            <div style="width: 70px; float: left;">Email</div><div style="width: auto; float: left;">: {{$email}}</div><br/>
             <div style="width: 70px; float: left;">Phone</div><div style="width: auto; float: left;">: {{$phone}}</div><br/>
            <div style="width: 70px; float: left;">Conatct Reason</div><div style="width: auto; float: left;">: {{config('default.contactReason')[$contactReason]}}</div><br/>
            <div style="width: 70px; float: left;">Order No</div><div style="width: auto; float: left;">: {{$orderNo}}</div><br/>
            <div style="width: 70px; float: left;">Message</div><div style="width: auto; float: left;">: {{$enquiry}}</div><br/>
        </div>
    </div>
    </body>
</html>