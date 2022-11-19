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
                    <h3><b class="route-name">{{ __('labels.brand_tab.list.title') }}</b></h3>
                </div>
              <div class="col-6 text-right">
                <button data-toggle="modal" data-target="#brandAddModal" class="btn btn-secondary add-popup">{{ __('labels.button.sign_up') }}</button>
              </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header customer-header">
                    <div class="d-flex">
                        <div class="d-flex flex-wrap">
                            <form class="form-inline" method="get">
                                <fieldset class="form-group w-337p">
                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                        <label for="s-id" class="col-form-label justify-content-start pb-0">
                                            {{ __('labels.brand_tab.list.brand_name') }}
                                        </label>
                                        <input id="s-id" type="text" class="form-control" name="brand_name" value="{{
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
                                    <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-wrap table-bordered b-table-fixed">
                                        <colgroup>
                                            <col style="width: 140px;">
                                            <col style="width: 991px;">
                                            <col style="width: 194px;">
                                            <col style="width: 119px;">
                                        </colgroup>
                                        <thead role="rowgroup" class="">
                                        <tr role="row" class="">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_brand_id">
                                                <input type="hidden" value="brand_id" name="brand_id" class="brand_id">
                                                <div>{{ __('labels.brand_tab.list.brand_id') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_brand_name">
                                                <input type="hidden" value="brand_name" name="brand_name" class="name">
                                                <div>{{ __('labels.brand_tab.list.brand_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="6" aria-sort="none" class="sort parent_display_order">
                                                <input type="hidden" value="display_order" name="display_order" class="display_order">
                                                <div>{{ __('labels.brand_tab.list.display_order') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="6" class="">
                                                <div>{{ __('labels.brand_tab.list.operation') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                        @foreach ($brands as $brand)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class"><span>{{ $brand->brand_id }}</span></td>
                                                <td aria-colindex="3" role="cell" class="td-class"><span> {{ $brand->brand_name }} </span></td>
                                                <td aria-colindex="6" role="cell" class="td-class"><span> {{ $brand->display_order }} </span></td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <a href="{{ route('brands.show', $brand->brand_id) }}" class="btn btn-secondary">
                                                        {{ __('labels.button.detail') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @include('portal.dashboard.base.table-footer', ['data' => $brands])
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </div>
    @include('portal.dashboard.admin.brand.brandAddModal')
<style lang="scss">
    .w-337p {
        width: 337px;
    }
    .form-check-input {
        margin-left: -6px !important;
        transform: scale(1.8);
    }
    .form-inline .form-control {
        display: inline-block;
        width: 337px;
        vertical-align: middle;
    }
</style>
@endsection

@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
