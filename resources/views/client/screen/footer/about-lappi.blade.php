@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/about-lappi.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-bottom: unset !important;
            padding-top: unset !important;
            min-height: unset !important;
        }

        .sub-title-point-three {
            color: #EE3D48;
            font-size: 14px;
        }
    </style>
@endsection
@section('header')
    <meta name="description" content="キャラクターがカエルのワケ？">
    <title>About Lappi</title>
@endsection
@section('content')
    <div class="about-lappi-wrap text-center">
        <label for="" class="label position-relative">
            <span class="f-w6">キャラクターがカエルのワケ？</span>
            {{--            <img src="{{asset('assets/img/about-lappi/label-bg.svg')}}" alt="">--}}
        </label>
        <header class="header">
            <div class="d-flex justify-content-center align-items-center header__wrap">
                <div class="header__introduce">
                    <h2 class="f-w6">幸運の象徴のカエルが幸せを運ぶ。</h2>
                    <h3 class="f-w6">（金運・健康運・仕事運・子宝・厄払いなど）</h3>
                    <h4 class="f-w6 mb-0">カエルは日本をはじめ、アジアやヨーロッパのたくさんの国々で縁起の良い幸運の象徴の動物として知られています。</h4>
                    @php
                        $isLogin = \Auth::guard('client')->check();
                        $userType = \Auth::guard('client')->user()->user_type ?? null;
                    @endphp
                    @if ($isLogin && $userType === \App\Enums\DBConstant::USER_TYPE_STUDENT)
                        <a class="display-off-sp" href="{{ route('client.become-lappi') }}" class="f-w6">新規会員登録へ</a>
                    @endif
                    @if (!$isLogin)
                        <a class="btn-register f-w6 text-center mt-4 display-off-sp"
                           href="{{ route('client.register') }}">新規会員登録へ</a>
                    @endif
                </div>
                <img src="{{asset('assets/img/about-lappi/header-img.png')}}" alt="">
            </div>
            <div class="button-sp">
                @php
                    $isLogin = \Auth::guard('client')->check();
                    $userType = \Auth::guard('client')->user()->user_type ?? null;
                @endphp
                @if ($isLogin && $userType === \App\Enums\DBConstant::USER_TYPE_STUDENT)
                    <a href="{{ route('client.become-lappi') }}" class="f-w6">新規会員登録へ</a>
                @endif
                @if (!$isLogin)
                    <a class="btn-register f-w6 text-center mt-4" href="{{ route('client.register') }}">新規会員登録へ</a>
                @endif
            </div>
        </header>
        <section class="content-wrap">
            <label for="" class="content-wrap__label position-relative">
                <span class="f-w6">サービスの特徴</span>
                {{--                <img src="{{asset('assets/img/about-lappi/label-content-bg.svg')}}" alt="">--}}
            </label>
            <div class="content-wrap__list">
                <div class="item-one">
                    <div class="wrap-content">
                        <div class="wrap-content__text f-w6 text-left">
                            <h1 class="f-w6">POINT 1</h1>
                            <h2 class="f-w6">３種類の中から今必要なサービスを選択！</h2>
                            <p class="text-black">教えて！ライブ配信 <span class="text-white">&nbsp;(ライブ配信による講座）</span></p>
                            <p class="text-white mb-2">※投げ銭機能アリ</p>
                            <p class="text-normal">幅広いジャンルから、あなたの今ある疑問や悩みを<br class="none-mobile">ライブ配信講座で解決しませんか。</p>
                            <p class="text-black">オンライン悩み相談<span class="text-white">&nbsp;&nbsp;(ビデオ通話1対1）</span></p>
                            <p class="text-normal">愚痴聞き、話し相手からカウンセリングまで幅広いジャンルで<br class="none-mobile">実体験や、知識豊富なカウンセラーがあなたの悩みを解決いたします。
                            </p>
                            <p class="text-black">オンライン悩み相談<span class="text-white">&nbsp;&nbsp;(ビデオ通話1対1）</span></p>
                            <p class="text-normal mb-0">電話やチャットではなく、オンラインでも対面ならではの<br class="none-mobile">本格占いで満足して頂ける占いを体験しませんか。
                            </p>
                        </div>
                        <div class="wrap-content__img">
                            <img src="{{asset('assets/img/about-lappi/point1.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="item-two">
                    <div class="wrap-content">
                        <div class="wrap-content__img">
                            <img src="{{asset('assets/img/about-lappi/point2.png')}}" alt="">
                        </div>
                        <div class="wrap-content__text f-w6 text-left">
                            <h1 class="f-w6">POINT 2</h1>
                            <p class="text-white">顔出しがイヤでも大丈夫！</p>
                            <p class="text-normal">ビデオ通話サービス（1対1)ではARエフェクトで顔出しNGでも大丈夫。<br class="none-mobile">スピリチュアル的に縁起の良いと言われている３種類の動物のオリジナル<br
                                        class="none-mobile">ARエフェクトを使って疑問、悩み、問題を解決しませんか！</p>
                            <div class="list-img f-w6">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/img/about-lappi/tho.png')}}" alt="">
                                    <span>ウサギ</span>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/img/about-lappi/khi.png')}}" alt="">
                                    <span>サル</span>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/img/about-lappi/cumeo.png')}}" alt="">
                                    <span>フクロウ</span>
                                </div>
                            </div>
                            <p class="note">※お部屋を隠したい場合はバーチャル背景もご利用できます。</p>
                        </div>
                    </div>
                </div>
                <div class="item-three">
                    <div class="wrap-content">
                        <div class="wrap-content__text f-w6 text-left">
                            <h1 class="f-w6">POINT 3</h1>
                            <h2 class="f-w6 d-flex flex-column">安心してサービスを受けたい！
                                <span class="sub-title-point-three f-w6">※出品者の方へ書類提出の依頼及び契約の締結を行っています。</span>
                            </h2>
                            <p>全ての出品者の本人確認書類の提出</p>
                            <p>資格保有の確認書類の提出：オンライン悩み相談</p>
                            <p class="d-flex flex-column">機密保持契約（NDA）：オンライン占いサービス<span
                                        class="text-note-nda">※出品者が知り得た機密情報を第三者に漏らさない事を決める契約です。</span></p>
                            {{--                            <p>全ての出品者の本人確認書類の提出</p>--}}
                            {{--                            <a class="link-detail" href="{{ route("client.safety-and-security") }}">詳しくはこちら</a>--}}
                        </div>
                        <div class="wrap-content__img">
                            <img src="{{asset('assets/img/about-lappi/point3.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
