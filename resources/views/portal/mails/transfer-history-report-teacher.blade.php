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
        {{ $teacher }}さん
    </p>
    <div class="course-end-email__text-note">
        <p style="margin: 0">受取口座の口座情報に誤りがあり振込が完了できませんでした。</p>
        <p style="margin: 0">正しい受取口座情報を入力し再申請してください。</p>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <p class="course-end-email__course-info__item" style="margin: 0">【口座情報を変更する】画面はこちら</p>
        <p style="margin: 0" href="{{ route('client.teacher.my-page.transfer-apply') }}"
           target="_blank">{{ route('client.teacher.my-page.transfer-apply') }}</p>
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
                    <p class="title-sp" style="margin: 0">
                        本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
                </div>
                <p style="margin: 0;">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
            </div>
        </div>
        <hr>
        <p class="ml-5px">Lappiお問い合わせ窓口</p>
        <a class="ml-5px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>

