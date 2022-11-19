@extends('portal.dashboard.base')

@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div class="container-fluid">
      <form method="POST" action="{{ route('clients.update', $clients->client_id) }}" id="formUserUpdate">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.client_tab.list.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
              <a href="{{ route('clients.show', $clients->client_id) }}">
                <button type="button" class="btn btn-secondary">{{ __('labels.button.cancel') }}</button>
              </a>
              <button type="submit" class="btn btn-primary btn-update">{{ __('labels.button.update') }}</button>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5">
                <div class="col-sm-12">
                    <div class="row mb-3 title-user">
                        <div class="col-md-5 pl-0">
                            <p><b>{{ __('labels.client_tab.detail.title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.client_id') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('client_id', $clients->client_id) }}" name="client_id" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.client_name') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('name', $clients->client_name) }}" name="name" class="form-control">
                          @foreach ($errors->get('name') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.mgmt_portal_user_name') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('mgmt_portal_user_name', $clients->mgmt_portal_user_name) }}" name="mgmt_portal_user_name" class="form-control">
                          @foreach ($errors->get('mgmt_portal_user_name') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.email') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('email', $clients->email) }}" name="email" class="form-control">
                          @foreach ($errors->get('email') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.phone') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('phone', $clients->phone) }}" name="phone" class="form-control" maxlength="13">
                          @foreach ($errors->get('phone') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="h-adr">
                    <div class="row mb-4">
                      <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.zip_code') }}</b>
                      </div>
                      <div class="col-md-4">
                        <span class="p-country-name" style="display:none;">Japan</span>
                        <input type="text" value="{{ old('zip_code', $clients->zip_code) }}" name="zip_code"
                               class="form-control p-postal-code" maxlength="8" size="8" id="postal-code">
                        @foreach ($errors->get('zip_code') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.prefecture') }}</b>
                      </div>
                      <div class="col-md-4">
                        <span class="p-country-name" style="display:none;">Japan</span>
                        <input type="text" value="{{ old('prefecture', $clients->prefecture) }}" name="prefecture"
                               class="form-control p-region" id="prefecture">
                        @foreach ($errors->get('prefecture') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-2">
                        <b>{{ __('labels.users_tab.detail.city') }}</b>
                      </div>
                      <div class="col-md-4">
                        <input type="text" value="{{ old('city', $clients->city) }}" name="city" class="form-control p-locality p-street-address p-extended-address">
                        @foreach ($errors->get('city') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.subsequent_address') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('subsequent_address', $clients->subsequent_address) }}" name="subsequent_address" class="form-control">
                          @foreach ($errors->get('subsequent_address') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.corporate_number') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('corporate_number', $clients->corporate_number) }}" name="corporate_number" class="form-control">
                          @foreach ($errors->get('corporate_number') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.memo') }}</b>
                        </div>
                        <div class="col-md-10 pr-5">
                          <input type="text" value="{{ old('memo', $clients->memo) }}" name="memo" class="form-control">
                          @foreach ($errors->get('memo') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5">
                <div class="col-sm-12">
                    <div class="row mb-3 title-user">
                        <div class="col-md-5 pl-0">
                            <p><b>{{ __('labels.client_tab.account_detail.title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.bank_name') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('bank_name', $clients->bank_name) }}" name="bank_name" class="form-control">
                          @foreach ($errors->get('bank_name') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.branch_name') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('branch_name', $clients->branch_name) }}" name="branch_name" class="form-control">
                          @foreach ($errors->get('branch_name') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_type') }}</b>
                        </div>
                        <div class="col-md-1">
                          <select class="form-control custom-select" name="account_type">
                            @foreach(\App\Enums\Constant::ACCOUNT_TYPE as $key => $value)
                              <option value="{{ $key }}"
                                  {{ old('account_type', $clients->account_type) === $key ? 'selected' : ''  }}
                              >
                                {{ $value }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_number') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('account_number', $clients->account_number) }}" name="account_number" class="form-control">
                          @foreach ($errors->get('account_number') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_name') }}</b>
                        </div>
                        <div class="col-md-4">
                          <input type="text" value="{{ old('account_name', $clients->account_name) }}" name="account_name" class="form-control">
                          @foreach ($errors->get('account_name') as $errorMsg)
                            <label class="form-text text-danger error">{{ $errorMsg }}</label>
                          @endforeach
                    </div>
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
        .body-box {
            width: 50%;
            margin-top: -20px;
        }
        .modal-content {
            max-width: 400px;
            max-height: 200px;
        }
        .btn-delete {
            padding: 13px 47px 13px 47px;
        }
        .modal-body {
            width: 82% !important;
        }
        .modal-content .modal-footer .btn-secondary {
            margin-right: 15px;
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
