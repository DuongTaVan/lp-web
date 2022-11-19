@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="Terms of Service"/>
    <meta name="description" content="会員登録をしたい">
    <title>よくあるご質問</title>
@endsection
@section('css')
    <link href="{{ mix('css/footer/terms-of-service.css') }}" rel="stylesheet">
    <link href="{{ mix('css/footer/faq.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="footer-common faq">
        <div class="footer-common__title">
            <h1 class="footer-common__title--text">よくあるご質問</h1>
        </div>
        <div class="footer-common__container">
            <div class="content">
                <div class="content__container">
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">会員登録をしたい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>会員登録は無料です。</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        サービスの購入・出品には会員登録が必要です。
                                        </li>
                                        <li>購入者・出品者の会員登録、出品者の掲載料も無料です。
                                            <br>
                                            ※出品者のアカウントは（購入者用・出品者用）の両方に登録されます。
                                            <br>
                                            （購入者用・出品者用）新規会員登録は<a href="{{ route('client.register') }}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                                <div class="group">
                                    <div><strong>未成年者のサービス利用について。				</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        未成年者は１８歳以上からご利用いただけます。
                                        <br>
                                        ただし、未成年者の会員登録は事前に親権者など法定代理人の同意が必要です。
                                        </li>
                                    </ul>
                                </div>
                                <div class="group">
                                    <div><strong>手続き方法					</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        会員登録画面で親権者・法定代理人の同意入力欄「私はLappiの利用について、親権者の同意を得ています。」
                                        <br>
                                        にチェックを入れてください。
                                        <br>
                                        ※未成年者が親権者の同意を得ずに当社サービスをご利用した事実を検知した場合は、運営より確認の連絡を行う場合があります。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">登録は実名でするの？
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                        <div class="expand-item__content--answer">
                                <div class="group">
                                    <ul class="list list--dot">
                                        <li>
                                        ユーザー登録：ニックネームの登録になります。
                                        </li>
                                        <li>出品者登録　：ニックネームの登録 or ( 氏名 or ビジネスネーム）　
                                            <br>
                                            ※登録名は公開されます。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">ログインできない
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                    <div class="group">
                                        <div><strong>メールアドレス・パスワードの再確認</strong></div>
                                        <ul class="list list--dot list--mt5">
                                            <li>
                                            会員登録画面ではなく、ログイン画面からログインに必要な情報を入力しているかご確認ください。
                                            </li>
                                            <li>メールアドレス・パスワードはすべて半角で入力しているかご確認ください。(記号含め@も半角です)
                                            </li>
                                            <li>サブメールアドレスではログインできませんので、登録メールアドレスを入力しているか確認してください。</li>
                                            <li>【Google/LINE/Facebook】で会員登録した場合、メールアドレスとパスワードの組み合わせによるログインではなく、
                                                <br>
                                                「各アカウントでログインする」のボタンからログインをお試しください。
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="group">
                                        <div><strong>Cookie削除					</strong></div>
                                        <ul class="list list--dot list--mt5">
                                            <li>
                                            ブラウザに古い情報が残っていると正常にログインできない場合がありますので、Cookie削除をお試しください。
                                            <br>
                                            ※ブラウザ設定でCookieを「無効」にしないようご注意ください。　　
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <strong>上記いずれの方法でもログインできない場合</strong>
                                        </div>
                                        <ul class="list--mt5 list--none custom-marker">
                                            <li><span>※</span>「登録メールアドレス」は、運営からお教えすることができないため、ご自身で思い出していただく必要があります。 <br>
　お問い合わせをいただいた場合でも、個人情報保護の観点よりアカウント情報を運営から開示することはできかねますので、
　<br>予めご了承ください。
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">パスワードを忘れた
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>パスワードを忘れた場合			</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        パスワードをお忘れの場合やパスワードでのログインをご希望の場合は、再発行の手続きをお願いします。
                                        </li>
                                        <li>パスワード再設定は<a href="{{ route('client.password-reset.show-link') }}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">支払い方法を知りたい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                        <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>お支払い</strong></div>
                                    <div>ご利用いただけるクレジットカードは、以下のとおりです。<br>
なお、有効期限が切れているクレジットカードはご利用いただけません。</div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        VISA
                                        </li>
                                        <li>MasterCard
                                        </li>
{{--                                        <li>JCB</li>--}}
                                        <li>AMEX</li>
{{--                                        <li>DINERS</li>--}}
                                    </ul>
                                    <ul class="list list--none">
                                        <li>※支払回数は一括のみとなります。
　<br> 引き落とし日は各カード会社規定の日になります。		</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">クレジットカードで支払いができない
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <ul class="list list--dot">
                                        <li>
                                        個人保護の観点より、Lappiからクレジットカード会社に確認することができません。										<br>お手数をおかけしますが、ご利用のクレジットカード会社に直接お問い合わせください。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">クレジットカードの決済時期はいつか
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <ul class="list list--dot">
                                        <li>
                                        開催日前日22:00に決済が行われる仕組みです。
                                        <br>
                                        なお、デビットカードやその他一部のカードでは決済のタイミングが異なる場合がございます。
                                        <br>
                                        ※開催日前日２２以降はキャンセルはできません。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">デビットカードを利用したい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <ul class="list list--dot">
                                        <li>
                                        一部のデビットカードはご利用いただけない場合がございます。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">キャンセル・日時変更をしたい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>キャンセルの場合</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        開催日前日21:59まではキャンセルは可能です。
                                        <br>
                                        ２２時を過ぎますとサービスの参加の有無に関係なく返金はできません。
                                        </li>
                                        <li>
                                        キャンセル画面は<a class="link" href="{{route('client.student.my-page.order')}}">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                                <div class="group">
                                    <div><strong>日時変更の場合</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        開催日時を変更することはできません。
                                        <br>
                                        その場合は一旦キャンセルをしてください。	    <br>
                                        ※キャンセルは開催日前日２２時以降はできません。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">出品者へ質問したい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>サービスの予約をしていない場合					</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        サービス予約をしていない場合は、サービス詳細ページの「質問をする」から
                                        <br>メッセージをお送りください。
                                    </ul>
                                </div>
                                <div class="group">
                                    <div><strong>サービスの予約をした場合			</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        購入者マイページの「メッセージ」の「購入中サービス」の予約しているサービスの									<br class="mobile-hide"><img src="{{ url('assets/img/icons/email-down.svg') }}" alt="email-icon" class='email-icon'>よりメッセージを送ることができます。

                                        <br>メッセージは画面は<a href="{{ route('client.student.message.list') }}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon" width="10px">
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">当日の配信開始の操作がわからない
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>購入者用</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        ライブ配信は<a href="{{route('client.live-streaming')}}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                        <li>
                                        ビデオ通話はこちら<a href="{{route('client.video-call')}}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">顔出しがイヤ、お部屋も映したくない
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>オリジナルARエフェクト・バーチャル背景（ビデオ通話サービスご利用時のみ）</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        LappiではオリジナルARエフェクトを３種類の動物の中からお選びできます。
                                        <br>（ウサギ・サル・フクロウ）を着用すると配信時の画面には顔は映りません。
                                        <br>※配信画面からはみ出さないようにお気をつけください。
                                        </li>
                                        <li>お部屋が映りたくない場合はバーチャル背景をご利用できます。
                                        <br>設定されている画像からの選択や、ご自分のお気に入りの画像もご利用できます。
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">プロフィール情報・画像を変更したい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>購入者用</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>
                                        プロフィール編集画面より（ニックネーム・プロフィール・プロフィール画像）の変更ができます。
                                        </li>
                                        <li>プロフィール編集画面は<a href="{{route('client.student.my-page.profile-and-email')}}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">レビューの投稿をしたい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>レビューの投稿		</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>レビュー投稿ページは<a href="{{route('client.student.my-page.review')}}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">通知の受信設定を変更したい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>通知設定</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>通知設定ページは<a href="{{ route('client.student.my-page.notify-setting') }}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">退会手続きをしたい
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="expand-item__content--answer">
                                <div class="group">
                                    <div><strong>退会手続き	</strong></div>
                                    <ul class="list list--dot list--mt5">
                                        <li>退会手続きは<a href="{{ route('client.student.my-page.delete-account') }}" class="link">こちら</a><img src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                        </li>
                                    </ul>
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
        function expand() {
            const $expands = $(".js-expandable");
            for (let expand of $expands){
                $(expand).find(".expand-item__title").on('click',function(){
                    const $title =$(this).find(".expand-item__title--icon");
                    const content_height = $(expand).find(".expand-item__content").outerHeight();
                    const title_height = $(expand).find(".expand-item__title").outerHeight();
                    if(!$title.hasClass('active')){
                        $(expand).animate({height: content_height+ title_height}, 200)
                    }else{
                        $(expand).animate({height: title_height}, 200)
                    }
                    $title.toggleClass('active')
                })
            }
        }
        expand();
    </script>

@endsection
