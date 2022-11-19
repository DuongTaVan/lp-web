@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/usage_fee.css') }}" rel="stylesheet">
@endsection
@section('header')
    <meta name="description" content="登録料、掲載料は全て無料">
    <title>サービス手数料について</title>
@endsection
@section('content')
    <div class="banner-usage-fee">
        {{--        <div class="banner-usage-fee__content-outline">--}}
        {{--            <div class="banner-usage-fee__content-outline__text">--}}
        {{--                <span class="f-w6">サービス手数料について</span>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    <div class="main usage-fee-main">
        <div class="main usage-fee-main__title-page f-w6">サービス手数料について</div>
        <div class="usage-fee-main__outline">
            <div class="usage-fee-main__outline__paragraph">
                <div class="usage-fee-main__outline__paragraph__icon">
                    <img src="{{asset('assets/img/usage_fee/note-icon.png')}}" alt="">
                </div>
                <div class="usage-fee-main__outline__paragraph__content">
                    <div class="title f-w6">登録料、掲載料は<strong class="text-red-line f-w6">全て無料</strong></div>
                    <p>※売上が発生ない間は手数料も発生致しません。</p>
                </div>
            </div>
            <div class="usage-fee-main__outline__paragraph">
                <div class="usage-fee-main__outline__paragraph__icon">
                    <img src="{{asset('assets/img/usage_fee/note-icon.png')}}" alt="">
                </div>
                <div class="usage-fee-main__outline__paragraph__content">
                    <div class="title f-w6 lh-app">販売代金に対して<strong
                                class="text-red-line f-w6">２２％</strong>の手数料</div>
                    <p class="text-red-line coin-sales" style="margin-bottom: 5px">
                    <p>※別途１配信（１ユーザー毎）に50円(税別)システム利用料がかかります。</p>
                </div>
            </div>
            <div class="usage-fee-main__outline__paragraph">
                <div class="usage-fee-main__outline__paragraph__icon">
                    <img src="{{asset('assets/img/usage_fee/note-icon.png')}}" alt="">
                </div>
                <div class="usage-fee-main__outline__paragraph__content">
                    <div class="title f-w6 title-livestream holding-period-title">ライブ配信のコイン分配金は<strong
                                class="text-red-line f-w6">独自計算式により変動</strong></div>
                    <p class="holding-period">※独自計算式は公表しておりません。（開催実績・レビュー評価・開催期間）により変動致します。</p>
                    <p class="holding-period" style="font-size: 20px; color: #111; margin: 10px 0">ご自分でZoomなどのビデオ通話サービスの契約は必要ありません。</p>
                    <p class="holding-period" style="font-size: 14px; color: #EE3D48">※消費税は別途かかります。</p>
                    <p class="holding-period-app">
                        ※独自計算式は公表しておりません。
                        <br>
                        (開催実績・レビュー・開催期間）により
                        <br>
                        変動致します。
                    </p>
                    <p class="holding-period-app">
                        ご自分でZoomなどのビデオ通話サービスの契約は必要ありません。
                    </p>
                    <p class="holding-period-app" style="font-size: 14px; color: #EE3D48">
                        ※消費税は別途かかります。
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
