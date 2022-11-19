@extends('portal.dashboard.base')
@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.header.change_password') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right"></div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5">
                <div class="col-sm-12">
                    <form action="{{ route('change-password') }}" method="post">
                        @csrf
                        <div class="row mb-3 title-user">
                            <div class="col-md-5 pl-0">
                                <p><b class="text-label-change-password">{{ __('labels.header.change_password') }}</b></p>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-3 text-right"></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2 text-label-change-password">
                                {{ __('labels.change_password.password_current') }}
                            </div>
                            <div class="col-md-3">
                                <input type="password" value="" name="password_current" class="form-control">
                                @foreach ($errors->get('password_current') as $errorMsg)
                                    <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                @endforeach
                            </div>
                            <div class="col-md-7"></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2 text-label-change-password">
                                {{ __('labels.change_password.password_new') }}
                            </div>
                            <div class="col-md-3">
                                <input type="password" value="" name="password_new" class="form-control">
                                @foreach ($errors->get('password_new') as $errorMsg)
                                    <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                @endforeach
                            </div>
                            <div class="col-md-7"></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2 pr-0 text-label-change-password">
                                {{ __('labels.change_password.password_confirm') }}
                            </div>
                            <div class="col-md-3">
                                <input type="password" value="" name="password_confirmation" class="form-control">
                                @foreach ($errors->get('password_confirmation') as $errorMsg)
                                    <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                @endforeach
                            </div>
                            <div class="col-md-5"></div>
                            <div class="col-md-2 text-right pr-5">
                                <button type="submit" class="btn btn-primary change-password-button" data-toggle="modal" data-target="#exampleModalCenter">
                                    {{ __('labels.change_password.button_change_password') }}
                                </button>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2 text-label-change-password">
                                @if (!is_null(session()->get('dataError')))
                                    <div class="error-alert">
                                        {{ session()->get('dataError')['error']['msg'] }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-5"></div>
                            <div class="col-md-2 text-right pr-5"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        .change-password-button {
            width: 150px;
        }
        .error-alert {
            margin-left: 0 !important;
        }
        @media only screen and (max-width: 1440px) {
            .text-label-change-password {
                font-size: 12.7px;
            }
        }
    </style>
@endsection
@section('javascript')

@endsection
