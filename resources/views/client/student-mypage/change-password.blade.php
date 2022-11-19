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
            <div class="main-right page-change-pass">
                @include('client.common.dashboard-role')
                <div class="main-right__title">
                    <div class="sidebar-right__title__text">
                        <div>
                            @lang('labels.account-setting.account_settings')
                            > @lang('labels.change-password.change_passwords')
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('client.student.my-page.post-student-changePassword') }}">
                    @csrf
                    <div class="main_content d-flex align-items-baseline mt-0">
                        <div class="main_content__title">
                            <p class="f-w6">@lang('labels.change-password.current_password')</p>
                        </div>
                        <div class="main_content__input">
                            <input type="password" name="current_password" id="" value="{{ old('current_password') }}">
                            @if ($errors->has('current_password'))
                                <div class="error">{{ $errors->first('current_password') }}</div>
                            @endif
                            @if (session('error-wrong') != null)
                                <div class="error">{{ session('error-wrong') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="main_content d-flex align-items-baseline">
                        <div class="main_content__title">
                            <p class="f-w6">@lang('labels.change-password.new_password')</p>
                        </div>
                        <div class="main_content__input">
                            <input type="password" name="new_password" id="" value="{{ old('new_password') }}">
                            <div>@lang('labels.change-password.validate_password')</div>
                            @if ($errors->has('new_password'))
                                <div class="error">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="main_content d-flex align-items-baseline">
                        <div class="main_content__title">
                            <p class="f-w6">@lang('labels.change-password.password_confirmation')</p>
                        </div>
                        <div class="main_content__input">
                            <input type="password" name="confirm_password" id="" value="{{ old('confirm_password') }}">
                            <div>@lang('labels.change-password.confirm_same_password')</div>
                            @if ($errors->has('confirm_password'))
                                <div class="error">{{ $errors->first('confirm_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="main_content__button">
                        <a href="{{ route('client.student.my-page.account-setting') }}"
                           class="btn fs-14 back button button--back">
                            {{ trans('labels.button.back_step') }}
                        </a>
                        <button type="submit" class="button button--submit">
                            @lang('labels.change-password.button')
                        </button>
                    </div>
                </form>
                @if (session('success') != null)
                    <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
                @endif
            </div>
        </div>
    </div>
@endsection
