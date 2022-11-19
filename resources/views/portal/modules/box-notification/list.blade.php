@extends('portal.layouts.main')
@section('styles')
<style>
    .date-time-course {
        position: relative;
        border: 0;
        height: 30px !important;
    }

    .date-time-course>img {
        position: absolute;
        right: 11px;
        cursor: pointer;
        object-fit: cover;
    }

    .input-date {
        height: 40px;
        border: 1px solid #CCCCCC;
        border-radius: 3px;
        padding: 0 10px;
        font-size: 12px;
    }
</style>
@endsection
@section('content')
@if (session('message') != null)
<div id="show-toast-success" data-msg="{{ session('message') }}"></div>
@endif
<div class="box-notification-trans-list">
    <div class="text-left box-notification-trans-list__title">
        <span class="f-w6">お知らせ管理</span>
    </div>
    <div class="card">
        <div class="text-left f-w3">
            <form action="" methd="GET">
                <div class="d-flex flex-wrap list-option--top hidden-calendar" style="margin-bottom: 15px;">
                    <div>
                        <p class="seach-form__title">指定日 (開始)</p>
                        <div class="jquery-datetime-picker datetimepicker date-time-course">
                            <input type="text" class="auto-trim start-datetime input-date start" data-input value="{{ Request::get('start_date') ?? null }}" name="start_date" autocomplete="off" data-format="Y-m-d">
                            <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                        </div>

                    </div>
                    <div>
                        <p class="seach-form__title">指定日 (終了)</p>
                        <div class="jquery-datetime-picker datetimepicker date-time-course">
                            <input type="text" class="auto-trim end-datetime input-date end" data-input value="{{ Request::get('end_date') ?? null }}" name="end_date" autocomplete="off" data-format="Y-m-d">
                            <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-left f-w3 header justify-content-between align-items-center">
                    <div class="d-flex position-relative">
                        <div class="seach-form">
                            <p class="seach-form__title">タイトル</p>
                            <input type="text" class="input-title" name="title" value="{{ array_key_exists('title', $searchParams) ? $searchParams['title']: '' }}" />
                        </div>
                        <div class="seach-form mr-3">
                            <p class="seach-form__title">宛先</p>
                            <select name="to_type" class="form-select form-select-lg custom-select status ">
                                <option value=""></option>
                                @foreach(\App\Enums\DBConstant::BOX_NOTIFICATION_TO_TYPE_OPTION as $key => $value)
                                <option value="{{ $key }}" class="status__option" @if(Request::get('to_type') !=null) {{Request::get('to_type') == $key ? 'selected' : '' }} @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f-w3">
                            <button id="search-button" class="btn-primary search-button">検索</button>
                        </div>
                    </div>
                    <div class="btn-create-box-notification">
                        <a href="{{ route('portal.box-notification-trans-contents.create') }}" class="btn box-notification-trans-btn-create">
                            新規作成
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="box-notification-trans-list__content">
            <div class="d-flex justify-content-start align-items-center record">
                <select class="form-select form-select-lg custom-select record__select" name="" id="select-per-page" per-page="{{$data->perPage()}}" current-page="{{$data->currentPage()}}" last-page="{{$data->lastPage()}}" total-record="{{$data->total()}}" aria-label=".form-select-lg example">
                    @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                    <option value="{{ $key }}" {{ $data->perPage() === $value ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <span>件表示</span>
            </div>
            <div class="box-notification-trans-list__table" id="box-notification-trans-list__table">
                @include('portal.modules.box-notification.boxNotificationListTable')
            </div>
        </div>
        @include('portal.components.table-footer', ['data' => $data])
    </div>
</div>
@endsection
