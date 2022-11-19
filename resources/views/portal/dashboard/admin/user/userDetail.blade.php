@extends('portal.dashboard.base')

@section('content')

    @if (!is_null(session()->get('dataSuccess')))
        <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
    @elseif (!is_null(session()->get('dataError')))
        <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.users_tab.list.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('users.edit', $user->user_id) }}">
                    <button type="submit" class="btn btn-secondary">
                        <img src="{{ asset(config('storage.icon_folder') . 'ico_edit.png' ) }}" alt="" class="icon-edit">
                        {{ __('labels.button.save') }}
                    </button>
                </a>
                <a href="{{ route('users.index') }}">
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
                            <p><b>{{ __('labels.users_tab.detail.title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.list.user_id') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $user->user_id }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.last_name_kanji') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->last_name_kanji }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.first_name_kanji') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->first_name_kanji }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.last_name_kana') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->last_name_kana }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.first_name_kana') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->first_name_kana }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.list.email') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.phone') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $user->phone }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.zip_code') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $user->zip_code }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.prefecture') }}</b>
                        </div>
                        <div class="col-md-10">
                            {{ $user->prefecture }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.city') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->city }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.subsequent_address') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->subsequent_address }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.ekyc_identity_verification') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ \App\Enums\Constant::EKYC_STATUS[$user->ekyc_status] }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.users_tab.detail.memo') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap">
                            {{ $user->memo }}
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
                            <p><b>{{ __('labels.users_tab.detail.title') }}</b></p>
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
                                            <col style="width: 140px;">
                                            <col style="width: 140px;">
                                            <col style="width: 326px;">
                                            <col style="width: 210px;">
                                            <col style="width: 210px;">
                                            <col style="width: 507px;">
                                            <col style="width: 283px;">
                                            <col style="width: 283px;">
                                            <col style="width: 203px;">
                                            <col style="width: 203px;">
                                        </colgroup>
                                        <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2">
                                                <div>{{ __('labels.users_tab.detail.reservation_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3">
                                                <div>{{ __('labels.users_tab.detail.reservation_detail_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3">
                                                <div>{{ __('labels.users_tab.detail.plan_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5">
                                                <div>{{ __('labels.users_tab.detail.serial_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7">
                                                <div>{{ __('labels.users_tab.detail.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7">
                                                <div>{{ __('labels.users_tab.detail.product_model_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8">
                                                <div>{{ __('labels.users_tab.detail.reserved_at') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8">
                                                <div>{{ __('labels.users_tab.detail.pickup_time') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8">
                                                <div>{{ __('labels.users_tab.detail.start_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8">
                                                <div>{{ __('labels.users_tab.detail.end_date') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                        @foreach($reservations as $reservation)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    <span>
                                                        {{ $reservation->reservation_id }}
                                                    </span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $reservation->reservation_detail_id }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $reservation->plan_name }}</span>
                                                </td>
                                                <td aria-colindex="5" role="cell" class="td-class">
                                                    <span>{{ $reservation->serial_no }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->model_no }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->product_model_name }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->reserved_at }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->pickup_time }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->start_date }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->end_date }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @include('portal.dashboard.base.table-footer', ['data' => $reservations])
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
                        {{ __('labels.users_tab.modal_confirm_delete.content_title') }}
                        <p class="pb-0 mb-0">{{ __('labels.users_tab.modal_confirm_delete.content_body') }}</p>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
                        <form class="form-delete" action="{{ route('users.destroy', $user->user_id) }}" method="POST">
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
            margin-right: 0;
            padding-left: 3rem;
        }
    </style>
@endsection
