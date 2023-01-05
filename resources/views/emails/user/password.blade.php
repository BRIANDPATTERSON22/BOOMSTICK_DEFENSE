<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$option->name}} - Reset Password</title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="padding: 0 5%">
    <div style="overflow: hidden; padding: 5% 10%; background: #f44336; color: #fff; font-size: 18px;">
        Reset Password - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; border: 1px solid #FAFAFA; font-size: 12px;">
        Hi {{$name}}, <br/><br/>

        <p>You can now reset your password using following link</p>
        <br/>
        <a style="padding: 10px 15px; background: #f44336; color:#fff; border-radius: 3px; text-decoration: none" href="{{url('forgot-password/'.$link)}}" target="_blank">RESET PASSWORD</a>
        <br/>
        <br/>
        <p>
            Thank you for your trust in our solutions, <br/>
            The {{$option->name}} Team
        </p>
    </div>
</body>
</html>