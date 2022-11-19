<style>
    .mw-82 {
        max-width: 82px;
    }

    .teacher-register-wrapper .teacher-register-nda .content .confirm-nda {
        display: unset !important;
    }

    .teacher-register-wrapper .teacher-register-nda .content .confirm-nda:first-child {
        display: unset !important;
        margin-right: 10px;
        color: #2A3242;
        border: 1px solid #4E576833;
        background-color: #FFFFFF;
        width: 150px;
        height: 41px;
    }

    .confirm-all-nda {
        text-align: center;
    }

    @media only screen and (max-width: 414px) {
        .teacher-register-wrapper .teacher-register-nda .content .confirm-nda:first-child {
            width: unset;
            height: unset;
        }
    }

</style>
@php
    $user = auth()->guard('client')->user();
    $userId = auth()->guard('client')->user()->user_id;
@endphp
@extends('client.base.base')
@section('content')
    <div class="teacher-register-wrapper">
        <div class="step-wrapper d-flex justify-content-center align-items-center">
            <div class="step active">
                <div>
                    1
                </div>
                <div class="ml-11">
                    {{ __('labels.teacher_register.personal_information') }}
                </div>
            </div>
            {{-- <div class="next-step next-step-active"></div> --}}
            <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step mw-82"
                 alt="line-step-active">
            <div class="step active">
                <div>
                    2
                </div>
                <div class="ml-15">
                    {{ __('labels.teacher_register.identification') }}
                </div>
            </div>
            {{-- <div class="next-step next-step-active"></div> --}}
            <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step mw-82"
                 alt="line-step-active">
            <div class="step active">
                <div>
                    3
                </div>
                <div class="ml-17">
                    機密保持契約
                </div>
            </div>
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step mw-82"
                 alt="line-step-not-active">
            <div class="step not-active">
                <div>
                    4
                </div>
                <div class="ml-17">
                    振込口座情報
                </div>
            </div>
        </div>
        <div class="step-mobile">
            @include('client.payment.process-payment-circle', ['step' => 'STEP 3', 'deg' => 320, 'title' => '機密保持契約', 'size' => 56])
        </div>
        <div class="teacher-register-nda teacher-register-nda--verify">
            <div class="content">
                <div class="content__title f-w6 text-center">機密保持契約書 (NDA)</div>
                <div class="content__note f-w6 text-center">オンライン占いを選択の場合は機密保持契約(NDA)の締結が必要です。</div>
                <div class="content__horizontal"></div>
                <p class="content__text text-left">
                    （以下「甲」という）と株式会社Lappi（以下「乙」という）とは、両当事者が開示する情報の取り扱いについて、下記のとおりに契約を締結します。</p>
                <div class="content__note content__note--small f-w3 text-center">※出品者が知り得た秘密情報を第三者に漏らさない事を決める契約です。</div>
                <div style="margin-top: -10px">@include('client.screen.teacher.my-page.content_nda')</div>
                <label for="" class="content__label content__label--black mt-0 f-w3">{{ now()->format('Y') }}
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
                <p class="content__text content__text--confirm text-center">
                    契約内容を確認し合意の上で、「機密保持契約（NDA）を締結する」ボタンを押して下さい</p>
                <div class="confirm-all-nda">
                    <button class="confirm-nda" id="href-submit" data-redirect="{{route('client.teacher.register.setting-account.identification-two')}}">戻る</button>
                    <button class="confirm-nda" id="nda-submit"
                            data-redirect="{{route('client.teacher.register.setting-account.payment', $userId)}}">
                        機密保持契約（NDA）を締結する
                    </button>
                </div>

                <p style="color: #EE3D48; font-weight: bold; margin-top: 20px" class="content__text text-center">
                    ※出品者マイページ「アカウント設定」より契約書の閲覧、ダウンロードができます。</p>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let user = @json($user);
        let userId = @json($userId);
        let uploadButton = document.getElementById("files");
        let inputFileNote = document.querySelector(".content-item__note-img");
        uploadButton.onchange = () => {
            const [file] = uploadButton.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }
    </script>
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection

