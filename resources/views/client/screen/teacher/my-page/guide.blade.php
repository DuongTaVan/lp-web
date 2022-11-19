@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/guide.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }

        .teacher-guide__content__step__one__text-danger-mobile {
            padding-left: 30px;
        }

        @media only screen and (max-width: 414px) {
            .teacher-guide__content__step__one__text-danger-mobile {
                padding-left: unset;
            }
        }
    </style>


@endsection
@section('content')
    <div class="teacher-guide">
        <div class="teacher-guide__block">
            <div class="teacher-guide__block__title">
                <h1 class="teacher-guide__block__title__text mb-0 f-w6">サービスの出品（新規・再出品)</h1>
                <div class="teacher-guide__block__title__tag">
                    <div class="teacher-guide__block__title__tag__text"></div>
                </div>
            </div>

        </div>
        <div class="teacher-guide__content">
            <div class="teacher-guide__content__block">
                <div class="teacher-guide__content__block__title f-w6">配信のはじめ方</div>
                <div class="teacher-guide__content__block__note f-w6">(ライブ配信・ビデオ通話)</div>
            </div>
            <div class="teacher-guide__content__step">
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 1</div>
                    <div class="teacher-guide__content__step__one__note">出品者マイページの「販売サービス管理」<br class="none-pc">「販売中サービス」の「準備画面へ」より<br
                                class="none-pc"> <span>開催時間１５分前より</span>入室できます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/image46-guide.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-eight-img-first">
                        <img src="{{url('/assets/img/clients/teacher/image64.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 2</div>
                    <div class="teacher-guide__content__step__one__note">「新規サービスの作成」で選択した（顔出しOK・顔出しNG）のLappi
                        ARエフェクトが自動で装着されます。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger"> ※この画面から変更することはできません。</div>
                    <div class="teacher-guide__content__step__one__note">
                        下記の「背景変更」からバーチャル背景の選択、又はご自分のお気に入り画像もご利用することもできます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/image38.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-eight-img-second">
                        <img src="{{url('/assets/img/clients/teacher/image66.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 3</div>
                    <div class="teacher-guide__content__step__one__note">準備ができましたら「準備OK」ボタンを押し、開始までの残り時間が表示されます。</div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/image 38_alt.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-eight-img-first">
                        <img src="{{url('/assets/img/clients/teacher/image67.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger teacher-guide__content__step__one__text-danger-mobile">
                        ※万一出品者が開始時間に遅刻した場合は、出品者が<br class="none-pc">（準備OK)ボタンを押してから配信が開始します。
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 4</div>
                    <div class="teacher-guide__content__step__one__note">開始時間になりましたら自動で配信が開始します。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/image45-guide-fix.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-eight-img-first">
                        <img src="{{url('/assets/img/clients/teacher/image68-fix.svg')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 5</div>
                    <div class="teacher-guide__content__step__one__note">開始時間までに「ガイドライン禁止行為」をご確認ください。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/Group_6563.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-eight-img-second">
                        <img src="{{url('/assets/img/clients/teacher/image69-fix.svg')}}" alt="">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
