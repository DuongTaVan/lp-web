@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }
        .sidebar-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess') }}"></div>
    @endif
    <div class="main dashboard-wrapper my-page-student d-flex">
        @include('client.student-mypage.sidebar-left')
        <div class="content-right main_content">
            <div class="sidebar-right content-right__wrap">
                @include('client.common.dashboard-role')
                <div class="sidebar-right__title">
                    <div class="sidebar-right__title__text">
                        @lang('labels.account-setting.account_settings')
                    </div>
                </div>
                <div class="account-setting-right page-account-setting">
                    <div class="sidebar-right__list pl-0">
                        @lang('labels.account-setting.account_information')
                    </div>
                    <div class="account-setting-right__main">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting.user_information')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6" href="{{ route('client.student.my-page.edit-profile') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                    <div class="account-setting-right__main">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting.password')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6" href="{{ route('client.student.my-page.change-password') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                    <div class="account-setting-right__main">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting.notification_settings')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6" href="{{ route('client.student.my-page.notify-setting') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                    <div class="account-setting-right__main pb-0">
                        <div class="account-setting-right__main__text">
                            @lang('labels.account-setting.credit_card_information')
                        </div>
                        <div class="account-setting-right__main__button">
                            <a class="f-w6" href="{{ route('client.student.my-page.credit-card-info') }}">@lang('labels.button.change')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
