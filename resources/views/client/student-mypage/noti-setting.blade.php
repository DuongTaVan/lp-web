@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }

        .main-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student d-flex">
        @include('client.student-mypage.sidebar-left')
        <div class="content-right content-right__wrap main_content">
            <div class="main-right page-notify ">
                @include('client.common.dashboard-role')
                <div class="main-right__title">
                    <div class="sidebar-right__title__text">
                        @lang('labels.account-setting.account_settings')
                        > @lang('labels.notification-settings.notification_settings')
                    </div>
                </div>
                <div class="content-noti">
                    <div class="main-noti">
                        <div class="main-noti__title">
                            <p class="f-w6">@lang('labels.notification-settings.notification_reception')</p>
                        </div>
                        <div class="main-noti__content">
                            <div class="main-noti__content__checkbox">
                                <form action="{{ route('client.student.my-page.setting-notify') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="wrap-check-box">
                                        <label class="input-checkbox custom-lable">
                                            @lang('labels.notification-settings.transaction_contact')
                                            <input type="checkbox" checked="checked" disabled>
                                            <span class="checkmark"></span>
                                            <div class="main-noti__content__helperText">
                                                @lang('labels.notification-settings.helper_text')
                                            </div>
                                        </label>
                                        <label class="input-checkbox">
                                            @lang('labels.notification-settings.message')
                                            <input type="checkbox" name="message"
                                                   value="1" {{ $notiSetting['message'] ?? null == 1 ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="input-checkbox">
                                            @lang('labels.notification-settings.follow')
                                            <input type="checkbox" name="followed_or_faved"
                                                   value="1" {{ $notiSetting['followed_or_faved'] ?? null == 1 ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="input-checkbox">
                                            @lang('labels.notification-settings.discount_coupons')
                                            <input type="checkbox" name="special_offers"
                                                   value="1" {{ $notiSetting['special_offers'] ?? null == 1 ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="input-checkbox">
                                            @lang('labels.notification-settings.function_update')
                                            <input type="checkbox" name="maintenance"
                                                   value="1" {{ $notiSetting['maintenance'] ?? null == 1 ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    {{-- <div class="main_content__button">
                                        <button type="button"> 
                                            @lang('labels.button.back_step')
                                        </button>
                                        <button type="submit"> 
                                            @lang('labels.change-password.button')
                                        </button>
                                    </div> --}}
                                    <div class="button-action button-action__noti-setting">
                                        <a href="{{ route('client.student.my-page.account-setting') }}"
                                           class="button-action__btn button-action__btn--back">@lang('labels.button.back_step')</a>
                                        <button type="submit"
                                                class="button-action__btn button-action__btn--submit f-w6">@lang('labels.change-password.button')</button>
                                    </div>
                                </form>
                                @if (session('success') != null)
                                    <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
                                @endif
                                @if ($errors->has('error'))
                                    <div id="show-toast-error" data-msg="{{ $errors->first('error') }}"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
