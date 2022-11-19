<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【PreGo】ログインパスワード再設定のご案内</title>
</head>

<body>
    <p>
        Lappiをご利用いただき、ありがとうございます。
    </p>
    <p>パスワードが正常にリセットされました</p>
    <p>パスワード:{{$password}}</p>
    <p>
        <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>
    </p>

</body>

</html>