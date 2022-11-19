<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lappi</title>
    <link rel="stylesheet" href="{{ asset('/') }}">
    <link rel="stylesheet" href="{{ mix('css/portals/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('css/toastr.min.css') }}">
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
@include('portal.components.loading')
<div class="guest">
    @yield('guest')
</div>
<script src="{{ asset('js/portals/portal.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.datetimepicker.js') }}"></script>
<script src="{{ asset('js/custom-validator.js') }}"></script>
<script src="{{ asset('js/toast.min.js') }}"></script>
<script src="{{ asset('js/live-search.js') }}"></script>
<script src="{{ asset('js/loading-overlay.min.js') }}"></script>
@yield('scripts')
</body>
</html>
