@extends('client.base.base')
@section('header')
    <meta name="description" content="あなたもLappiになりませんか？">
    <title>Become Lappi</title>
@endsection
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/become.css') }}" rel="stylesheet">
    <style>
        .content-wrap {
            margin: 0 auto;
        }

        .layout-content {
            padding-bottom: unset !important;
            padding-top: unset !important;
            min-height: unset !important;
        }

        .become__header__content__text__black-custom {
            text-align: center;
        }

        .become__service__all__two span {
            color: #EE3D48;
            font-weight: 600;
            font-size: 20px;
        }

        .become__service__one {
            max-width: 500px;
            background-color: #fff;
            border-radius: 5px;
            border: 3px solid #cbc7c7;
        }

        @media only screen and (max-width: 414px) {
            .become__service__all__two span {
                font-weight: 300;
                font-size: 10px;
                line-height: 15px;
            }

            .become__service__all__one {
                font-size: 12px;
            }

            .layout-content {
                padding-bottom: 60px !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="become">
        <div class="become__header">
            <div class="become__header__content">
                <div class="become__header__content__icon">
                    <img src="{{url('/assets/img/clients/teacher/group5479.svg')}}" alt="">
                </div>
                <div class="become__header__content__icon-mobile">
                    <img src="{{url('/assets/img/clients/teacher/conechvaytay1.svg')}}" alt="">
                </div>
                <div class="become__header__content__text  ml-375">
                    <div class="become__header__content__text__title f-w6 text-center text-nowrap">あなたもLappiになりませんか？
                    </div>
                    <div class="become__header__content__text__black">オンラインサービス（ライブ配信・ビデオ通話）を通じて</div>
                    <div class="become__header__content__text__black">あなたの持っている知識や経験が「疑問・悩み・問題」を</div>
                    <div class="become__header__content__text__black"> 抱えているたくさんの人たちに共有することで解決し</div>
                    <div class="become__header__content__text__black">皆んながハッピーになれるお手伝いをしませんか！</div>
                    <div class="become__header__content__text__black-mobile">
                        オンラインサービス（ライブ配信・ビデオ通話）を通じて
                        あなたの持っている知識や経験が「疑問・悩み・問題」を
                        抱えているたくさんの人たちに共有することで解決し<br>
                        皆んながハッピーになれるお手伝いをしませんか！
                    </div>
                    <div class="become-btn">
                        @if(\Auth::guard('client')->check() && \Auth::guard('client')->user()->user_type === \App\Enums\Constant::CHECK_USER_TYPE)
                            <div class="become-btn__text">
                                <a href="{{route('client.teacher.register.setting-account',\Auth::guard('client')->user()->user_id )}}">出品者新規登録へ</a>
                            </div>
                        @elseif(\Auth::guard('client')->check() && \Auth::guard('client')->user()->user_type === \App\Enums\Constant::CHECK_TEACHER_TYPE)
                        @else
                            <div class="become-btn__text">
                                <a href="{{route('client.register')}}">出品者新規登録へ</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="become__content">
            <div class="become__content__bgr"></div>
        </div>
        <div class="become__option">
            <div class="become__option-one">
                <div class="become__option-one__left">
                    <div class="become__option-one__left__custom">
                        <div class="become__option-one__left__tooltip f-w6">最大の特徴
                            <div class="become__option-one__left__tooltip__rectangle"></div>
                        </div>
                    </div>

                    <div class="become__option-one__left__title f-w6">顔出しがイヤでも大丈夫！</div>
                    <div class="become__option-one__left__black f-w6">「独自配信システムが便利」</div>
                </div>
                <div class="become__option-one__right">
                    <div class="become__option-one__right__one">
                        <div class="become__option-one__right__one__number"> 1</div>
                        <div class="become__option-one__right__one__content">
                            <div class="become__option-one__right__one__content__black">全てのサービスで利用できるLappi</div>
                            <div class="become__option-one__right__one__content__black">ARエフェクトで顔出しNGでもOK。</div>
                        </div>
                    </div>
                    <div class="become__option-one__right__one">
                        <div class="become__option-one__right__one__number"> 2</div>
                        <div class="become__option-one__right__one__content">
                            <div class="become__option-one__right__one__content__black">お部屋を隠したい場合はバーチャル</div>
                            <div class="become__option-one__right__one__content__black">背景が便利。</div>
                        </div>
                    </div>
                    <div class="become__option-one__right__one become__option-one__right__one__custom">
                        <div class="become__option-one__right__one__number"> 3</div>
                        <div class="become__option-one__right__one__content">
                            <div class="become__option-one__right__one__content__black">（準備OKボタン）を押すだけで開始</div>
                            <div class="become__option-one__right__one__content__black">時間に自動で簡単スタート</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="become__type">
            <div class="become__type__title f-w6">３種類のサービス</div>
            <div class="become__type__all point-one-outline">
                <div class="become__type__left">
                    <div class="become__type__left__point">
                        <div class="become__type__left__point__one">POINT 1</div>
                        <div class="become__option-one__left__tooltip__rectangle "></div>
                    </div>
                </div>
                <div class="become__type__right">
                    <div class="become__type__right__content">
                        <div class="become__type__right__content__title f-w6">教えて！ライブ配信<br class="visible-mobile"><span
                                    class="negative-margin">（ライブ配信による講座）</span><span class="f-w6">※投げ銭機能アリ</span>
                        </div>
                        <div class="become__type__right__content__black-small mw-sp-278">
                            あなたの持っている知識や経験を生かしたライブ配信講座をやってみませんか
                        </div>
                        <div class="become__type__right__content__black types-of-monetization text-bold">
{{--                            ３種類のマネタイズ（ライブ配信のみ）--}}
                            ２種類のマネタイズ（ライブ配信のみ）
                        </div>
                    </div>
                </div>
            </div>
            <div class="become__type__table table-outline">
                <div class="become__type__table__all">
                    <div class="become__type__table__all__left f-w6">１）入場料</div>
                    <div class="become__type__table__all__right f-w6">1,000円〜5,000円までで設定<br class="visible-mobile"><span
                                class="negative-margin font-24 font-sp-10">（60分までの設定が可能）</span></div>
                </div>
{{--                <div class="become__type__table__all">--}}
{{--                    <div class="become__type__table__all__left f-w6"> ２）挙手　（質問）--}}
{{--                    </div>--}}
{{--                    <div class="become__type__table__all__right f-w6">１挙手20コイン（200円）</div>--}}
{{--                </div>--}}
                <div class="become__type__table__all">
                    <div class="become__type__table__all__left f-w6">２）投げ銭（フルーツ）</div>
                    <div class="become__type__table__all__right f-w6">10コイン（100円）〜500コイン（5,000円）</div>
                </div>
            </div>
            <div class="become__type__all point-two-outline">
                <div class="become__type__left">
                    <div class="become__type__left__point">
                        <div class="become__type__left__point__one">POINT 2</div>
                        <div class="become__option-one__left__tooltip__rectangle "></div>
                    </div>
                </div>
                <div class="become__type__right">
                    <div class="become__type__right__content">
                        <div class="become__type__right__content__title f-w6">オンライン悩み相談（ビデオ通話1対1）
                        </div>
                        <div class="become__type__right__content__black-small point-two">
                            <span>愚痴聞き、話し相手からカウンセリングまで幅広いジャンルで</span>
                            <span>資格保有の有無に関係なく、あなたの持っている経験や知識で</span>
                            <span>悩みを抱えている方達の解決のお手伝いをしませんか。</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="become__type__all">
                <div class="become__type__left">
                    <div class="become__type__left__point">
                        <div class="become__type__left__point__one">POINT 3</div>
                        <div class="become__option-one__left__tooltip__rectangle "></div>
                    </div>
                </div>
                <div class="become__type__right">
                    <div class="become__type__right__content">
                        <div class="become__type__right__content__title f-w6">オンライン占い　（ビデオ通話1対1）</div>
                        <div class="become__type__right__content__black-small point-two">
                            <span class="mw-672">電話やチャットではなく、オンラインでも対面ならではの本格占いで質の高い満足して頂ける占いを提供しませんか。</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="become__service-relative">
            <div class="become__service">
                <div class="become__service__title f-w6">サービス手数料について</div>
                <div class="become__service__all become__service__one">
                    <div class="become__service__one__all">
                        <div class="become__service__all__one f-w6"><span>今だけ手数料が10％に‼</span></div>
                        <div class="become__service__all__one text-center">全てのサービスが対象</div>
                        <div class="become__service__all__two text-center">※サービス開始日から<span>60日間限定</span></div>
                    </div>
                </div>
                <div class="become__service__all">
                    <div class="become__service__all__one f-w6">登録料、掲載料は <span class="f-w6">全て無料</span></div>
                    <div class="become__service__all__two text-center">※売上が発生しない間は手数料も発生致しません。</div>
                </div>
                <div class="become__service__all">
                    {{-- <div class="become__service__all__custom">
                        <div></div>
                        <div>（別途消費税はかかります）</div>
                    </div> --}}
                    <div class="become__service__all__one after-text f-w6 position-relative">販売代金に対して<span class="f-w6">２２％ </span>の手数料<span
                                class="small-black">(別途消費税はかかります)</span></div>
{{--                    <div class="become__service__all__two become__service__all__two--custom">--}}
{{--                        ※ライブ配信サービスのみ別途１配信に対し１ユーザー５０円 (税別)のシステム料がかかります。--}}
{{--                    </div>--}}
                    <div class="become__service__all__two become__service__all__two--custom">
                        ※別途１配信（１ユーザー毎）に50円(税別)システム利用料がかかります。
                    </div>
                </div>
                <div class="become__service__all">
                    <div class="become__service__all__one f-w6">ライブ配信のコイン分配金は<span class="f-w6">独自計算式により変動 </span></div>
                    <div class="become__service__all__two become__service__all__two--custom--02">※独自計算式は公表しておりません。<br
                                class="visible-mobile">（開催実績・レビュー評価・開催期間）により変動いたします。
                    </div>
                    <div class="become__service__all__danger f-w6">※ご自分でZOOMなどのビデオ通話サービスの契約は必要ありません。</div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function () {
            const heightDivBecomeService = $('.become__service').outerHeight() - 340;
            $('.become__service-relative').height(heightDivBecomeService);
        });
    </script>
@endsection
