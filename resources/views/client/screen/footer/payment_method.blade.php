@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/about_payment_method.css') }}" rel="stylesheet">
    <style>
        .payment-method-main__title-page {
            margin-right: 95px;
        }

        .payment-method-main__outline--logo {
            display: flex;
            justify-content: space-between;
            margin: 70px 0 50px 0;
        }

        .payment-method-main__title {
            padding-left: 0;
        }

        .payment-method-main__outline__content:first-child {
            padding: 6px 90px 0 0;
            width: 565px;
        }

        .payment-method-main__outline__content:last-child {
            padding: 6px 30px 0 55px;
        }

        .payment-method-main__image img {
            max-height: 50px;
        }

        .payment-method-main__image {
            width: 95%;
            padding: 10px 20px;
            margin-top: unset;
        }

        .all_bank {
            width: 50%;
            padding-left: 25px;
            padding-right: 65px;
        }

        @media only screen and (max-width: 414px) {
            .payment-method-main__title-page {
                margin-right: unset;
            }

            .payment-method-main__outline--logo {
                display: block;
                margin: unset;
            }

            .payment-method-main__image {
                width: 100%;
                margin: 10px 0;
                padding: 20px 25px
            }

            .all_bank {
                width: 100%;
                padding-left: unset;
                padding-right: unset;

            }

            .payment-method-main__outline__content:last-child {
                padding: 6px 40px 0 0;
            }
            .payment-method-main__outline__content:first-child {
                width: unset;
            }
            .payment-method-main__outline__content h1 {
                margin-bottom: 20px;
            }
        }

    </style>
@endsection
@section('header')
    <meta name="description" content="クレジットカード（デビットカード)VISA / Master / AMEXがご利用いただけます。有効期限が切れているクレジットカードはご利用できません。">
    <title>お支払い方法</title>
@endsection
@section('content')
    <div class="banner-payment-method">
        {{--        <div class="banner-payment-method__content-outline">--}}
        {{--            <div class="banner-payment-method__content-outline__text">--}}
        {{--                <span class="f-w6">お支払い方法</span>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    <div class="main payment-method-main">
        <div class="main payment-method-main__title-page f-w6">お支払い方法</div>
        <div class="payment-method-main__outline--logo">
            <div class="payment-method-main__title">
                <h1 class="f-w6">クレジットカード（デビットカード)</h1>
                <p>VISA / Master / AMEXがご利用いただけます。<br>
                    有効期限が切れているクレジットカードはご利用できません。 </p>
            </div>
            <div class="all_bank">
                <div class="payment-method-main__image">
                    <img src="{{asset('assets/img/payment_method/visa.png')}}" alt="visa">
                    <img src="{{asset('assets/img/payment_method/master_card.png')}}" alt="master_card">
                    {{--            <img src="{{asset('assets/img/payment_method/jcb.png')}}" alt="jcb">--}}
                    <img src="{{asset('assets/img/payment_method/ae.png')}}" alt="ae">
                    {{--            <img src="{{asset('assets/img/payment_method/dc.png')}}" alt="dc">--}}
                </div>
            </div>

        </div>

        <div class="payment-method-main__outline">
            <div class="payment-method-main__outline__content">
                <h1 class="f-w6">クレジットカードをお持ちでない場合</h1>
                <ul>
                    <li><strong class="f-w6">プリペイドVISAカードはクレジットカード同様にお使いいただけます。</strong></li>
                    <li>VISAプリペイドカード / VANDOLECARD (バンドルカード）<a href="https://vandle.jp/hello/app-description/"
                                                               target="_blank">について
                            <img src="{{asset('assets/img/payment_method/icon-right-link.png')}}" alt="" width="10"></a>
                    </li>
                    <li>※審査や年齢制限もなく、アプリから会員登録により作成できます。</li>
                    <li>VANDLECARD（バンドルカード）の <a href="https://vandle.jp/hello/app-usage-register/" target="_blank">登録・ご利用方法はこちら<img
                                    src="{{asset('assets/img/payment_method/icon-right-link.png')}}" alt="" width="10"></a>
                    </li>
                </ul>
            </div>
            <div class="payment-method-main__outline__content">
                <h1 class="f-w6">クレジットカード払いの安全性について</h1>
                <ul>
                    <li><strong class="f-w6">クレジットカードは以下の決済代行会社が提供するサービスを採用しております。</strong></li>
                    <li>世界４６ヵ国以上で利用されている（stripe) <a href="https://stripe.com/jp" target="_blank">ストライプジャンパン株式会社<img
                                    src="{{asset('assets/img/payment_method/icon-right-link.png')}}" alt="" width="10"></a>
                    </li>
                    <li>VISA / Master / AMEX</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
