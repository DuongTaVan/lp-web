@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/safety_security.css') }}" rel="stylesheet">
@endsection
@section('header')
    <meta name="description" content="その1. 安心・安全の決済システム">
    <title>安心・安全の理由</title>
@endsection
@section('content')
    <div class="banner-safe-security">
        <img src="{{asset('assets/img/safe_security/banner-safety-security.png')}}" alt=""
             class="banner-safe-security__image-pc">
        <img src="{{asset('assets/img/safe_security/banner-safety-security-sp.jpg')}}" alt=""
             class="banner-safe-security__image-sp">
    </div>
    <div class="main safety-security">
        <div class="main safety-security__title-page f-w6">安心・安全の理由</div>
        <div class="safety-security__part-one">
            <div class="safety-security__part-one__content">
                <h1 class="f-w6 safety-security__part-one__content__title">その1. 安心・安全の決済システム</h1>
                <p class="safety-security__part-one__content__body">
                    Lappiでは、購入代金を一時的に運営側で預かり、取引終了後に出品者に支払われる仕組みを設けています。<br>
                    これにより詐欺などのトラブルを防ぐ事ができます。<br>
                    また、出品者は未払いのリスクがなく、取引終了後に確実に売上金を受け取ることができます。
                </p>
            </div>
        </div>
        <div class="safety-security__part-two">
            <div class="safety-security__part-two__content">
                <h1 class="f-w6 safety-security__part-two__content__title">その2. 出品者ランク制度の導入 </h1>
                <p class="safety-security__part-two__content__body content-two">
                    Lappiでは、安心してお取引していただけるよう、ランク認定された出品者がいます。<br>
                    <strong> <span>出品者ランクは、開催実績、開催期間、レビュー評価の満足度をLappi独自の基準で評価し、</span> <span> 「ブロンズ」「シルバー」「ゴールド」「プラチナ」の4ランクを認定しています。</span></strong>

                </p>
                <div class="f-w6 safety-security__part-two__content__image">
                    <div class="rank-outline">
                        <img src="{{asset('assets/img/safe_security/bronze.png')}}" alt="">
                        <div class="name-rank">ブロンズ</div>
                    </div>
                    <div class="polygon"><img src="{{asset('assets/img/safe_security/polygon.png')}}" alt=""></div>
                    <div class="rank-outline">
                        <img src="{{asset('assets/img/safe_security/silver.png')}}" alt="">
                        <div class="name-rank">シルバー</div>
                    </div>
                    <div class="polygon"><img src="{{asset('assets/img/safe_security/polygon.png')}}" alt=""></div>
                    <div class="rank-outline">
                        <img src="{{asset('assets/img/safe_security/gold.png')}}" alt="">
                        <div class="name-rank">ゴールド</div>
                    </div>
                    <div class="polygon"><img src="{{asset('assets/img/safe_security/polygon.png')}}" alt=""></div>
                    <div class="rank-outline">
                        <img src="{{asset('assets/img/safe_security/platium.png')}}" alt="">
                        <div class="name-rank">プラチナ</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="safety-security__part-three">
            <div class="safety-security__part-three__content">
                <h1 class="f-w6 safety-security__part-three__content__title">
                    その3. 全ての出品者の本人確認書類の提出
                </h1>
                <p class="safety-security__part-three__content__body">
                    Lappiでは全ての出品者が、指定した本人確認書類を必須で提出して頂いています。<br>
                    サービスの購入時に不安なく安心してお取引いただけます。
                </p>
                <div class="f-w6 safety-security__part-three__content__image">
                    <div class="outline">
                        <img src="{{asset('assets/img/safe_security/identification.png')}}" alt="">
                        <div class="name-achievement">本人確認</div>
                    </div>
                    <div class="outline">
                        <img src="{{asset('assets/img/safe_security/nda.png')}}" alt="">
                        <div class="name-achievement"> 機密保持契約(NDA)</div>
                    </div>
                    <div class="outline">
                        <img src="{{asset('assets/img/safe_security/qh.png')}}" alt="">
                        <div class="name-achievement">資格保有</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
