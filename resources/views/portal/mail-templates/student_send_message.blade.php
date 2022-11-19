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
            margin-left: 10px;
            max-width: fit-content;
        }

        .course-end-email__course-info {
            font-size: 14px;
            margin-bottom: 10px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .course-end-email__course-info__title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .course-end-email__course-info__note-review {
            margin-top: 10px;
        }

        .course-end-email__content {
            font-size: 14px;
            max-width: fit-content;
        }

        .course-end-email__content > p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .course-end-email__content .mb-10px {
            margin-bottom: 10px;
        }

        .course-end-email__content .ml-15px {
            margin-left: 15px;
        }

        .course-end-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .course-end-email__content__note__body {
            /*display: flex;*/
            /*flex-direction: column;*/
        }

        .font-course-end {
            font-size: 16px;
        }

        .link-url {
            margin-left: 15px;
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

            .font-course-end {
                font-size: 20px !important;
            }

            .course-end-email__title {
                font-size: 20px !important;

            }

            .course-end-email__text-note {
                font-size: 17px !important;
            }

            .course-end-email__course-info {
                font-size: 17px !important;
            }

            .course-end-email__content {
                font-size: 17px !important;
            }

            .block-sp {
                display: inline-table !important;
            }
        }

        .fit-content {
            max-width: fit-content;
        }

        .unset-text {
            max-width: unset;
        }
    </style>
</head>

<body>
<div class="course-end-email">
    <p style="" class="course-end-email__title">
        {{ $fullName }}さん
    </p>
    <div class="course-end-email__text-note">
        <p style="margin: 0;">{{$fullNameStudent}}さんから質問がありました。</p>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <p style="margin: 0;" class="course-end-email__course-info__title">メッセージ内容</p>
        <hr>
        <div class="course-end-email__course-info__item unset-text">
            <p style="margin: 0;">{!! $messageDetail !!}</p>
            <hr>
        </div>
    </div>
    <div class="course-end-email__course-info">
        <p style="margin: 0;" class="course-end-email__course-info__title">下記のURLからご確認ください。</p>
        <div class="course-end-email__course-info__item">
            <a href="{{route('client.teacher.my-page.message.inquiry-list')}}">{{route('client.teacher.my-page.message.inquiry-list')}}</a>
        </div>
        <hr>
    </div>

    <div class="course-end-email__content">
        <div class="course-end-email__content__note">
            <div class="course-end-email__content__note__body">
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
        <p class="ml-15px">Lappiお問い合わせ窓口</p>
        <a class="ml-15px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
