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
                <h3><b class="route-name">{{ __('labels.inventory_tab.list.title') }}</b></h3>
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
                                        {{ __('labels.inventory_tab.list.serial_no') }}
                                    </label>
                                    <input id="s-id" type="text" class="form-control" name="serial_no" value="{{
                                        array_key_exists('serial_no', $searchParams) ? $searchParams['serial_no']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.inventory_tab.list.client_name') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="client_name" value="{{
                                        array_key_exists('client_name', $searchParams) ? $searchParams['client_name']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.inventory_tab.list.model_no') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="model_no" value="{{
                                        array_key_exists('model_no', $searchParams) ? $searchParams['model_no']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-200p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-email" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.inventory_tab.list.brand_name') }}
                                    </label>
                                    <input id="s-company_business_card_id" type="text" class="form-control" name="brand_name" value="{{
                                        array_key_exists('brand_name', $searchParams) ? $searchParams['brand_name']: '' }}">
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
                                        <col style="width: 140px;">
                                        <col style="width: 210px;">
                                        <col style="width: 133px;">
                                        <col style="width: 283px;">
                                        <col style="width: 403px;">
                                        <col style="width: 156px;">
                                        <col style="width: 119px;">
                                    </colgroup>
                                    <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_serial_no">
                                                <input type="hidden" value="serial_no" name="serial_no" class="serial_no">
                                                <div>{{ __('labels.inventory_tab.list.serial_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_client_name">
                                                <input type="hidden" value="client_name" name="client_name" class="client_name">
                                                <div>{{ __('labels.inventory_tab.list.client_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_model_no">
                                                <input type="hidden" value="model_no" name="model_no" class="model_no">
                                                <div>{{ __('labels.inventory_tab.list.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_brand_name">
                                                <input type="hidden" value="brand_name" name="brand_name" class="brand_name">
                                                <div>{{ __('labels.inventory_tab.list.brand_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_product_model_name">
                                                <input type="hidden" value="product_model_name" name="product_model_name" class="product_model_name">
                                                <div>{{ __('labels.inventory_tab.list.product_model_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_royalty_rate">
                                                <input type="hidden" value="royalty_rate" name="royalty_rate" class="royalty_rate">
                                                <div>{{ __('labels.inventory_tab.list.royalty_rate') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8">
                                                  <div>{{ __('labels.users_tab.list.operation') }}</div>
                                              </th>
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach ($inventories as $inventory)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class text-center">
                                                  <span>{{ $inventory->serial_no }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                  <span>{{ $inventory->client_name ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                  <span>{{ $inventory->model_no ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="5" role="cell" class="td-class">
                                                  <span>{{ $inventory->brand_name ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                  <span class="text-nowrap">{{ $inventory->product_model_name ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $inventory->royalty_rate . \App\Enums\Constant::PERCENT_SIGN }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <a href="{{ route('inventories.show', $inventory->product_instance_id) }}" class="btn btn-secondary">
                                                        {{ __('labels.button.detail') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('portal.dashboard.base.table-footer', ['data' => $inventories])
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
