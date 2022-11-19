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
            margin: 20px 0;
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

        /*.course-end-email__course-info__note-review {*/
        /*    margin-top: 10px;*/
        /*}*/

        .course-end-email__content {
            font-size: 14px;
            max-width: fit-content;
            margin-left: 10px;
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

        .link-course-end {
            text-decoration: none;
        }

        .font-course-end {
            font-size: 16px;
        }

        .line-sp, .line-pc {
        }

        .line-pc {
            margin-bottom: 0;
            margin-top: 0;
            margin-left: 5px;
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
                display: block;
            }

            .line-pc {
                display: none;
            }

            .course-end-email__content {
                font-size: 17px !important;
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

            .course-end-email__content__note {
                font-size: 17px !important;
            }

            .block-sp {
                display: inline-table !important;
            }
        }

        .fit-content {
            max-width: fit-content;
        }
    </style>
</head>

<body>
<div class="course-end-email">
    <p class="course-end-email__title">
        {{ $fullName }}さん
    </p>
    @if($status)
        <div class="course-end-email__text-note">
            <p style="margin: 0"> 本人確認の手続きが完了しましたのでお知らせいたします。</p>
            <p style="margin: 0"> 新規サービスの作成よりサービスの公開ができます。</p>
            <hr>
        </div>
        <div class="course-end-email__course-info">
            <div class="fit-content">
                <p class="course-end-email__course-info__title" style="margin: 0">【＋新規サービスの作成】はこちら</p>
                <hr>
            </div>
            <div>
                <a href="{{route('client.teacher.my-page.service-list', 'tab=clone')}}"
                   style="margin: 0">{{route('client.teacher.my-page.service-list', 'tab=clone')}}</a>
            </div>
        </div>
    @else
        <div class="course-end-email__text-note">
            <p style="margin: 0"> 本人確認審査が否認されましたのでお知らせいたします。</p>
            <p style="margin: 0"> 下記理由の場合に承認ができない事がございますので </p>
            <p style="margin: 0"> 再度ご確認の上、申請下さいますようお願いいたします。</p>
            <hr>
        </div>
        <div class="course-end-email__course-info">
            <div class="fit-content">
                <p class="course-end-email__course-info__title" style="margin: 0">【承認ができない場合】</p>
            </div>
            <div class="fit-content">
                <p style="margin: 0">・書類がアップロード画面からはみ出している</p>
                <p style="margin: 0">・アップロード画像が不鮮明（手ブレ・ピンボケ・光の反射）</p>
                <p style="margin: 0">・登録情報の不備（登録情報と本人確認書類の内容が異なる）</p>
                <p style="margin: 0">・本人確認書類の不備（利用不可の本人確認書類）</p>
                <hr>
            </div>
            <div class="fit-content">
                <p class="course-end-email__course-info__title" style="margin: 0">【ご利用いいただける本人確認書類】</p>
            </div>
            <div>
                <p style="margin: 0">・運転免許書/運転経歴証明書（表面・裏面）</p>
                <p style="margin: 0">・健康保健所 （表面・裏面）</p>
                <p style="margin: 0">・パスポート （顔写真入り・住所記載ページ）</p>
                <p style="margin: 0">・住民票</p>
                <p style="margin: 0">※個人番号（マイナンバー）の記載された住民票は利用できません。</p>
                <p style="margin: 0">・在留カード （表面・裏面）</p>
                <p style="margin: 0">・国民年金手帳（住所記載ページ）</p>
                <hr>
            </div>

            <div class="fit-content">
                <p class="course-end-email__course-info__title" style="margin: 0">
                    再度ご確認の上、申請下さいますようお願いいたします。</p>
            </div>
            <div>
                <p style="margin: 0">本人確認書類の再提出は出品者マイページのアカウント設定画面</p>
                <p style="margin: 0">の「本人確認書類」から再度アップロードして下さい。</p>
                <hr>
            </div>

            <div class="fit-content">
                <p class="course-end-email__course-info__title" style="margin: 0">【本人確認書類変更する】画面はこちら</p>
            </div>
            <div>
                <a href="{{route('client.register')}}" style="margin: 0">{{route('client.register')}}</a>
            </div>
        </div>
    @endif
    <div class="course-end-email__content">
        <hr>
        <div class="student-restock-email__content__note" style="margin-top: 10px">
            <div class="student-restock-email__content__note__body">
                <p style="margin: 0" class="text-inquiry">※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう<br
                            style="display: none">お願い申し上げます。
                </p>
                <div class="block-sp">
                    <p class="title-pc" style="margin: 0; display: none">本メールアドレスは送信専用になります、本メールにご返信いただいても</p>
                    <p class="title-pc" style="margin: 0; display: none">お答えできませんのでご了承ください。</p>
                    <p class="title-sp" style="margin: 0">
                        本メールアドレスは送信専用になります、本メールにご返信いただいてもお答えできませんのでご了承ください。</p>
                </div>
                <div>ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</div>
            </div>
        </div>
        <hr>
        <p>Lappiお問い合わせ窓口</p>
        <a href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
        <hr>
    </div>
</div>
</body>
</html>
