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
    <link rel="stylesheet" href="{{ mix('css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    @yield('lib-js')
</head>

<body class="c-app">
<div id="fb-root"></div>
@if(session('error'))
    <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
@endif
@if(session('success'))
    <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
@endif
@include('portal.dashboard.base.loading')

<div class="layout-wrap" data-url="{{route('schedules-in-day')}}">
    <div class="layout-header" id="layout-header">
        @include('client.layout.header')
    </div>
    <div id="layout-content" class="base-content layout-content
        {{ in_array(\Request::route() ? Request::route()->getName() : null, \App\Enums\Constant::LIST_SCREEN_BACKGROUND_GRAY) ? ' layout-content--bg-gray' : '' }}
        {{ in_array(\Request::route() ? Request::route()->getName() : null, \App\Enums\Constant::LIST_SCREEN_BACKGROUND_OTHER) ? ' layout-content--bg-other' : '' }}
        {{ in_array(\Request::route() ? Request::route()->getName() : null, \App\Enums\Constant::LIST_SCREEN_NO_PADDING) ? 'layout-content-no-padding' : '' }}
        {{ \Request::route() && Request::route()->getName() === 'client.about-lappi' ? 'layout-content--bg-about-lappi' : '' }}"
         style="padding-bottom: 80px">
        @yield('content')
    </div>
    @include('client.layout.footer')
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script src="{{ mix('js/jquery.validate.min.js') }}"></script>
<script src="{{ mix('js/toast.min.js') }}"></script>
<script src="{{ mix('js/custom-validator.js') }}"></script>
<script src="{{ mix('js/clients/client.js') }}"></script>
<script src="https://use.fontawesome.com/a8c96b1a15.js"></script>
<script src="{{ mix('js/ckeditor.js') }}"></script>
@yield('script')
<script src="{{ mix('js/flatpickr.min.js') }}"></script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
    localStorage.setItem('isRoleTeacher', '<?php echo \Auth::guard('client')->check() ? \Auth::guard('client')->user()->user_type : '';?>');

</script>

<script>
    $(document).ready(function () {
        $('body').css('overflow', 'auto');
    });
</script>

</body>

</html>
