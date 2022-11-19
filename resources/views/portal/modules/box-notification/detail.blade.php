@extends('portal.layouts.main')
@section('content')
    <div class="box-notification-trans-detail">
        <div class="text-left box-notification-trans-detail__title">
            <span class="f-w6 box-notification-trans-detail__title--text">お知らせ管理</span>
            <div class="box-notification-trans-detail__action">
                <a href="{{ route('portal.box-notification-trans-contents.index') }}"
                   class="box-notification-trans-detail-back f-w3">一覧に戻る</a>
            </div>
        </div>
        <div class="card">
            <div class="box-notification-trans-detail__content">
                <div class="box-notification-trans-detail-title">
                    <p class="f-w6 fields-title">宛先</p>
                    <p class="f-w3 fields-title-content">{{ $data->to_type_text }}</p>
                </div>
                <div class="box-notification-trans-detail__body">
                    <p class="f-w6 fields-title">タイトル</p>
                    <p class="f-w3 fields-title-content">{{ $data->title }}</p>
                </div>
                <div class="box-notification-trans-detail__body">
                    <p class="f-w6 fields-title">本文</p>
                    <div class="f-w3 fields-title-content">{!! nl2br($data->body) !!}</div>
                </div>
                <div class="box-notification-trans-detail__schedule">
                    <p class="f-w6 fields-title">指定配信日時</p>
                    <p class="f-w3 fields-title-content" >{{ $data->scheduled_at }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
