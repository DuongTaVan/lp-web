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
            margin-left: 10px;
        }

        .student-cancel-email__course-info {
            font-size: 14px;
            margin-bottom: 10px;
            margin-left: 10px;
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
            line-height: 17px;
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
            line-height: 17px;
        }

        .student-cancel-email__item .text-title-bold {
            font-weight: 700;
        }

        .student-cancel-email__course-info__image img {
            max-width: 200px;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 0;
        }
        @media only screen and (max-width: 414px) {
            .student-cancel-email__course-info {
                font-size: 17px;

            }
        }
    </style>
</head>

<body>
<div class="student-cancel-email" >

    <div class="student-cancel-email__course-info" >
        <div class="student-cancel-email__course-info__item">
            ユーザー名 {{$fullName}} 様よりお問い合わせを正常に受け付けました。
        </div>
        <div class="student-cancel-email__course-info__item">
            メールアドレス： {{$email}}
        </div>
        <div class="student-cancel-email__course-info__item">
            種別： {{$type}}
        </div>
        <div class="student-cancel-email__course-info__item">
            件名： {{$subjectTitle}}
        </div>
        <div class="student-cancel-email__course-info__item">お問い合わせ内容:
            {{$contentInquiry}}
        </div>
        <div class="student-cancel-email__course-info__image">画像：<br> <a href="{{$urlImage}}"><img src="{{$urlImage}}"
                                                                                                   alt=""></a></div>
        <div class="student-cancel-email__course-info__item">
            お問い合わせの時間：{{Carbon\Carbon::now()->format('m')}}月{{Carbon\Carbon::now()->format('d')}}日 {{Carbon\Carbon::now()->format('H')}}:{{Carbon\Carbon::now()->format('i')}}
        </div>
    </div>
    <div>------------------------------------------------------------------------</div>
</div>
</body>
</html>
