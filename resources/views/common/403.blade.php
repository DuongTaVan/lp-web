@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/error_page.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="main">
        <div class="page-error-paragraph">
            <div class="page-error-paragraph__image-forbidden">
                <img src="{{asset('assets/img/icons/403.svg')}}" alt="">
            </div>
            <a href="{{route('client.home')}}" class="btn btn-return-page btn-forbidden">@lang('labels.auth.reset_success.redirect')</a>
        </div>
    </div>
@endsection
