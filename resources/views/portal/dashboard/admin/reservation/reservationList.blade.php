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
                <h3><b class="route-name">{{ __('labels.reservation_tab.list.title') }}</b></h3>
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
                                        {{ __('labels.reservation_tab.list.reservation_id') }}
                                    </label>
                                    <input id="s-id" type="text" class="form-control" name="reservation_id" value="{{
                                        array_key_exists('reservation_id', $searchParams) ? $searchParams['reservation_id']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.reservation_tab.list.name') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="name" value="{{
                                        array_key_exists('name', $searchParams) ? $searchParams['name']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.reservation_tab.list.model_no') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="model_no" value="{{
                                        array_key_exists('model_no', $searchParams) ? $searchParams['model_no']: '' }}">
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
                                        <col style="width: 140px;">
                                        <col style="width: 210px;">
                                        <col style="width: 326px;">
                                        <col style="width: 163px;">
                                        <col style="width: 233px;">
                                        <col style="width: 203px;">
                                        <col style="width: 203px;">
                                    </colgroup>
                                    <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_reservation_id">
                                                <input type="hidden" value="reservation_id" name="reservation_id" class="reservation_id">
                                                <div>{{ __('labels.reservation_tab.list.reservation_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_reservation_detail_id">
                                                <input type="hidden" value="reservation_detail_id" name="reservation_detail_id" class="reservation_detail_id">
                                                <div>{{ __('labels.reservation_tab.list.reservation_detail_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_full_name">
                                                <input type="hidden" value="full_name" name="full_name" class="full_name">
                                                <div>{{ __('labels.reservation_tab.list.full_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_name">
                                                <input type="hidden" value="name" name="name" class="name">
                                                <div>{{ __('labels.reservation_tab.list.name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_model_no">
                                                <input type="hidden" value="model_no" name="model_no" class="model_no">
                                                <div>{{ __('labels.reservation_tab.list.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_client_name">
                                                <input type="hidden" value="client_name" name="client_name" class="client_name">
                                                <div>{{ __('labels.reservation_tab.list.client_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_start_date">
                                              <input type="hidden" value="start_date" name="start_date" class="start_date">
                                              <div>{{ __('labels.reservation_tab.list.start_date') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_end_date">
                                              <input type="hidden" value="end_date" name="end_date" class="end_date">
                                              <div>{{ __('labels.reservation_tab.list.end_date') }}</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach ($reservations as $reservation)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class text-center"><span>{{ $reservation->reservation_id }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span>{{ $reservation->reservation_detail_id }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                  <span>{{ $reservation->last_name_kanji . $reservation->first_name_kanji }}</span>
                                                </td>
                                                <td aria-colindex="5" role="cell" class="td-class"><span>{{ $reservation->name }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class"><span class="text-nowrap">{{ $reservation->model_no }}</span></td>
                                                <td aria-colindex="7" role="cell" class="td-class">
                                                    <span>{{ $reservation->client_name ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                  <span>{{ $reservation->start_date }}</span>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
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
