@extends('client.base.base')
@section('content')
    <div class="guidelines-wrap text-center">
        <section class="guidelines-header">
            <span class="guidelines-header__title f-w6">ガイドライン禁止行為</span>
        </section>
        <section class="guidelines-content mx-auto">
            <img src="{{asset('assets/img/clients/teacher/guidelines.svg')}}" alt="logo-guidelines">
            <span class="guidelines-content__title f-w6">以下の行為は禁止します。</span>
            <div class="content-list">
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>犯罪行為に結びつく行為、若しくは犯罪行為を助長に関連する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>宗教活動、およびマルチ商法・ネズミ講などの勧誘・奨励</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>公序良俗に反する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>特定の個人、団体への誹謗中傷や名誉・信用を毀損する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>参加者からの承諾を得ないで参加者の肖像権やプライバシーを侵害しうる行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>配信内容が参加者の安否に危険を及ぼすリスクが高い行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>卑猥な表現又はわいせつな行為を含む情報</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>告知内容と著しく異なる内容で配信を提供する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>肖像権、プライバシー、その他の権利を侵害する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>本サイトのシステムを利用せず代金の支払いの誘導行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>当サイトの運営を妨害する行為</span>
                </div>
                <div class="content-list__item d-flex align-items-center">
                    <img src="{{asset('assets/img/clients/teacher/guidelines-icon.svg')}}" alt="logo-guidelines">
                    <span>ご利用規約・ご利用ガイドに反する行為</span>
                </div>
            </div>
        </section>
    </div>
@endsection
