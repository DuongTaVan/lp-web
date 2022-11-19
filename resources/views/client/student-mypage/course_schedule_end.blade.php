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
        {{ $data['username'] }}さん
    </p>
    <div class="course-end-email__text-note">
        <p style="margin: 0"> 本日はご利用ありがとうございました。</p>
        <p style="margin: 0"> ご利用サービスはご満足いただけましたでしょうか？</p>
        <p style="margin: 0"> またのご利用を楽しみにお待ちしています。</p>
        <p style="margin: 0"> 本日のサービスの感想を頂けましたら幸いです。</p>
        <p style="margin: 0"> 今後のサービスの改善の為にレビュー投稿にご協力お願いします。</p>
        <hr>
    </div>
    <div class="course-end-email__course-info">
        <div class="fit-content">
            <p class="course-end-email__course-info__title" style="margin: 0">購入サービスの詳細</p>
            <hr>
        </div>
        <div class="fit-content">
            <p style="margin: 0">サービス： {{ $data['title'] }}</p>
            <p style="margin: 0">開催日： {{ $data['date'] }}</p>
            <p style="margin: 0">時間 : {{ $data['time'] }}</p>
            <p style="margin: 0">金額 ： {{ number_format($data['price']) }}円</p>
            <hr>
        </div>
        <p class="course-end-email__course-info__note-review" style="margin: 0">・レビュー投稿は下記URLレビュー画面の「評価する」よりお願いします。</p>
        <p class="course-end-email__course-info__title" style="margin: 0">【レビュー画面】はこちら</p>
        <a class="link-course-end"
           href="{{route('client.student.my-page.review')}}"
           target="_blank">{{route('client.student.my-page.review')}}</a>
    </div>
    @if(isset($data['subCourse']) && count($data['subCourse'])>0)
        <div class="course-end-email__course-info">
            <p class="course-end-email__course-info__title" style="margin: 0">★★★ 受講者限定サービス！★★★</p>
            <p class="course-end-email__course-info__title" style="margin: 0">もっと詳しくお聞きしたい方は</p>
            <p class="course-end-email__course-info__title" style="margin: 0">個別講座（ビデオ通話1対1）をご利用くださいね！</p>
            <div class="course-end-email__course-info__item">
                <p class="course-end-email__course-info__title" style="margin: 0">【日程を見る】</p>
                <a class="link-course-end"
                   href="{{route('client.student.student-join-course.pay-extent',$data['courseScheduleId'])}}"
                   target="_blank">{{route('client.student.student-join-course.pay-extent',$data['courseScheduleId'])}}</a>
            </div>
        </div>
    @endif
    <div class="course-end-email__content">
        <hr>
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
