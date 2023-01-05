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
    <div style="overflow: hidden; padding: 5% 10%; background: #000000; color: #fff; font-size: 18px;">
       Welcome to {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #eaeaea; font-size: 14px;">
        Hello {{$name}}, <br/><br/>
        <p>
            Thank you for registering with {{$option->name}}
            Please click on the button below to verify your email address.
        </p>
        <br/>
        <a style="padding: 10px 15px; background: #000000; color:#fff; border-radius: 3px; text-decoration: none" href="{{url('email-verification/'.$url)}}" target="_blank">VERIFY YOUR EMAIL</a>
        <br/><br/>
        <p>
            Best Wishes <br/>
            {{$option->name}}
        </p>
    </div>
</body>
</html>