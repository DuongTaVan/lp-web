@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/footer/user-guide.css')}}" rel="stylesheet">
@endsection
@section('header')
    <meta name="description" content="新規会員登録(購入者)・(出品者)">
    <title>ご利用ガイド</title>
@endsection
@section('content')
    <header class="user-guide-ft__header">
        <h1 class="title f-w6">ご利用ガイド</h1>
        <div class="hr"></div>
    </header>
    <div class="main">
        <div class="user-guide-ft">
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">新規会員登録(購入者)・(出品者)</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <a href="{{ route('client.guide-new-member') }}" class=""> 詳しくはこちら<img
                                        src="{{asset('assets/img/payment_method/icon-right-link.png')}}" alt="icon"
                                        width="10px"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">サービスを購入する</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <span>・サービスを探す</span>
                                <span>・出品者に質問する</span>
                                <span>・メッセージを確認する</span>
                                <span>・サービスを購入する</span>
                                <a href="{{ route('client.student-guide') }}" class="ml-15px ml-10px"> 詳しくはこちら<img
                                        src="{{asset('assets/img/payment_method/icon-right-link.png')}}" alt="icon"
                                        width="10px"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">キャンセルをする</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide block-content-user-guide-sp link-user-guide">
                                <div class="course-timing">
                                    <span> 購入者マイページ (販売中サービス) の一覧の、該当するサービスの中から（キャンセルをする）をクリックし完了</span>
                                    <span>※開催日前日２２：００以降は（キャンセルする）が表示されず（終了）が表示されます。</span>
                                </div>
                                <span>キャンセル画面は <a target="_blank"
                                                  href="{{route('client.student.my-page.order')}}">こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">開催日前日のリマインドメール</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <div class="d-flex">
                                    <div>・</div>
                                    <div class="course-timing">
                                        <span class="">開催日前日のリマインドメールで翌日開催の再案内を自動配信します。</span>
                                        (例文)　ご予約いただいたサービスの開催が明日となりましたのでご連絡いたしました。
                                    </div>
                                </div>

                                <div class="remind-mail">
                                    <div class="remind-mail__note"><span> ・</span>明日はこちらの（配信準備画面）のURLからご参加くださいね！
                                        ※開催時間１５分前から可能です。
                                    </div>
                                    <span class="remind-mail__link-note link-note-pc">Https//・・・・・・・・・・・・・・・・・・・・・・（配信準備画面）</span>
                                    <span
                                        class="remind-mail__link-note link-note-sp">Https//・・・・・・・・・・・・・（配信準備画面）</span>
                                    <div class="remind-mail__note"><span> ・ </span>購入者マイページからは（販売サービス管理）の（販売中サービス）画面より配信準備画面へ。
                                    </div>
                                    <span class="remind-mail__link-note link-note-pc">Https//・・・・・・・・・・・・・・・・・・・・・・（販売中サービス画面）</span>
                                    <span
                                        class="remind-mail__link-note link-note-sp">Https//・・・・・・・・・・（販売中サービス画面）</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">配信の開始方法（ライブ配信・ビデオ通話）</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <span class="f-w6">２種類の方法があります。 ※開催時間１５分前までは（配信準備画面）への入室はできません。</span>
                                <div class="d-flex">
                                    <span>１）</span><span>開催日前日に送られてくるリマインドメールにあるURLより（配信準備画面）へ入室</span>
                                </div>
                                <div class="d-flex">
                                    <span>２）</span><span>購入者マイページ（販売サービス管理）→（販売中サービス）→（準備画面へ）より入室</span>
                                </div>
                                <div class="d-flex ml-25px"><span>・</span>ライブ配信使用方法
                                    （バーチャル背景の設定・準備OKボタン・開始残り時間の表示、自動開始・開始時間遅延の場合の画面表示)
                                </div>
                                <div class="d-flex ml-25px"><span>・</span>ビデオ通話使用方法（ARエフェクトの設定・バーチャル背景の設定・準備OKボタン・開始残り時間の表示と自動開始・開始時間遅延の場合の画面表示）

                                </div>
                                <span>購入中サービス画面は <a target="_blank"
                                                    href="{{route('client.student.my-page.purchase-service')}}">こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">配信時の画面使用方法（教えて！ライブ配信）</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div>配信画面の見方（ライブ配信）</div>
                                <div><a target="_blank" href="{{route('client.delivery-screen-livestream')}}">
                                        詳しくはこちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">配信時の画面使用方法（オンライン悩み相談）</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div>配信画面（ビデオ通話）</div>
                                <div><a target="_blank" href="{{route('client.delivery-screen-video-call')}}">
                                        詳しくはこちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">配信時の画面使用方法（オンライン占い）</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div>配信画面（ビデオ通話）</div>
                                <a target="_blank" href="{{route('client.delivery-screen-fortune')}}">詳しくはこちら<img
                                        src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                        alt="icon"
                                        width="10px"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">評価する（レビューの投稿）</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <div class="d-flex"><span>・</span>終了後のサンクスメールのURLよりレビューを投稿してください。</div>
                                <div class="d-flex"><span>・</span>購入者マイページ（購入履歴・レビュー）のレビューの（評価する）よりを投稿してください。</div>
                                <div class="d-flex"><span>・</span>レビュー投稿ページ→（満足度５段階評価0.5〜５・レビュー本文の入力）</div>
                                <span class="ml-15px ml-13px">レビュー画面は <a target="_blank"
                                                                         href="{{route('client.student.my-page.review')}}"> こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">評価コメントのガイドライン</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <span>    Lappiは、全てのユーザーに対して透明性のあるプラットフォームを目指しています。</span>
                                <span>公開された評価コメントに対してLappi側で編集・削除などは原則行いません。</span>
                                <span>  ただし、利用規約に反する、または以下のような内容は確認され次第、編集・削除することがあります。</span>
                                <span class="d-flex"><span>・</span>	サービスと関係ないコメント</span>
                                <span class="d-flex"><span>・</span>	個人や団体の権利を侵害するコメント（公開していない本名、住所、その他身元が特定できる情報を無断で配信する行為）</span>
                                <span class="d-flex"><span>・</span>	誹謗中傷を含む内容でLappi事務局が問題であると判断したコメント</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">購入履歴を見る</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div class="d-flex"><span>・</span>購入者マイページ（販売履歴・レビュー）画面よりご参照して下さい。</div>
                                <div class="ml-15px"> 購入履歴画面は <a target="_blank"
                                                                 href="{{route('client.student.my-page.list')}}">
                                        こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">ダッシュボードを見る</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div class="d-flex"><span>・</span>ダッシュボードでは（購入サービス・メッセージ・レビュー・ポイント・クーポン・フォロー）の
                                    過去、現在の速報が表示がされます。
                                </div>
                                <div class="ml-15px"> プロフィール編集画面は<a target="_blank"
                                                                    href="{{route('client.student.my-page.dashboard')}}">
                                        こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">プロフィールを変更する (画像・自己紹介タイトル・自己紹介文)
                        </div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div class="user-guide-ft__content__service-listing__right__black link-user-guide">
                                <div class="d-flex"><span>・</span>購入者マイページ、サイドバーのトップの（プロフィール編集）より変更ができます</div>
                                <div class="ml-15px ml-10px"> プロフィール編集画面は <a target="_blank"
                                                                             href="{{route('client.teacher.mypage-teacher-profile-edit-nickname')}}">
                                        こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">
                            登録情報を変更する（ユーザー情報・パスワード・通知設定・カード情報の変更）
                        </div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <span>購入者マイページ（アカウント設定）より変更ができます。</span>
                                <span>・ユーザー情報　　：(メールアドレス・性別）の変更</span>
                                <span>・パスワード　　　：パスワードの変更</span>
                                <span>・通知設定　　　　：通知受信の設定変更</span>
                                <span>・クレジットカード：カード情報の変更</span>
                                <span class="ml-15px ml-13px">アカウント設定画面は<a target="_blank"
                                                                           href="{{route('client.student.my-page.account-setting')}}">こちら<img
                                            src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                            alt="icon"
                                            width="10px"></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-guide-ft__block">
                <div class="user-guide-ft__service-listing">
                    <div class="user-guide-ft__service-listing__left">
                        <div class="user-guide-ft__service-listing__left__one f-w6">Q.</div>
                        <div class="user-guide-ft__service-listing__left__two f-w6">安全の取り組み</div>
                    </div>
                    <div class="user-guide-ft__service-listing__three"><img
                            src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                            class="icon-dropdown-type"></div>
                </div>
                <div class="user-guide-ft__content">
                    <div class="user-guide-ft__content__service-listing__right">
                        <div class="rules">
                            <div class="user-guide-ft__content__service-listing__number f-w6">A.</div>
                            <div
                                class="user-guide-ft__content__service-listing__right__black block-content-user-guide link-user-guide">
                                <span class="f-w6 mb-10px">その1. 安心・安全の決済システム</span>
                                <span>Lappiでは、購入代金を一時的に運営側で預かり、取引終了後に出品者に支払われる仕組みを設けています。</span>
                                <span>これにより詐欺などのトラブルを防ぐ事ができます。</span>
                                <span>また、出品者は未払いのリスクがなく、取引終了後に確実に売上金を受け取ることができます。</span>
                                <span class="f-w6 mb-10px">その2. 出品者ランク制度の導入</span>
                                <span>Lappiでは、安心してお取引していただけるよう、ランク認定された出品者がいます。</span>
                                <span>出品者ランクは、開催実績、開催期間、レビュー評価の満足度をLappi独自の基準で評価し、</span>
                                <span>「ブロンズ」「シルバー」「ゴールド」「プラチナ」の4ランクを認定しています。</span>
                                <span class="f-w6 mb-5px">その3. 全ての出品者の本人確認書類の提出</span>
                                <span>Lappiでは全ての出品者が、指定した本人確認書類を必須で提出して頂いています。</span>
                                <span>サービスの購入時に不安なく、安心してお取引いただけます。</span>
                                <a target="_blank" href="{{route('client.safety-and-security')}}">詳しくはこちら<img
                                        src="{{asset('assets/img/payment_method/icon-right-link.png')}}"
                                        alt="icon"
                                        width="10px"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.user-guide-ft__content').hide();
            $('body').on('click', '.user-guide-ft__service-listing', function () {
                $(this).find('img').toggleClass('img-rotate'); //Add class to img tag.
                $(this).closest('.user-guide-ft__block').find('.user-guide-ft__content').slideToggle(); //Find element in block .
            })
        })
    </script>
@endsection
