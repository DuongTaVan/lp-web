@extends('client.base.base-maintain')
@section('css')
    <link href="{{ mix('css/maintain_page.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="main">
        @php
            $defaultTime = formatTime(now(), 'Y年m月d日') . '　12：00～16：00';
        @endphp
        <div class="page-maintain-paragraph">
            <div>
                <img class="icon-frog mb-20" src="{{url('assets/img/clients/header-common/lappiになる.svg')}}" alt="">
                <div class="text_title mb-20">ただいまメンテナンス中です</div>
                <div class="text_title mb-10">【メンテナンス日時】</div>

                <div class="text_timeline mb-20">
                    {{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] ?? $defaultTime }}
                </div>

                <div class="text_sub">
                    ご利用の皆様にはご迷惑をおかけし、申し訳ありません。
                    <br>
                    メンテナンス終了までしばらくお待ちください。
                </div>
            </div>
        </div>
    </div>
@endsection
