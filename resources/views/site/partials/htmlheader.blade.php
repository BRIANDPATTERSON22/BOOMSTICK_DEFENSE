<title> @yield('htmlheader_title', 'Page not found') | @if($option->title){{$option->title}} @else {{$option->name}} @endif </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="{{$option->description}}">
<meta name="keywords" content="{{$option->keywords}}">
<meta name="author" content="{{$option->name}}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@if($option->favicon)
  <link rel="icon" href="{{asset('storage/options/'.$option->favicon)}}" type="image/x-icon">
  <link rel="shortcut icon" href="{{asset('storage/options/'.$option->favicon)}}" type="image/x-icon">
@endif

<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/font-awesome.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/themify.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/animate.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('site/css/color2.css') }}" media="screen" id="color">

@include('site.partials.custom_css')