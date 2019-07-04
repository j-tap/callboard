<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
	 <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/admin.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <noscript>
        <strong>We're sorry but vue-admin-lte-template doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>
    <div class="wrapper">
        <div id="app"></div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <!-- built files will be auto injected -->
    <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
</body>
</html>
