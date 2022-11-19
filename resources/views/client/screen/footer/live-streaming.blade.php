@extends('client.base.base')
@section('header')
@endsection
@section('css')
    <link href="{{ mix('css/clients/modules/footer/live-streaming.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div id="live-streaming">
        <div class="live-streaming">
            <div class="col3">
                <div class="rectangle fs-14">
                    <div class="rectangle__description active d-flex align-items-center">
                        <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/icon-video.svg") }}" alt="">
                        <span class="f-w6 rectangle__description__text">ライブ配信開始方法</span>
                    </div>
                    <div class="rectangle__description">
                        <a href="{{route('client.video-call')}}">ビデオ通話開始方法</a>
                    </div>
                </div>
            </div>
            <div class="col9">
                <div class="body">
                    <header class="text-center">
                        <span class="title f-w6">配信開始方法の確認</span>
                        <span class="sub-title f-w6 fs-16">教えて！ライブ配信</span>
                    </header>

                    <section class="body__content text-left">
                        <div id="step1">
                            <p class="step1 f-w6 fs-14">STEP 1</p>
                            <span class="fs-14" style="white-space: nowrap">購入者マイページの「購入中サービス」の「準備画面へ」より開催時間１５分前より入室できます。</span>
                            <img class="image-step1 custom"  src="{{ asset("assets/img/clients/footer-common/tutorial-course/livestreaming-01.jpg") }}" alt="">
                            <img class="image-step1--sp" src="{{ asset("assets/img/clients/footer-common/tutorial-course/image72.png") }}" alt="">

                        </div>
                        <div id="step2">
                            <p class="step2 f-w6 fs-14">STEP 2</p>
                            <span class="fs-14">「準備OK」のボタンを押す。	</span>
                            <img class="image-step2 mb-25"  src="{{ asset("assets/img/clients/footer-common/tutorial-course/livestreaming-step2-1.svg") }}" alt="">
                            <img class="image-step2--sp mb-25" src="{{ asset("assets/img/clients/footer-common/tutorial-course/image73.png") }}" alt="">

                            <span class="fs-14">「開始までの残り時間」が表示され、お時間になると自動で開始いたします。</span>
                            <img class="image-step2" src="{{ asset("assets/img/clients/footer-common/tutorial-course/livestreaming-step2-2-fix.svg") }}" alt="">
                            <img class="image-step2--sp mb-25" src="{{ asset("assets/img/clients/footer-common/tutorial-course/image77-fix.svg") }}" alt="">

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
