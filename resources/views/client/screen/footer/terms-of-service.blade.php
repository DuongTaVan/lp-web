@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="Terms of Service"/>
    <meta name="description" content="第１条（目的及び適用）">
    <title>利用規約</title>
@endsection
@section('css')
    <link href="{{ mix('css/footer/terms-of-service.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="footer-common terms-of-service">
        <div class="footer-common__title">
            <h1 class="footer-common__title--text">利用規約</h1>
        </div>
        <div class="footer-common__container">
            <div class="content">
                <div class="content__des">
                </div>
                <div class="content__container">
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１条（目的及び適用）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    この利用規約（以下、「本規約」といいます）は、○○（以下「当社」といいます）がこのサイト上で提供するサービス（以下、「本サービス」といいます）の利用条件を定めるものです。本サービスご利用される出品者及び利用者（以下、総称して「ユーザー」といいます）は、本規約の内容に従って、本サービスを利用頂くものとします。
                                    {{--                                    この利用規約（以下、「本規約」といいます）は、株式会社Lappi（以下「当社」といいます）がこのサイト上で提供するサービス <br>(以下、「本サービス」といいます）の利用条件を定めるものです。--}}
                                    {{--                                    <div class="direction-sp">--}}
                                    {{--                                        <span>本サービスご利用される出品者及び購入者（以下、総称して「ユーザー」といいます）は、本規約の内容に従って、本サービスを利用</span>--}}
                                    {{--                                        <span>頂くものとします。</span>--}}
                                    {{--                                    </div>--}}
                                </li>
                                <li>
                                    本規約は、当社及びすべてのユーザー間の本サービスの利用に関わる一切の関係に適用されるものとします。また、当社が本サイトに掲載の上、提供する内容は本規約の一部として構成されます。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第２条（本規約への同意）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            ユーザーは、本規約の内容を理解し、これに同意の上、本サイトを利用するものとします。なお、本サイトを利用した場合、ユーザーは、本規約の内容を理解し、これに同意の上、本サイトを利用したとみなすものとします。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第３条（登録）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    本サービスの利用を希望する者（以下、「登録希望者」といいます）は、本規約の全条項を遵守することに同意し、かつ当社の定める一定の情報（以下、「登録情報」といいます）を当社の定める方法により当社に提供することにより、本サービスの利用の登録を申請することができます。なお、出品者は、本サービスを利用するにあたり当社が別途定める出品者ガイドラインの各規定を遵守することにも同意をしなければいけないものとします。
                                </li>
                                <li>
                                    登録の申請は、必ず本サービスを利用する本人が行わなければならず、当社が事前に承諾した場合を除き、代理人による登録申請は認められません。また、登録希望者は、登録の申請にあたり、真実、正確かつ最新の情報を当社に提供しなければなりません。
                                </li>
                                <li>
                                    当社は、第１項に基づき登録を申請した者が以下の各号のいずれかの事由に該当する場合は、当該登録を拒否又は取消しをすることができ、当社はこれについて一切の責任を負わないものとします。
                                    <ol class="list--style2 list">
                                        <li>提供された登録情報の全部または一部につき虚偽、誤記、記載漏れがあった場合</li>
                                        <li>過去に本規約に違反したことのある者から登録申請を受けた場合</li>
                                        <li>未成年者である場合に、法定代理人の包括的な同意を得ていない場合</li>
                                        <li>
                                            反社会的勢力等（暴力団、暴力団員、右翼団体、反社会的勢力、その他これらに準ずる者を意味する。以下同様とします。）である、又は資金提供そのほかを通じて反社会的勢力等の維持、運営若しくは経営に協力若しくは関与する等反社会的勢力等と何らかの交流若しくは関与を行っていると当社が判断した場合
                                        </li>
                                        <li>その他当社が登録を適当ではないと判断した場合</li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第４条（アカウントの管理）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    ユーザーは、利用に際して登録した情報（以下、「登録情報」といいます。電話番号やパスワード等を含みます）について、自己の責任の下、任意に登録、管理するものとします。ユーザーは、これを第三者に利用させ、または貸与、譲渡、名義変更、売買などをしてはならないものとします。
                                </li>
                                <li>
                                    当社は、登録情報によって本サービスの利用があった場合、利用登録をおこなった本人が利用したものと扱うことができ、当該利用によって生じた結果ならびにそれに伴う一切の責任については、利用登録を行ったユーザー本人に帰属するものとします。
                                </li>
                                <li>
                                    ユーザーは、登録情報の不正使用によって当社または第三者に損害が生じた場合、当社および第三者に対して、当該損害を賠償するものとします。
                                </li>
                                <li>
                                    登録情報の管理は、ユーザーが自己の責任の下で行うものとし、登録情報が不正確ま
                                    たは虚偽であったためにユーザーが被った一切の不利益および損害に関して、当社は責任を負わないものとします。
                                </li>
                                <li>
                                    登録情報が盗用されまたは第三者に利用されていることが判明した場合、ユーザーは直ちにその旨を当社に通知するとともに、当社からの指示に従うものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第５条（購入手続及びサービス提供契約の成立）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    購入者は、当社サービスにおいてサービスの購入を希望する場合、当社所定のフォームより購入手続きを行うものとします。
                                </li>
                                <li>
                                    サービス提供契約は、購入者が前項の購入手続きを完了した時点で、出品者と当該購入者との間で成立します。なお、当社はサービス提供契約の当事者となるものではなく、サービス提供契約につき、出品者又は購入者のいずれの立場に関す責任も負いません。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第６条（外部サービスとの連携）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    ユーザーは、外部サービスとの連携機能を利用してログインする際に、当社がデータにアクセスすることについての許可を求められることがあり、かかる内容を確認の上、許可した場合に限り、当該連携機能を利用することができるものとします。
                                </li>
                                <li>
                                    外部サービスのユーザーIDの登録・利用を含むすべての外部サービスの利用については、ユーザーは、外部サービスの運営者が規定する各規約の定めに従うものとします。
                                </li>
                                <li>
                                    外部サービスを利用する場合、ユーザーは、自己の責任において当該サービスを利用するものとし、当社は、当該サービスを利用したことにより生じた損害、当該サービスの運営者・利用者等との間に生じたトラブルその他の当該サービスに関連する一切の事項について何らの責任も負わないものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第７条（コイン）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    利用者は、本サイトに別途掲示する金額をお支払いいただくことで、コインを購入することができます。
                                </li>
                                <li>
                                    利用者は、本サービス内のライブ配信時において、投げ銭又は挙手の質問をする目的にのみコインを使用することができます。
                                </li>
                                <li>
                                    利用者は、当社が特に定めた場合を除き、コイン及びコンテンツの使用権を他の利用者その他第三者に使用させ、又は貸与、譲渡、売買、質入等をすることができないものとします。
                                </li>
                                <li>
                                    利用者は、当社が特に認めた場合を除き、コインの払い戻し、又はコインと当社の指定するコンテンツ以外のコンテンツとの交換を求めることはできないものとします。
                                </li>
                                <li>
                                    コインの具体的な使用期限については個々のコイン発行の際に当社が決定するものとします。なお、有償で発行するコインの使用期限についてはいかなる場合でも１８０日を超えることはないものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第８条（収益分配）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    当社は、出品者より出金の申請があった場合、当社所定の手数料及び出金手数料を控除した残額を出品者に支払うものとします。なお、収益の支払い方法等は当社が自由に定めることができ、かつ、当社は適宜自由に変更することができるものとします。
                                </li>
                                <li>
                                    当社は、出品者が実施するライブ配信の内容または当該ライブ配信を視聴する利用者の行動等に基づき、当社の定める方法により出品者の当該ライブ配信を評価し、その評価に基づき当社が定める金員（以下、「分配金」といいます）を、当社が本サービスにおいて得た収益から収益分配として支払うものとします。なお、配信者が実施するライブ配信の評価方法、分配金の支払方法等は当社が自由に定めることができ、かつ当社が自由に変更できるものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第９条（利用料・手数料など）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list--style1 list">
                                <li>
                                    出品者が当社に対して支払う手数料は、別途当社と出品者との間で合意した金額とします。
                                </li>
                                <li>
                                    出品者は、当社に対し、利用者より支払われる料金を代理受領する権限を付与するものとし、利用者から直接料金を受領してはならないものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１０条（ポイント）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style2">
                                <li>
                                    ユーザーは、本サービスにおけるレビューを投稿することにより、別途当社が定めるポイントを獲得することができるものとします。
                                </li>
                                <li>ユーザーは、本サービスの決済としてポイントを使用することができます。</li>
                                <li>
                                    ポイントの具体的な使用期限については個々のコイン発行の際に当社が決定するものとします。なお、ポイントの使用期限についてはいかなる場合でも１８０日を超えることはないものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１１条（知的財産権）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            本サービスに関する一切の情報についての著作権及びその他の知的財産権（ただし、ユーザーが本サイト等を通じて、第三者の権利を侵害することなく送信したデータを除きます）はすべて当社又は当社にその利用を許諾した権利者に帰属します。ユーザーは、複製、譲渡、貸与、翻訳、改変、転載、公衆への送信（公衆への送信を可能とすることを含みます）、転送、配布、出版、営業のための使用等をしてはならないものとします。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１２条（禁止事項）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            ユーザーは、本サービスの利用にあたり、以下の行為を行わないものとします。
                            <br>
                            <ol class="list list--style2 ml-1">
                                <li>本サービスの円滑な提供を妨げる行為又は妨げる恐れのある行為</li>
                                <li>当社又は第三者の知的財産権若しくは他の権利・利益を侵害する行為又は侵害する恐れのある行為</li>
                                <li>法令若しくは公序良俗に違反する行為又は違反する恐れのある行為</li>
                                <li>犯罪行為に関連する行為</li>
                                <li>面識のない異性との出会いや交際及びその媒介を目的とする行為</li>
                                <li>本サービスによって得られた情報を商業的に利用する行為</li>
                                <li>当社のサービスの運営を妨害する恐れのある行為</li>
                                <li>不正な目的をもって本サービスを利用する行為</li>
                                <li>当社又は第三者の名誉・信用を毀損する行為又は毀損する恐れのある行為</li>
                                <li>当社又は第三者を誹謗、中傷する行為又は誹謗、中傷、攻撃、脅迫、扇動、罵倒する恐れのある行為</li>
                                <li>その他、当社が不適切と判断する行為</li>
                            </ol>

                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１３条（情報の保存）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            当社は、ユーザーが送受信したメッセージその他の情報を運営上一定期間保存していた場合であっても、かかる情報を保存する義務を負うものではなく、当社はいつでもこれらの情報を削除できるものとします。なお、当社は本条に基づき当社が行った措置に基づきユーザーに生じた損害について一切の責任を負いません。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１４条（本サービスの提供の停止等）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>当社は、以下のいずれかの事由があると判断した場合、ユーザーに事前に通知することなく、本サービスの全部または一部の提供を停止又は中断することがあります。
                                    <ol class="list list--style2">
                                        <li>本サービスに係るコンピュータシステムの保守点検又は更新を行う場合</li>
                                        <li>コンピューター又は通信回線等が事故により停止した場合
                                        </li>
                                        <li>地震、落雷、火災、風水害、停電、天災地変などの不可抗力により本サービスの提供が困難となった場合
                                        </li>
                                        <li>その他、当社が本サービスの提供が困難と判断した場合
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    当社は、本サービスの提供の停止又は中断により、ユーザー又は第三者が被ったいかなる不利益または損害について、理由を問わず一切の責任を負わないものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１５条（利用制限および登録抹消）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    当社は、以下の場合には、事前の通知なく、当該ユーザーに対して、本サービスの全部もしくは一部の利用を制限し、またはユーザーとしての登録を抹消することができるものとします。
                                    <ol class="list list--style2">
                                        <li>
                                            本規約のいずれかの条項、又は関連法令に違反した場合
                                        </li>
                                        <li>
                                            登録事項等に虚偽の事実があることが判明した場合
                                        </li>
                                        <li>
                                            その他、当社が本サービスの利用を適当でないと判断した場合
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    当社は、本条に基づき当社が行った行為によりユーザーに生じた損害について、一切の責任を負いません。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１６条（本規約の変更)
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>当社は以下の場合に、当社の裁量により、本規約を変更することができます。
                                    <ol class="list list--style2">
                                        <li>本規約の変更が、ユーザーの一般の利益に適合するとき
                                        </li>
                                        <li>
                                            本規約の変更が、契約した目的に反せず、かつ、変更の必要性、変更後の内容の相当性、変更の内容その他の変更に係る事情に照らして合理的なものであるとき
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    当社は前項による本規約の変更にあたり、事前に利用規約を変更する旨及び変更後の利用規約の内容とその効力発生日を本サービス上にて掲示し、またはユーザーに電子メールで通知するものとします。
                                </li>
                                <li>
                                    変更後の利用規約の効力発生日以降にユーザーが本サービスを利用したときは、ユーザーは、利用規約の変更に同意したものとみなします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１７条（規約違反があった場合の取り扱い）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    当社は、ユーザーが本サービスの不正利用など利用規約等の何らの条項に違反した場合、本サービスの使用差止め、サービスの利用停止（アカウント停止）、強制退会、損害賠償請求（合理的な弁護士費用を含む）等の措置を取ることができます。
                                </li>
                                <li>
                                    ユーザーによる不正使用を含む利用規約等の違反に関連し、生起する第三者との法的請求や責任については、当社は一切責任を負わず、利用規約等に違反したユーザーは、自己の責任においてこれを処理し、当社に一切の迷惑や損害を与えないことを保証します。
                                </li>
                                <li>
                                    ユーザーが利用規約等に違反した場合で当社が必要と判断したとき、当社は、該当するユーザーの連絡先その他、当社が当該ユーザーに関して有する情報を、当該違反に関連する第三者に開示できるものとします。
                                </li>
                                <li>
                                    利用規約の違反等の報告が当社にあった場合、当社は、当該違反の是正について合理的な範囲での最善の措置を講ずるよう努め、当社の裁量で当社が行う対応を決定することができるものとします。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１８条（保証の否認及び免責）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    当社は、本サービスに事実上又は法律上の瑕疵（安全性、信頼性、正確性、完全性、有効性、特定の目的への適合性、セキュリティなどに関する欠陥、エラーやバグ、権利侵害などを含みます）がないことを明示的にも黙示的にも保証しておりません。
                                </li>
                                <li>
                                    当社は、本サービスに起因してユーザーに生じたあらゆる損害について一切の責任を負いません。ただし、本サービスに関する当社とユーザーとの間の契約（本規約を含みます）が消費者契約法に定める消費者契約となる場合、この免責規定は適用されません。
                                </li>
                                <li>
                                    前項ただし書に定める場合であっても、当社は、当社の過失（重過失を除きます）による債務不履行または不法行為によりユーザーに生じた損害のうち特別な事情から生じた損害（当社またはユーザーが損害発生につき予見し、または予見しえた場合を含みます）について一切の責任を負いません。
                                </li>
                                <li>
                                    当社は、本サービスに関して、ユーザーと他のユーザー又は第三者との間において生じた取引、連絡又は紛争等について一切の責任を負いません。
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第１９条（秘密保持）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    本規約において「秘密保持」とは、利用契約又は本サービスに関連して、ユーザーが当社より書面、口頭若しくは記録媒体等により提供若しくは開示されたか、又は知りえた、当社の技術、営業、業務、財務、組織、その他の事項に関する全ての情報を意味します。ただし、
                                    <ol class="list list--style2">
                                        <li>当社から提供若しくは開示がなされたとき又は知得したときに、既に一般に公知となっていた、又は既に知得していたもの、</li>
                                        <li>当社から提供若しくは開示又は知得した後、自己の責めに帰せざる事由により刊行物その他により公知となったもの、</li>
                                        <li>提供又は開示の権限のある第三者から秘密保持義務を負わされることなく適法に取得したもの、</li>
                                        <li>秘密情報によることなく単独で開発したもの、</li>
                                        <li>当社から秘密保持の必要なき旨書面で確認されたものについては、秘密情報から除外するものとします。</li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第２０条（分離可能性）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            本規約のいずれかの条項又はその一部が、消費者契約法その他の法令等により無効又は執行不能と判断された場合であっても、本規約の残りの規定及び一部が無効又は執行不能と判断された規定の残りの部分は、継続して完全に効力を有するものとします。
                        </div>
                    </div>
                    <div class="expand-item js-expandable">
                        <h3 class="expand-item__title">
                            <div class="expand-item__title--text">
                                第２１条（準拠法および管轄裁判所）
                            </div>
                            <div class="expand-item__title--icon">
                                <img src="{{ url('assets/img/icons/dropdown-arrow-black.svg') }}" alt="expand-icon">
                            </div>
                        </h3>
                        <div class="expand-item__content">
                            <ol class="list list--style1">
                                <li>
                                    本規約の解釈に当たっては、日本法を準拠法とします。
                                </li>
                                <li>
                                    本サービスに関して紛争が生じた場合には、当社の所在地を管轄する裁判所を専属的合意管轄とします。
                                </li>
                            </ol>
                            <br>
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
                        $(expand).animate({ height: content_height + title_height }, 200)
                    } else {
                        $(expand).animate({ height: title_height }, 200)
                    }
                    $title.toggleClass('active')
                })
            }
        }

        expand();
    </script>

@endsection
