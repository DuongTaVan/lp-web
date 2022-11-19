<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lappi</title>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900|Noto+Serif+JP:200,300,400,500,600,700,900|Roboto&display=swap"
          rel="stylesheet">
    <style>
        .remind-course-email {
            font-style: normal;
        }

        .remind-course-email__title {
            font-size: 16px;
            margin: 20px 0 20px 12px;
        }

        .remind-course-email__text-note {
            font-size: 14px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .remind-course-email__title-two {
            font-weight: 700;
            font-size: 14px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .remind-course-email__content {
            font-size: 14px;
            max-width: fit-content;
        }

        .remind-course-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .remind-course-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .remind-course-email__content .ml-5px {
            margin-left: 5px;
        }

        .remind-course-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .remind-course-email__content__note__body {
            /*display: flex;*/
            /*flex-direction: column;*/
        }

        .line-sp, .line-pc {

        }

        .line-sp {
            display: none;
        }

        .line-pc {
            margin-bottom: 0;
            margin-top: 0;
            margin-left: 5px;
        }

        .course-end-email__course-info__title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .course-end-email__course-info__title__href {
            margin-left: 5px;
        }

        .block-sp {
            display: flex;
            flex-direction: column;
        }

        .student-restock-email__course-info {
            margin-left: 0 !important;
        }

        .title-pc {
            display: block !important;
        }

        .title-sp {
            display: none;
        }

        @media only screen and (max-width: 414px) {
            .remind-course-email {
                color: #2A3242 !important;
            }

            .title-sp {
                display: block;
            }

            .title-pc {
                display: none !important;
            }

            .remind-course-email__title {
                font-size: 20px;
            }

            .remind-course-email__text-note {
                font-size: 17px !important;
            }

            .remind-course-email__title-two {
                font-size: 20px !important;
            }

            .remind-course-email__content {
                font-size: 17px !important;
            }

            .remind-course-email__content__note__body {
                font-size: 17px !important;
            }

            .line-sp {
                display: block;
            }

            .line-pc {
                display: none;
            }

            .block-sp {
                display: inline-table !important;
            }

            .course-end-email__course-info__title {
                font-weight: 700;
            }
        }

        hr {
            color: #2A3242;
        }
    </style>
</head>

<body>
<div class="remind-course-email">
    <div class="remind-course-email__title">
        {{$fullName}}さん
    </div>
    <div class="remind-course-email__text-note">
        ご予約頂きましたサービスの開催が
        <br>
        明日になりますのでご連絡いたします。
        <hr>
    </div>
    <div class="remind-course-email__title-two" style="font-weight: bold">
        予約サービスの詳細
        <hr>
    </div>
    <div class="remind-course-email__content">
        <p>・当日は下記の「配信準備画面」URLからご参加くださいね！ ※開催時間１５分前から可能です。</p>
        <p>・購入者マイページからは「販売中サービス」画面より配信準備画面へお進み下さい。</p>
        <div class="mb-10px course-end-email__course-info__title" style="font-weight: bold">【販売中サービス】画面はこちら</div>
        <a class="course-end-email__course-info__title__href"
           href="{{route('client.student.my-page.purchase-service')}}"
           target="_blank">{{route('client.student.my-page.purchase-service')}}</a>
        <hr>
        <div class="remind-course-email__content__note">
            {{--            <div>※</div>--}}
            <div class="remind-course-email__content__note__body">
                <div>※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう</div>
                <div>お願い申し上げます。</div>
                <div class="block-sp">
                    <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                    <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                    <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
                </div>
                <div>ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</div>
            </div>
        </div>
        <hr>
        <p class="">Lappiお問い合わせ窓口</p>
        <a class="" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
