@extends('client.base.base')
@section('content')
    <div class="main main-mypage-teacher">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="sidebar-right">
                <div class="sidebar-right__title">
                    <div class="sidebar-right__title__text">
                        @lang('labels.account-setting.account_information')
                    </div>
                </div>
                <div class="account-setting-right page-account-setting">
                    <div class="account-setting-right__main">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting-teacher.registration_information')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6"
                               href="{{ route('client.teacher.mypage-teacher-info-edit') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                    <div class="account-setting-right__main">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting-teacher.identity_verification_documents')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6"
                               href="{{ route('client.teacher.mypage-teacher-verifi-identity') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                    @if(Auth::guard('client')->user()->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION)
                        <div class="account-setting-right__main">
                            <div class="account-setting-right__main__text">
                                @lang('labels.account-setting-teacher.credentials')
                            </div>
                            <div class="account-setting-right__main__button">
                                <a class="f-w6"
                                   href="{{ route('client.teacher.mypage-teacher-credentials') }}">@lang('labels.button.change')</a>
                            </div>
                        </div>
                    @endif
                    @if(Auth::guard('client')->user()->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING)
                        <div class="account-setting-right__main">
                            <div class="account-setting-right__main__text">
                                機密保持契約
                            </div>
                            <div class="account-setting-right__main__button">
                                <a class="f-w6"
                                   href="{{ route('client.teacher.mypage-teacher-nda') }}">詳細を見る</a>
                            </div>
                        </div>
                    @endif
                    <div class="account-setting-right__main" style="border-bottom: unset; padding-bottom: 0">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting-teacher.service_outage')
                        </div>
                        @php
                            $userStatus = \Auth::guard('client')->user()->user_status;
                        @endphp
                        @if($userStatus === \App\Enums\DBConstant::NOT_STOP_SERVICE)

                            <div class="account-setting-right__main__button"
                                 data-toggle="modal" data-target="#exampleModal">
                                <style>
                                    .p-custom {
                                        display: flex;
                                        -ms-flex-pack: center;
                                        justify-content: center;
                                        -ms-flex-align: center;
                                        align-items: center;
                                        background: #46CB90;
                                        border: 1px solid #46CB90;
                                        box-sizing: border-box;
                                        border-radius: 5px;
                                        width: 96px;
                                        height: 41px;
                                        color: #FFFFFF;
                                        text-align: center;
                                        font-size: 14px;
                                        line-height: 21px;
                                        text-decoration: none;
                                        margin-bottom: 0;
                                        cursor: pointer;
                                    }
                                </style>
                                <p class="f-w6 p-custom"
                                   href="{{ route('client.teacher.mypage-teacher-restAccount') }}">
                                    @lang('labels.button.rest')
                                </p>

                            </div>
                        @else
                            <style>
                                .p-custom1 {
                                    display: flex;
                                    -ms-flex-pack: center;
                                    justify-content: center;
                                    -ms-flex-align: center;
                                    align-items: center;
                                    box-sizing: border-box;
                                    /*border-radius: 5px;*/
                                    width: 96px;
                                    height: 41px;
                                    color: #FFFFFF;
                                    text-align: center;
                                    font-size: 14px;
                                    line-height: 21px;
                                    text-decoration: none;
                                    margin-bottom: 0;
                                    cursor: pointer;
                                }
                            </style>
                            <div class="account-setting-right__main__button"
                                 data-toggle="modal" data-target="#exampleModal">
                                <p style="background: #f9fafb;color: #EE3D48"
                                   class="f-w6 p-custom1">
                                    @lang('labels.button.rest_change')
                                </p>
                            </div>
                        @endif
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="sidebar-right__modal-content__header">
                                    <div id="sidebar-right__modal-content__header__text"
                                         class="sidebar-right__modal-content__header__text">
                                        {{-- {{ $userStatus === \App\Enums\DBConstant::NOT_STOP_SERVICE ? 'サービスの休止をしてもよろしいですか？' : 'サービスの休止を解除してもよろしいですか？' }} --}}
                                        @if ($userStatus === \App\Enums\DBConstant::NOT_STOP_SERVICE)
                                            @lang('labels.button.stop_service')
                                        @else
                                            @lang('labels.button.un_stop_service')
                                        @endif
                                    </div>
                                </div>
                                <div class="sidebar-right__modal-content__content">
                                    <button class="btn sidebar-right__modal-content__content__cancel"
                                            data-dismiss="modal" aria-label="Close">
                                        @lang('labels.button.cancel')
                                    </button>
                                    <button data-url="{{ route('client.teacher.mypage-teacher-restAccount') }}"
                                            id="sidebar-right__modal-content__content__setting_ok"
                                            class="btn sidebar-right__modal-content__content__ok"
                                            data-dismiss="modal" aria-label="Close">
                                        OK
                                    </button>
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
    <script>
        $('body').on('click', '#sidebar-right__modal-content__content__setting_ok', function (e) {
            e.preventDefault();
            let url = $(this).data('url')
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
            })
                .done(function (data) {
                    if (data.user.status === 'true') {
                        toastr.success(data.user.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1500);

                    } else {
                        toastr.error(data.user.message);
                        $(".sidebar-right__modal-content__content__cancel").trigger("click");
                    }
                });
        })

    </script>
@endsection

