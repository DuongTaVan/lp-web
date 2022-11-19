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
            font-weight: 300;
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

        .student-restock-email__course-info {
            font-size: 14px;
            margin-left: 5px;
            font-weight: 300;
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
            line-height: 17px;
            max-width: fit-content;
            margin-left: 5px;
        }

        .student-restock-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .student-restock-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .student-restock-email__content .ml-5px {
            margin-left: 5px;
        }

        .student-restock-email__content__note {
            margin-left: 5px;
        }

        .student-restock-email__content__note__body {
            /*display: flex;*/
            /*flex-direction: column;*/
        }

        .block-three {
            display: flex;
            flex-direction: column;
        }

        .line-sp, .line-pc {
            margin: 0;
        }

        .line-sp {
            display: none;
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

            .student-restock-email__content {
                font-size: 17px !important;
            }

            .block-three {
                display: inline-table !important;
            }

            .line-sp {
                display: block;
            }

            .line-pc {
                display: none;
            }

            .student-restock-email__content .ml-5px {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
<div class="student-restock-email">
    <p class="student-restock-email__title">
        {{$fullName}}さん
    </p>
    <div class="student-restock-email__text-note">
        <p style="margin: 0"> ご購入頂きましてありがとうございます。</p>
        <p style="margin: 0"> 下記の内容をお確かめください。</p>
        <hr>
    </div>
    <div class="student-restock-email__course-info">
        <p class="student-restock-email__course-info__item" style="margin: 0">
            出品者：{{$teacher}}
        </p>
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
    <div class="student-restock-email__course-info">
        <hr>
        <p class="student-restock-email__course-info__title" style="font-weight: bold; margin: 0"> 【サービスの詳細はこちら】</p>
        <a href="{{ route('client.course-schedules.detail', ['course_schedule_id' => $courseSchedule['course_schedule_id']]) }}">{{ route('client.course-schedules.detail', ['course_schedule_id' => $courseSchedule['course_schedule_id']]) }}</a>
        @if(count($listCourseSchedules) > 0)
            <hr>
            <p style="margin: 0;">・当日は下記の「配信準備画面」URLからご参加くださいね！ <span
                        class="line-pc">※開催時間１５分前から可能です。</span></p>
            <p class="line-sp" style="margin: 0; ">※開催時間１５分前から可能です。</p>
            @foreach($listCourseSchedules as $listCourseSchedule)
                <p class="student-restock-email__course-info__title"
                   style="font-weight: bold;margin: 0">@if((int)$listCourseSchedule['dist_method'] === 1 && (int)$listCourseSchedule['course_type'] === 1)
                        【ライブ配信準備画面】はこちら  @else【ビデオ通話準備画面】はこちら  @endif</p>
                <a href="{{route('client.student.student-join-course.join-course-id',$listCourseSchedule['course_schedule_id'])}}">{{route('client.student.student-join-course.join-course-id',$listCourseSchedule['course_schedule_id'])}}</a>
            @endforeach
            <p style="margin: 0; font-weight: 500">・購入者マイページからは「販売中サービス」画面より配信準備画面へお進み下さい。</p>
            <p class="student-restock-email__course-info__title" style="font-weight: bold;margin: 0">【購入中サービス】画面はこちら</p>
            <a href="{{ route('client.student.my-page.purchase-service') }}">{{ route('client.student.my-page.purchase-service') }}</a>
        @endif
        <hr>
    </div>
    <div class="student-restock-email__content">
        <div class="block-three" style="margin: 0">
            <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
            <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
            <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
        </div>
        <p style="margin: 0">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
        <hr>
        <p class="ml-5px">Lappiお問い合わせ窓口</p>
        <a class="ml-5px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>

</body>
</html>

