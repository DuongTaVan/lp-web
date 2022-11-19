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
        .student-restock-email {
            /*color: #2A3242;*/
            font-style: normal;
        }

        .student-restock-email__title {
            font-size: 16px;;
            margin: 20px 0 10px 5px;
        }

        .student-restock-email__text-note {
            font-size: 14px;
            margin-left: 5px;
            max-width: fit-content;
        }

        .student-restock-email__course-info {
            font-size: 14px;
            margin-left: 5px;
            max-width: fit-content;
        }

        .student-restock-email__course-info__title {
            font-weight: 700;
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

        .ml-5px {
            margin-left: 5px;
        }

        .student-restock-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .student-restock-email__content__note__body {
        }

        .line-sp, .line-pc {
            margin-bottom: 10px;
        }

        .line-sp {
            display: none;
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

            .line-sp {
                display: block !important;
            }

            .line-pc {
                display: none !important;
            }

            .student-restock-email__content {
                font-size: 17px !important;
            }

            .student-restock-email__title {
                font-size: 20px !important;
            }

            .student-restock-email__text-note {
                font-size: 17px !important;
            }

            .student-restock-email__content__note__body {
                font-size: 17px !important;
            }

            .student-restock-email__course-info {
                font-size: 17px !important;
            }

            .block-sp {
                display: inline-table !important;
            }
        }

        hr {
            color: #2A3242;
        }
    </style>
</head>

<body>
<div class="student-restock-email">
    <p class="student-restock-email__title">
        {{$user_name}}さん
    </p>
    <div class="student-restock-email__text-note">
        <p style="margin: 0"> 資格証明書の確認手続きが完了しましたのでお知らせいたします。</p>
        <p class="title-pc" style="margin: 0; display: none"> サービスページのプロフィール画面に【資格保有】のバッジが表示されますので</p>
        <p class="title-pc" style="margin: 0; display: none"> ご提出いただきました資格内容をプロフィールに掲載して下さい。</p>
        <p class="title-sp" style="margin: 0"> サービスページのプロフィール画面に【資格保有】のバッジが表示されますので、ご提出いただきました資格内容をプロフィールに掲載して下さい。</p>
        <hr>
    </div>

    <div class="student-restock-email__course-info" style="margin-top: 10px">
        <p class="student-restock-email__course-info__title" style="margin: 0">【プロフィール編集】画面はこちら</p>
        <a href="{{route('client.teacher.mypage-teacher-profile-edit')}}"
           target="_blank">{{route('client.teacher.mypage-teacher-profile-edit')}}</a>
        <hr>
    </div>

</div>
<div class="student-restock-email__content">
    <div class="student-restock-email__content__note" style="margin-top: 10px">
        <div class="student-restock-email__content__note__body">
            <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br style="display: none">お願い申し上げます。
            </p>
            <div class="block-sp">
                <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
            </div>
            <div>ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</div>
        </div>
    </div>
    <hr>
    <p class="ml-5px">Lappiお問い合わせ窓口</p>
    <a class="ml-5px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
    <hr>
</div>

</body>
</html>
