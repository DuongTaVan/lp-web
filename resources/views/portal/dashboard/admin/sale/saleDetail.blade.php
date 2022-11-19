@extends('portal.dashboard.base')

@section('content')
    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div class="container-fluid">
        <div class="row" id="title-form">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.sale_tab.detail.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-set-width" id="exportPdf">
                    {{ __('labels.button.export_pdf') }}
                </button>
                <a href="{{ route('sales.index') }}">
                    <button type="submit" class="btn btn-secondary">
                        {{ __('labels.button.back') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5">
                <div class="col-sm-12">
                    <div class="row mb-3 title-user">
                        <div class="col-md-5 pl-0">
                            <p><b>{{ __('labels.sale_tab.detail.basic_title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.client_name') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $billing->name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $billing->mgmt_portal_user_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.target_month') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ str_replace('-', \App\Enums\Constant::YEAR, $billing->target_month) . \App\Enums\Constant::MONTH }}
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
                            <p><b>{{ __('labels.sale_tab.detail.account_information_title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.bank_name') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $billing->bank_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.branch_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $billing->branch_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.account_type') }}</b>
                        </div>
                        @if ($billing->account_type)
                            <div class="col-md-10 word-wrap">
                                {{ \App\Enums\Constant::ACCOUNT_TYPE[$billing->account_type] }}
                            </div>
                        @endif
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.account_number') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $billing->account_number }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.sale_tab.detail.account_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $billing->account_name }}
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
                            <p><b>{{ __('labels.inventory_tab.detail.reservation_history_title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div data-v-5bc7506e="">
                                <div class="table-responsive">
                                    <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-wrap table-bordered b-table-fixed" id="__BVID__51">
                                        <colgroup>
                                            <col style="width: 326px;">
                                            <col style="width: 280px;">
                                            <col style="width: 283px;">
                                            <col style="width: 203px;">
                                            <col style="width: 203px;">
                                            <col style="width: 149px;">
                                        </colgroup>
                                        <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2">
                                                <div>{{ __('labels.sale_tab.detail.product_model_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3">
                                                <div>{{ __('labels.sale_tab.detail.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3">
                                                <div>{{ __('labels.sale_tab.detail.reservation_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5">
                                                <div>{{ __('labels.sale_tab.detail.start_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7">
                                                <div>{{ __('labels.sale_tab.detail.end_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7">
                                                <div>{{ __('labels.sale_tab.detail.payment_amount') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                            @foreach ($reservationDetails as $reservationDetail)
                                                <tr role="row" tabindex="0" class="">
                                                    <td aria-colindex="2" role="cell" class="td-class">
                                                        <span>
                                                            {{ $reservationDetail->name }}
                                                        </span>
                                                    </td>
                                                    <td aria-colindex="3" role="cell" class="td-class">
                                                        <span>{{ $reservationDetail->model_no }}</span>
                                                    </td>
                                                    <td aria-colindex="3" role="cell" class="td-class">
                                                        <span>{{ $reservationDetail->reservation_id }}</span>
                                                    </td>
                                                    <td aria-colindex="7" role="cell" class="td-class">
                                                        <span>{{ $reservationDetail->start_date }}</span>
                                                    </td>
                                                    <td aria-colindex="7" role="cell" class="td-class">
                                                        <span>{{ $reservationDetail->end_date }}</span>
                                                    </td>
                                                    <td aria-colindex="7" role="cell" class="td-class">
                                                        <span>{{ $reservationDetail->payment_amount . \App\Enums\Constant::YEN }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ __('labels.sale_tab.detail.sales_amount') }}
                                                </td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ $billing->sales_amount . \App\Enums\Constant::YEN }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ __('labels.sale_tab.detail.royalty_fee') }}
                                                </td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ $billing->royalty_fee . \App\Enums\Constant::YEN }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class"></td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ __('labels.sale_tab.detail.transfer_amount') }}
                                                </td>
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    {{ $billing->transfer_amount . \App\Enums\Constant::YEN }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($isClient)
            <div class="row mt-4 mb-5" id="footer-form">
                <div class="col-md-5"></div>
                <div class="col-md-5"></div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-primary btn-set-width" data-toggle="modal" data-target="#exampleModalCenter">
                        {{ __('labels.button.billing_confirmed') }}
                    </button>
                </div>
            </div>
        @endif
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
                    <div class="modal-body body-box offset-md-1">
                        {{ __('labels.sale_tab.modal_confirm_update_status.content_title') }}
                        <p class="pb-0 mb-0">{{ __('labels.sale_tab.modal_confirm_update_status.content_body') }}</p>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
                        <form class="form-delete" action="{{ route('sales.updateStatus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $billing->id }}">
                            <button type="submit" class="btn btn-secondary btn-delete" id="delete-modal">{{ __('labels.button.update_status_modal') }}</button>
                        </form>
                        <button type="button" class="btn btn-primary btn-delete cancel" data-dismiss="modal">{{ __('labels.button.cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
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
        .btn-set-width {
            width: 150px;
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ asset('js/portal/exportPdf.js') }}"></script>
@endsection
