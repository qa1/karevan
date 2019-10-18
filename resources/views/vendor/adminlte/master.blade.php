<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
	@yield('title', config('adminlte.title', 'AdminLTE 2'))
	@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
	<link href="{{mix('images/favicon.ico')}}" rel="shortcut icon">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ mix('dist/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('dist/panel.css') }}">

    @stack('head')
    @yield('adminlte_css')
</head>
<body class="hold-transition fixed @yield('body_class')">

@yield('body')
<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>

<script src="{{ mix('dist/vendor.js') }}"></script>
<script src="{{ mix('dist/panel.js') }}"></script>

@yield('adminlte_js')

<script>if (window.module) module = window.module;</script>

</body>
</html>
