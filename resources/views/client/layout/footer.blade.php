<footer id="footer" class="mobile-device">
    <div class="l-footer text-center">
        <div class="l-footer__content d-flex justify-content-between f-w3">
            <div class="l-footer__content__item tell-me">
                <label class="f-w6" for="">教えて！</label>
                <a href="{{ route('client.about-lappi') }}">Lappiって？</a>
                <a href="{{route('client.user-guide')}}">ご利用ガイド</a>
                <a href="{{route('client.about.payment-method')}}"> お支払い方法</a>
                <a href="{{route('client.safety-and-security')}}"> 安心・安全の理由</a>
            </div>
            <div class="l-footer__content__item teach">
                <label class="f-w6" for="">教える</label>
                <a href="{{ route('client.become-lappi') }}">Lappiになる方募集</a>
                <a href="{{route('client.usage-fee')}}">サービス手数料について</a>
                <a href="{{route('client.seller-guidelines')}}">出品者ガイドライン</a>
                <a href="{{route('client.seller-rank')}}">出品者ランク</a>
            </div>
            <div class="l-footer__content__item about">
                <label class="f-w6" for="">Lappiについて</label>
                <div class="about-content">
                    <div class="about-content-left">
                        <a href="{{ route('client.management-company') }}">運営会社</a>
                        <a href="{{route('client.terms-of-service')}}"> 利用規約</a>
                        <a href="{{route('client.privacy-policy')}}">プライバシーポリシー</a>
                    </div>
                    <div class="about-content-right">
                        <a href="{{route('client.specified-commercial-transaction-law')}}">特定商取引法</a>
                    {{-- TODO --}}
                    <!-- <a href="{{ route('client.student.my-page.delete-account') }}">よくあるご質問</a> -->
                        <a href="{{ route('client.faq') }}">よくあるご質問</a>
                        <a href="{{route('client.inquiry')}}"> お問い合わせ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="l-footer__license f-w3 d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/clients/at-sign.svg') }}" alt="">
        {{ date('Y') }} Lappi All Rights Reserved.
    </div>
</footer>
