@extends('portal.layouts.main')
@section('styles')
    <style>
        @media only screen and (max-width: 1439px) {
            .box-notification-trans-create__form .box-notification-trans-create-form-group .input-title {
                width: 100%;
            }
        }
    </style>
@endsection
@section('content')
    <div class="box-notification-trans-create">
        <div class="text-left box-notification-trans-create__title">
            <span class="f-w6 box-notification-trans-create__title--text">お知らせ管理</span>
            <div class="box-notification-trans-create__action">
                <a href="{{ route('portal.box-notification-trans-contents.index')}}"
                   class="box-notification-trans-create__back f-w3">キャンセル</a>
                <button type="submit"
                        id="box-notification-submit"
                        class="box-notification-trans-create__btn-create f-w6"
                        form="box-notification-trans-content-form-create"
                >
                    配信する
                </button>
            </div>
        </div>
        <div class="card">
            <div class="text-left f-w6">
                <div class="box-notification-trans-create__content">
                    <div class="box-notification-trans-create__form">
                        <form action="{{ route('portal.box-notification-trans-contents.store') }}"
                              id="box-notification-trans-content-form-create" method="post">
                            @csrf
                            <div class="box-notification-trans-create-select-to_type">
                                <p class="label-title">宛先 *</p>
                                <select class="form-select form-select-lg custom-select status select-to_type f-w3"
                                        name="to_type" aria-label=".form-select-lg example">
                                    @foreach(\App\Enums\DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TO_TYPE_PORTAL as $key => $value)
                                        <option value="{{ $key }}" class="status__option f-w3">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="box-notification-trans-create-form-group">
                                <p class="label-title">タイトル *</p>
                                <input type="text" name="title" onchange="thuchanh(this)" value="{{ old('title') }}"
                                       class="input-title f-w3">
                                @if($errors->has('title'))
                                    <div class="error">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="box-notification-trans-create-form-group">
                                <p class="label-body">本文 *</p>
                                <textarea rows="15" cols="60" name="body" id="bodyNotification"
                                          class="input-body f-w3">{{ old('body') }}</textarea>
                                @if($errors->has('body'))
                                    <div class="error">{{ $errors->first('body') }}</div>
                                @endif
                            </div>
                            <div class="box-notification-trans-create-form-group">
                                <p class="label-schedule">指定配信日時（指定しない場合は即時配信)</p>
                                <div class="d-flex justify-content-start align-items-center datetimepicker">
                                    <div class="custom-calendar d-flex justify-content-center align-items-center">
                                        <img src="{{ url('assets/img/icons/calendar.PNG') }}" width="16" height="18"
                                             alt="" data-toggle>
                                    </div>
                                    <input type="text" class="f-w3" data-timepicker="true" data-input
                                           name="scheduled_at" data-format="Y/m/d H:i:S"
                                           data-min="{{ now()->format('Y/m/d H:i:s') }}"
                                           value="{{ old('scheduled_at') ? old('scheduled_at') : now()->format('Y/m/d H:i:s') }}"
                                    >
                                </div>
                                @if($errors->has('scheduled_at'))
                                    <div class="error">{{ $errors->first('scheduled_at') }}</div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ mix('js/portals/box-notification.js') }}"></script>
@endsection
