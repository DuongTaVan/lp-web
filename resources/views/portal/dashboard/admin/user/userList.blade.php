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
                <h3><b class="route-name">{{ __('labels.users_tab.list.title') }}</b></h3>
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
                                        {{ __('labels.search_input.user_id') }}
                                    </label>
                                    <input id="s-id" type="text" class="form-control" name="user_id" value="{{
                                        array_key_exists('user_id', $searchParams) ? $searchParams['user_id']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.users_tab.list.surname') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="last_name_kanji" value="{{
                                        array_key_exists('last_name_kanji', $searchParams) ? $searchParams['last_name_kanji']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.users_tab.list.name') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="first_name_kanji" value="{{
                                        array_key_exists('first_name_kanji', $searchParams) ? $searchParams['first_name_kanji']: '' }}">
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
                            <fieldset class="form-group w-200p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-email" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.users_tab.list.ekyc_identity_verification') }}
                                    </label>
                                    <select name="ekyc_status" class="mb-1 ekyc form-control custom-select">
                                        <option value="" {{ array_key_exists('ekyc_status', $searchParams) && $searchParams['ekyc_status'] === null ? 'selected' : '' }}></option>
                                        @foreach(\App\Enums\Constant::EKYC_STATUS as $key => $value)
                                            <option value="{{ $key }}" {{ array_key_exists('ekyc_status', $searchParams)
                                                && $searchParams['ekyc_status'] == $key && $searchParams['ekyc_status'] !== null ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-wrap table-bordered b-table-fixed" id="__BVID__51">
                                    <colgroup>
                                        <col style="width: 90px;">
                                        <col style="width: 150px;">
                                        <col style="width: 150px;">
                                        <col style="width: 300px;">
                                        <col style="width: 250px;">
                                        <col style="width: 150px;">
                                        <col style="width: 150px;">
                                    </colgroup>
                                    <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_user_id">
                                                <input type="hidden" value="user_id" name="user_id" class="user_id">
                                                <div>{{ __('labels.users_tab.list.user_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_last_name_kanji">
                                                <input type="hidden" value="last_name_kanji" name="last_name_kanji" class="last_name_kanji">
                                                <div>{{ __('labels.users_tab.list.surname') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_first_name_kanji">
                                                <input type="hidden" value="first_name_kanji" name="first_name_kanji" class="first_name_kanji">
                                                <div>{{ __('labels.users_tab.list.name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_email">
                                                <input type="hidden" value="email" name="email" class="email">
                                                <div>{{ __('labels.users_tab.list.email') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_created_at">
                                                <input type="hidden" value="created_at" name="created_at" class="created_at">
                                                <div>{{ __('labels.users_tab.list.registed_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_ekyc_status">
                                                <input type="hidden" value="ekyc_status" name="ekyc_status" class="ekyc_status">
                                                <div>{{ __('labels.users_tab.list.ekyc_identity_verification') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8" class="text-center">
                                                  <div>{{ __('labels.users_tab.list.operation') }}</div>
                                              </th>
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach ($users as $user)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class text-center"><span>{{ $user->user_id }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span>{{ $user->last_name_kanji }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span>{{ $user->first_name_kanji }}</span></td>
                                                <td aria-colindex="5" role="cell" class="td-class"><span>{{ $user->email ?? '' }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class"><span class="text-nowrap">{{ $user->created_at }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ \App\Enums\Constant::EKYC_STATUS[$user->ekyc_status] }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-secondary">
                                                        {{ __('labels.button.detail') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('portal.dashboard.base.table-footer', ['data' => $users])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    @media only screen and (max-width: 1440px) {
        .c-main .container-fluid {
            padding-top: 1rem;
            padding-left: 1.9rem;
            padding-right: 1.9rem;
            padding-bottom: 1rem;
        }
    }

    .form-check-input {
        margin-left: -6px !important;
        transform: scale(1.8);
    }
    .ekyc {
        margin-top: 5px;
        width: 161px !important;
    }

</style>
@endsection
@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
