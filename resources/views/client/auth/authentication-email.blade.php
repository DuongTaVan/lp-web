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
            width: 600px;
            margin: 0 auto;
            box-sizing: border-box;
            border-radius: 5px;
        }

        .auth-email__label {
            justify-content: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .auth-email__logo {
            display: block;
            margin: 0 auto;
            width: 115px;
        }

        .auth-email__label span {
            font-size: 24px;
            line-height: 36px;
            color: #2A3242;
            display: inline-block;
            margin-left: 5.66px;
            font-weight: 600;
        }

        .auth-email__content {
            background-color: #F9FAFB;
            padding: 30px 0 32px 0;
            text-align: center;
            border-radius: 5px;
        }

        .auth-email__content h1 {
            font-size: 16px;
            line-height: 24px;
            margin-bottom: 19px;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .auth-email__content__note {
            width: 390px;
            margin: 0 auto 20px;
        }

        .auth-email__content__note p {
            margin-bottom: 0;
            font-size: 14px;
            line-height: 21px;
            text-align: left;
            margin-top: 0;
            text-align: center
        }

        .auth-email__content .link-24h {
            font-size: 12px;
            line-height: 18px;
            color: #2A3242;
            display: block;
            margin-bottom: 14px;
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
            font-weight: 600;
        }

        .auth-email__content .redirect a {
            width: 100%;
            height: 100%;
            color: #FFFFFF;
            margin: auto;
        }

        .br-mobile {
            display: none;
        }

        /* // MOBILE */
        @media only screen and (max-width: 767px) {
            body {
                padding: 10px;
                margin: 0;
            }

            .auth-email {
                width: 100%;
                margin: 0 auto;
                box-sizing: border-box;
                border-radius: 5px;
            }

            .auth-email__content {
                padding: 15px 16px;
            }

            .auth-email__content h1 {
                text-align: left;
                margin-bottom: 2px;
                font-size: 14px;
                line-height: 21px;
            }

            .auth-email__content__note {
                text-align: left;
                width: 100%;
                margin-bottom: 11px;
            }

            .auth-email__content__note p {
                text-align: left;
                width: 100%;
                font-size: 11px;
                line-height: 16.5px;
            }

            .auth-email__content .redirect {
                width: 100%;
                height: 41px;
            }

            .auth-email__content .link-24h {
                font-size: 10px;
                line-height: 15px;
                margin: 7px 0;
            }

            .auth-email__content .about-lappi {
                font-size: 10px;
                line-height: 15px;
                margin-top: 7px;
            }

            .br-mobile {
                display: block;
            }

            .show-pc {
                display: none;
            }
        }

    </style>
</head>

<body>
<div class="auth-email">
    <div class="auth-email__label">
        <img class="auth-email__logo" src="{{ asset('/assets/img/clients/auth/logo-auth.png') }}"/>
    </div>
    <div class="auth-email__content">
        <h1 class="">ご登録メールアドレスの確認</h1>
        <div class="auth-email__content__note">
            <p>Lappiにご登録いただきまして<span class="show-pc">、</span><br class="br-mobile">誠にありがとうございます。</p>
            <p>下記ボタンをクリックで本登録が完了いたします。</p>
        </div>
        <button class="redirect f-w6"><a href="{{$url}}">本登録を完了する</a></button>
        <span class="link-24h">※上記リンクは24時間有効です。</span>
        <p class="about-lappi">このメールに心当たりがない場合は<br class="br-mobile"><a>information@Lappi.co.jp</a>までお知らせください。</p>
    </div>
</div>
</body>
</html>
