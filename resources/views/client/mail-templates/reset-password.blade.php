<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Lappi】ログインパスワード再設定のご案内</title>
    <style>
        .mrb {
            margin-bottom: 36px;
        }

        .mt {
            margin-top: 5px;
        }

        p {
            font-family: "Hiragino Kaku Gothic ProN", "Hiragino Kaku Gothic Pro", "メイリオ", "Meiryo", "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #2A3242;
            font-size: 14px;
            line-height: 21px;
        }
    </style>
</head>

<body>
<p class="mrb">
    {{ $user->full_name }}様
</p>
<p class="mrb">
    Lappiのご利用、いつもありがとうございます。
</p>
<p class="mrb">パスワードを再設定するには、下記のURLをクリックしてパスワード変更のページにアクセスしていただく必要があります。</p>
<p style="margin-bottom: 0;">ページの案内に従って、パスワードを再設定してください。</p>
<p class="mrb mt">
    <a style="color: #46CB90" href="{{ $url }}">{{ $url }}</a>
</p>
<p style="margin-bottom: 0">ご注意：</p>
<p class="mrb mt">
    セキュリティ保護のため、このメールの送信後24時間経過すると、上記リンクは無効になりますので、ご注意ください。
</p>
<br>
<p style="margin-top: -5px">※こちらのメールは送信専用のメールアドレスより送信しています。恐れ入りますが、このメールに返信されても受信できません。</p>
</body>
</html>
