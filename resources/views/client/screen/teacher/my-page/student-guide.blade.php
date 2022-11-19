@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/guide.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }

        .teacher-guide__content__step__one {
            margin-top: 30px;
        }

        .teacher-guide__content__step__one {
            margin-bottom: unset;
        }
    </style>
@endsection
@section('content')
    <div class="teacher-guide">
        <div class="teacher-guide__block">
            <div class="teacher-guide__block__title">
                <div class="teacher-guide__block__title__text f-w6">サービスを購入する</div>
                <div class="teacher-guide__block__title__tag">
                    <div class="teacher-guide__block__title__tag__text"></div>
                </div>
            </div>

        </div>
        <div class="teacher-guide__content">
            <div class="teacher-guide__content__block">
                <div class="teacher-guide__content__block__title f-w6">サービスの購入をしたい</div>
                <div class="teacher-guide__content__block__note f-w6">「疑問・悩み・問題」を解決！</div>
            </div>
            <div class="teacher-guide__content__block-two">
                <div class="none-mobile">
                    <div class="teacher-guide__content__block-two__black">オンラインサービス（ ライブ配信・ビデオ通話 ）を通じて</div>
                    <div class="teacher-guide__content__block-two__black">出品者の皆んなが持っている知識や経験を共有することで</div>
                    <div class="teacher-guide__content__block-two__black">あなたの「疑問・悩み・問題」を解決しませんか！</div>
                </div>
                <div class="none-pc">
                    <div class="teacher-guide__content__block-two__black">オンラインサービス（ ライブ配信・ビデオ通話 ）を通じて出品者の皆んなが持っている知識や経験を共有することであなたの「疑問・悩み・問題」を解決しませんか！</div>
                </div>
            </div>
            <div class="teacher-guide__content__step">
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title f-w6">STEP 1</div>
                    <div class="teacher-guide__content__step__one__bold f-w6">サービスを探す
                    </div>
                    <div class="teacher-guide__content__step__one__note">カテゴリ一覧、ランキング、新着サービスの中からサービスを探します。
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title f-w6">STEP 2</div>
                    <div class="teacher-guide__content__step__one__bold f-w6">出品者に質問をする場合</div>
                    <div class="teacher-guide__content__step__one__note">サービスの内容の詳細や、その他質問がある場合は</div>
                    <div class="teacher-guide__content__step__one__note">出品者プロフィールの（質問をする）より質問をお送り下さい。</div>
                    <div class="teacher-guide__content__step__one__avatar avatar-student avatar-student-guide">
                        <img src="{{url('/assets/img/clients/teacher/view-user.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile">
                        <img src="{{url('/assets/img/clients/teacher/view-user.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold f-w6">メッセージを確認する場合</div>
                    <div class="teacher-guide__content__step__one__note">
                        出品者への質問の返信は登録メールアドレスに送られます。また、購入者マイページの（お問い合わせ）の該当するサービス一覧に
                    </div>
                    <div class="teacher-guide__content__step__one__note">(受信) ✅が表示されますのでメッセージ<img
                                src="{{url('assets/img/icons/email-down.svg')}}" alt=""
                                class="email-down-icon">から確認して下さい。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar avatar-student course-my-page-guide">
                        <img src="{{url('/assets/img/clients/teacher/image47-student-guide.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile">
                        <img src="{{url('/assets/img/clients/teacher/image40.svg')}}" alt="">
                    </div>
                </div>

                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title f-w6">STEP 3</div>
                    <div class="teacher-guide__content__step__one__bold f-w6">サービスを購入する</div>
                    <div class="teacher-guide__content__step__one__note">購入手続きへ進み決済する。
                    </div>
                    <div class="teacher-guide__content__step__one__avatar avatar-student course-detail-guide">
                        <img src="{{url('/assets/img/clients/teacher/image5.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile">
                        <img src="{{url('/assets/img/clients/teacher/image41-1.svg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__bold f-w6">クレジットカードがご利用いただけます。</div>
                    <div class="teacher-guide__content__step__one__avatar avatar-student payment-guide">
                        <img src="{{url('/assets/img/clients/teacher/image36.png')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile">
                        <img src="{{url('/assets/img/clients/teacher/image81.svg')}}" alt="">
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
