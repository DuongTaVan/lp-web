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
        .course-end-email {
            font-style: normal;
        }

        .course-end-email__title {
            font-size: 16px;
            margin: 20px 0 20px 12px;
        }

        .course-end-email__text-note {
            font-size: 14px;
            margin: 20px 0;
            margin-left: 5px;
            max-width: fit-content;
        }

        .course-end-email__content {
            font-size: 14px;
            max-width: fit-content;
            margin-left: 5px;
        }

        .course-end-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .course-end-email__content .ml-5px {
            margin-left: 5px;
        }

        .course-end-email__content hr {
            margin-left: 5px;
        }

        .text-inquiry br {
            display: block !important;
        }

        @media only screen and (max-width: 414px) {
            .text-inquiry br {
                display: none !important;
            }

            .course-end-email__title {
                margin: 20px 0 20px 0px;
            }

            .course-end-email__content {
                font-size: 17px !important;
            }

            .course-end-email__title {
                font-size: 20px !important;
            }

            .course-end-email__text-note {
                font-size: 17px !important;
                margin-left: 0px;
            }

            .course-end-email__content hr {
                margin-left: 0px;
            }
        }
    </style>
</head>

<body>
<div class="course-end-email">
    <p class="course-end-email__title">
        Lappi事務局
    </p>
    <div class="course-end-email__text-note">
        <p style="margin: 0">振込再申請が完了しましたのでお知らせいたします。</p>
        <hr>
    </div>
    <div class="course-end-email__content">
        <div><span>エラー通知日</span>: {{ $body['failed_at'] }}</div>
        <div><span>振込再申請日</span>: {{ now()->format('Y-m-d') }}</div>
        <div><span>振込合計金額</span>: {{ $body['sum'] }}円</div>
        <div><span>不足金額　　</span>: {{ $body['missing_amount'] }}円</div>
        <hr>
        <p class="ml-5px" style="color: #525F7F">Stripe チーム</p>
        <hr>
    </div>
</div>
</body>
</html>

