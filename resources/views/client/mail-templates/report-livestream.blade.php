<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lappi</title>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900|Noto+Serif+JP:200,300,400,500,600,700,900|Roboto&display=swap"
          rel="stylesheet">
    <style>
        .report-livestream {
            font-style: normal;
            font-weight: 300;
        }

        .report-livestream__title {
            font-size: 18px;
            margin: 20px 0 40px 12px;
        }

        .report-livestream__content {
            font-size: 18px;
            line-height: 25px;
            margin-left: 10px;
        }
    </style>
</head>

<body>
<div class="report-livestream">
    {{-- <div class="report-livestream__title">
        通報を正常に受け付けました。
    </div> --}}
</div>
<div class="report-livestream__content">
    <div>{{ $content['name_student'] ?? '' }} 様より通報を正常に受け付けました。</div>
    <div>通報対象者: {{ $content['name_teacher'] ?? '' }}</div>
    <div>通報内容: {{ $content['content'] ?? '' }}</div>
    <div>通報時間: {{ now()->format('Y/m/d H:i:s') }}</div>
</div>
</body>
</html>
