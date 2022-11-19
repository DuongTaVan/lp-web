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

        .course-end-email__content .ml-5px {
            margin-left: 5px;
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

        .text-reject-course br {
            display: block !important;
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

            .text-reject-course br {
                display: none !important;
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
                margin-left: 5px;
            }

            .block-sp {
                display: inline-table !important;
            }


        }
    </style>
</head>

<body>
<div class="course-end-email">
    <p class="course-end-email__title">
        {{ $fullName }}さん
    </p>
    <div class="course-end-email__text-note">
        <p style="margin: 0"> 新規サービスの申請が否認されましたのでお知らせいたします。</p>
        <p style="margin: 0" class="text-reject-course"> 下記の「出品者ガイドライン」をご参照頂き<br style="display: none">公開申請をお断りする場合をご確認ください。
        </p>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <p class="course-end-email__course-info__title" style="margin: 0 0 5px 0">【出品者ガイドライン】はこちら</p>
        <a href="{{route('client.seller-guidelines')}}">{{route('client.seller-guidelines')}}</a>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <p class="course-end-email__course-info__title" style="margin: 0 0 5px 0">再度ご確認の上、申請下さいますようお願いいたします。</p>
        <p class="title-pc" style="margin: 0; display: none">
            新規サービスの再申請は出品者マイページの販売サービス管理画面
        </p>
        <p class="title-pc" style="margin: 0; display: none">
            の「＋新規サービス作成」から再度サービスを作成して承認申請して下さい。
        </p>
        <p class="title-sp" style="margin: 0">
            新規サービスの再申請は出品者マイページの販売サービス管理画面の「＋新規サービス作成」から再度サービスを作成して承認申請して下さい。
        </p>
        <p class="course-end-email__course-info__title" style="margin: 0 0 5px 0">【＋新規サービス作成】画面はこちら</p>
        <a href="{{route('client.teacher.my-page.service-list', 'tab=clone')}}">{{route('client.teacher.my-page.service-list', 'tab=clone')}}</a>

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
        <p class="ml-5px">Lappiお問い合わせ窓口</p>
        <a class="ml-5px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
