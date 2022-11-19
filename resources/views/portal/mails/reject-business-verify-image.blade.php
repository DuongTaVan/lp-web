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

        .student-restock-email__course-info {
            font-size: 14px;
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
            line-height: 17px;
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
            line-height: 19px;
        }

        .line-sp, .line-pc {

        }

        .line-sp {
            display: none;
        }

        .identity-block .identity-block__content {
            display: flex;
        }

        .resident-card, .block-three {
            display: flex;
            flex-direction: column;
        }

        .resident-card .text-note {
            color: red;
        }

        .block-sp {
            display: flex;
            flex-direction: column;
        }

        .text-reject-image br {
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

            .text-reject-image br {
                display: none !important;
            }

            .resident-card, .block-three {
                display: block !important;
            }

            .line-sp {
                display: block !important;
            }

            .line-pc {
                display: none !important;
            }

            .student-restock-email__title {
                font-size: 20px !important;
            }

            .student-restock-email__content {
                font-size: 17px !important;
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
        <p style="margin: 0"> 資格証明書確認の審査否認のお知らせいたします。</p>
        <p style="margin: 0" class="text-reject-image">下記理由の場合に承認ができない事がございますので<br style="display:none;">再度ご確認の上、申請下さいますようお願いいたします。
        </p>
        <hr>
    </div>

    <div class="student-restock-email__course-info" style="margin-top: 10px">
        <p class="student-restock-email__course-info__title" style="margin: 0"> 【承認ができない場合】</p>
        <div class="identity-block">
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>書類がアップロード画面からはみ出している</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>アップロード画像が不鮮明（手ブレ・ピンボケ・光の反射）</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>資格証明書として確認できない場合</span>
            </p>
            <hr>
        </div>
        <p class="student-restock-email__course-info__title" style="margin: 0">再度ご確認の上、申請下さいますようお願いいたします。</p>
        <div class="identity-block">
            <p class="identity-block__content block-three" style="margin: 0">
                <span>資格証明書の再提出は出品者マイページのアカウント設定画面</span>
                <span>の「資格証明書」から再度アップロードして下さい。</span>
            </p>
        </div>
        <p class="student-restock-email__course-info__title" style="margin: 0">【資格証明書変更する】画面はこちら</p>
        <a class="ml-5px"
           href="{{route('client.teacher.mypage-teacher-settingAccount')}}">{{route('client.teacher.mypage-teacher-settingAccount')}}</a>
        <hr>
    </div>
</div>
<div class="student-restock-email__content">
    <div class="course-end-email__content__note">
        <div class="course-end-email__content__note__body">
            <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br
                        style="display: none">お願い申し上げます。</p>
            <div class="block-sp" style="margin: 0">
                <span>本メールアドレスは送信専用になります、本メールにご返信いただいても</span>
                <span>お答えできませんのでご了承ください。</span>
            </div>
            <div style="margin: 0">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</div>
        </div>
    </div>
    <hr>
    <p class="ml-5px">Lappiお問い合わせ窓口</p>
    <a class="ml-5px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
    <hr>
</div>

</body>
</html>
