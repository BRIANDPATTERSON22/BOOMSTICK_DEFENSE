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
    <div style="overflow: hidden; padding: 5% 10%; background: #f44336; color: #fff; font-size: 18px;">
        Registration completed  - {{$option->name}}
    </div>
    <div style="overflow: hidden; padding: 5% 10%; background: #FAFAFA; border: 1px solid #FAFAFA; font-size: 12px;">
        Hi {{$name}}, <br/><br/>

        <p>Congratulations, your {{$option->name}} account has been created successfully and we are pleased to welcome you to our community.
            We recommend you keep this e-mail to store your credentials.</p>
        <br/>
        Your credentials:
        <br/>
        <ul>
            <li>Username: {{$email}}</li>
            <li>Password: {{$password}}</li>
        </ul>
        <br/><br/><br/>
        <p>You can now sign in to <a href="{{url('/')}}">{{$option->name}}</a> with your username and password.</p>
        <br/>
        <p>
            Thank you for your trust in our solutions, <br/>
            {{$option->name}} Team
        </p>
    </div>
</body>
</html>