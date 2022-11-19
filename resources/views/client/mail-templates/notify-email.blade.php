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
        .auth-email {
            width: 879px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .auth-email__label {
            justify-content: center;
            margin-bottom: 18.34px;
            display: flex;
            align-items: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            color: #2A3242;
        }

        .auth-email__label span {
            font-size: 24.66px;
            line-height: 36.99px;
            color: #2A3242;
            display: inline-block;
            margin-left: 14.49px;
            font-weight: 600;
        }

        .auth-email__content {
            background-color: #F9FAFB;
            padding: 32px 0 37px 0;
            text-align: center;
            width: 600px;
            margin: 0 auto;
        }

        .auth-email__content h1 {
            font-size: 24px;
            line-height: 36px;
            margin-bottom: 19px;
            font-weight: 600;
            color: #2A3242;
        }

        .auth-email__content__note {
            width: 390px;
            margin: 0 auto 22px;
        }

        .auth-email__content__note p {
            margin-bottom: 0;
            font-size: 14px;
            line-height: 21px;
            text-align: left;
            color: #2A3242;
        }

        .auth-email__content .link-24h {
            font-size: 12px;
            line-height: 18px;
            color: #2A3242;
            display: block;
            margin-bottom: 19px;
            margin-top: 10px;
        }

        .auth-email__content .about-lappi {
            font-size: 12px;
            line-height: 18px;
            margin-bottom: 0;
            color: #2A3242;
        }

        .auth-email__content .about-lappi span {
            color: #46CB90;
        }

        a {
            text-decoration: none;
            color: #46CB90
        }

        .auth-email__content .redirect {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            width: 250px;
            height: 41px;
            line-height: 41px;
            color: #FFFFFF;
            background: #46CB90;
            border: 1px solid #46CB90;
            box-sizing: border-box;
            border-radius: 5px;
            margin: auto;
        }

        .auth-email__content .redirect a {
            width: 100%;
            height: 100%;
            color: #FFFFFF;
            margin: auto;
        }

    </style>
</head>

<body>
<div class="auth-email">
    <div class="auth-email__label">
        <img style="margin: auto" src="{{ $message->embed(public_path() . '/assets/img/clients/auth/auth-email-logo.png') }}"/>
    </div>
    <div class="auth-email__content">
        <p>{{ $fromUser ?? "" }}{{ __('labels.profile-email.message_title') }}</p>
        {!! $content !!}
        <a href="{{$url ?? ""}}">{{$url ?? ""}}</a>
    </div>
</div>
</body>
</html>
