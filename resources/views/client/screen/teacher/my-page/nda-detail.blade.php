@extends('client.base.base')
@section('css')
    <style>

        .img-responsive {
            width: 100%;
        }

        .confirm {
            margin-top: 28px;
        }

        .confirm__button.next {
            background-color: #46CB90;
            color: #FFFFFF;
            margin-left: 12px;
        }

        .confirm__button {
            width: 150px;
            height: 41px;
            border-radius: 5px;
            font-size: 14px;
            line-height: 21px;
            font-weight: 600;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .confirm__button.back {
            border: 1px solid rgba(78, 87, 104, 0.2);
            margin-right: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="main main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="sidebar-right">
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                機密保持契約（NDA）
                            </div>
                        </div>
                        <div class="teacher-register-wrapper p-mobile-0">
                            <div class="teacher-register-nda">
                                <div class="content">
                                    <div class="content__title f-w6 text-center">機密保持契約書 (NDA)</div>
                                    <div class="content__horizontal"></div>
                                    <p class="content__text text-left">
                                        （以下「甲」という）と株式会社Lappi（以下「乙」という）とは、両当事者が開示する情報の取り扱いについて、下記のとおりに契約を締結します。</p>
                                    <div class="content__note content__note--small f-w3 text-center">
                                        ※出品者が知り得た秘密情報を第三者に漏らさない事を決める契約です。
                                    </div>
                                    <div style="margin-top: -10px">@include('client.screen.teacher.my-page.content_nda')</div>
                                    <label for=""
                                           class="content__label content__label--black mt-0 f-w3">{{ now()->format('Y') }}
                                        年{{ now()->format('m') }}月{{ now()->format('d') }}日</label>
                                    <div class="content__user">
                                        <div class="content__user-one">
                                            <p>甲：{{ $user->address ?? null }}</p>
                                            <span>{{ $user->last_name_kanji . ' ' . $user->first_name_kanji }}</span>
                                        </div>
                                        <div class="content__user-two">
                                            <p>乙：株式会社Lappi</p>
                                            <span>大阪府大阪市北区豊崎３丁目１５番５号</span>
                                            <span>代表取締役社長　高橋真二</span>
                                        </div>
                                    </div>
                                    {{-- --}}
                                    {{--                                    @if ($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)--}}
                                    {{--                                        <a href="{{ route('client.teacher.mypage-generate-pdf-nda') }}" target="__blank" class="download-pdf f-w6">--}}
                                    {{--                                            PDF出力--}}
                                    {{--                                            <img src={{url('/assets/img/teacher-page/icon/download-pdf.svg')}} alt="download-pdf">--}}
                                    {{--                                        </a>--}}
                                    {{--                                    @else--}}
                                    {{--                                        <a class="download-pdf f-w6 btn-disabled">--}}
                                    {{--                                            PDF出力--}}
                                    {{--                                            <img src={{url('/assets/img/teacher-page/icon/download-pdf.svg')}} alt="download-pdf">--}}
                                    {{--                                        </a>--}}
                                    {{--                                    @endif--}}

                                    <div class="confirm d-flex justify-content-center">
                                        <a href="{{route('client.teacher.mypage-teacher-settingAccount')}}"
                                           class="btn fs-14 back confirm__button">
                                            戻る
                                        </a>
                                        @if ($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                            <a href="{{ route('client.teacher.mypage-generate-pdf-nda') }}"
                                               target="__blank" class="f-w6 btn fs-14 confirm__button next">
                                                PDF出力
                                                <img src={{url('/assets/img/teacher-page/icon/download-pdf.svg')}} alt="download-pdf">
                                            </a>
                                        @else
                                            <a class="f-w6 btn-disabled btn fs-14 confirm__button next">
                                                PDF出力
                                                <img src={{url('/assets/img/teacher-page/icon/download-pdf.svg')}} alt="download-pdf">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection
