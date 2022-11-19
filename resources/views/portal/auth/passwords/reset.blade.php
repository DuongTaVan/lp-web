
@extends('portal.dashboard.authBase')

@section('content')
             
<div class="container d-flex content-center min-vh-100">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <span>
                            <form class="form-custom" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <p class="form-title text-left">
                                    <b>{{ __('labels.change_password.title') }}</b>
                                </p>
                                <p class="text-left">
                                    {{ __('labels.change_password.description') }}
                                </p>
                                <span>
                                    <div role="group" class="form-group">
                                        <div class="input-group">
                                            <input type="password" placeholder="{{ __('labels.change_password.password') }}" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password" id="password">
                                            @if($errors->has('password'))
                                                <label class="form-text text-danger error">{{$errors->first('password')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                </span>
                                <span>
                                    <div role="group" class="form-group">
                                        <div class="input-group">
                                            <input type="password" placeholder="{{ __('labels.change_password.password_confirm') }}" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password_confirmation">
                                            @if($errors->has('password_confirmation'))
                                                <label class="form-text text-danger error">{{$errors->first('password_confirmation')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                </span>
                                @if (!is_null(session()->get('dataError')))
                                    <div class="error-alert">
                                        {{ session()->get('dataError')['error']['msg'] }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="text-left col-4">
                                        <button type="submit" class="btn px-4 text-nowrap btn-primary auth-btn">
                                            {{ __('labels.button.register') }}
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $token }}">
                            </form>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection

@section('css')
<style type="text/css">
    .card-group {
        width: 450px;
    }
    input.form-control {
        width: 80% !important;
    }
</style>
@endsection

@section('javascript')

@endsection
