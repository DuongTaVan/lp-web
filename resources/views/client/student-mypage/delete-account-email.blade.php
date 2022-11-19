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
        .delete-account-email {
            font-style: normal;

        }

        .delete-account-email__title {
            font-size: 16px;
            margin: 20px 0 20px 15px;
        }

        .delete-account-email__content {
            font-size: 14px;
            /*line-height: 20px;*/
            max-width: fit-content;
        }

        .delete-account-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 15px;
        }

        .delete-account-email__content .mb-5px {
            margin-bottom: 5px;
        }

        .delete-account-email__content .ml-15px {
            margin-left: 15px;
        }

        .delete-account-email__content .ml-12px {
            margin-left: 12px;
        }

        .delete-account-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .delete-account-email__content__note__body {
            line-height: 20px;
        }

        .text-delete-account br {
            display: block !important;
        }

        .text-inquiry br {
            display: block !important;
        }

        .title-pc {
            display: block !important;
        }

        .title-sp {
            display: none;
        }

        @media only screen and (max-width: 414px) {
            .text-inquiry br {
                display: none !important;
            }

            .title-sp {
                display: block;
            }

            .title-pc {
                display: none !important;
            }

            .text-delete-account br {
                display: none !important;
            }

            .delete-account-email__title {
                font-size: 20px !important;
            }

            .delete-account-email__content {
                font-size: 17px !important;
            }
        }
    </style>
</head>

<body>
<div class="delete-account-email">
    <p class="delete-account-email__title" style="margin-bottom: 20px">
        {{$userName}}さん
    </p>
    <div class="delete-account-email__content">
        <div style="max-width: fit-content">
            <p style="margin: 0">当サイトの退会手続きが完了いたしましたのでお知らせいたします。</p>
            <p style="margin: 0">これまでご利用いただきまして、誠にありがとうございました。</p>
            <p style="margin: 0">退会手続きをいたしましたので、お持ちのポイントは全て無効となります。</p>
            <p style="margin: 0" class="text-delete-account">また、今までのご利用サービス履歴の閲覧もご利用は出来ませんので<br style="display: none">ご了承をお願い申し上げます。
            </p>
            <hr>
        </div>
        <div class="delete-account-email__content__note" style="display: flex">
            <div class="delete-account-email__content__note__body">
                <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br
                            style="display: none">お願い申し上げます。</p>
                <div class="block-sp">
                    <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                    <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                    <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
                </div>
            </div>
        </div>
        <hr>
        <p class="ml-12px mb-10px">Lappiお問い合わせ窓口</p>
        <a class="ml-12px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
