<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Lappi</title>
    <link rel="icon" href="{!! asset('/assets/img/icons/logo.svg') !!}"/>
    <link rel="stylesheet" href="{{ mix('css/portals/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@yield('styles')
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
</head>

<body>
<div class="wrapper">
    @include('portal.components.loading')
    <div class="wrapper__sidebar active">
        @include('portal.layouts.sidebar')
    </div>
    <div
        class="wrapper_main show_sidebar {{ \Request::route() && \Request::route()->getName() === 'portal.dashboard' ? 'bg-dashboard' : '' }}">
        <div class="wrapper_header">
            @include('portal.layouts.header')
        </div>
        <div class="wrapper_content">
            @yield('content')
        </div>
        <div class="wrapper_footer">
            @include('portal.layouts.footer')
        </div>
    </div>
</div>
<script src="{{ asset('js/portals/portal.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/flatpickr.min.js') }}"></script>
<script src="{{ asset('js/custom-validator.js') }}"></script>
<script src="{{ asset('js/toast.min.js') }}"></script>
<script src="{{ asset('js/live-search.js') }}"></script>
<script src="{{ asset('js/loading-overlay.min.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/ckeditor.js') }}"></script>
@if(config('app.socket'))
    <script src="{{ mix('js/portals/realtime.js') }}"></script>
@endif
@yield('scripts')
</body>

</html>
