<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prego</title>
    <link rel="stylesheet" href="{{ asset('/') }}">
    <link rel="stylesheet" href="{{ mix('css/portals/style.css') }}" type="text/css">
</head>
<body>
<div class="page-error">
    @yield('error')
</div>
<script src="{{ asset('js/portals/portal.js') }}"></script>
</body>
</html>
