@extends('client.base.base')
@section('css')
    <style>
        .content-wrap {
            margin: 0 auto;
        }
        a.btn-register {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 41px;
            background-color: #46CB90;
            color: #ffffff;
            margin: 0 auto;
            border-radius: 5px
        }
    </style>
@endsection
@section('content')
    <div class="content-wrap text-center">
        <h2 class="text-center mt-4">About lappi</h2>
        @php 
            $isLogin = \Auth::guard('client')->check();
            $userType = \Auth::guard('client')->user()->user_type ?? null;
        @endphp
        @if ($isLogin && $userType === \App\Enums\DBConstant::USER_TYPE_STUDENT)
        <a class="btn-register f-w6 text-center mt-4" href="{{ route('client.become-lappi') }}">Lappiになる</a>
        @endif
        @if (!$isLogin)
        <a class="btn-register f-w6 text-center mt-4" href="{{ route('client.register') }}">出品者新規登録へ</a>
        @endif
    </div>
@endsection
