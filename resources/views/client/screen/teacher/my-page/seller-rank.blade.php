@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/seller-rank.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }
    </style>
@endsection
@section('header')
    <meta name="description" content="Lappiでは、出品者の販売実績や購入者からの満足度を反映した独自の基準で評価を行いランク認定しています。">
    <title>出品者ランク</title>
@endsection
@section('content')
    <div class="seller-rank">
        <div class="seller-rank__banner">
            {{--            <div class="seller-rank__banner__content">--}}
            {{--                <div class="seller-rank__banner__content__background">--}}
            {{--                    <div class="seller-rank__banner__content__background__text">--}}
            {{--                        出品者ランク--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            {{--            </div>--}}
        </div>
        <div class="seller-rank__title">
            <div class="seller-rank__title__title-page f-w6">出品者ランク</div>
            <div class="seller-rank__title__one f-w3">
                Lappiでは、出品者の販売実績や購入者からの満足度を
            </div>
            <div class="seller-rank__title__two f-w3">
                反映した独自の基準で評価を行いランク認定しています。
            </div>

            <div class="seller-rank__title__one seller-rank__title__one-mobile f-w6">
                Lappiでは出品者の販売実績や、
            </div>
            <div class="seller-rank__title__one seller-rank__title__one-mobile f-w6">
                購入者からの満足度を
            </div>
            <div class="seller-rank__title__one seller-rank__title__one-mobile f-w6">
                反映した独自の基準で評価を行い、
            </div>
            <div class="seller-rank__title__two seller-rank__title__one-mobile f-w6">
                ランク認定しています。
            </div>
        </div>
        <div class="seller-rank-pc">
            <div class="seller-rank__content-one">
                <div class="seller-rank__content-one__title">
                    バッジ獲得の流れ
                </div>
                <div class="seller-rank__content-one__img"></div>
            </div>

            <div class="seller-rank__content-two">
                <div class="seller-rank__content-two__title">
                    ランク認定基準
                </div>
                <div class="seller-rank__content-two__img"></div>
                <div class="seller-rank__content-two__bottom">※バッジのランクアップは要件を達成した翌月1日に反映します。</div>
            </div>
        </div>
        <div class="seller-rank-mobile">
            <img src="{{ asset("assets/img/clients/teacher/guide-nine-background_02.png") }}" alt="">
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
