@extends('portal.dashboard.base')
@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-sm-6 col-sm-6 pt-1 pb-2">
                    <h3><b class="route-name">{{ __('labels.client_tab.list.title') }}</b></h3>
                </div>
              <div class="col-6 text-right">
                <button data-toggle="modal" data-target="#clientAddModal" class="btn btn-secondary add-popup">{{ __('labels.button.sign_up') }}</button>
              </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header customer-header">
                    <div class="d-flex">
                        <div class="d-flex flex-wrap">
                            <form class="form-inline" method="get">
                                <fieldset class="form-group w-200p mr-3">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <label for="s-id" class="col-form-label justify-content-start pb-0">
                                            {{ __('labels.search_input.client_id') }}
                                        </label>
                                        <input id="s-id" type="text" class="form-control" name="client_id" value="{{
                                            array_key_exists('client_id', $searchParams) ? $searchParams['client_id']: '' }}">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group w-250p mr-3">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <label for="s-name" class="col-form-label justify-content-start pb-0">
                                            {{ __('labels.client_tab.list.client_name') }}
                                        </label>
                                        <input id="s-email" type="text" class="form-control" name="client_name" value="{{
                                            array_key_exists('client_name', $searchParams) ? $searchParams['client_name']: '' }}">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group w-250p mr-3">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <label for="s-name" class="col-form-label justify-content-start pb-0">
                                            {{ __('labels.client_tab.list.mgmt_portal_user_name') }}
                                        </label>
                                        <input id="s-email" type="text" class="form-control" name="mgmt_portal_user_name" value="{{
                                            array_key_exists('mgmt_portal_user_name', $searchParams) ? $searchParams['mgmt_portal_user_name']: '' }}">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group w-200p mr-3">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <label for="s-email" class="col-form-label justify-content-start pb-0">
                                            {{ __('labels.search_input.email') }}
                                        </label>
                                        <input id="s-company_business_card_id" type="text" class="form-control" name="email" value="{{
                                            array_key_exists('email', $searchParams) ? $searchParams['email']: '' }}">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group ml-4">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <div data-v-5bc7506e=""><label class="col-form-label d-xs-none pt-0">&nbsp;</label></div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('labels.button.search') }}
                                        </button>
                                    </div>
                                </fieldset>
                                <input type="hidden" id="limit" name="limit" value="">
                                <input type="hidden" id="sort" name="sort" value="">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body customer-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <fieldset class="form-group form-inline">
                                <form>
                                    <select name="limit" class="mb-1 custom-select per-page">
                                        @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                                            <option value="{{ $key }}" {{ array_key_exists('limit', $searchParams) && $searchParams['limit'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                <span class="ml-1">{{ __('labels.pagination.display_record_label') }}</span>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div data-v-5bc7506e="">
                                <div class="table-responsive">
                                    <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-wrap table-bordered b-table-fixed">
                                        <colgroup>
                                            <col style="width: 90px;">
                                            <col style="width: 150px;">
                                            <col style="width: 150px;">
                                            <col style="width: 300px;">
                                            <col style="width: 250px;">
                                            <col style="width: 70px;">
                                        </colgroup>
                                        <thead role="rowgroup" class="">
                                        <tr role="row" class="">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_client_id">
                                                <input type="hidden" value="client_id" name="client_id" class="client_id">
                                                <div>{{ __('labels.client_tab.list.client_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_client_name">
                                                <input type="hidden" value="client_name" name="client_name" class="name">
                                                <div>{{ __('labels.client_tab.list.client_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="4" aria-sort="none" class="sort parent_mgmt_portal_user_name">
                                                <input type="hidden" value="mgmt_portal_user_name" name="mgmt_portal_user_name" class="mgmt_portal_user_name">
                                                <div>{{ __('labels.client_tab.list.mgmt_portal_user_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_email">
                                                <input type="hidden" value="email" name="email" class="email">
                                                <div>{{ __('labels.client_tab.list.email') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="6" aria-sort="none" class="sort parent_created_at">
                                                <input type="hidden" value="created_at" name="created_at" class="created_at">
                                                <div>{{ __('labels.client_tab.list.created_at') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="6" class="">
                                                <div style="margin-left: 12px;">{{ __('labels.client_tab.list.operation') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                        @foreach ($clients as $client)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class"><span>{{ $client->client_id }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span> {{ $client->client_name }} </span></td>
                                                <td aria-colindex="4" role="cell" class="td-class"><span> {{ $client->mgmt_portal_user_name }} </span></td>
                                                <td aria-colindex="5" role="cell" class="td-class"><span> {{ $client->email }} </span></td>
                                                <td aria-colindex="6" role="cell" class="td-class"><span> {{ $client->created_at }} </span></td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <a href="{{ route('clients.show', $client->client_id) }}" class="btn btn-secondary">
                                                        {{ __('labels.button.detail') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @include('portal.dashboard.base.table-footer', ['data' => $clients])
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </div>
    @include('portal.dashboard.admin.client.clientAddModal')
<style lang="scss">
    @media only screen and (min-width: 992px) {
        .w-250p {
             .form-control {
                width: 200px;
             }
        }

        .w-200p {
            .form-control {
                width: 130px;
             }
        }
    }

    @media only screen and (min-width: 1920px) {
        .w-250p {
             .form-control {
                width: 250px;
             }
        }

        .w-200p {
            .form-control {
                width: 180px;
             }
        }
    }
    .form-check-input {
        margin-left: -6px !important;
        transform: scale(1.8);
    }
</style>
@endsection

@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
