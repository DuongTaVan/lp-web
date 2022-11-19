@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/seller.css') }}" rel="stylesheet">
    <style>
        .seller-user-guide__service-listing__left__one__custom {
            display: flex;
        }

        .text-custom-user-1 {
            margin-left: 15px;
        }

        .text-custom-user-2 {
            margin-left: 5px;
        }

        .seller-user-guide__content__service-listing__right__black {
            display: flex;
            align-items: center;
        }

        .all-time {
            margin-right: 15px;
        }

        @media only screen and (max-width: 414px) {
            .seller-user-guide__content__service-listing__right__black {
                display: block;
            }

            .img-arrow {
                text-align: center;
                margin-right: 95px;
            }

            .img-arrow img {
                transform: rotate(90deg);
                width: 11%;
            }

            .seller-user-guide__service-listing__left__custom {
                display: block;
            }

            .seller-user-guide__content__service-listing__right__black__custom {
                font-style: normal;
                font-weight: 300;
                font-size: 12px;
            }

            .seller-user-guide__content__service-listing__right__content {
                margin-left: 10px;
            }


        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__content seller-user-guide">
                <div class="seller-user-guide__title">出品者ご利用ガイド</div>
                <div class="seller-user-guide__block">
                    <div class="seller-user-guide__service-listing">
                        <div class="seller-user-guide__service-listing__left">
                            <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                            <div class="seller-user-guide__service-listing__left__two f-w6">サービスの出品（新規・再出品)</div>
                        </div>
                        <div class="seller-user-guide__service-listing__three"><img
                                    src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                    class="icon-dropdown-type"></div>
                    </div>
                    <div class="seller-user-guide__toogle">
                        <div class="seller-user-guide__content">
                            <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                            <div class="seller-user-guide__content__service-listing__right">
                                <div class="seller-user-guide__content__service-listing__right__green"><a
                                            href="{{route('client.teacher-guide')}}" target="_blank">詳しくはこちら</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="seller-user-guide__block">
                    <div class="seller-user-guide__service-listing">
                        <div class="seller-user-guide__service-listing__left seller-user-guide__service-listing__left__custom">
                            <div class="seller-user-guide__service-listing__left__one seller-user-guide__service-listing__left__one__custom">
                                <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                                <div class="seller-user-guide__service-listing__left__two f-w6">ソーシャルシェアボタンの活用</div>
                            </div>

                            <div class="seller-user-guide__service-listing__left__three f-w6">
                                お使いのSNSから集客（Facebook・Twitter・LINE)
                            </div>
                        </div>
                        <div class="seller-user-guide__service-listing__three"><img
                                    src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                    class="icon-dropdown-type"></div>
                    </div>
                    <div class="seller-user-guide__toogle">
                        <div class="seller-user-guide__content">
                            <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                            <div class="seller-user-guide__content__service-listing__right">
                                <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                    <span>・</span>
                                    <span>ソーシャルシェアボタンで、自身のSNSでサービスの告知を（Facebook・Twitter・LINE）</span>
                                </div>
                                <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__danger">
                                    ※ソーシャルシェアボタンがある、全てのページからお使いできます。
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="seller-user-guide__block">
                    <div class="seller-user-guide__service-listing">
                        <div class="seller-user-guide__service-listing__left seller-user-guide__service-listing__left__custom">
                            <div class="seller-user-guide__service-listing__left__one seller-user-guide__service-listing__left__one__custom">
                                <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                                <div class="seller-user-guide__service-listing__left__two f-w6">サービス公開後の編集・削除</div>
                            </div>
                        </div>
                        <div class="seller-user-guide__service-listing__three"><img
                                    src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                    class="icon-dropdown-type"></div>
                    </div>
                    <div class="seller-user-guide__toogle">
                        <div class="seller-user-guide__content">
                            <div class="seller-user-guide__content__service-listing__one">A.</div>
                            <div class="seller-user-guide__content__service-listing__right">
                                <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                    <span>・</span>
                                    <span>出品者マイページ（販売サービス管理）の（販売中サービス）の（編集する）より編集　※購入者がいる場合はできません。</span>
                                </div>
                                <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                    <span>・</span>
                                    <span>出品者マイページ（販売サービス管理）の（削除・キャンセル）の（削除）より削除する　※購入者がいる場合はできません。</span>
                                </div>
                                <div class="seller-user-guide__content__service-listing__right__green"><a
                                            href="{{route('client.teacher.my-page.service-list')}}" target="_blank">こちらのページより</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="seller-user-guide__block">
                    <div class="seller-user-guide__service-listing">
                        <div class="seller-user-guide__service-listing__left">
                            <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                            <div class="seller-user-guide__service-listing__left__two f-w6">予約が入る、予約状況の確認</div>

                        </div>
                        <div class="seller-user-guide__service-listing__three"><img
                                    src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                    class="icon-dropdown-type"></div>
                    </div>
                    <div class="seller-user-guide__toogle">
                        <div class="seller-user-guide__content">
                            <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                            <div class="seller-user-guide__content__service-listing__right">
                                <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                    <span>・</span>
                                    <span>ユーザーが購入し予約が入った場合は、登録アドレスに受信（予約が入りました。）</span>
                                </div>
                                <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                    <span>・</span>
                                    <span>出品者マイページ（販売サービス管理）の（販売サービス）の（予約状況）より予約者の詳細の確認ができます。</span>
                                </div>
                                <div class="seller-user-guide__content__service-listing__right__green"><a
                                            href="{{route('client.teacher.my-page.service-list')}}" target="_blank">こちらのページより</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">メッセージのやり取り</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>メッセージが入った場合は登録アドレスに着信（メッセージ内容・出品者マイページ (メッセージ) 画面へのURL）</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（メッセージ）の（購入者・未購入者・お知らせ配信・Lappi事務局）で確認。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>一括送信（販売中サービス毎の購入者全員への連絡）</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>購入者とのマイページからのメッセージのやり取りは、サービス終了後４８時間後にクローズされます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.my-page.message.message-course')}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">購入者がキャンセルをした場合</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>購入者は（購入者マイページ）より自身でキャンセル処理を行います。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>購入者のキャンセルは（開催日前日２１：５９）までは無償でキャンセルを行うことができます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>購入者がキャンセルを（開催日２２：００）以降のキャンセルはできません。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span class="ml-12px"></span>
                                <span>また、その場合に購入者はサービスの参加の有無に関係なく出品者への支払いが実行されます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>購入者のキャンセルが成立した場合に（出品者の登録メールアドレス）に通知が来ます。</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">出品者がキャンセルをする場合（緊急事のみ)</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・出品者マイページ（販売サービス管理）の（削除・キャンセル）の（キャンセル）<img
                                            src="{{url('assets/img/icons/email-down.svg')}}" alt="email-down"
                                            class="email-down-icon">より詳細文を入力し送信でキャンセル実行</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <div class="direction-sp">
                                    <span>・キャンセル手数料は購入者がいる場合のみ（前日２２：００以降から対象</span>
                                    <span>※キャンセル手数料２２％（税込）</span>
                                </div>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.my-page.service-list', ['tab' => 'cancel'])}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">配信開始方法（ライブ配信・ビデオ通話）共通</div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.guide')}}" target="_blank">詳しくはこちら</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">配信画面の見方（ライブ配信・ビデオ通話）</div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>配信画面の見方（ライブ配信)</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black">
                                <span>・</span>
                                <span>配信画面の見方（ビデオ通話）</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green">
                                <a href="{{route('client.guide-nine')}}" target="_blank">▶ 詳しくはこちら</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">共有画面の使い方（ライブ配信・ビデオ通話)</div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black">
                                ・3種類の方法で共有画面がご利用できます。
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black">
                                (あなたの全画面・ウィンドウ・chromeタブ)
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black">
                                ※ブラウザはchromeをお使いの場合のみご利用可能。
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__danger">
                                PCからの配信時のみご利用できます。
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">サービスの再出品がない場合の販売画面の表示</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>終了したサービスの販売画面に（開催リクエストをする）が自動表示されます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>ユーザーが（開催リクエストをする）ボタンをクリックで、出品者の登録メールアドレスに受信（開催リクエストがありまし
                                    た。）</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>サービスの再公開時に（開催リクエストをする）をクリックしたユーザーの（登録メールアドレス）にお知らせ通知が自動配信されます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>ユーザーが（開催リクエストをする）ボタンをクリックで（リクエスト人数）が画面に表示されます。</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">サービスの出品を休止したい、長期間お休みをする
                        </div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（アカウント設定）の（サービスの休止）より（設定する）をクリックで実行。戻すときは再クリックで休止解除。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>終了しているサービス販売ページ画面には（現在開催をしておりません）が表示される</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>終了しているサービス販売ページ画面からの（質問する）から受け付けができなくなります。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.mypage-teacher-settingAccount')}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">お知らせ配信をする（過去の購入者・フォロワー）
                        </div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>サイトへの再訪問の為の定期的なお知らせ配信　</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>公開ページのURLを貼り付け、案内したい文章を作成し対象者へお知らせ配信ができます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.my-page.message.notice')}}" target="_blank">こちらのページより</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">
                            前日リマインドメール・終了後のサンクスメールの自動配信
                        </div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__black__custom">
                                ・前日のリマインドメールで翌日開催の再案内を自動配信します。

                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__black__custom">
                                （例文)　ご予約いただいたサービスの開催が明日となりましたのでご連絡いたしました。　
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__content seller-user-guide__content__service-listing__right__black__custom">
                                ・明日はこちらの（配信準備画面）のURLからご参加くださいね！
                                <span class="seller-user-guide__content__service-listing__right__content__danger seller-user-guide__content__service-listing__right__black__custom seller-user-guide__content__service-listing__right__danger">
                                    ※開催時間１５分前から可能です。
                                </span>
                                　　　　　
                                <div class="seller-user-guide__content__service-listing__right__content__green seller-user-guide__content__service-listing__right__black__custom">
                                    Https//・・・・・・・・・・・・・・・・・・・・・・（配信準備画面）
                                </div>
                                ・購入者マイページからは（販売サービス管理）の（販売中サービス）画面より配信準備画面へ。
                                　　　　
                                <div class="seller-user-guide__content__service-listing__right__content__green seller-user-guide__content__service-listing__right__black__custom">
                                    Https//・・・・・・・・・・・・・・・・・・・・・・（販売中サービス画面）
                                </div>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black seller-user-guide__content__service-listing__right__black__custom">
                                ・終了後のサンクスメールでレビュー投稿を促す自動配信メール<br>（例文)　本日はご利用頂きましてありがとうございました。 <span
                                        class="text-posting-reviews">レビュー投稿にご協力お願いします。</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">販売履歴を見る</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（販売履歴・レビュー）画面よりご参照ください。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.sale')}}" target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">販売したサービスの分析数値を見る</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（ダッシュボード）より、売上など１５項目の数値を見ることができます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.my-page.dashboard')}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">販売したサービスの収益を見る</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（売上管理）より、販売したサービスの収益を見ることができます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.profit-livestream')}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left">
                        <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                        <div class="seller-user-guide__service-listing__left__two f-w6">売上の振込申請をする</div>

                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ（振込申請）より申請の依頼ができます。</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black">
                                <div class="all-time">
                                    <div><span>・</span>１日-１５日（２３：５９）まで</div>
                                    <div><span style="opacity: 0">・</span>１６日-月末（２３：５９）まで</div>
                                </div>
                                <div class="img-arrow">
                                    <img src="{{asset('assets/img/common/arrow.svg')}}" alt="">
                                </div>
                                <div>
                                    <div class="text-custom-user-1">締日の翌日から<span style="color: #EE3D48;">３営業日まで</span>に振込
                                    </div>
                                    <div class="text-custom-user-1">※締日は<span style="color: #EE3D48;">15日と月末</span>です
                                    </div>
                                    <div class="text-custom-user-2" style="color: #EE3D48;">（土日祝・年末年始・夏季休業除く）</div>
                                </div>

                            </div>
                            <div class="seller-user-guide__content__service-listing__right d-flex">
                                <span>※各期間中1回のみ申請可能</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.my-page.transfer-apply')}}" target="_blank">こちらのページより</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left seller-user-guide__service-listing__left__custom">
                        <div class="seller-user-guide__service-listing__left__one seller-user-guide__service-listing__left__one__custom">
                            <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                            <div class="seller-user-guide__service-listing__left__two f-w6">プロフィールを変更する</div>
                        </div>
                        <div class="seller-user-guide__service-listing__left__three f-w6">
                            (画像・自己紹介タイトル・自己紹介文)
                        </div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>出品者マイページ、サイドバーのトップの（プロフィール編集）より変更ができます</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.mypage-teacher-profile-edit')}}" target="_blank">こちらのページより</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left seller-user-guide__service-listing__left__custom">
                        <div class="seller-user-guide__service-listing__left__one seller-user-guide__service-listing__left__one__custom">
                            <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                            <div class="seller-user-guide__service-listing__left__two f-w6">登録情報を変更する</div>
                        </div>
                        <div class="seller-user-guide__service-listing__left__three f-w6">
                            (登録情報・本人確認書・資格証明書)
                        </div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__black">
                                出品者マイページ（アカウント設定）より変更ができます。
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>登録情報：（お名前・ビジネスネーム）の変更</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>公開表示：（お名前・ニックネーム）※ニックネームの変更は購入者マイページより変更可能</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>メールアドレス</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__black d-flex">
                                <span>・</span>
                                <span>性別（男性・女性・その他・無回答）</span>
                            </div>
                            <div class="seller-user-guide__content__service-listing__right__green"><a
                                        href="{{route('client.teacher.mypage-teacher-settingAccount')}}"
                                        target="_blank">こちらのページより</a></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="seller-user-guide__block">
                <div class="seller-user-guide__service-listing">
                    <div class="seller-user-guide__service-listing__left seller-user-guide__service-listing__left__custom">
                        <div class="seller-user-guide__service-listing__left__one seller-user-guide__service-listing__left__one__custom">
                            <div class="seller-user-guide__service-listing__left__one f-w6">Q.</div>
                            <div class="seller-user-guide__service-listing__left__two f-w6">サポートにお問い合わせる</div>
                        </div>
                        <div class="seller-user-guide__service-listing__left__three f-w6">
                            (その他、解決しない場合)
                        </div>
                    </div>
                    <div class="seller-user-guide__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-user-guide__toogle">
                    <div class="seller-user-guide__content">
                        <div class="seller-user-guide__content__service-listing__one f-w6">A.</div>
                        <div class="seller-user-guide__content__service-listing__right">
                            <div class="seller-user-guide__content__service-listing__right__green">
                                <a href="{{route('client.inquiry-teacher')}}" target="_blank" class="mt-1px">Lappi事務局（お問い合わせフォーム)</a>
                            </div>
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
            $('body').on('click', '.seller-user-guide__service-listing', function () {
                $(this).find('img').toggleClass('img-rotate'); //Add class to img tag.
                $(this).closest('.seller-user-guide__block').find('.seller-user-guide__toogle').slideToggle(); //Find element in block .
            })
        })
    </script>
@endsection
