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
            width: 445px;
        }

        .course-end-email__text-note > p {
            margin: 0;
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

        .course-end-email__content__note > p {
            margin: 0;

        }

        .course-end-email__content__note__body > p {
            margin: 0;
        }


        .block-sp {
            display: flex;
            flex-direction: column;
        }

        .line-sp {
            display: none;
        }

        hr {
            color: #2A3242;
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

            .course-end-email__text-note > br {
                display: none;
            }

            .line-sp {
                display: block;
            }

            .line-pc {
                display: none;
            }

            .course-end-email__title {
                font-size: 20px !important;
                margin: 20px 0 20px 12px;
            }

            .course-end-email__text-note {
                font-size: 17px !important;
                margin-left: 10px;
            }

            .course-end-email__course-info {
                font-size: 17px !important;
                margin-bottom: 10px;
                margin-left: 10px;
            }

            .course-end-email__content {
                font-size: 17px !important;
            }

            .block-sp {
                display: inline-table !important;
            }
        }
    </style>
</head>

<body>
<div class="course-end-email">
    <p class="course-end-email__title" style="">
        {{ $fullNameTeacher }}さん
    </p>

    <div class="course-end-email__text-note">
        <p style="margin: 0"> 新規サービスの申請が承認がされましたのでお知らせいたします。</p>
        <p>引き続きサービスの出品（編集画面）より新規サービスの作成 （STEP２,３）へ進みサービスを公開して下さい。</p>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <p class="course-end-email__course-info__title" style="margin: 0">サービスの出品【編集画面へ】はこちら</p>
        <a class="link-url"
           href="{{route('client.teacher.my-page.service-list', 'tab=new')}}">{{route('client.teacher.my-page.service-list', 'tab=new')}}</a>
        <hr>
    </div>

    <div class="course-end-email__content">
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
        <p class="ml-15px">Lappiお問い合わせ窓口</p>
        <a class="ml-15px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
