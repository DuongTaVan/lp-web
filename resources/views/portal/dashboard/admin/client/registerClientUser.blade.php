
@extends('portal.dashboard.authBase')

@section('content')

<div class="container d-flex content-center min-vh-100">
    <div class="row wrap">
        <div class="col-md-12 login-box">
            <div class="card-group">
                <div class="card p-4 login-box-body">
                    <div class="card-body">
                        <span>
                            <form id="form-login" class="form-custom" method="POST" action="{{ route('register-client-user.update', $clientId) }}">
                                @csrf
                                @method('PUT')
                                <p class="form-title text-left title-color">
                                    <b>{{ __('labels.client_tab.register.title') }}</b>
                                </p>
                                <p class="form-title text-left content mb-4 input-text-color">
                                    {{ __('labels.client_tab.register.content') }}
                                </p>
                                 <div class="row">
                                    <div class="col-sm-12 mt-3">
                                        <div class="row mb-3">
                                            <div class="col-md-3 text-left center input-text-color">
                                                <p><b>{{ __('labels.client_tab.register.phone') }}</b></p>
                                            </div>
                                            <div class="col-md-9">
                                              <input type="text" value="{{ old('phone', session()->get('phone')) }}" name="phone" class="form-control input-text-color" maxlength="13">
                                              @foreach ($errors->get('phone') as $errorMsg)
                                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 <div class="h-adr">
                                    <div class="row mb-4">
                                      <div class="col-md-3 text-left center input-text-color">
                                        <b>{{ __('labels.client_tab.register.zip_code') }}</b>
                                      </div>
                                      <div class="col-md-9">
                                        <span class="p-country-name" style="display:none;">Japan</span>
                                        <input type="text" value="{{ old('zip_code', session()->get('zip_code')) }}" name="zip_code"
                                           class="form-control p-postal-code input-text-color" maxlength="8" size="8" id="postal-code">
                                        @foreach ($errors->get('zip_code') as $errorMsg)
                                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                        @endforeach
                                      </div>
                                    </div>
                                    <div class="row mb-4">
                                      <div class="col-md-3 text-left center input-text-color">
                                        <b>{{ __('labels.client_tab.register.prefecture') }}</b>
                                      </div>
                                      <div class="col-md-9">
                                        <span class="p-country-name" style="display:none;">Japan</span>
                                        <input type="text" value="{{ old('prefecture', session()->get('prefecture')) }}" name="prefecture"
                                           class="form-control p-region input-text-color" id="prefecture">
                                        @foreach ($errors->get('prefecture') as $errorMsg)
                                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                        @endforeach
                                      </div>
                                    </div>
                                    <div class="row mb-4">
                                      <div class="col-md-3 text-left center input-text-color">
                                        <b>{{ __('labels.client_tab.register.city') }}</b>
                                      </div>
                                      <div class="col-md-9">
                                        <input type="text" value="{{ old('city', session()->get('city')) }}" name="city" class="form-control p-locality p-street-address p-extended-address input-text-color">
                                        @foreach ($errors->get('city') as $errorMsg)
                                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3 text-left center input-text-color">
                                                <p><b>{{ __('labels.client_tab.register.subsequent_address') }}</b></p>
                                            </div>
                                            <div class="col-md-9">
                                              <input type="text" value="{{ old('subsequent_address', session()->get('subsequent_address')) }}" name="subsequent_address" class="form-control input-text-color">
                                              @foreach ($errors->get('subsequent_address') as $errorMsg)
                                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3 text-left center input-text-color">
                                                <p><b>{{ __('labels.client_tab.register.corporate_number') }}</b></p>
                                            </div>
                                            <div class="col-md-9">
                                              <input type="text" value="{{ old('corporate_number', session()->get('corporate_number')) }}" name="corporate_number" class="form-control input-text-color">
                                              @foreach ($errors->get('corporate_number') as $errorMsg)
                                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3 text-left center input-text-color">
                                                <p><b>{{ __('labels.client_tab.register.password') }}</b></p>
                                            </div>
                                            <div class="col-md-9">
                                              <input type="password"  name="password" class="form-control input-text-color">
                                              @foreach ($errors->get('password') as $errorMsg)
                                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3 text-left center input-text-color">
                                                <p><b>{{ __('labels.client_tab.register.password_confirm') }}</b></p>
                                            </div>
                                            <div class="col-md-9">
                                              <input type="password"  name="password_confirmation" class="form-control input-text-color">
                                              @foreach ($errors->get('password_confirmation') as $errorMsg)
                                                <label class="form-text text-danger error">{{ $errorMsg }}</label>
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                <div class="row mb-4">
                                    <div class="col-md-12 text-right">
                                      <button type="submit" class="btn btn-primary" id="btn-add">{{ __('labels.button.register_action') }}</button>
                                    </div>
                                </div>
                                 @if (!is_null(session()->get('dataError')))
                                    <div class="error-alert">
                                      {{ session()->get('dataError')['error']['msg'] }}
                                    </div>
                                 @endif
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
  <style lang="scss">
    .wrap {
      width: 56%;
    }
    .content {
      font-size: 13px;
    }
    #btn-add {
      background: #1874C4;
    }
    .center {
      line-height: 35px;
    }
    .input-text-color {
      color: #333333;
    }
    .title-color {
      color: #000000;
    }
  </style>
@endsection

@section('javascript')
  <script src="{{ asset('js/portal/user/edit.js') }}"></script>
@endsection
