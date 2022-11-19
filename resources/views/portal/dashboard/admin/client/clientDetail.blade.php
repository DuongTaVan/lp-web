@extends('portal.dashboard.base')

@section('content')

    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div class="container-fluid" style="padding-bottom: 0;">
        <div class="row">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.client_tab.list.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('clients.edit', $clients->client_id) }}">
                    <button type="submit" class="btn btn-secondary">
                        <img src="{{ asset(config('storage.icon_folder') . 'ico_edit.png' ) }}" alt="" class="icon-edit">
                        {{ __('labels.button.save') }}
                    </button>
                </a>
                <a href="{{ route('clients.index') }}">
                    <button type="submit" class="btn btn-secondary">
                        {{ __('labels.button.back') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5 content-padding">
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
                        <div class="col-md-10">
                            {{ $clients->client_id }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.client_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->client_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.mgmt_portal_user_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->mgmt_portal_user_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.list.email') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->email }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.phone') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->phone }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.zip_code') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->zip_code }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.prefecture') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $clients->prefecture }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.city') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $clients->city }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.subsequent_address') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $clients->subsequent_address }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.corporate_number') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->corporate_number }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.detail.memo') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->memo }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5 content-padding">
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
                        <div class="col-md-10">
                            {{ $clients->bank_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.branch_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->branch_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_type') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                          {{ $clients->account_type !== null ? \App\Enums\Constant::ACCOUNT_TYPE[$clients->account_type] : '' }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_number') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->account_number }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.client_tab.account_detail.account_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $clients->account_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
            <div class="row pl-5 content-padding">
                <div class="col-sm-12">
                    <div class="row mb-3 title-user">
                        <div class="col-md-5 pl-0">
                            <p><b>{{ __('labels.client_tab.table.title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div data-v-5bc7506e="">
                                <div class="table-responsive">
                                    <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-wrap table-bordered b-table-fixed" id="__BVID__51">
                                        <input type="hidden" id="sort" name="sort" value="">
                                        <colgroup>
                                            <col style="width: 140px;">
                                            <col style="width: 210px;">
                                            <col style="width: 133px;">
                                            <col style="width: 283px;">
                                            <col style="width: 522px;">
                                            <col style="width: 156px;">
                                        </colgroup>
                                        <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_serial_no">
                                                <input type="hidden" value="serial_no" name="serial_no" class="serial_no">
                                                <div>{{ __('labels.client_tab.table.serial_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_client_name">
                                                <input type="hidden" value="client_name" name="client_name" class="client_name">
                                                <div>{{ __('labels.client_tab.table.client_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_model_no">
                                                <input type="hidden" value="model_no" name="model_no" class="model_no">
                                                <div>{{ __('labels.client_tab.table.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_brands_name">
                                                <input type="hidden" value="brands_name" name="brands_name" class="brands_name">
                                                <div>{{ __('labels.client_tab.table.brands_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_product_models_name">
                                                <input type="hidden" value="product_models_name" name="product_models_name" class="product_models_name">
                                                <div>{{ __('labels.client_tab.table.product_models_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_royalty_rate">
                                                <input type="hidden" value="royalty_rate" name="royalty_rate" class="royalty_rate">
                                                <div>{{ __('labels.client_tab.table.royalty_rate') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                        @foreach($products as $product)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    <span>
                                                        {{ $product->serial_no }}
                                                    </span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $product->client_name }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $product->model_no }}</span>
                                                </td>
                                                <td aria-colindex="5" role="cell" class="td-class">
                                                    <span>{{ $product->brands_name }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $product->product_models_name }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ ($product->royalty_rate)/1 }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @include('portal.dashboard.base.table-footer', ['data' => $products])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-5">
            <div class="col-md-5"></div>
            <div class="col-md-6"></div>
            <div class="col-md-1 text-right">
                <button type="submit" class="btn btn-danger delete-button" data-toggle="modal" data-target="#exampleModalCenter">
                    {{ __('labels.button.delete') }}
                </button>
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
                    <div class="modal-body body-box offset-md-1">
                        {{ __('labels.client_tab.modal_confirm_delete.content_title') }}
                        <p class="pb-0 mb-0">{{ __('labels.client_tab.modal_confirm_delete.content_body') }}</p>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
                        <form class="form-delete" action="{{ route('clients.destroy', $clients->client_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-delete" id="delete-modal">{{ __('labels.button.delete-modal') }}</button>
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
            margin-right: -50px;
            padding-left: 3rem;
        }
        .content-padding {
            padding-right: 3rem;
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
