<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0 "); // Proxies.
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>{{ config('app.appname_user') }}</title>
        <link rel="icon" href="{!! asset('/assets/img/icons/logo.svg') !!}"/>
        <meta name="theme-color" content="#ffffff">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900|Noto+Serif+JP:200,300,400,500,600,700,900|Roboto&display=swap"
              rel="stylesheet">
        <link href="{{ mix('css/clients/style.css') }}" rel="stylesheet">
        <link href="{{ mix('css/agora/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/toastr.min.css') }}">
    @yield('css')
    <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');
        </script>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>

    <body class="c-app">
    {{--sound notification--}}
    <audio id="audioNotification" src="{{ asset('/assets/sounds/notification-2.wav') }}" preload="auto"></audio>

    @if(session('error'))
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    @if(session('success'))
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif
    @include('portal.dashboard.base.loading')

    <div class="layout-wrap" data-url="{{route('schedules-in-day')}}">
        <div class="livestream__layout-header" id="layout-header">
            @include('client.layout.livestream.header')
        </div>
        <div class="livestream__layout-content">
            @yield('content')
        </div>
        {{--    @include('client.layout.footer')--}}
    </div>
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=60fe75f919c512001348300e&product=inline-share-buttons'
            async='async'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ mix('js/jquery.validate.min.js') }}"></script>
    <script src="{{ mix('js/toast.min.js') }}"></script>
    <script src="{{ mix('js/custom-validator.js') }}"></script>
    <script src="{{ asset('deepar/lib/deepar.js') }}"></script>
    <script src="{{ mix('js/clients/client.js') }}"></script>
    <script src="https://use.fontawesome.com/a8c96b1a15.js"></script>

    @yield('script')
    <script src="{{ mix('js/flatpickr.min.js') }}"></script>
    @yield('lib-js')
    </body>

</html>
