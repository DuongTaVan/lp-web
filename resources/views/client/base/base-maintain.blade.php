<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0 "); // Proxies.
?>
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="theme-color" content="#ffffff">
    @if(View::hasSection('header'))
        @yield('header')
    @else
        <title>Lappi</title>
    @endif

    <link rel="icon" href="{!! asset('/assets/img/icons/logo.svg') !!}"/>
    <!-- Fonts -->
    <style>
        html, body {
            margin: 0;
            height: 100%;
            overflow: hidden
        }
    </style>
    <link
        href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900|Noto+Serif+JP:200,300,400,500,600,700,900|Roboto&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/clients/style.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body class="c-app">
<div id="fb-root"></div>

<div class="layout-wrap" data-url="{{route('schedules-in-day')}}">
    <div id="layout-content" class="base-content layout-content">
        @yield('content')
    </div>
</div>

</body>

</html>
