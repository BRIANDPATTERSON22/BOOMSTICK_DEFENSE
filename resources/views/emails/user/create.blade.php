<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} - Registration completed</title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #19191b; color: #fff; font-size: 18px;">
        Account Verification - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; font-size: 14px;">
        Hi {{$name}}, <br/><br/>
        <p>
            Congratulations, your {{$option->name}} account has been created successfully and we are pleased to welcome you to our community.
        </p>
        <br/>
        <a style="padding: 10px 15px; background: #19191b; color:#fff; border-radius: 3px; text-decoration: none" href="{{url('email-verification/'.$url)}}" target="_blank">VERIFY YOUR EMAIL</a>
        <br/><br/>
        <p>
            Thank you for your trust in our solutions, <br/>
            The {{$option->name}} Team
        </p>
    </div>
</body>
</html>