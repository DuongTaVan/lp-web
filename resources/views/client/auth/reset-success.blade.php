@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div class="reset-form-success-wrap">
        <div class="reset-password-success">
            <img src="{{ asset('assets/img/icons/reset-success.svg') }}" alt="">
            <div class="success f-w6">
                {{ __('labels.auth.reset_success.success') }}
            </div>
            <div class="notification">
                {{ __('labels.auth.reset_success.notification') }}
            </div>
            <a href="{{ route('client.home') }}">
                {{ __('labels.auth.reset_success.redirect') }}
            </a>
        </div>
    </div>
@endsection

