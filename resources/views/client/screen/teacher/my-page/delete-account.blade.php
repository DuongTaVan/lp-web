@extends('client.base.base')
@section('css')
    <style>
        .content-right {
            margin-left: auto;
        }

        .col-md-9, .col-sm-9 {
            padding-right: unset;
        }

        .delete-account {
            width: unset;
        }
    </style>
@endsection
@section('content')
    <div class="main mypage-teacher">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="sidebar-right">
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                @lang('labels.delete-account.unsubscribed')
                            </div>
                        </div>
                        <div class="delete-account">
                            <form action="{{ route('client.teacher.mypage-teacher-delete-account-update') }}"
                                  method="POST">
                                @csrf
                                <div class="main-content">
                                    <div class="main-content__text">
                                        <div class="main-content__text__title">
                                            @lang('labels.delete-account.to_unsubscribe')
                                        </div>
                                        <div class="main-content__text__list">
                                            <ul>
                                                <li>@lang('labels.delete-account.unsubscribe_1')</li>
                                                <li>@lang('labels.delete-account.unsubscribe_2')</li>
                                                <li>@lang('labels.delete-account.unsubscribe_3')</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="main-content__text">
                                        <div class="main-content__text__title">
                                            @lang('labels.delete-account.conditions')
                                        </div>
                                        <div class="main-content__text__list">
                                            <ul>
                                                <li>@lang('labels.delete-account.conditions_1')</li>
                                                <li>@lang('labels.delete-account.conditions_2')</li>
                                                <li>@lang('labels.delete-account.conditions_3')</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="main-content__select">
                                        <div class="title">@lang('labels.delete-account.select_reason')</div>
                                        <div class="main-content__select__input">
                                            <div class="select_reason">
                                                <select name="archive_reason" id="input" class="form-control">
                                                    <option value="">@lang('labels.delete-account.reason_1')</option>
                                                    <option value="1"
                                                            @if(old('archive_reason') == '1' || (!old('archive_reason') && $user->archive_reason == 1)) selected @endif>@lang('labels.delete-account.reason_2')</option>
                                                    <option value="2"
                                                            @if(old('archive_reason') == '2' || (!old('archive_reason') && $user->archive_reason == 2)) selected @endif>@lang('labels.delete-account.reason_3')</option>
                                                    <option value="3"
                                                            @if(old('archive_reason') == '3' || (!old('archive_reason') && $user->archive_reason == 3)) selected @endif>@lang('labels.delete-account.reason_4')</option>
                                                    <option value="4"
                                                            @if(old('archive_reason') == '4' || (!old('archive_reason') && $user->archive_reason == 4)) selected @endif>@lang('labels.delete-account.reason_5')</option>
                                                    <option value="5"
                                                            @if(old('archive_reason') == '5' || (!old('archive_reason') && $user->archive_reason == 5)) selected @endif>@lang('labels.delete-account.reason_6')</option>
                                                    <option value="6"
                                                            @if(old('archive_reason') == '6' || (!old('archive_reason') && $user->archive_reason == 6)) selected @endif>@lang('labels.delete-account.reason_7')</option>
                                                </select>
                                            </div>
                                            <div class="img"><img
                                                        src="{{asset('assets/img/student/my-page/icon/triangleupanddown.svg')}}"
                                                        class="img-responsive" alt="Image"></div>
                                        </div>
                                        @if($errors->has('archive_reason'))
                                            <small class="error text-danger">
                                                {{ $errors->first('archive_reason') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="main-content__input">
                                        <div class="title">@lang('labels.delete-account.detailed_reason')</div>
                                        <textarea name="archive_reason_text" class="form-control"
                                                  rows="5">{{ old('archive_reason_text', $user->archive_reason_text ?? null) }}</textarea>
                                        @if($errors->has('archive_reason_text'))
                                            <small class="error text-danger">
                                                {{ $errors->first('archive_reason_text') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="main-content__button">
                                        <button style="font-weight: 600" type="submit"
                                                @if ($user->archive_reason && $user->is_archived === 1) class="btn-disable"
                                                disabled @endif>
                                            @lang('labels.delete-account.button')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
