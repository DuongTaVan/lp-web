@extends('client.base.base')
@section('header')
@endsection
@section('css')
    <link href="{{ mix('css/clients/modules/footer/delivery-method.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div id="delivery-method">
        <div class="delivery-method">
            <div class="body">
                <header class="text-center">
                    <span class="title f-w6">配信開始方法の確認（出品者)</span>
                    {{--                     <div id="sub-title">--}}
                    {{--                         <span class="sub-title f-w6 fs-16">教えて！ライブ配信</span>--}}
                    {{--                         <span class="sub-title f-w6 fs-16">オンライン（悩み相談・占い)</span>--}}
                    {{--                     </div>--}}
                </header>

                <section class="body__content text-left">
                    <div id="step1">
                        <p class="step1 f-w6 fs-14">STEP 1</p>
                        <span class="fs-14" style="white-space: nowrap">購入者マイページの「購入中サービス」の配信「準備画面へ」より</span>
                        <span>開催時間１５分前より入室できます。</span>
                        <img class="image-step1" width="609px"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/image50.svg") }}" alt="">
                        <img class="image-step1--sp"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/image78.png") }}" alt="">
                    </div>
                    <div id="step2">
                        <p class="step2 f-w6 fs-14">STEP 2</p>
                        <span class=" ">「新規サービスの作成」で選択した（顔出しOK・顔出しNG）のARエフェクトが自動で装着されます。</span>
                        <span class="warning fs-14">※この画面から変更することはできません。</span>
                        <span class="fs-14">バーチャル背景の選択はご自分のお気に入りをご利用することもできます。</span>
                        <span class="fs-14">準備ができましたら「準備OK」ボタンを押す。</span>
                        <img class="image-step2 mb-20"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/delivery-method-step2-01-fix.svg") }}"
                             alt="">
                        <img class="image-step2--sp mb-20"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/image79.svg") }}" alt="">

                        <span class="fs-14">「開始までの残り時間」が表示され、お時間になると自動で開始いたします。</span>
                        <span class="warning fs-14">※開始時間までに「ガイドライン禁止行為」をご確認ください。</span>
                        <img class="image-step2"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/image52-fix.svg") }}" alt="">
                        <img class="image-step2--sp"
                             src="{{ asset("assets/img/clients/footer-common/tutorial-course/image77-fix.svg") }}" alt="">

                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
