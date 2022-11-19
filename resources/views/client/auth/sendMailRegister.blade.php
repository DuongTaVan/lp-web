@extends('client.base.base')

@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div id="content">
        <section class="section" id="section01">
            <div class="inner">
                <div class="inner-02">
                    <p class="ib" id="topics"><span class="home"><a href="{{ route('top.show') }}"><img src="{{ asset('assets/icons/icon05.svg') }}" alt=""></a></span>
                        <span>{{ __('labels.users.register_screen.new_member') }}</span>
                    </p>
                    <h2 class="head head-A"><span class="max">{{ __('labels.users.register_screen.new_member_en') }}</span>
                        <span class="min">{{ __('labels.users.register_screen.new_member') }}</span>
                    </h2>
                    <div class="box box-B">
                        <form id="form-login" class="form-custom" method="POST" action="{{ route('register.send-mail-register') }}">
                            @csrf
                            <dl class="unit">
                                <dt class="label">{{ __('labels.users.register_screen.email') }}：</dt>
                                <dd class="item">
                                    <input type="text" class="input-B form-control {{ $errors->has('email') ? 'error' : '' }}"
                                           name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力してください">
                                    @if ($errors->has('email'))
                                        <label class="form-text text-danger error">{{ $errors->first('email') }}</label>
                                    @endif
                                </dd>
                            </dl>
                            <p class="btn btn-A">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('labels.users.register_screen.send_email') }}
                                </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- E CONTENT -->
@endsection
