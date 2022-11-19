@extends('portal.dashboard.base')

@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{ route('users.update', $user->user_id) }}" id="formUserUpdate">
            @method('PATCH')
            @csrf
        <div class="row mt-2">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.users_tab.list.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('users.show', $user->user_id) }}">
                    <button type="button" class="btn btn-secondary">{{ __('labels.button.cancel') }}</button>
                </a>
                <button type="submit" class="btn btn-primary btn-update">{{ __('labels.button.update') }}</button>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-4">
            <div class="row pl-5">
                <div class="col-sm-12">
                <div class="row mb-3 title-user">
                    <div class="col-md-5 pl-0">
                        <p><b>{{ __('labels.users_tab.detail.title') }}</b></p>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-3 text-right"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.list.user_id') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('user_id', $user->user_id) }}" name="user_id" class="form-control" disabled>
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.last_name_kanji') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('last_name_kanji', $user->last_name_kanji) }}" name="last_name_kanji" class="form-control">
                        @foreach ($errors->get('last_name_kanji') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.first_name_kanji') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('first_name_kanji', $user->first_name_kanji) }}" name="first_name_kanji" class="form-control">
                        @foreach ($errors->get('first_name_kanji') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.last_name_kana') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('last_name_kana', $user->last_name_kana) }}" name="last_name_kana" class="form-control">
                        @foreach ($errors->get('last_name_kana') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.first_name_kana') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('first_name_kana', $user->first_name_kana) }}" name="first_name_kana" class="form-control">
                        @foreach ($errors->get('first_name_kana') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.list.email') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('email', $user->email) }}" name="email" class="form-control">
                        @foreach ($errors->get('email') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.phone') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('phone', $user->phone) }}" name="phone" class="form-control">
                        @foreach ($errors->get('phone') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="h-adr">
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.zip_code') }}</b>
                        </div>
                        <div class="col-md-3">
                            <span class="p-country-name" style="display:none;">Japan</span>
                            <input type="text" value="{{ old('zip_code', $user->zip_code) }}" name="zip_code"
                                class="form-control p-postal-code" maxlength="8" size="8" id="postal-code">
                            @foreach ($errors->get('zip_code') as $errorMsg)
                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                            @endforeach
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.prefecture') }}</b>
                        </div>
                        <div class="col-md-3">
                            <span class="p-country-name" style="display:none;">Japan</span>
                            <input type="text" value="{{ old('prefecture', $user->prefecture) }}" name="prefecture"
                                   class="form-control p-region" id="prefecture">
                            @foreach ($errors->get('prefecture') as $errorMsg)
                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                            @endforeach
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.city') }}</b>
                        </div>
                        <div class="col-md-3">
                            <input type="text" value="{{ old('city', $user->city) }}" name="city" class="form-control p-locality p-street-address p-extended-address">
                            @foreach ($errors->get('city') as $errorMsg)
                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                            @endforeach
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.subsequent_address') }}</b>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="{{ old('subsequent_address', $user->subsequent_address) }}" name="subsequent_address" class="form-control">
                        @foreach ($errors->get('subsequent_address') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.ekyc_identity_verification') }}</b>
                        </div>
                        <div class="col-md-3">
                            <input type="text" value="{{ \App\Enums\Constant::EKYC_STATUS[$user->ekyc_status] }}" name="ekyc_status" class="form-control" disabled>
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.memo') }}</b>
                        </div>
                        <div class="col-md-10 pr-5">
                            <input type="text" value="{{ old('memo', $user->memo) }}" name="memo" class="form-control">
                            @foreach ($errors->get('memo') as $errorMsg)
                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                            @endforeach
                        </div>
                    </div>
            </div>
        </form>
    </div>
@endsection
@section('css')
    <style lang="scss">
        .body-card {
            background: #ffffff;
        }
        input {
            height: 40px;
        }
        .title-user {
            border-bottom: 1px solid #CCCCCC;
            margin-left: -3rem;
            margin-right: 0;
            padding-left: 3rem;
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('js/portal/user/edit.js') }}"></script>
@endsection