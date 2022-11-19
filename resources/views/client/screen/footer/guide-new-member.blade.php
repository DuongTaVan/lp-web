@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="Guide new member registration"/>
@endsection
@section('css')
    <link href="{{ mix('css/footer/terms-of-service.css') }}" rel="stylesheet">
    <link href="{{ mix('css/footer/guide-new-member.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="footer-common guide-new-member">
        <div class="footer-common__title">
            <h1 class="footer-common__title--text">新規会員登録 (購入者・出品者)</h1>
        </div>
        <div class="footer-common__container">
            <div class="content">
                <div class="guide-new-member__container">
                    <div class="group">
                        <div class="group__step">
                            Step 1
                        </div>
                        <div class="group__title">
                        登録画面から新規登録を行う　(購入者・出品者)
                        </div>
                        <div class="group__description">
                        必須項目の全てに入力し「利用規約に同意して登録」をして下さい。<br>※出品者の登録をされる方は（出品者＋購入者）の両方で使えるアカウントが登録がされます。
                        </div>
                        <div class="group__warning">
                        ※１８歳未満の方はご利用できません。
                        </div>
                        <div class="group__image group__image--pc w-480">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image100.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image110.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 2
                        </div>
                        <div class="group__title">
                        １８歳以上の未成年の方
                        </div>
                        <div class="group__description">
                        ※未成年者は親権者など法定代理人の同意を得た上で会員登録を行ってください。
                        <br>※未成年者が親権者の同意を得ずに当社サービスをご利用した事実を検知した場合は、運営より確認の連絡を行う場合があります。
                        </div>
                        <div class="group__image group__image--pc w-480">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image101.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image111.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 3
                        </div>
                        <div class="group__title">
                        本登録を完了する
                        </div>
                        <div class="group__description">
                            <ul>
                                <li class="no-margin">「利用規約に同意して登録する」をクリックしましたら、下記画面が表示されます。</li>
                                <li>登録メールアドレスに承認メールが届きますので、「本登録を完了する」をクリックして下さい。</li>
                            </ul>
                        </div>
                        <div class="group__image group__image--pc w-480">
                            <ul>
                                <li>
                                    <br>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image102.png") }}" alt="image">
                                </li>
                                <li>
                                    <br>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image103.png") }}" alt="image">
                                </li>
                            </ul>

                        </div>

                        <div class="group__image group__image--sp w-301">
                            <ul>
                                <li>
                                    <br>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image112.png") }}" alt="image">
                                </li>
                                <li>
                                    <br>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image113.png") }}" alt="image">
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 4
                        </div>
                        <div class="group__title">
                        本登録を完了しました。
                        </div>
                        <div class="group__description">
                            <ul>
                                <li> 購入者用の登録が完了しましたので「トップページへ」から進みご利用開始しして下さい。</li>
                                <li>出品者の方も購入者用の登録が完了しましたので、次は出品者用登録の「新規出品者登録」にお進み下さい。</li>
                            </ul>
                        </div>
                        <div class="group__image group__image--pc w-480">
                            <ul>
                                <li>
                                    <div>購入者</div>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image104.png") }}" alt="image">
                                </li>
                                <li>
                                    <div>出品者</div>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image105.png") }}" alt="image">
                                </li>
                            </ul>

                        </div>
                        <div class="group__image group__image--sp w-301">
                            <ul>
                                <li>
                                    <div>購入者</div>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image114.png") }}" alt="image">
                                </li>
                                <li>
                                    <div>出品者</div>
                                    <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image115.png") }}" alt="image">
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 5
                        </div>
                        <div class="group__title">
                            {{ trans('labels.teacher_register.new_seller_registration') }}
                        </div>
                        <div class="group__description">
                        必須項目の全てに入力し「次へ」にお進み下さい。<br>※ニックネームでの公開は「購入者用」アカウントで登録したニックネームが表示されます。

                        </div>
                        <div class="group__image group__image--pc w-640">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image106.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image116.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 6
                        </div>
                        <div class="group__title">
                        ご利用サービスの選択
                        </div>
                        <div class="group__description custom-margin">
                        必須項目の全てに入力し「次へ」にお進み下さい。<br>※サービスの選択は１つしかお選びすることができません。
                        </div>
                        <div class="group__image group__image--pc w-640">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image107.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image117.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 7
                        </div>
                        <div class="group__title">
                        本人確認情報
                        </div>
                        <div class="group__description">
                        必須項目の全てに入力し「次へ」にお進み下さい。
                        <div class="group__warning custom-margin">※本人確認書類の氏名と振込銀行口座の名義が違う場合は登録できません。		</div>
                        </div>
                        <div class="group__image group__image--pc w-640">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image108.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/Group_6633.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 8
                        </div>
                        <div class="group__title">
                            {{ trans('labels.teacher_register.title_payment') }}
                        </div>
                        <div class="group__description">
                            口座情報の全てに入力し「登録する」で完了して下さい。
                        </div>
                        <div class="group__image group__image--pc w-640">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image109.png") }}" alt="image">
                        </div>
                        <div class="group__image group__image--sp w-310">
                            <img src="{{ asset("assets/img/clients/footer-common/tutorial-course/image119.png") }}" alt="image">
                        </div>
                    </div>
                    <div class="group">
                        <div class="group__step">
                            Step 9
                        </div>
                        <div class="group__title">
                            新規出品者登録の完了
                        </div>
                        <div class="group__description">
                            登録が完了しましたので、サービスをすぐに出品する場合は<br>「新規サービスの作成へ」お進み下さい。
                        </div>
                        <div class="group__button w-480 w-310-m">
                            <div class="button__container">
                                <div class="button__title">
                                    新規出品者登録が完了しました。
                                </div>
                                <div class="button__row">
                                    <a href="#">トップページへ</a>
                                    <a href="#">新規サービス作成へ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


