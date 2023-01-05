<!DOCTYPE html>
<html>

@section('htmlheader_title')
    Under Maintenance
@endsection

<head>
    @include('site.partials.htmlheader')
</head>

<body>
<div style="height: 100vh; overflow: hidden; padding: 20px 0;">
    <div class="container">
        <header>
            <div class="text-center">
                @if($option->logo)<img src="{{asset('storage/options/'.$option->logo)}}" alt="{{$option->name}}"/>
                @else{{$option->name}}@endif
            </div>
        </header>
        <section>
            <div style="text-align:center; padding: 5% 0">
                <h1>Under Maintenance</h1>
                <h4>We will back to you soon !</h4>
                <p>Address: {!! $option->address !!}</p>
                <p>Phone: {{$option->phone}}</p>
                <p>Email: {{$option->email}}</p>
            </div>
        </section>
        <footer>
            <div style="border-top: 1px solid #333; padding-top: 10px;">
                <div style="float: right">
                    <p style="color: #da318c;">Solution by <a href="http://www.innovay.com/" target="_blank">innovay</a></p>
                </div>
                <div>
                    <p 
            <div style="color: #da318c;"><?php echo date('Y'); ?> Copyright &copy; {{$option->name}}</p>
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
</html>