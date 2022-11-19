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
                <h3><b class="route-name">{{ __('labels.sale_tab.list.title') }}</b></h3>
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
                                        {{ __('labels.sale_tab.list.target_month') }}
                                    </label>
                                    <input id="s-id" type="text" class="form-control" name="target_month" value="{{
                                        array_key_exists('target_month', $searchParams) ? $searchParams['target_month']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.sale_tab.list.client_name') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="client_name" value="{{
                                        array_key_exists('client_name', $searchParams) ? $searchParams['client_name']: '' }}">
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
                                        <col style="width: 227px;">
                                        <col style="width: 233px;">
                                        <col style="width: 293px;">
                                        <col style="width: 171px;">
                                        <col style="width: 233px;">
                                        <col style="width: 128px;">
                                        <col style="width: 128px;">
                                        <col style="width: 229px;">
                                    </colgroup>
                                    <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_user_id">
                                                <input type="hidden" value="user_id" name="user_id" class="user_id">
                                                <div>{{ __('labels.sale_tab.list.target_month') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_name">
                                                <input type="hidden" value="name" name="name" class="name">
                                                <div>{{ __('labels.sale_tab.list.client_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_product_model_name">
                                                <input type="hidden" value="product_model_name" name="product_model_name" class="product_model_name">
                                                <div>{{ __('labels.sale_tab.list.product_model_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_sales_amount">
                                                <input type="hidden" value="sales_amount" name="sales_amount" class="sales_amount">
                                                <div>{{ __('labels.sale_tab.list.sales_amount') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_scheduled_transfer_date">
                                                <input type="hidden" value="scheduled_transfer_date" name="scheduled_transfer_date" class="scheduled_transfer_date">
                                                <div>{{ __('labels.sale_tab.list.scheduled_transfer_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_status">
                                                <input type="hidden" value="status" name="status" class="status">
                                                <div>{{ __('labels.sale_tab.list.status') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_is_transferred">
                                                <input type="hidden" value="is_transferred" name="is_transferred" class="is_transferred">
                                                <div>{{ __('labels.sale_tab.list.is_transferred') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8" class="text-center">
                                                  <div>{{ __('labels.users_tab.list.operation') }}</div>
                                              </th>
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach ($sales as $sale)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class"><span>{{ $sale->target_month }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span>{{ $sale->name ?? '' }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span>{{ $sale->product_model_name }}</span></td>
                                                <td aria-colindex="5" role="cell" class="td-class"><span>{{ $sale->sales_amount }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class"><span class="text-nowrap">{{ $sale->scheduled_transfer_date }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ \App\Enums\Constant::STATUS[$sale->status] }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ \App\Enums\Constant::IS_TRANSFERRED[$sale->is_transferred] }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <div class="button-transferred">
                                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-secondary">
                                                            {{ __('labels.button.detail') }}
                                                        </a>
                                                        @if ($sale->is_transferred === \App\Enums\DBConstant::NOT_TRANSFER_FLAG)
                                                            <a class="btn btn-secondary add-transfer" data-toggle="modal" data-target="#exampleModalCenter">
                                                                {{ __('labels.button.transferred_registration') }}
                                                                <input type="hidden" name="transfer_flag" class="transfer_flag" value="{{ $sale->id }}">
                                                            </a>
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('portal.dashboard.base.table-footer', ['data' => $sales])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">
                  <img src="{{ asset(config('storage.icon_folder') . 'ico_close.png' ) }}">
              </span>
                </button>
            </div>
            <div class="modal-body body-box">
                {{ __('labels.sale_tab.modal_confirm_update_transferred.content_title') }}
                <p class="pb-0 mb-0">{{ __('labels.sale_tab.modal_confirm_update_transferred.content_body') }}</p>
            </div>
            <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
                <form class="form-delete" action="{{ route('sales.updateTransfer') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" class="id-transfer-flash">
                    <button type="submit" class="btn btn-secondary btn-delete" id="delete-modal">{{ __('labels.button.update_transferred_modal') }}</button>
                </form>
                <button type="button" class="btn btn-primary btn-delete cancel" data-dismiss="modal">{{ __('labels.button.cancel') }}</button>
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
    .button-transferred {
        display: flex;
        justify-content: space-between;
        margin: 0 20px;
    }
</style>
@endsection
@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
    <script src="{{ asset('js/portal/sale/updateTransfer.js') }}"></script>
@endsection
