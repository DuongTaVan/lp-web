@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div id="content">
        <section class="section" id="section01">
            <div class="inner">
                <div class="inner-02">
                    <p class="ib" id="topics">
                        <span class="home">
                            <a href=""><img src="{{ asset('assets/icons/icon05.svg')}}" alt="" /></a>
                        </span>
                        <span>プライバシーポリシー</span>
                    </p>
                    <h2 class="head head-A"><span class="max">Privacy Policy</span><span class="min">プライバシーポリシー</span></h2>
                    <div class="text-box text-box-A">
                        <p class="text">
                            株式会社Premier（以下「当社」という）が運営するシェアサービス「PREwiz」その他のサービス（以下「本サービス」という）における個人情報の取扱いは以下の通りです。内容についてご理解とご同意を頂いた上で、本サービスをご利用下さい。
                        </p>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">1. 取得する情報及び取得方法</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                1）当社が運営するウェブサイト（https://www.prewiz.net、以下「本サイト」という）上、書面またはメール等でご登録またはご提供頂いた情報（メールアドレス、氏名・住所等）<br />
                                2）自動取得する情報<br />
                                a.行動履歴情報（本サイト上の閲覧履歴等）<br />
                                b.Cookie 情報<br />
                                c.端末識別情報<br />
                                d.広告ID（IDFA・Advertising ID）
                            </p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">2.利用目的</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                1）本サービスの円滑な運営およびサービス内容の向上のため<br />
                                2）本サービスに関するキャンペーン、プレゼント等の実施または情報提供のため<br />
                                3）本会員からのご意見、ご要望、お問合せ等に対し適切に対応するため<br />
                                4）本人確認、商品アイテムの保管状況の確認または不正利用の防止・調査のため<br />
                                5）ご利用代金のご請求等のため<br />
                                6）当社と業務委託等の関係にある事業者により、本サービスの一部を提供するため<br />
                                7）当社または第三者の広告の配信その他の情報を提供するため<br />
                                8）マーケティングデータの測定・分析のため<br />
                                9）その他上記各号に準ずる目的のため
                            </p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">3.利用者関与の方法</h3>
                        <div class="text-box text-box-A">
                            <p class="text">お客様より提供頂いた会員情報につきましては、お客様の申し出があった場合、本人確認等所定の手続きを経て、変更及び削除することができます。お問い合わせフォームよりお申し出下さい。</p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">4.第三者提供</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                お客様より提供頂いた会員情報につきましては、以下の場合を除き、あらかじめご本人の同意を得ることなく第三者に提供致しません｡<br />
                                1）法令に基づく場合<br />
                                2）生命、身体または財産の保護のために必要がある場合であって、同意を得ることが困難である場合<br />
                                3）国の機関若しくは地方公共団体又はその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがある場合<br />
                                4）合併、会社分割、事業譲渡その他の事由によって個人情報を含む弊社の事業の承継が行われる場合<br />
                                5）利用目的達成に必要な範囲で、会員情報の取扱いを外部委託する場合
                            </p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">5.情報収集モジュール</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                広告配信及びに本アプリの利用状況や広告効果等を測定・解析するため、以下の情報収集モジュールが組み込まれています。以下モジュールは、個人を特定する情報を含むことなく会員情報を自動取得し、取得された情報は、モジュール提供者の定めるプライバシーポリシー等に基づき管理されます。
                                <br />
                                1)「google Analytics」<br />
                                提供先：グーグル㈱<br />
                                利用目的：アクセス解析<br />
                                提供方法：提供先への自動送信<br />
                                プライバシーポリシー：<a href="https://www.google.co.jp/intl/ja/policies/privacy/" target="_blank">https://www.google.co.jp/intl/ja/policies/privacy/</a>
                            </p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">6.本ポリシーの変更</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                会員情報の取扱いの改善等のため、本ポリシーは変更されることがあります。変更後のポリシーにつきましては、本サイト上又は当社の運営するウェブサイトでの掲示その他の方法により告知しますので定期的にご確認下さい。
                            </p>
                        </div>
                    </div>
                    <div class="box">
                        <h3 class="head head-C">7.問い合わせ窓口</h3>
                        <div class="text-box text-box-A">
                            <p class="text">
                                本ポリシーに関するお問合せは下記までお寄せください。<br />
                                <br />
                                ＜プライバシーポリシーお問合せ窓口＞<br />
                                株式会社Premier 個人情報保護担当<br />
                                〒107-0062　東京都港区南青山5-8-11 萬楽庵ビル ３F<br />
                                <a href="mailto:info@premier-jpn.com">info@premier-jpn.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- E CONTENT -->

@endsection
