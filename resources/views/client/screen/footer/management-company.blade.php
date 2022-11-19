@extends('client.base.base')
@section('header')
@endsection
@section('css')
    <link href="{{ mix('css/clients/modules/footer/management-company.css') }}" rel="stylesheet">
@endsection
@section('header')
    <meta name="description"
          content="喜び・感動・幸せを分かち合う人になれると、もっと幸福度が高い人生を送ることができます。誰もが持っているたくさんの経験や知識を、たくさんの人達と共有することで多くの喜びや感動を与え人の喜びが自分の喜びになり、みんなでみんなの幸せを作りあげていく、そんな世界を目指します。">
    <title>VISIONみんなでみんなの幸せを作り上げていく世界へ</title>
@endsection
@section('content')
    <div class="management_company-page__top">
        <!-- <div class="management_company_banner"></div> -->
        <img class="management_company_banner--pc" src="{{ asset("assets/img/management-company/banner_pc.png") }}"
             alt="">
        <img class="management_company_banner--sp" src="{{ asset("assets/img/management-company/banner_pc.png") }}"
             alt="">
        <div class="main ">
            <div class="container">
                <div class="banner-content">
                    <h2>vision</h2>
                    <span>みんなでみんなの幸せを作り上げていく世界へ</span>
                    <p>喜び・感動・幸せを分かち合う人になれると、もっと幸福度が高い人生を送ることができます。<br>
                        誰もが持っているたくさんの経験や知識を、たくさんの人達と共有することで多くの喜びや感動を与え<br>
                        人の喜びが自分の喜びになり、みんなでみんなの幸せを作りあげていく、そんな世界を目指します。</p>
                </div>
            </div>
        </div>
    </div>
    <div class="management_company-page--gray">
        <h3 class="f-w6">MISSION</h3>
        <span class="f-w6">誰もが持っているたくさんの経験や知識を共有し<br>「疑問・悩み・問題」を解決する</span>
    </div>


    <div class="management_company-page-form">
        <div class="form-content">
            <h3 class="form-heading f-w6">Company</h3>
            <div class="item">
                <div class="item-left">
                    <span>会社名</span>
                </div>
                <div class="item-right">
                    <span>株式会社Lappi</span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>設立日</span>
                </div>
                <div class="item-right">
                    <span>令和３年４月２２日</span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>代表</span>
                </div>
                <div class="item-right">
                    <span>代表取締役社長　高橋 真二 </span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>資本金</span>
                </div>
                <div class="item-right">
                    <span>１,０００万円</span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>事業内容</span>
                </div>
                <div class="item-right">
                    <span class="business-content">「疑問・悩み・問題」を解決のオンラインスキルシェア<span>『Lappi』のサイト開発・運営</span> </span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>メールアドレス</span>
                </div>
                <div class="item-right">
                    <span>info@lappi-live.com</span>
                </div>
            </div>
            <div class="item">
                <div class="item-left">
                    <span>事務所</span>
                </div>
                <div class="item-right">
                    <span>〒531-0072 </span>
                    <span class="address">
                    大阪府大阪市北区豊崎３丁目１５番５号
                </span>
                </div>
            </div>

        </div>
    </div>

@endsection
