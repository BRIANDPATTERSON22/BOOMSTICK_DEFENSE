<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} | Contact Enquiry Confirmation</title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #f44336; color: #fff; font-size: 18px;">
        Enquiry Confirmation - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; border: 1px solid #FAFAFA; font-size: 12px;">
        Dear {{$name}}, <br/><br/>
        <p>
            Thank you for contacting us. We'll process your enquiry and get back to you soon.
        </p>
        <br/>
        <br/>
        <p>
            Thank you for your trust in our solutions, <br/>
            The {{$option->name}} Team
        </p>
    </div>
    </body>
</html>