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
        .student-cancel-email {
            font-style: normal;
        }

        .student-cancel-email__title {
            font-size: 16px;
            margin: 20px 0 20px 12px;
        }

        .student-cancel-email__text-note {
            font-size: 14px;
            margin-left: 5px;
            max-width: fit-content;
        }

        .student-cancel-email__course-info {
            font-size: 14px;
            margin-bottom: 10px;
            margin-left: 5px;
            max-width: fit-content;
        }

        .student-cancel-email__course-info__title {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .student-cancel-email__course-info__item .text-title-bold {
            font-weight: 700;
        }

        .student-cancel-email__course-info__note-review {
            margin-top: 10px;
        }

        .student-cancel-email__content {
            font-size: 14px;
            max-width: fit-content;
            margin-left: 5px;
        }

        .student-cancel-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .student-cancel-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .student-cancel-email__content .ml-15px {
            margin-left: 15px;
        }

        .student-cancel-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .student-cancel-email__content__note__body {
        }

        .student-cancel-email__item {
            max-width: fit-content;
            margin-left: 5px;
        }

        .student-cancel-email__item .text-title-bold {
            font-weight: 700;
        }

        .block-sp {
            display: flex;
            flex-direction: column;
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

            .student-cancel-email__content {
                font-size: 17px !important;
            }

            .student-cancel-email__text-note {
                font-size: 17px !important;

            }

            .student-cancel-email__title {
                font-size: 20px !important;
            }

            .student-cancel-email__course-info {
                font-size: 17px !important;

            }

            .block-sp {
                display: inline-table !important;
            }

        }

        .teacher-cancel {
            max-width: fit-content;
        }
    </style>
</head>

<body>
<div class="student-cancel-email">
    <p style="" class="student-cancel-email__title">
        {{$teacherName}}さん
    </p>
    <div class="student-cancel-email__text-note">
        <p style="margin: 0;">下記開催日の予約キャンセルがありましたのでご確認ください。</p>
        <hr>
    </div>
    <div class="student-cancel-email__course-info">
        <div class="teacher-cancel">
            <p style="margin: 0; font-weight: bold" class="student-cancel-email__course-info__title"> キャンセルの詳細</p>
            <hr>
        </div>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">
            キャンセル日時：{{Carbon\Carbon::parse($course->updated_at)->format('m')}}
            月{{Carbon\Carbon::parse($course->updated_at)->format('d')}}日　
        </p>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">購入者：{{$userName}}さん</p>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">サービス：{{$course->title}}</p>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">
            開催日：{{Carbon\Carbon::parse($course->start_datetime)->format('m')}}
            月{{Carbon\Carbon::parse($course->start_datetime)->format('d')}}日
        </p>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">時間
            : {{Carbon\Carbon::parse($course->start_datetime)->format('H')}}
            :{{Carbon\Carbon::parse($course->start_datetime)->format('i')}}
            -{{Carbon\Carbon::parse($course->end_datetime)->format('H')}}
            :{{Carbon\Carbon::parse($course->end_datetime)->format('i')}}</p>
        <p style="margin: 0;" class="student-cancel-email__course-info__item">金額： {{number_format($course->price)}}円</p>
        <hr>
    </div>
    <p style="margin: 0;" class="student-cancel-email__note-review">・出品者マイページからは「販売履歴」画面よりご確認下さい。</p>
    <div class="student-cancel-email__item" style="font-weight: 500; color: #2A3242;">
        <span class="text-title-bold">【販売履歴】</span>： <a
                href="{{route('client.teacher.sale')}}"
                target="_blank">{{route('client.teacher.sale')}}</a>
        <hr>
    </div>

    <div class="student-cancel-email__content">
        <div class="student-cancel-email__content__note" style="display: flex;">
            <div class="student-cancel-email__content__note__body">
                <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br
                            style="display: none">お願い申し上げます。</p>
                <div class="block-sp">
                    <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                    <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                    <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
                </div>
                <p style="margin: 0;">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
            </div>
        </div>
        <hr>
        <p class="ml-15px mb-10px">Lappiお問い合わせ窓口</p>
        <a class="ml-15px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
