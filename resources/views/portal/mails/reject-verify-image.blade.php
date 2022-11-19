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
            font-style: normal;
        }

        .student-restock-email__title {
            font-size: 16px;;
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
            font-weight: bold;
        }

        .student-restock-email__course-info__item .text-title-bold {
            font-weight: bold;
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

        .student-restock-email__content .ml-15px {
            margin-left: 15px;
        }

        .student-restock-email__content__note {
            display: flex;
            margin-left: 5px;
        }

        .student-restock-email__content__note__body {
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

            .text-reject-image br {
                display: none !important;
            }

            .title-sp {
                display: block;
            }

            .title-pc {
                display: none !important;
            }

            .resident-card, .block-three {
                display: block !important;
            }

            .line-sp {
                display: block;
            }


            .student-restock-email {
                color: unset;
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

            .student-restock-email__content__note__body {
                font-size: 17px !important;
            }

            .block-sp {
                display: inline-table !important;
            }
        }
    </style>
</head>

<body>
<div class="student-restock-email">
    <p class="student-restock-email__title">
        {{$user_name}}さん
    </p>
    <div class="student-restock-email__text-note">
        <p style="margin: 0"> 本人確認審査が否認されましたのでお知らせいたします。</p>
        <p style="margin: 0" class="text-reject-image">下記理由の場合に承認ができない事がございますので<br style="display: none">再度ご確認の上、申請下さいますようお願いいたします。
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
                <span>・</span><span>登録情報の不備（登録情報と本人確認書類の内容が異なる）</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>本人確認書類の不備（利用不可の本人確認書類）</span>
            </p>
            <hr>
        </div>

        <p class="student-restock-email__course-info__title" style="margin: 0">
            【ご利用いいただける本人確認書類】
        </p>
        <div class="identity-block">
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>運転免許書/運転経歴証明書（表面・裏面）</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>健康保健所 （表面・裏面）</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>パスポート （顔写真入り・住所記載ページ）</span>
            </p>
            <p class="identity-block__content resident-card" style="margin: 0">
                <span>・住民票</span>
                <span class="text-note">※個人番号（マイナンバー）の記載された住民票は利用できません。</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>在留カード （表面・裏面</span>
            </p>
            <p class="identity-block__content" style="margin: 0">
                <span>・</span><span>国民年金手帳（住所記載ページ）</span>
            </p>
        </div>
        <hr>
        <p class="student-restock-email__course-info__title" style="margin: 0">
            再度ご確認の上、申請下さいますようお願いいたします。
        </p>
        <div class="identity-block">
            <p class="identity-block__content block-three" style="margin: 0">
                <span>本人確認書類の再提出は出品者マイページのアカウント設定画面</span>
                <span>の「本人確認書類」から再度アップロードして下さい。</span>
            </p>
        </div>
        <p class="student-restock-email__course-info__title" style="margin: 0">
            【本人確認書類変更する】画面はこちら
        </p>
        <a href="{{route('client.register')}}">{{route('client.register')}}</a>
        <hr>
    </div>
</div>
<div class="student-restock-email__content">
    <div class="student-restock-email__content__note">
        <div class="student-restock-email__content__note__body">
            <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br
                        style="display: none">お願い申し上げます。</p>
            <div class="block-sp">
                <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                <p class="title-sp" style="margin: 0">本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
            </div>
            <p style="margin: 0">ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</p>
        </div>
    </div>
    <hr>
    <p class="ml-15px">Lappiお問い合わせ窓口</p>
    <a class="ml-15px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
    <hr>
</div>

</body>
</html>
