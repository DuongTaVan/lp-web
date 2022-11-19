<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Lappi】ログインパスワード再設定のご案内</title>
</head>

<body>
<p>
    Lappiをご利用いただき、ありがとうございます。
</p>
<p>下記URLよりパスワードの再設定を行ってください。</p>
<p>
    <a href="{{ $url }}">{{ $url }}</a>
</p>
<p></p>
<p>
    本URLの有効期限は発行より30分となっております。
</p>
<p>
    期限が切れてしまった際には、再度パスワード変更を行なってください。
</p>
<p></p>
<p>
    ご不明な点や、お困りのことがございましたらお手数ですが以下のメールアドレスにお問い合わせください。
</p>
<p>
    ※本メールにお心当たりの無い方は、大変お手数ですが本メールを破棄頂きますようお願い申し上げます。
</p>
<p>
    本メールアドレスは送信になりますので、本メールにご返信頂いてもお答えできませんのでご了承下さい。
</p>
<p>
    <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
</p>
</body>
</html>
