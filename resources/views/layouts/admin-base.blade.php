<!DOCTYPE html>
<html lang="en" class="{{$htmlClass or ''}}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ assets('css/admin.css') }}">
</head>
<body class="{{$bodyClass or ''}}">
@yield('body')
@yield('beforeJs')
@yield('js')
@yield('afterJs')
</body>
</html>