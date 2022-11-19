@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/seller_guidelines.css') }}" rel="stylesheet">
@endsection
@section('header')
    <meta name="description" content="オンライン形式による３つのサービス">
    <title>出品者ガイドライン</title>
@endsection
@section('content')
    <header class="seller-guidelines__header">
        <h1 class="title f-w6">出品者ガイドライン</h1>
        <div class="hr"></div>
    </header>
    <div class="main">
        <div class="seller-guidelines">
            <div class="seller-guidelines__content-header">
                    <h1 class="f-w6">オンライン形式による３つのサービス</h1>
                    <ul class="seller-guidelines__content-header__option-seller">
                        <li>１）教えて！ライブ配信（ライブ配信）１対複数</li>
                        <li>２）オンライン悩み相談（ビデオ通話）１対１</li>
                        <li>３）オンライン占い　　（ビデオ通話）１対１</li>
                        <li class="seller-guidelines__content-header__option-seller__attentive">出品者アカウントでは上記のサービスのいずれか１つを選択できます</li>
                    </ul>
                </div>
            <div class="seller-guidelines__content-header__note f-w6">出品者がサービスを配信する場合に該当するガイドラインを以下に定義します。</div>
            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">１.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">本人確認書類の提出について</div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="seller-guidelines__content__service-listing__right__title mb-10px">
                            Lappiでは安心してサービスを受けて頂くために、全ての出品者から本人確認書類のご提出をお願いしています。
                            <br>
                            ※本人確認の承認には約３営業日程度かかります。（土日・祝日・休日除く) 提示可能な本人確認書
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                運転免許証（表面・裏面）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
{{--                                健康保健所 <span class="ml-3"></span>（表面・裏面）--}}
                                パスポート（顔写真入りページ・住所記載ページ）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number"> ３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
{{--                                パスポート <span class="ml-3"></span>（顔写真入り・住所記載ページ）--}}
                                マイナンバーカード（表面のみ）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
{{--                                住民票 <span class="ml-5"></span> ※個人番号（マイナンバー）の記載された住民票は利用できません。--}}
                                在留カード（表面・裏面）
                            </div>
                        </div>
{{--                        <div class="rules">--}}
{{--                            <div class="seller-guidelines__content__service-listing__number">５）</div>--}}
{{--                            <div class="seller-guidelines__content__service-listing__right__black">--}}
{{--                                住民基本台帳 (表面・裏面）--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="rules">--}}
{{--                            <div class="seller-guidelines__content__service-listing__number">６）</div>--}}
{{--                            <div class="seller-guidelines__content__service-listing__right__black">--}}
{{--                                在留カード　（表面・裏面）--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="rules">--}}
{{--                            <div class="seller-guidelines__content__service-listing__number">７）</div>--}}
{{--                            <div class="seller-guidelines__content__service-listing__right__black">--}}
{{--                                国民年金手帳（住所記載ページ）--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__right__black">
                                ※上記の書類に不備がある場合
                            </div>
                        </div>
                        <div class="warning-note">
                            ＜注意点＞

                            <div class="d-flex"><span>・</span><span>氏名、生年月日、現住所が確認できる本人確認書類が必要です。</span></div>

                            <div class="d-flex"><span>・</span><span>日本国内発行の本人確認書類に限ります。</span></div>

                            <div class="d-flex"><span>・</span><span>画像が加工されていたり、一部隠されている場合は、健康保険証の保険者番号等の一部情報を除き、申請書類として承認できかねる場合があ ります。</span>
                            </div>

                            <div class="d-flex"><span
                                        class="ml-3"></span><span>※本人確認書類の氏名と振込口座の口座名義が一致しない場合は振込登録はできません。</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">２.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">
                            ニックネーム又は、お名前（本名またはビジネスネーム）での公開について
                        </div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="seller-guidelines__content__service-listing__right__title">
                            Lappiのサービスでは出品者のみ、新規会員登録時のニックネーム又はお名前 (本名またはビジネスネーム）
                            <br>
                            のどちらかでの公開が必須になります。※ユーザーはニックネームで公開
                        </div>
                    </div>

                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">３.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">新規サービスの作成について</div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                オンライン（悩み相談・占い）サービスでは新規作成ページで作成後から公開することができます。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                教えて！ライブ配信のサービスでは新規サービス作成後に審査で承認が必要です。
                                <br>
                                ※申請から承認まで３営業日程度かかります。（土日・祝日・休日除く）
                                <br>
                                また、サービスの内容及び出品者のプロフィールによってはサービスの公開をお断りする場合があります。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                教えて！ライブ配信での新規サービス作成では、上記の審査が承認されてから開催日時、オプションの設定後に公開ができます。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                教えて！ライブ配信のサービスでは、２回目以降の同じサービス（全ての内容が同じ) の公開の場合は審査なく何度でも公開できます。
                                <br>
                                ※サブカテゴリの選択、タイトルの変更はできません。 内容に変更がある場合は新規サービス作成となり申請が必要になります。
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">４.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">公開申請をお断りする場合があるサービスと出品者について
                        </div>

                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                政治に関連する講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                宗教に関連する講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                薬物や犯罪などの関与に関わるおそれのある講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                金融商品、不動産投資などに関する販売や勧誘などのおそれがある講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">５）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                ヒーリング・セラピー・スピリチュアル・睡眠術に関する講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">６）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                交流やイベントの勧誘を目的としたおそれのある講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">７）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                営業、販売、採用を目的としたおそれのある講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">８）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                ネットワークビジネスへの関与が疑われると当社が判断した講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">９）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                受講者に危険を及ぼすリスクの高いと当社が判断した講座
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">10）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                その他、当社が不適切と判断した講座及び出品者の講座
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">５.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">サービスの公開後の内容の変更について</div>

                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                サービス公開後に購入者がまだいない場合ライブ配信サービスでは承認を得たサービスの（サブカテゴリ・タイトル）の変更はできません。
                                <br>
                                オンライン（悩み相談・占い）では購入者がまだいない場合はサービス内容の加筆修正を行う事が出来ます。
                                <br>
                                開催日時、利用時間、金額の変更も可能ですが内容の大幅な変更はお控え下さい。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                購入者がいる場合 全ての配信サービスでは購入者が発生した後の内容の変更はいっさい出来ません。
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">６.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">
                            サービス代金の設定について（入場料・相談料・鑑定料）※価格表示は全て税込です
                        </div>

                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number"> １）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                教えて！ライブ配信
                                <br>
                                入場料として1,000円〜5,000円までの設定が可能（利用時間は30分,40分,50分,60分の中から選択）
                                <br>
                                個別講座の料金の設定は1,000円以上から可能（利用時間は30分,40分,50分,60分の中から選択）
                                <br>
                                ※個別講座はオプション設定の有無で選択可
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                オンライン（悩み相談・占い）
                                <br>
                                相談料、鑑定料は1,000円以上から設定が可能（利用時間は20分,30分,40分,50分,60分の中から選択）
                                <br>
                                延長リクエストの料金の設定は1,000円以上から可能（利用時間は15分,20分,30分の中から選択）
                                <br>
                                ※延長リクエスト設定の有無で選択可
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">７.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">禁止事項について</div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                犯罪行為に結びつく行為、若しくは犯罪行為を助長に関連する行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                宗教活動、およびマルチ商法・ネズミ講などの勧誘・奨励
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                公序良俗に反する行為（反社会的勢力との関係示唆、もしくは民族・人種・性別・年齢等による差別につながる表現を含む）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                特定の個人、団体へ迷惑をかけたり不利益を与える行為、誹謗中傷や名誉・信用を毀損する行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">５）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                参加者からの承諾を得ないで参加者の肖像権やプライバシーを侵害しうる行為（写真撮影、動画配信などを含む）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">６）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                配信内容が参加者の安否に危険を及ぼすリスクが高い行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">７）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                卑猥な表現又はわいせつな行為を含む情報並びに、第三者の承諾を得ることなく第三者の容貌又は肢体等を撮影したものを利用
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">８）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                告知内容と著しく異なる内容で配信を提供する行為（価格、日時を含む）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">９）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                Lappiを含む第三者の知的財産権（著作権・意匠権・特許権・実用新案権・商標権・ノウハウが含まれるがこれらに限定されない）
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">10）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                肖像権、プライバシー、その他の権利を侵害する行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">11）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                Lappiへの手数料の支払いを意図的に回避する行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">12）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                外部サイトへの誘導や（メール・電話・SNS）などで直接本サイトのシステムを利用せず代金の支払いの誘導行為
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">13）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                当サイトの運営を妨害する行為
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">14）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                その当社が不適切と判断する行為
                            </div>
                        </div>
                        <div class="rules mb-1">
                            <span class="f-w6">
                                その他Lappiで提供するサービスとして相応しくないと当社が判断した行為
                            </span>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__right__black">
                                <div> 過去を含め、出品者の活動がLappiの内外関係なく相応しくない行為を行ったものと当社が判断した場合は</div>
                                <div> 当社はその事実をベースに以降の出品者のサービスの公開をお断りする権利を持つと共に</div>
                                <div> その事実をサイト上で公表することができるものとし、出品者はこれを一切の異議を申し立てないものとします。</div>
                                <div> また、公表によって出品者に生じる場合がある損害などについて、当社は一切の責任を負わないものとします。</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">８.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">手数料のお支払いと報酬の受け取りについて</div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                手数料、システム利用料の支払いについて
                                <br>
                                出品者は利用規約に従い、Lappiを通じて出品サービスを購入した購入者が支払われた代金の総額から出品者と当社で合意されている
                                <br>
                                手数料を当社に対して支払うものとします。手数料の適用比率と金額については出品者と当社の別途合意がされていない限り
                                <br>
                                手数料記載ページに定義してある通りとします。手数料は消費税相当額を含まない金額を意味するものとし、出品者は別途消費税相当額を
                                <br>
                                当社に支払うものとします。※キャンセル手数料（出品者の自己都合による場合のみ）は消費税が含まれています。
                                <br>
                                また、システム利用料については出品者が「教えて！ライブ配信」サービスの利用時に配信を実施した場合のみシステム利用料ページに
                                <br>
                                記載されている費用がかかります。システム利用料は消費税相当額を含まない金額を意味するものとし、出品者は別途消費税相当額を
                                <br>
                                当社に支払うものとします。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                報酬の受け取りについて
                                <br>
                                出品者は当社に対する手数料などの支払いを担保する為に、購入者が出品者に対して支払う代金のうち手数料に相当する金額を
                                <br>
                                当社が出品者に代わって受領する権限を当社に対して付与するものとします。　
                                <br>
                                当社は出品者に代わって受領した代金を持って手数料の支払いに充当する事ができるものとし、代金及び手数料の支払いに関する
                                <br>
                                一連の過程において利息は発生しないものとします。
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">９.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">出品者のキャンセルについて</div>
                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                公開されたサービスの開催義務と、キャンセル・中止の原則禁止について
                                <br>
                                出品者はサービスの公開後は責任を持って告知した内容通りサービスの開催する義務を負うものとします。
                                <br>
                                出品者は当社が設けているキャンセル及び返金のルールに対して齟齬のあるキャンセルポリシーを別途定義及び提示できないものとします。
                                <br>
                                出品者側の理由による開催のキャンセル・中止はやむを得ない場合を除いては原則できないものとします。
                                <br>
                                <div class="cancel-rules-text-nine-one">
                                    <span>また、出品者が開催のキャンセルにあたって本ガイドラインに定めるプロセスを経ず、予約者から、開催の実態やキャンセルプロセスに</span>
                                    <span> ついての異議申し立てが発生した場合、当社は出品者に警告を発することがあります。</span>
                                </div>
                                もし出品者が当社の忠告を聞き入れなかった場合、あるいは従わないと当社が判断した場合は、以降のサービスの作成・開催および
                                <br>
                                その他のユーザー機能の利用権利を剥奪する可能性がありますのでご留意ください。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                やむを得ない場合における開催のキャンセルについて
                                <br>
                                <span>出品者は日程を公開したとき以降、やむを得ない場合を除いては原則、責任を持って告知した内容の通りに日程を開催する義務を負う事と</span>
                                <span>します。 万が一、やむを得ない理由により出品者側からサービスの開催をキャンセルしなければならない事態が発生した場合はサービスが</span>
                                <span>まだ開催されていないタイミングにおいてのみ、出品者が速やかに以下のプロセスに沿って対応するものとします。</span>
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                開催のキャンセルを決定した時点で、「販売サービス管理」のキャンセルの連絡のメッセージ機能を用いて、予約者全員に対して
                                <br>
                                開催をキャンセルすること及びキャンセル理由やキャンセルと同時に返金処理が行われる旨を伝えていただきます。
                                <br>
                                メッセージ機能ではキャンセルの連絡を購入者全員への送信と同時にキャンセル処理が行われます。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                キャンセルメールに返金に関して説明の定型文章が自動で表示されてますが、購入者へはその旨の説明も併記する。
                                <br>
                                また、開催のキャンセルに際する返金やサービスの振替実施などの一切の対応は、出品者に委ねるものとし、その実施に伴ういかなる争いや
                                <br>
                                損害が発生した場合についても、当社は一切の責任を負わず不介入の立場をとるものとします。
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">10.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">購入者のキャンセルについて</div>

                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">
                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                開催日前日21:59分までのキャンセル申し出について
                                <br>
                                購入者は開催日前日21:59分までは予約キャンセルが可能であり、当社はサービス代金を購入者に返還するものとします。
                                <br>
                                なお、購入者はキャンセル締切日時までのキャンセルについては、当社側の理由によりキャンセルが実行できなかった場合を除いて
                                <br>
                                返金を伴う予約のキャンセル成立には、購入者自信がサイト上でキャンセルの実行を行いキャンセル確定の自動通知メールを
                                <br>
                                確認する必要があります。購入者側からの任意の連絡のみでは予約のキャンセルは成立したものとはみなされませんのでご留意ください。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                キャンセル締切日時経過後のキャンセルについて
                                <br>
                                購入者はキャンセル締切日時を経過した後は、いかなる理由においても予約をキャンセルすることはできないものとし
                                <br>
                                出品者に対してはサービス代金の返金や振替対応の義務は原則発生しないものとします。
                                <br>
                                仮に、キャンセル締切日時経過後の参加のキャンセル要望が発生した場合、その際の返金などの一切の判断と対応は出品者に委ねるものとし
                                <br>
                                その実施に伴ういかなる争いや損害が発生した場合についても、当社は一切の責任を負わず不介入の立場をとるものとします。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                開催キャンセルの実行について
                                <br>
                                開催キャンセルの実行については、一度実行するとシステム上取り消し及び変更処理ができないことを理解し、慎重な判断と
                                <br>
                                対応をする必要がある旨ご留意ください。
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="seller-guidelines__block">
                <div class="seller-guidelines__service-listing">
                    <div class="seller-guidelines__service-listing__left">
                        <div class="seller-guidelines__service-listing__left__one f-w6">11.</div>
                        <div class="seller-guidelines__service-listing__left__two f-w6">その他</div>

                    </div>
                    <div class="seller-guidelines__service-listing__three"><img
                                src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt=""
                                class="icon-dropdown-type"></div>
                </div>
                <div class="seller-guidelines__content">

                    <div class="seller-guidelines__content__service-listing__right">
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">１）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                オンラインサービスに必要な環境について
                                <br>
                                出品者は、サービスを配信するための外部環境、通信速度等、安定してオンライン講座が開催できる環境づくりに努めるものとします。
                                <br>
                                なお、PCをはじめとした各種機器及び通信環境のみ出品者自身で用意し、かかる費用はすべて出品者の自己負担となります。
                                <br>
                                ※ご自身でのZoomなどのビデオ通話サービスの契約は必要ございません。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">２）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                参加者への配信を開始する使用方法の対応について
                                <br>
                                参加者への配信を開始する使用方法の案内、当日の配信開始に関するサポートは出品者自身がおこなうものとします。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">３）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                開催の中止について
                                <br>
                                サービス開始前・開催中において、出品者ご自身が用意するの通信端末や通信機器のトラブルによりサービスの開催が困難な場合は
                                <br>
                                出品者は、参加者と話し合い開催キャンセル（返金）などの適切な対応をとるものとします。
                                <br>
                                配信中に発生した購入者の機器・通信トラブルの原因の特定、責任の所在について、当社は一切の判断ができかねますので予めご
                                <br>
                                了承ください。
                                <br>
                                尚、参加者から当社に対し、通信品質等に関する報告が複数回あり、当社が改善の必要があると判断した場合
                                <br>
                                出品者に対し通信品質改善についての通告、またはオンラインサービスの掲載の停止をさせて頂く場合がございます。
                            </div>
                        </div>
                        <div class="rules mb-10px">
                            <div class="seller-guidelines__content__service-listing__number">４）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                配信サービスの録画について
                                <br>
                                配信サービスの録画機能はございません。又承諾得ていない参加者の映像・声を含むデータファイルを無断でインターネット等に
                                <br>
                                掲載することは出来ません。
                            </div>
                        </div>
                        <div class="rules">
                            <div class="seller-guidelines__content__service-listing__number">５）</div>
                            <div class="seller-guidelines__content__service-listing__right__black">
                                購入者からの異議申し立てについて
                                <br>
                                サービスを受講した参加者は、購入サービスが現実に開催されたのか否かについて、当社に異議申し立てができることとします。
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
            $('.seller-guidelines__content').hide();
            $('body').on('click', '.seller-guidelines__service-listing', function () {
                $(this).find('img').toggleClass('img-rotate'); //Add class to img tag.
                $(this).closest('.seller-guidelines__block').find('.seller-guidelines__content').slideToggle(); //Find element in block .
            })
        })
    </script>
@endsection
