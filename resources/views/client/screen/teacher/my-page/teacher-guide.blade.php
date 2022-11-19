@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/guide.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }

        .teacher-guide__content__step__one {
            margin-top: 35px;
        }

        .teacher-guide__content__step__one {
            margin-bottom: unset;
        }

        .teacher-guide__content__step__one__avatar img {
            max-width: 820px;
        }
    </style>
@endsection
@section('content')
    <div class="teacher-guide">
        <div class="teacher-guide__block">
            <div class="teacher-guide__block__title">
                <div class="teacher-guide__block__title__text">サービスの出品（新規・再出品)</div>
                <div class="teacher-guide__block__title__tag">
                    <div class="teacher-guide__block__title__tag__text"></div>
                </div>
            </div>

        </div>
        <div class="teacher-guide__content">
            <div class="teacher-guide__content__block">
                <div class="teacher-guide__content__block__title">サービスの出品をしたい</div>
                <div class="teacher-guide__content__block__note">あなともLappiになりませんか！</div>
            </div>
            <div class="teacher-guide__content__block-two">
                <div>
                    <div class="teacher-guide__content__block-two__black">オンラインサービス（ライブ配信・ビデオ通話）を通じて
                        あなたの持っている<br class="none-mobile">豊富な知識や経験が「疑問・悩み・問
                        題」を抱えているたくさんの人たちに<br class="none-mobile">共有する事で解決し、
                        皆んながハッピーになれるお手伝いをしませんか！
                    </div>
                    {{-- <div class="teacher-guide__content__block-two__black"> 豊富な知識や経験が「疑問・悩み・問題」を抱えているたくさんの人達に</div>
                    <div class="teacher-guide__content__block-two__black"> 共有する事で解決し、皆んながハッピーになれるお手伝いをしませんか！</div> --}}
                </div>
            </div>
            <div class="teacher-guide__content__step">
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 1</div>
                    <div class="teacher-guide__content__step__one__bold">新規サービス作成
                    </div>
                    <div class="teacher-guide__content__step__one__note">出品者マイページの (販売サービス管理) の (＋新規サービス作成) からスタート
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image 43.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 2</div>
                    <div class="teacher-guide__content__step__one__bold">サービス内容のサブカテゴリを選択する</div>
                    <div class="teacher-guide__content__step__one__bold">１）教えて！ライブ配信</div>
                    <div class="teacher-guide__content__step__one__note">新規出品者登録時に選択したご利用サービスが、カテゴリとして表示されます。</div>
                    <div class="teacher-guide__content__step__one__note">出品される内容を、サブカテゴリの中から選択して下さい</div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※教えて！ライブ配信サービスでは講座の申請から承認まで３営業日がかかります。(土日・祝日・休日除く)
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step2(1).svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image44.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">２）オンライン（悩み相談・占い）</div>
                    <div class="teacher-guide__content__step__one__note">
                        新規出品者登録時に選択したご利用サービスが、カテゴリとして表示されます。
                    </div>
                    <div class="teacher-guide__content__step__one__note"> 出品される内容をサブカテゴリの中から選択して下さい <span>※サービスの申請承認は不要です。</span>
                    </div>
                    <div class="teacher-guide__content__step__one__bold">(オンライン悩み相談)</div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/step2_2_1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image45.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">(オンライン占い)</div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step2(2).svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image46.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 3</div>
                    <div class="teacher-guide__content__step__one__bold">配信時の（顔出しOK・顔出しNG）いずれかの選択をする</div>
                    <div class="teacher-guide__content__step__one__note">顔出しNGの場合（Lappi ARエフェクト）のご利用で配信時の顔は全て見えません。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※選択した（顔出しOK・顔出しNG)はサイト上のプロフィール画面に表示されます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step3.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image47.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 4</div>
                    <div class="teacher-guide__content__step__one__bold">開催日時・ご利用時間の設定をする</div>
                    <div class="teacher-guide__content__step__one__note">開催日時と、ご利用時間の設定をします。同時に10件まで作成することが出来ます。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※教えて！ライブ配信サービスのみ、申請が承認されてから開催日時の設定ができます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/Step4.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image48.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 5</div>
                    <div class="teacher-guide__content__step__one__bold">料金・タイトル・画像・タイトル補足説明の設定と記入をする</div>
                    <div class="teacher-guide__content__step__one__note ">・全ての料金　　　：（入場料・相談料・鑑定料）は￥1000円以上から設定できます。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger custom-pl10">
                        ※教えてライブ配信サービスでは¥1,000〜￥5,000までの設定となります。
                    </div>
                    <div class="teacher-guide__content__step__one__note">・タイトル　　　　：（シンプルで短く、ターゲット層に分かりやすいタイトルを）
                    </div>
                    <div class="teacher-guide__content__step__one__note"> ・タイトル補足説明：（どんな方に、どんなサービスを提供し、何を解決するのか）
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger custom-pl10">
                        (例）教えて！ライブ配信（新規サービスの作成ページ）
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step5.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image49.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 6</div>
                    <div class="teacher-guide__content__step__one__bold">内容について・当日の流れ・ご利用にあたっての必要な情報を記入する</div>
                    <div class="teacher-guide__content__step__one__note hidden-sp">・内容について　　　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ：（具体的なサービスの詳細内容を記入して下さい。）
                    </div>
                    <div class="teacher-guide__content__step__one__note hidden-pc">
                        ・内容について　：（具体的なサービスの詳細内容を記入して下さい。）
                    </div>
                    <div class="teacher-guide__content__step__one__note">・当日の流れ
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）教えて！ライブ配信
                        ：（自己紹介・予定終了時間・定型スタンプ・ギフト・個別講座の設定がある場合）の説明
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）オンライン悩み相談 ：（自己紹介・予定終了時間・延長リクエストの設定がある場合）の説明
                    </div>
                    <div class="teacher-guide__content__step__one__note">
                        （例）オンライン占い：（自己紹介・予定終了時間・延長リクエスト・有料オプションの設定がある場合）のご利用の説明
                    </div>
                    <div class="teacher-guide__content__step__one__note">・ご利用に当たって
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例文）　　　　　　　　 <span
                                style="font-style: normal;font-weight: 600;font-size: 14px;color: #2A3242;">【必ずお読みください】ご購入された場合は以下をご同意頂きます。</span>
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）全てのサービス　　
                        ：開催日前日のリマインドメール（再確認）のURLより、開催時間15分前より配信準備画面に入室できます
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）ビデオ通話サービス
                        ：ARエフェクトやバーチャル背景をご利用の場合は、開催時間までにご準備ください。
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）全てのサービス　　
                        ：開始時間に配信が自動スタートしますので、遅刻の場合も終了時間を変更する事はできません。
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）全てのサービス　　 ：遅刻をされる場合は恐れ入りますが、ご連絡をください。
                    </div>
                    <div class="teacher-guide__content__step__one__note"> （例）全てのサービス　　
                        ：購入後の日程変更はできません。その場合は一旦キャンセルをして下さい。※前日21：59まで可能
                    </div>
                    <div class="teacher-guide__content__step__one__note">（例）全てのサービス　　
                        ：ユーザー様の都合での配信不具合や切断には当方は対応できません。ご了承ください。
                    </div>

                    <div class="teacher-guide__content__step__one__note"> ・ご利用に当たって：
                        <span>※特記する必要事項がある場合のみご利用ください。</span></div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step6.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image50.png')}}" alt="">
                    </div>
                </div>
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 7</div>
                    <div class="teacher-guide__content__step__one__bold">オプション設定する</div>
                    <div class="teacher-guide__content__step__one__bold">１）オンライン悩み相談</div>
                    <div class="teacher-guide__content__step__one__note">オプションの設定で（延長リクエスト）の設定の有無が選択できます。
                    </div>
                    <div class="teacher-guide__content__step__one__note">
                        既に公開されているサービスの開催時間と延長時間が被って設定してもどちらかのサービスが購入された時点で同じ時間帯のサービスは表示さ
                    </div>
                    <div class="teacher-guide__content__step__one__note">
                        れなくなります。
                    </div>

                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step7 (1).svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image51.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">２）オンライン占い</div>
                    <div class="teacher-guide__content__step__one__note">オプションの設定で（延長リクエスト）と（有料オプションアイテム）設定の有無が選択できます。
                    </div>
                    <div class="teacher-guide__content__step__one__note">
                        (延長リクエスト）は既に公開されているサービスの開催時間と延長時間が被って設定してもどちらかのサービスが購入された時点で同じ時間帯のサービスは表示されなくなります。
                    </div>
                    <div class="teacher-guide__content__step__one__note">
                        また、有料オプションも同時に設定できます。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※オプション設定での（有料オプション）は延長リクエスト設定時のみご利用できます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step7 (2).svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image52.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 8</div>
                    <div class="teacher-guide__content__step__one__bold">公開せずに下書き保存する</div>
                    <div class="teacher-guide__content__step__one__bold">１）下書き保存する</div>
                    <div class="teacher-guide__content__step__one__note">ページ下位の(下書きを保存）をクリックし保存する。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        （例）オンライン占い（新規サービスの作成ページ）
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step8.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image53.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 9</div>
                    <div class="teacher-guide__content__step__one__bold">新規サービスを公開する</div>
                    <div class="teacher-guide__content__step__one__bold">１）オンライン悩み相談、オンライン占い</div>
                    <div class="teacher-guide__content__step__one__note">プレビュー画面で最終確認後にページ下位の（公開する）をクリックで公開。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image54.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・下書き保存から公開する場合</div>
                    <div class="teacher-guide__content__step__one__note">出品者マイページの（販売サービス管理）の（下書き）の動作 (編集する) より公開して下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 2.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image55.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">２）教えて！ライブ配信</div>
                    <div class="teacher-guide__content__step__one__bold">・承認申請をする(STEP１)</div>
                    <div class="teacher-guide__content__step__one__note">プレビュー画面で最終確認後にページ下位の（承認申請）をクリックで申請を依頼する。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※教えて！ライブ配信サービスでは講座の申請から承認まで３営業日がかかります。（土日・祝日・休日除く）
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 3.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image56.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・申請完了（STEP 2・STEP 3）</div>
                    <div class="teacher-guide__content__step__one__note">STEP 1の承認申請が完了しましたら、出品者マイページ(販売サービス管理) の
                        (新規サービス作成)画面に(申請中) が表示されます。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 4.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image82.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・審査結果</div>
                    <div class="teacher-guide__content__step__one__note">
                        審査が完了しましたら、登録メールアドレスに審査結果が通知され、出品者マイページの(販売サービス管理）の（新規サービス作成）の画面に（
                    </div>
                    <div class="teacher-guide__content__step__one__note">(承認・否認）が表示されます。</div>
                    <div class="teacher-guide__content__step__one__note"> 結果通知の <img
                                src="{{url('assets/img/icons/email-down.svg')}}" alt=""
                                class="email-down-icon"> からも結果内容を確認できます。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※否認された場合出品者ご利用ガイド (公開申請をお断りする場合があるサービスと出品者について)をご参照下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 5.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image58.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・新規サービスの作成（STEP 2,3)</div>
                    <div class="teacher-guide__content__step__one__note">承認がされた場合は、サービスの出品の(編集画面へ)から新規作成ページ（STEP
                        2,3)へお進み下さい。<br class="word-wrap-sp">まず、STEP 2では(開催日時)の設定を 行って下さい。
                    </div>
                    <!-- <div class="teacher-guide__content__step__one__note"></div> -->
                    <div class="teacher-guide__content__step__one__note"> 開催日時とご利用時間の設定は、同時に10件まで作成することが出来ます。</div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※承認されたサービスの（サブカテゴリ・タイトル）の変更はできません。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9-ver2.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9-ver1.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・オプション設定</div>
                    <div class="teacher-guide__content__step__one__note">STEP ３では(オプション設定)を行って下さい。

                    </div>
                    <div class="teacher-guide__content__step__one__note">全ての設定が終わりましたら、プレビューで最終確認後に公開して下さい。</div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※オプション設定が必要な場合のみご利用下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 (step3).svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image60.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">・承認後（STEP 2,3）の下書き保存から公開する場合</div>
                    <div class="teacher-guide__content__step__one__note">出品者マイページの（販売サービス管理）の（下書き）の動作 (編集する) より公開して下さい。

                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step9 - 6.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image61.png')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title">STEP 10</div>
                    <div class="teacher-guide__content__step__one__bold">同じサービスを公開する</div>
                    <div class="teacher-guide__content__step__one__bold">１）教えて！ライブ配信</div>
                    <div class="teacher-guide__content__step__one__note">同じサービスの再公開の場合の承認申請は<br class="word-wrap-sp">必要ございません。
                    </div>
                    <div class="teacher-guide__content__step__one__text-danger">
                        ※サブカテゴリ・タイトルの変更はできません、変更したい場合は新規の承認申請が必要です。
                    </div>
                    <div class="teacher-guide__content__step__one__note">(販売サービス管理) の (新規サービス作成）画面の前回公開日のリストより、サービスの出品から
                        (編集画面へ)をクリックし、新規サービスの
                    </div>
                    <div class="teacher-guide__content__step__one__note">作成画面(STEP2,3)へ進みサービスを公開して下さい。</div>
                    <div class="teacher-guide__content__step__one__note">また、前回公開されたサービス内容が反映されていますので、必要で可能な部分を修正して下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step10 - 1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image62.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold">２）オンライン悩み相談、オンライン占い</div>
                    <div class="teacher-guide__content__step__one__note">(販売サービス管理) の
                        (新規サービス作成）画面の前回公開日のリストより、サービスの出品から(編集画面へ)をクリックし 新規サービスの作
                    </div>
                    <div class="teacher-guide__content__step__one__note">成画面へ進みサービスを公開して下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__note"> また、前回公開されたサービス内容が反映されていますので、必要な部分を修正して下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/guide/Step10 - 1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile teacher-guide-step1">
                        <img src="{{url('/assets/img/clients/teacher/image63.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
