@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="Privacy Policy"/>
    <meta name="description" content="第１条（個人情報保護体制の確立）">
    <title>プライバシーポリシー</title>
@endsection
@section('css')
    <link href="{{ mix('css/footer/terms-of-service.css') }}" rel="stylesheet">
    <link href="{{ mix('css/footer/privacy-policy.css') }}" rel="stylesheet">
    <style>
        .blog-title {
            margin: 10px 0;
        }

        .blog9-2 li {
            display: flex;
        }

        .blog-content {
            margin-left: 2px;
        }

    </style>
@endsection

@section('content')
    <div class="footer-common privacy-policy">
        <div class="footer-common__title">
            <h1 class="footer-common__title--text">プライバシーポリシー</h1>
        </div>
        <div class="footer-common__container">
            <div class="content">
                <div class="content__container">
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１条（個人情報保護体制の確立）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            ○○（以下「当社」といいます）は、このサイト上で提供するサービス（以下、「本サービス」といいます）をご利用される出品者及び購入者（以下、総称して「ユーザー」といいます）を特定できる情報（以下、「個人情報」といいます）の保護について、社会的使命を十分に認識し、本人の権利の保護、個人情報に関する法規制等を遵守します。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第２条（個人情報の取り扱い目的）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、ユーザーの個人情報をユーザーの同意なくして利用目的の範囲を超えて利用することはございません。当社が取得した個人情報は、以下の目的に利用致します。
                            <ol class="list list--style3">
                                <li>本サービスの提供・運営のため</li>
                                <li>本人確認のため</li>
                                <li>本サイト等運営上のトラブルの解決のため</li>
                                <li>ユーザーからのお問い合わせに回答するため</li>
                                <li>個人情報を統計的に処理した情報を集約し調査結果として公表するため</li>
                                <li>ユーザーのトラフィック測定及び行動測定</li>
                                <li>ユーザーの利用状況を把握し、本サービスの改善や新サービスの開発に役立てるため</li>
                                <li>本サービスに関する規約変更など重要な通知の実施</li>
                                <li>法令の定め又は行政当局の通達・指導などに基づく対応を行うこと</li>
                                <li>その他個人情報取得時に明示した利用目的</li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第３条（個人情報の取り扱いについて）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style2 alt-style list list--block">
                                <li>
                                    ユーザーから直接取得する情報
                                    <br>
                                    当社は、本サービスの利用にあたって、ユーザーから以下の情報を取得します。
                                    <div class="box">
                                        （購入者様より）
                                        <ol class="list list--dot">
                                            <li>生年月日</li>
                                            <li>メールアドレス</li>
                                            <li>性別 （出品者様より）
                                            </li>
                                            <li>氏名</li>
                                            <li>生年月日</li>
                                            <li>住所</li>
                                            <li>メールアドレス</li>
                                            <li>性別</li>
                                            <li>資格に関する情報（提供するサービスに関して資格をお持ちの場合）</li>
                                        </ol>
                                    </div>
                                </li>
                                <li class="mt-15">
                                    技術情報の取得
                                    <br>
                                    ユーザーが本サービスにアクセスする際に、当社は以下の技術情報を取得します。
                                    <div class="box">
                                        <ol class="list list--dot">
                                            <li>端末の種類</li>
                                            <li>端末識別子</li>
                                            <li>ブラウザの種類
                                            </li>
                                            <li>IPアドレス</li>
                                            <li>Cookie</li>
                                        </ol>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第4条（IPアドレス）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、ウェブサーバー上で収集したIPアドレスを不正なアクセスを防止するとともに当社で使用するウェブサーバーに万一障害が発生した場合の迅速な原因特定と復旧を可能とし、当社のサービスを適切・安全に管理・運営するためにのみ利用する場合があり、当該IPアドレスをユーザーの個人情報と関連付けして利用または開示することはありません。また当社は、当社またはユーザーを保護するために必要と判断した場合、当社は、IPアドレスにより個人を特定して対策を実施することがあります。
                        </div>
                    </div>

                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第5条（Cookieの利用）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            本サービスは、ユーザーにより一層のサービスを提供するため、Cookie（クッキー）と呼ばれる技術を利用しています。Cookieとは、サーバーからユーザーのブラウザに送信され、ユーザーが使用しているコンピュータのストレージに蓄積される情報のことです。当社が送信するCookieの情報には、第三者がユーザー個人を特定できる情報は含まれておらず、ユーザーのプライバシーが侵害されることはありません。また、ユーザーは、使用しているブラウザの設定により、Cookieの受け取りを拒否することが可能です。但し、受け取り拒否をされた場合、一部サービスの利便性が低下する可能性がありますので、予めご了承ください。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第6条（個人情報の安全管理措置）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、個人情報への不正アクセス、個人情報の紛失・破壊・改ざん・漏洩等の防止その他個人情報の安全管理のために、組織的、物理的及び技術的な安全管理措置を適切に講じます。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第7条（個人情報の第三者への提供）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、次に掲げる場合を除くほか、予め利用者の同意を得ることなく、利用者の個人情報を第三者に提供致しません。
                            <ol class="list--style2 alt-style list">
                                <li>
                                    法令に基づく場合
                                </li>
                                <li>
                                    人の生命、身体又は財産の保護のために必要がある場合であって、本人の同意を得ることが困難であるとき
                                </li>
                                <li>公衆衛生の向上又は児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難であるとき</li>
                                <li>
                                    国の機関若しくは地方公共団体又はその委託を受けた者が法令の定める事務を遂行ことに対して協力する必要がある場合であって、本人の同意を得ることにより当該事務の遂行に支障を及ぼす恐れがあるとき
                                </li>
                                <li>
                                    利用者の行為が本サービスの利用規約や方針・告知等に違反している場合及び他の利用者、第三者又は当社の権利、財産を保護するために必要と認められる場合
                                </li>
                                <li>裁判所、行政機関の命令、警察又はこれらに準じる公的機関より、適法に開示を要請された場合</li>
                                <li>その他、法令又は利用者が同意した利用規約等により個人情報の開示、預託が認められる場合</li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第8条（プライバシーポリシーの変更）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、個人情報保護方針（プライバシーポリシー）の取り扱い方法について適宜見直しを行い、改訂することがあります。ただし、法令上ユーザーの同意が必要となるような本ポリシーの変更を行う場合、変更後の本ポリシーは、当社所定の方法で変更に同意したユーザーに対してのみ適用されるものとします。なお、当社は、本ポリシーを変更する場合には、変更後の本ポリシー施行時期及び内容を当社のサイト上での表示その他の適切な方法により周知し、またはユーザーに通知します。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第9条（個人情報の削除️及び訂正）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <div class="blog9-1">
                                <div class="blog-title">個人情報の削除</div>
                                <li>
                                    １、当社は、登録ユーザーがご自身の登録ユーザー情報（以下「登録ユーザー個人情報」）について、削除できるようにしています。ご自身の個人情報を削除するには <a href="{{route('client.inquiry')}}">info@lappi-live.com</a> までお問い合わせください。但し、個人情報保護法その他の法令により、当社が削除の義務を負わない場合は、この限りではありません。
                                </li>
                                <li>
                                    ２、削除処理を行うと、登録ユーザー個人情報は一定期間保存された後、削除されます。当社は削除処理前の登録ユーザー個人情報をバックアップとして一定期間保存しますが、これは操作ミスの際にユーザーの不利益を防止したり、規約違反情報を投稿してすぐに退会するなどの不正行為が発覚した際に、調査を行うことなどを目的とするものです。削除処理後の登録ユーザー個人情報が本サービスに利用されることはありません。
                                </li>
                                <li>
                                    ３、サービスを開催し、またはサービスへの参加手続きを完了した登録ユーザーの登録ユーザー個人情報について、第１項に基づき削除の手続きをとられた場合、前項の規定にかかわらず、サービスが開催され終了するまでの間、登録ユーザー個人情報は本サービスのために利用されることがあるものとし、登録ユーザーはこれに異議を申し述べないものとします。また、当社はサービス運営上の混乱を防止する目的でユーザー登録の抹消後もユーザー氏名を保有します。
                                </li>
                                <li>４、第２項にかかわらず、出品者であるユーザーの登録ユーザー個人情報の削除については、別に定めるところによるものとします。</li>
                            </div>

                            <div class="blog9-2">
                                <div class="blog-title">個人情報の訂正</div>
                                <li>
                                    <div>1.</div>
                                    <div class="blog-content">
                                        ユーザーは、当社の保有する自己の個人情報が誤った情報である場合には、当社が定める手続きにより、当社に対して個人情報の訂正、追加、または削除（以下、「訂正等」といいます）を請求することができます。
                                    </div>
                                </li>
                                <li>
                                    <div>2.</div>
                                    <div class="blog-content">
                                        当社は、ユーザーから前項の請求を受けてその請求に応じる必要があると判断した場合には、遅滞なく、当該個人情報の訂正等を行うものとします。
                                    </div>
                                </li>
                                <li>
                                    <div>3.</div>
                                    <div class="blog-content">
                                        当社は、前項の規定に基づき訂正等を行った場合、または訂正等を行わない旨の決定をしたときは遅滞なく、これをユーザーに通知します。
                                    </div>
                                </li>
                            </div>

                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第10条（個人情報の利用停止等）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    当社は、ユーザーから、個人情報が、利用目的の範囲を超えて取り扱われているという理由、または不正の手段により取得されたものであるという理由により、その利用の停止または消去（以下、「利用停止等」といいます）を求められた場合には、遅滞なく必要な調査を行います。
                                </li>
                                <li>前項の調査結果に基づき、その請求に応じる必要があると判断した場合には、遅滞なく、当該個人情報の利用停止等を行います。</li>
                                <li>
                                    当社は、前項の規定に基づき利用停止等を行った場合、または利用停止等を行わない旨の決定をしたときは、遅滞なく、これをユーザーに通知します。
                                </li>
                                <li>
                                    前二項にかかわらず、利用停止等に多額の費用を有する場合その他利用停止等をおこなうことが困難な場合であって、ユーザーの権利利益を保護するために必要なこれに代わるべき措置をとれる場合は、この代替策を講じるものとします。
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第11条（個人情報の開示）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    当社は、ユーザーより個人情報の開示を求められたときは、ユーザー本人に対し、これを遅滞なく開示します。ただし、開示することにより次のいずれかに該当する場合は、その全部または一部を開示しないこともあり、開示しない決定をした場合には、その旨を遅滞なく通知します。なお、個人情報の開示に際しては、１件当たり１，０００円の手数料を申し受けます。
                                    <ol class="list list--style2">
                                        <li>本人または第三者の生命、身体、財産その他の権利利益を害する恐れがある場合</li>
                                        <li>当社の業務の適正な実施に著しい支障を及ぼす恐れがある場合</li>
                                        <li>その他法令に違反することとなる場合</li>
                                    </ol>
                                </li>
                                <li>前項の定めにかかわらず、履歴情報及び特性情報などの個人情報以外の情報については、原則として開示致しません。</li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable step-12">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第12条（お問い合わせ）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            本ポリシーに関するご意見、ご質問、苦情の申し出その他お客様情報の取り扱いに関するお問い合わせは、下記の相談窓口までお願い致します。
                            <br><br>
                            株式会社Lappi　個人情報相談窓口<br>
                            【info@lappi-live.com】<br><br>

                            ２０２２年３月１日制定

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
