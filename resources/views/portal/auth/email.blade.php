@extends('portal.layouts.guest')
@section('guest')
<div class="container d-flex content-center min-vh-100">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <span>
                            <form class="form-custom" method="POST" action="">
                                @csrf
                                <p class="form-title text-left">
                                    <b>{{ __('labels.reset_password.title') }}</b>
                                </p>
                                <p class="text-left">
                                    {{ __('labels.reset_password.description') }}
                                </p>
                                <span>
                                    <div role="group" class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <img src="{{ asset(config('storage.icon_folder') . 'ico_email_login.svg' ) }}">
                                                </span>
                                            </div>
                                        <input type="text" placeholder="{{ __('labels.login.email') }}" autocomplete="username email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                                        </div>
                                    </div>
                                </span>
                                <div class="row">
                                    <div class="text-left col-4">
                                        <button type="submit" class="btn text-nowrap btn-primary auth-btn">
                                            {{ __('labels.button.send') }}
                                        </button>
                                    </div>
                                    <div class="text-right col-8">
                                        <a href="{{ route('portal.login') }}" class="auth-forward">
                                            <button type="button" class="btn px-0 text-nowrap btn-link">
                                                {{ __('labels.reset_password.return_login') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                </form>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

