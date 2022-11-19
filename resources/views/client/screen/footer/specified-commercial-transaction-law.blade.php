@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="Terms of Service"/>
    <meta name="description" content="06-4400-0770※お電話でのお問い合わせは受け付けておりません。お問い合わせの際はお問い合わせフォームをご利用ください。">
    <title>特定商取引法に基づく表記</title>
@endsection
@section('css')
    <link href="{{ mix('css/footer/terms-of-service.css') }}" rel="stylesheet">
    <link href="{{ mix('css/footer/specified-commercial-transaction-law.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="footer-common commercial-transaction">
        <div class="footer-common__title">
            <h1 class="footer-common__title--text">特定商取引法に基づく表記</h1>
        </div>
        <div class="footer-common__container">
            <div class="content">
                <div class="content__container mobile-hide">
                    <div class="commercial-sidebar">
                        <div class="commercial-sidebar__content">
                            <div class="commercial-sidebar__text active">サービス名</div>
                            <div class="commercial-sidebar__text">販売事業者</div>
                            <div class="commercial-sidebar__text">代表者</div>
                            <div class="commercial-sidebar__text">所在地</div>
                            <div class="commercial-sidebar__text">電話番号</div>
                            <div class="commercial-sidebar__text">お問い合わせ</div>
                            <div class="commercial-sidebar__text">販売価格</div>
                            <div class="commercial-sidebar__text">お支払方法</div>
                            <div class="commercial-sidebar__text">支払時期</div>
                            <div class="commercial-sidebar__text mt-91">販売価格以外で発生する金銭</div>
                            <div class="commercial-sidebar__text">サービスの提供時期</div>
                            <div class="commercial-sidebar__text mt-151">動作環境</div>
                            <div class="commercial-sidebar__text">返品・キャンセル</div>
                            <div class="commercial-sidebar__text">特別条件</div>
                            <div class="commercial-sidebar__text mt-29">免責事項</div>
                        </div>
                    </div>
                    <div class="commercial-right-content">
                        <div class="group active">Lappi</div>
                        <div class="group">株式会社Lappi　　</div>
                        <div class="group">高橋真二</div>
                        <div class="group">大阪府大阪市北区豊崎３丁目１５番−５号</div>
                        <div class="group">
                            <div>
                                06-4400-0770
                            </div>
                            <div>
                                ※お電話でのお問い合わせは受け付けておりません。
                            </div>
                            <div>
                                お問い合わせの際は<a href="{{route('client.inquiry')}}"
                                            style="text-decoration: none">お問い合わせフォーム</a>をご利用ください。
                            </div>
                        </div>
                        <div class="group">【info@lappi-live.com】までお問い合わせください。</div>
                        <div class="group">サイトの各サービスページに記載されておりますので、ご確認ください。</div>
                        <div class="group">クレジットカード決済（VISA・Master・American Express）</div>
                        <div class="group">購入時にお支払いください</div>
                        <div class="group">
                            本アプリの閲覧、コンテンツ購入等に必要となるインターネット接続料金、通信料金などはユーザーのご負担となります。
                            <br>それぞれの料金は、ユーザーがご利用のインターネットプロバイダーまたは携帯電話会社にお問い合わせください。<br>消費税は内税として表示しております。
                        </div>
                        <div class="group">表示されています開催日時に実施致します。</div>
                        <div class="group">
                            以下の推奨環境をご参照ください。<br>
                            <div class="group__table">
                                <ul>
                                    <li>Chrome</li>
                                    <li>Microsoft Edge</li>
                                    <li>Firefox</li>
                                    <li>Safari</li>
                                </ul>
                                <ul>
                                    <li>最新版</li>
                                    <li>最新版</li>
                                    <li>最新版</li>
                                    <li>最新版</li>
                                </ul>
                            </div>
                            ※最新OSについては順次動作を確認しますが、画面の一部が表示されないことがあります。<br>上記環境以外では、正常に動作しなかったり画面表示が崩れたりする可能性があります。ご利用頂いているブラウザの種類・バージョンをご確認頂き、推奨環境でのご利用をおススメします。
                        </div>
                        <div class="group">サービス開催日前日２２：００以降は、キャンセルはお受け致しません。</div>
                        <div class="group">利用規約に定める禁止事項に該当する場合は、サービスの提供を受けることはできません。</div>
                        <div class="group">
                            サーバートラブル、ネットワークトラブルその他不可抗力により生じたサービス・商品の提供不能、中断については、当サイトに重大な過失がある場合を除き、その責任を負わないものとします。
                        </div>
                    </div>
                </div>
                <div class="content__container mobile-show">
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">サービス名</div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            Lappi
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                販売事業者
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            株式会社Lappi
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                代表者
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            高橋真二
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                所在地
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            大阪府大阪市北区豊崎３丁目１５番−５号
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                電話番号
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <style>
                            .expand-item__content__phone-number a {
                                color: #1f2d3d;
                                text-decoration: none;
                            }
                        </style>
                        <div class="expand-item__content expand-item__content__phone-number">
                            06-4400-0770
                            <div>
                                ※お電話でのお問い合わせは受け付けておりません。
                            </div>
                            <div>
                                お問い合わせの際は<a href="{{route('client.inquiry')}}"
                                            style="text-decoration: none; color: #007bff">お問い合わせフォーム</a>をご利用ください。
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                お問い合わせ
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            【info@lappi-live.com】までお問い合わせください。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                販売価格
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            サイトの各サービスページに記載されておりますので、ご確認ください。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                お支払方法
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            クレジットカード決済（VISA・Master・American Express）
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                支払時期
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            購入時にお支払いください
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                販売価格以外で発生する金銭
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            本アプリの閲覧、コンテンツ購入等に必要となるインターネット接続料金、通信料金などはユーザーのご負担となります。<br>
                            それぞれの料金は、ユーザーがご利用のインターネットプロバイダーまたは携帯電話会社にお問い合わせください。<br>
                            消費税は内税として表示しております。

                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                サービスの提供時期
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            表示されています開催日時に実施致します。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                動作環境
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <!-- ::NOTE -->
                            <div class="group">
                                以下の推奨環境をご参照ください。<br>
                                <div class="group__table">
                                    <ul>
                                        <li>Chrome</li>
                                        <li>Microsoft Edge</li>
                                        <li>Firefox</li>
                                        <li>Safari</li>
                                    </ul>
                                    <ul>
                                        <li>最新版</li>
                                        <li>最新版</li>
                                        <li>最新版</li>
                                        <li>最新版</li>
                                    </ul>
                                </div>
                                ※最新OSについては順次動作を確認しますが、画面の一部が表示されないことがあります。<br>上記環境以外では、正常に動作しなかったり画面表示が崩れたりする可能性があります。ご利用頂いているブラウザの種類・バージョンをご確認頂き、推奨環境でのご利用をおススメします。
                            </div>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                返品・キャンセル
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            サービス開催日前日２２：００以降は、キャンセルはお受け致しません。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                特別条件
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            利用規約に定める禁止事項に該当する場合は、サービスの提供を受けることはできません。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                免責事項
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            サーバートラブル、ネットワークトラブルその他不可抗力により生じたサービス・商品の提供不能、中断については、当サイトに重大な過失がある場合を除き、その責任を負わないものとします。
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hightlight() {
            const $btns = $(".commercial-sidebar__text");
            const $contents = $(".group");
            $btns.on('click', function () {
                $btns.removeClass('active');
                $(this).addClass('active');
                const index = $btns.index(this);
                $contents.removeClass('active');
                $($contents[index]).addClass('active');
            })
        }

        hightlight();

        function expand() {
            const $expands = $(".js-expandable");
            for (let expand of $expands) {
                $(expand).find(".expand-item__title").on('click', function () {
                    const $title = $(this).find(".expand-item__title--icon");
                    const content_height = $(expand).find(".expand-item__content").outerHeight();
                    const title_height = $(expand).find(".expand-item__title").outerHeight();
                    if (!$title.hasClass('active')) {
                        $(expand).animate({height: content_height + title_height}, 200)
                    } else {
                        $(expand).animate({height: title_height}, 200)
                    }
                    $title.toggleClass('active')
                })
            }
        }

        expand();

    </script>
@endsection
