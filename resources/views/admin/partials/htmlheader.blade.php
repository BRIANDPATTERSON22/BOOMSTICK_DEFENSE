
<meta charset="UTF-8">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title> @yield('htmlheader_title', 'Page not found') | Admin panel - {{$option->name}}</title>

<meta name="description" content="{{$option->description}}">
<meta name="keywords" content="{{$option->keywords}}">
<meta name="author" content="innovay">

@if($option->favicon)<link rel="shortcut icon" href="{{asset('storage/options/'.$option->favicon)}}">
@else<link rel="shortcut icon" href="{{asset('admin/img/favicon.ico')}}">@endif

<!-- Bootstrap 3.3.4 -->
<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

<!-- Font Awesome Icons -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script> --}}

<!-- Ionicons -->
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('admin/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />

<!-- iCheck -->
<link href="{{ asset('/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />

<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/select2.min.css')}}">

<!-- Bootstrap date Picker -->
<link href="{{ asset('plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />

<!-- Bootstrap time Picker -->
<link href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" >

<!-- Tag input -->
<link rel='stylesheet' href='{{asset('plugins/tagsinput/bootstrap-tagsinput.css')}}' type='text/css' media='all' />

<!-- Bootstrap color picker -->
<link href="{{ asset('plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" >

<link href="{{ asset('plugins/pace/pace.min.css') }}" rel="stylesheet" >

<!-- Theme style -->
<link href="{{ asset('admin/css/innovay-admin.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('admin/css/skins/skin-innovay.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ asset('admin/css/skins/skin-red.css') }}" rel="stylesheet" type="text/css" /> --}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('page-style')