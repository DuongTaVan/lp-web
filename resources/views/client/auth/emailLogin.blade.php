@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div id="content">
        <section class="section" id="section01">
            <div class="inner">
                <div class="inner-02">
                    <form id="form-login" class="form-custom" method="POST" action="{{ route('user-login') }}">
                        @csrf
                        <p class="ib" id="topics"><span class="home"><a href="{{ route('top.show') }}"><img src="{{ asset('assets/icons/icon05.svg') }}" alt=""></a></span>
                            <span>{{ __('labels.users.login_screen.login') }}</span>
                        </p>
                        <h2 class="head head-A"><span class="max">{{ __('labels.users.login_screen.login_en') }}</span><span class="min">{{ __('labels.users.login_screen.login') }}</span></h2>
                        <div class="box box-B">
                            <dl class="unit">
                                <dt class="label">{{ __('labels.users.login_screen.email') }}：</dt>
                                <dd class="item">
                                    <input type="text" class="input-B form-control {{ $errors->has('email') ? 'error' : '' }}"
                                        name="email" value="{{ old('email', session()->get('dataError')['error']['data'] ?? '') }}"
                                        placeholder="{{ __('labels.users.login_screen.email_place_holder') }}">
                                    @if ($errors->has('email'))
                                        <label class="form-text text-danger error">{{ $errors->first('email') }}</label>
                                    @endif
                                </dd>
                            </dl>
                            <dl class="unit">
                                <dt class="label">{{ __('labels.users.login_screen.password') }}：</dt>
                                <dd class="item">
                                    <input type="password" class="input-B form-control {{ $errors->has('password') ? 'error' : '' }}"
                                        name="password" value="{{ old('password') }}" placeholder="{{ __('labels.users.login_screen.password_place_holder') }}">
                                    @if ($errors->has('password'))
                                        <label class="form-text text-danger error">{{ $errors->first('password') }}</label>
                                    @endif
                                </dd>
                            </dl>
                            @if (!is_null(session()->get('dataError')))
                                <div class="error-alert">
                                    {{ session()->get('dataError')['error']['msg'] }}
                                </div>
                            @endif
                            <p class="btn btn-A"><button type="submit" class="btn btn-primary">{{ __('labels.users.login_screen.login') }}</button></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div><!-- E CONTENT -->
@endsection
