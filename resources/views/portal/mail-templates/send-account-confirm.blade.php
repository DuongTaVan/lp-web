<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('passwords.mail_create_host') }}</title>
</head>

<body>
    <p>
        Lappi管理システムのアカウントが発行されました。
    </p>
    <p>
        ------------------------------------------------------------------------
    </p>
    <p>
        URL: <a href="{{ $url }}">{{ $url }}</a>
    </p>
    <p>
        ------------------------------------------------------------------------
    </p>
    <p>
        ※本メールにお心当たりの無い方は、大変お手数ですが本メールを破棄頂きますようお願い申し上げます。
    </p>
    <p>
        本メールアドレスは送信になりますので、本メールにご返信頂いてもお答えできませんのでご了承下さい。
    </p>
    <p>
        ご不明な点や、お困りのことがございましたらお手数ですが以下のメールアドレスにお問い合わせください。
    </p>
    <p>
        Lappi お問い合わせ窓口
    </p>
    <p>
        <a href="mailto:contact@funengage.jp">contact@funengage.jp</a>
    </p>

</body>
</html>
