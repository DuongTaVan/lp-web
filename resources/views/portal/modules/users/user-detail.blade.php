@extends('portal.layouts.main')
@section('styles')
    <style>
        .wrapper_content {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('content')
    <div class="user-detail">
        @php
            $query = app('request')->request->all();
        @endphp
        <div class="d-flex justify-content-between align-items-center" style="margin-top: 10px">
            <label for="" class="f-w6">{{ __('labels.users_tab.list.title') }}</label>
            @if(!empty($query['link']))
                @switch($query['link'])
                    @case($query['link'] === 'identity')
                    <a href="{{ route('portal.identity.identity-verification-image', $query) }}">
                        <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                    </a>
                    @break
                    @case($query['link'] === 'business')
                    <a href="{{ route('portal.business.business-verification-image', $query) }}">
                        <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                    </a>
                    @break
                    @case($query['link'] === 'transfer-histories')
                    <a href="{{ route('portal.transfer-histories', $query) }}">
                        <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                    </a>
                    @break
                    @case($query['link'] === 'sale-detail')
                    <a href="{{ route('portal.sale.index', $query) }}">
                        <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                    </a>
                    @break
                    @default
                    <a href="{{ route('portal.user.list', $query) }}">
                        <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                    </a>
                @endswitch
            @else
                <a href="{{ route('portal.user.list', $query) }}">
                    <button class="user-detail__back-list f-w3">{{ __('labels.button.back') }}</button>
                </a>
            @endif
        </div>
        <div class="d-flex justify-content-between">
            <div id="test" class="wrap-info wrap-2 f-w3">
                <div class="label-common f-w6">{{ __('labels.users_tab.detail.basic_title') }}</div>
                <div class="horizontal-line"></div>
                <div class="content">
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.user_id') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['user_id'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.user_type') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['user_type_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.category') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['teacher_category_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.nickname') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['nickname'] ?? null}}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.full_name') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if ($user)
                                {{ $user['last_name_kanji'] }}{{ $user['first_name_kanji'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.full_name_kana') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if ($user)
                                {{ $user['last_name_kana'] }}{{ $user['first_name_kana'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.sex') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['sex_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.login_type') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['login_type_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.email') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['email'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.cash_balance') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['cash_balance']))
                                {{ number_format($user['cash_balance']) }} {{ __('labels.unit.money') }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.point_balance') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['points_balance']))
                                {{ number_format($user['points_balance']) }} {{ __('labels.unit.point') }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.identification') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['identity_verification_status_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.qualification_confirmation') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['business_card_verification_status_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-4 f-w6">{{ __('labels.users_tab.list.nda') }}</label>
                        <p class="content__wrap__value col-md-8">
                            {{ $user['nda_status_text'] ?? null }}
                        </p>
                    </div>
                </div>
            </div>
            <div id="test2" class="wrap-img wrap-2 f-w3">
                <div class="label-common f-w6">{{ __('labels.users_tab.detail.image_title') }}</div>
                <div class="horizontal-line"></div>
                <div class="content">
                    <img src="{{ $user['profile_image'] ?? null }}" alt="" width="100%" height="439px"
                         style="object-fit: cover">
                </div>
            </div>
        </div>
        <div>
            <div class="wrap-1 f-w3">
                <div class="label-common f-w6">{{ __('labels.users_tab.profile.title') }}</div>
                <div class="horizontal-line"></div>
                <div class="content">
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.profile.year_of_birth') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['year_of_birth']))
                                {{ $user['year_of_birth'] }} {{ __('labels.unit.year') }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.profile.address') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['address']))
                                {{ $user['address'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.profile.catchphrase') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['catchphrase']))
                                {{ $user['catchphrase'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.profile.biography') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user['biography']))
                                {{ $user['biography'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.profile.last_login') }}</label>
                        <p class="content__wrap__value col-md-8">
                            @if (isset($user))
                                @if ($user['last_login'])
                                    {{ $user['last_login'] ?? null }}
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="wrap-1 f-w3">
                <div class="label-common f-w6">{{ __('labels.users_tab.account.title') }}</div>
                <div class="horizontal-line"></div>
                <div class="content">
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.account.bank_name') }}</label>
                        <p class="content__wrap__value col-md-10">
                            @if (isset($user['bank_name']))
                                {{ $user['bank_name'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.account.branch_name') }}</label>
                        <p class="content__wrap__value col-md-10">
                            @if (isset($user['branch_name']))
                                {{ $user['branch_name'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.account.type') }}</label>
                        <p class="content__wrap__value col-md-10">
                            {{ $user['account_type_text'] ?? null }}
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.account.number') }}</label>
                        <p class="content__wrap__value col-md-10">
                            @if (isset($user['account_number']))
                                {{ $user['account_number'] }}
                            @endif
                        </p>
                    </div>
                    <div class="content__wrap row">
                        <label for=""
                               class="content__wrap__label col-md-2 f-w6">{{ __('labels.users_tab.account.name') }}</label>
                        <p class="content__wrap__value col-md-10">
                            @if (isset($user['account_name']))
                                {{ $user['account_name'] }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
