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
            margin: 20px 0 10px 5px;
            max-width: fit-content;
        }

        .course-end-email__course-info {
            font-size: 14px;
            margin-bottom: 10px;
            margin-left: 5px;
            max-width: fit-content;
        }

        .course-end-email__content {
            font-size: 14px;
            max-width: fit-content;
            margin-left: 5px;
        }

        .course-end-email__content p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .course-end-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .course-end-email__content .ml-5px {
            margin-left: 5px;
        }

        .course-end-email__content__note {
            display: flex;
        }

        .course-end-email__course-info__item {
            display: flex;
            min-width: 130px;
            font-weight: 700;
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

            .course-end-email__course-info__item {
                min-width: 150px;
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

            .course-end-email__course-info {
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
        <p style="margin: 0">出品者振込口座誤情報により振込実施が完了できませんでした。</p>
        <p style="margin: 0">下記のアカウントへご連絡して下さい。</p>
        <hr>
    </div>
    <div class="course-end-email__content">
        <div><span>申請承認日</span>: {{ $data['approval_at'] }}</div>
        <div><span>氏名　　　</span>: {{ $data['nickname'] }}</div>
        <div><span>アカウント</span>: {{ $data['email'] }}</div>
        <div><span>カテゴリ　</span>: {{ $data['category'] }}</div>
        <hr>
        <div><span>銀行名　　</span>: {{ $data['bank'] }}</div>
        <div><span>支店名　　</span>: {{ $data['branch'] }}</div>
        <div><span>口座番号　</span>: {{ $data['account_number'] }}</div>
        <div><span>口座名義　</span>: {{ $data['account_name'] }}</div>
        <div><span>振込金額　</span>: ￥ {{ $data['amount'] }}</div>
        <hr>
        <p class="ml-5px" style="font-weight: bold">【振込申請画面で確認】</p>
        <a class="ml-5px" href="{{route('portal.transfer-histories')}}" target="_blank">{{route('portal.transfer-histories')}}</a>
        <hr>
        <p class="ml-5px" style="color: #525F7F">Stripe チーム</p>
        <hr>
    </div>
</div>
</body>
</html>

