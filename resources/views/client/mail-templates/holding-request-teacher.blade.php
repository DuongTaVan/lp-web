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
        .student-restock-email {
            font-style: normal;
        }

        .student-restock-email__title {
            font-size: 16px;
            margin: 20px 0 10px 12px;
        }

        .student-restock-email__text-note {
            font-size: 14px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .student-restock-email__course-info__title__custom {
            margin-left: -9px;
        }

        .student-restock-email__text-note__custom {
            margin-left: unset;
            max-width: fit-content;
        }

        .student-restock-email__course-info {
            font-size: 14px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .student-restock-email__course-info__title {
            font-weight: 700;
            margin-top: 5px;
        }

        .student-restock-email__course-info__item .text-title-bold {
            font-weight: 700;
        }

        .student-restock-email__course-info__note-review {
            margin-top: 10px;
        }

        .student-restock-email__content {
            font-size: 14px;
            max-width: fit-content;
        }

        .student-restock-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .student-restock-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .student-restock-email__content .ml-10px {
            margin-left: 10px;
        }

        .student-restock-email__content__note {
            margin-left: 5px;
        }

        .block-three {
            display: flex;
            flex-direction: column;
        }
        .title-pc {
            display: block !important;
        }

        .title-sp {
            display: none;
        }

        @media only screen and (max-width: 414px) {

            .student-restock-email__title {
                font-size: 20px !important;
            }

            .title-sp {
                display: block;
            }

            .title-pc {
                display: none !important;
            }

            .student-restock-email__text-note {
                font-size: 17px !important;
            }

            .student-restock-email__course-info {
                font-size: 17px !important;
            }

            .student-restock-email__content__note {
                font-size: 17px !important;
            }

            .student-restock-email__content {
                font-size: 17px !important;
            }

            .course-info-sp {
                font-size: 17px !important;
            }

            .block-three {
                display: inline-table !important;
            }

            .student-restock-email__text-note__custom {
                font-size: 17px !important;
            }
        }
    </style>
</head>

<body>
<div class="student-restock-email">
    <p class="student-restock-email__title">
        {{$teacher}}さん
    </p>
    <div class="student-restock-email__text-note">
        <p style="margin: 0"> 新規のご予約がありましたので下記の内容をお確かめください。</p>
        <hr>
    </div>
    <div class="student-restock-email__course-info">
        <p class="student-restock-email__course-info__item" style="margin: 0">サービス：{{$courseSchedule['title']}}</p>
        <p class="student-restock-email__course-info__item" style="margin: 0">
            開催日：{{now()->parse($courseSchedule['start_datetime'])->format('m月d日')}}</p>
        <p class="student-restock-email__course-info__item" style="margin: 0">
            時間 : {{now()->parse($courseSchedule['start_datetime'])->format('H:i')}}
            -{{now()->parse($courseSchedule['end_datetime'])->format('H:i')}}
        </p>
        <p class="student-restock-email__course-info__item" style="margin: 0">金額
            ： {{number_format($courseSchedule['price'])}}円</p>
    </div>
    <div class="student-restock-email__course-info course-info-sp">
        <hr>
        <div class="student-restock-email__text-note student-restock-email__text-note__custom"
             style="max-width: unset; margin: 0">
            <p> 販売中サービス画面の「予約状況」からご確認ください。</p>
        </div>
        <p class="student-restock-email__course-info__title student-restock-email__course-info__title__custom"
           style="margin: 0">
            【予約状況】画面はこちら
        </p>
        <a href="{{route('client.teacher.my-page.service-list')}}">{{route('client.teacher.my-page.service-list')}}</a>
        <hr>
    </div>
</div>
<div class="student-restock-email__content">
    <div class="student-restock-email__content__note">
        <div class="block-sp">
            <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
            <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
            <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
        </div>
        <p style="margin: 0">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
    </div>
    <hr>
    <p class="ml-10px">Lappiお問い合わせ窓口</p>
    <a class="ml-10px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
    <hr>
</div>

</body>
</html>

