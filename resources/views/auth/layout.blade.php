<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') — {{ env('APP_NAME') ?? 'Q&A' }}</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ mix('css/app.min.css') }}" rel="stylesheet">
</head>
<body class="hold-transition @yield('class')">
<div id="app">
    @yield('content')
</div>
<script src="{{ mix('js/app.min.js') }}"></script>
</body>
</html>
