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
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .student-restock-email {
            color: #2A3242;
            font-style: normal;
            font-weight: 300;
        }

        .student-restock-email__title {
            font-size: 16px;
            margin: 20px 0 40px 12px;
        }

        .student-restock-email__text-note {
            font-size: 14px;
            margin-left: 10px;
            max-width: fit-content;
        }

        .student-restock-email__course-info {
            font-size: 11px;
            margin-left: 10px;
            font-weight: 300;
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
            font-size: 11px;
            line-height: 17px;
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
            /*display: flex;*/
            line-height: 17px;
            /*flex-direction: column;*/
        }

        .block-sp {
            display: flex;
            flex-direction: column;
        }

        @media only screen and (max-width: 414px) {
            .block-sp {
                display: inline-table !important;
            }
        }
    </style>
</head>

<body>
<div class="student-restock-email">
    <div class="student-restock-email__title">
        ニックネームさん
    </div>
    <div class="student-restock-email__text-note">
        メッセージメッセージメッセージメッセージメッセージメッセージメッセージ
        <br>
        メッセージメッセージメッセージメッセージメッセージメッセージメッセージ
        <br>
        メッセージメッセージメッセージメッセージメッセージメッセージメッセージ
    </div>
    <hr>
    <div class="student-restock-email__course-info">
        <div class="student-restock-email__course-info__title"> サービスの詳細</div>
    </div>
    <div>------------------------------------------------------------------------</div>
    <div class="student-restock-email__course-info">
        <div class="student-restock-email__course-info__item">キャンセル日時：12月25日</div>
        <div class="student-restock-email__course-info__item">出品者：ニックネームさん</div>
        <div class="student-restock-email__course-info__item">サービス：あああああああああああああああああああああああああああああああああ</div>
        <div class="student-restock-email__course-info__item">時間 : 12:00-12:30</div>
        <div class="student-restock-email__course-info__item">金額 ： 5,000円</div>
    </div>
    <div>------------------------------------------------------------------------</div>
    <div class="student-restock-email__course-info">
        <div class="student-cancel-email__course-info__note-review">・購入者マイページからは「購入中サービス」画面よりご確認下さい。</div>
        <div class="student-cancel-email__course-info__item">
            <span class="text-title-bold">【購入中サービス】</span>： <a
                    href="{{route('client.teacher.sale')}}"
                    target="_blank">{{route('client.teacher.sale')}}</a>
        </div>
    </div>
</div>
<div>------------------------------------------------------------------------</div>
<div class="student-restock-email__content">
    <div class="student-restock-email__content__note">
        <div class="student-restock-email__content__note__body">
            <div>※本メールに心当たりの無い方は大変お手数ですが本メールを破棄いただきますよう</div>
            <div>お願い申し上げます。</div>
            <div class="block-sp">
                <span>本メールアドレスは送信専用になります、本メールにご返信いただいても</span>
                <span>お答えできませんのでご了承ください。</span>
            </div>
            <div>ご不明な点ございましたらお手数ですが以下のメールアドレスにお問い合わせください。</div>
        </div>
    </div>
    <p>-------------------------------------------------------------------------------------------</p>
    <p class="ml-15px">Lappiお問い合わせ窓口</p>
    <a class="ml-15px" href="{{route('client.inquiry')}}" target="_blank">{{route('client.inquiry')}}</a>
    <p>-------------------------------------------------------------------------------------------</p>
</div>

</body>
</html>
