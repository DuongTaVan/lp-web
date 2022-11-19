<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('passwords.mail_create_user') }}</title>
</head>

<body>
    <p>
      PREwizにご登録いただき、ありがとうございます。
    </p>
    <p>下記のURLをクリックし、本人確認を完了させてください。</p>
    <p>
      <a href="{{ $url }}">{{ $url }}</a>
    </p>
    <p></p>
    <p>
      本URLの有効期限は発行より30分となっております。
    </p>
    <p>
      期限が切れてしまった際には、再度アカウント登録を行なってください。
    </p>
    <p></p>
    <p>
      ※本メールにお心当たりの無い方は、大変お手数ですが本メールを破棄頂きますようお願い申し上げます。
    </p>
    <p></p>
    <p>
      本メールアドレスは送信になりますので、本メールにご返信頂いてもお答えできませんのでご了承下さい。
    </p>
    <p></p>
    <p>ご不明な点や、お困りのことがございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
    <p></p>
    <p>PREwiz お問い合わせ窓口</p>
    <p>
        <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>
    </p>

</body>
</html>
