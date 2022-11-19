<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Command</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid text-center mt-5">
    <p>
        <a href="{{ config('app.url') }}/telescope" target="_blank">Link check command</a>
    </p>

    <a href="{{ route('batch_01') }}" class="btn btn-primary">Batch 01</a>
    <a href="{{ route('batch_02') }}" class="btn btn-danger">Batch 02</a>
    <a href="{{ route('batch_03') }}" class="btn btn-success">Batch 03</a>
    <a href="{{ route('batch_04') }}" class="btn btn-success">Batch 04</a>
    <a href="{{ route('batch_05') }}" class="btn btn-warning">Batch 05</a>
    <a href="{{ route('batch_06') }}" class="btn btn-info">Batch 06</a>
    <a href="{{ route('batch_07') }}" class="btn btn-primary">Batch 07</a>
    <a href="{{ route('batch_08') }}" class="btn btn-secondary">Batch 08</a>
    <a href="{{ route('batch_09') }}" class="btn btn-secondary">Batch 09</a>
    <a href="{{ route('remind_confirm') }}" class="btn btn-success">Confirm Course Schedule</a>
    <a href="{{ route('test_mail') }}" class="btn btn-success">Test Mail</a>
    <a href="{{ route('cancel_course_schedule') }}" class="btn btn-danger">Cancel Course Schedule</a>
    <a href="{{ route('send_mail_new_service') }}" class="btn btn-primary">Send Mail New Service</a>
    <a href="{{ route('payout-teacher') }}" class="btn btn-primary">payout teacher</a>
    <a href="{{ route('payout-lappi') }}" class="btn btn-primary">payout lappi</a>
    {{-- <a href="{{ route('batch_02') }}" class="btn btn-secondary">Batch 02</a> --}}
    {{-- <a href="{{ route('batch_03') }}" class="btn btn-success">Batch 03</a>
    <a href="{{ route('batch_04') }}" class="btn btn-danger">Batch 04</a>
    <a href="{{ route('batch_05') }}" class="btn btn-warning">Batch 05</a>
    <a href="{{ route('batch_06_a') }}" class="btn btn-info">Batch 06 (PG)</a>
    <a href="{{ route('batch_06_b') }}" class="btn btn-dark">Batch 06 (BD)</a>
    <a href="{{ route('batch_07') }}" class="btn btn-primary">Batch 07</a>
    <a href="{{ route('batch_08') }}" class="btn btn-secondary">Batch 08</a>
    <a href="{{ route('batch_09') }}" class="btn btn-success">Batch 09</a>
    <a href="{{ route('batch_10') }}" class="btn btn-danger">Batch 10</a>
    <a href="{{ route('batch_11') }}" class="btn btn-warning">Batch 11</a>
    <a href="{{ route('batch_12_a') }}" class="btn btn-info">Batch 12 (male)</a>
    <a href="{{ route('batch_12_b') }}" class="btn btn-dark">Batch 12 (female)</a>
    <br>
    <br>
    <a href="{{ route('batch_13_a') }}" class="btn btn-info">Batch 13 (pg points)</a>
    <a href="{{ route('batch_13_b') }}" class="btn btn-dark">Batch 13 (bd points)</a>
    <a href="{{ route('batch_14_a') }}" class="btn btn-dark">Batch 14 (pg points)</a>
    <a href="{{ route('batch_14_b') }}" class="btn btn-dark">Batch 14 (bd points)</a> --}}
</div>
</body>
</html>
