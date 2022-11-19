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
                <h3><b class="route-name">{{ __('labels.products_tab.list.title') }}</b></h3>
            </div>
          <div class="col-6 text-right">
            <button data-toggle="modal" data-target="#modalAddProduct" class="btn btn-secondary add-popup" id="show-product">{{ __('labels.button.sign_up') }}</button>
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
                                        {{ __('labels.products_tab.list.model_no') }}
                                    </label>
                                    <input id="s-id" type="text" class="form-control" name="model_no" value="{{
                                        array_key_exists('model_no', $searchParams) ? $searchParams['model_no']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.products_tab.list.brand_name') }}
                                    </label>
                                    <input id="s-brand-name" type="text" class="form-control" name="brand_name" value="{{
                                        array_key_exists('brand_name', $searchParams) ? $searchParams['brand_name']: '' }}">
                                </div>
                            </fieldset>
                            <fieldset class="form-group w-250p mr-3">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <label for="s-name" class="col-form-label justify-content-start pb-0">
                                        {{ __('labels.products_tab.list.product_model_name') }}
                                    </label>
                                    <input id="s-email" type="text" class="form-control" name="name" value="{{
                                        array_key_exists('name', $searchParams) ? $searchParams['name']: '' }}">
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
                                        <col style="width: 283px;">
                                        <col style="width: 426px;">
                                        <col style="width: 133px;">
                                        <col style="width: 133px;">
                                        <col style="width: 133px;">
                                        <col style="width: 196px;">
                                    </colgroup>
                                    <thead role="rowgroup" class="">
                                        <!---->
                                        <tr role="row" class="abc">
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="2" aria-sort="none" class="sort parent_model_no">
                                                <input type="hidden" value="model_no" name="model_no" class="model_no">
                                                <div>{{ __('labels.products_tab.list.model_no') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_brand_name">
                                                <input type="hidden" value="brand_name" name="brand_name" class="brand_name">
                                                <div>{{ __('labels.products_tab.list.brand_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="3" aria-sort="none" class="sort parent_name">
                                                <input type="hidden" value="name" name="name" class="name">
                                                <div>{{ __('labels.products_tab.list.product_model_name') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="5" aria-sort="none" class="sort parent_pickup_flag">
                                                <input type="hidden" value="pickup_flag" name="pickup_flag" class="pickup_flag">
                                                <div>{{ __('labels.products_tab.list.pickup_flag') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_feature_flag">
                                                <input type="hidden" value="feature_flag" name="feature_flag" class="feature_flag">
                                                <div>{{ __('labels.products_tab.list.feature_flag') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="7" aria-sort="none" class="sort parent_is_hidden">
                                                <input type="hidden" value="is_hidden" name="is_hidden" class="is_hidden">
                                                <div>{{ __('labels.products_tab.list.is_hidden') }}</div>
                                            </th>
                                            <th role="columnheader" scope="col" tabindex="0" aria-colindex="8" class="text-center">
                                                  <div>{{ __('labels.users_tab.list.operation') }}</div>
                                              </th>
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach ($products as $product)
                                            <tr role="row" tabindex="0" class="">
                                                <td aria-colindex="2" role="cell" class="td-class">
                                                    <span>{{ $product->model_no }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $product->brand->name ?? '' }}</span>
                                                </td>
                                                <td aria-colindex="3" role="cell" class="td-class">
                                                    <span>{{ $product->name }}</span>
                                                </td>
                                                <td aria-colindex="5" role="cell" class="td-class text-center check-box-fixed">
                                                    <input class="form-check-input mt-0" id="checkbox" type="checkbox"
                                                        {{ $product->pickup_flag ? 'checked' : '' }} disabled>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center check-box-fixed">
                                                    <input class="form-check-input mt-0" id="checkbox" type="checkbox"
                                                            {{ $product->feature_flag ? 'checked' : '' }} disabled>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center check-box-fixed">
                                                    <input class="form-check-input mt-0" id="checkbox" type="checkbox"
                                                            {{ $product->is_hidden ? 'checked' : '' }} disabled>
                                                </td>
                                                <td aria-colindex="7" role="cell" class="td-class text-center">
                                                    <a href="{{ route('products.show', $product->product_model_id) }}" class="btn btn-secondary">
                                                        {{ __('labels.button.detail') }}
                                                    </a>
                                                    <button data-toggle="modal" data-target="#modalAddInventory" class="btn btn-secondary add-inventory add-popup"
                                                        id="show-inventory">
                                                        <input type="hidden" value="{{ $product->model_no }}" class="model_no">
                                                        {{ __('labels.button.inventory_registration') }}
                                                    </button>
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
</div>
@include('portal.dashboard.admin.product-model.productAddModal', ['brands' => $brands])
@include('portal.dashboard.admin.inventory.inventoryAddModal', ['clients' => $clients])
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
    .title {
      font-size: 13px;
    }
  .pt {
    line-height: 50px;
  }
  .custom-select2 {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      margin-bottom: 1.5rem;
  }
  .upload-text span {
      width: 22%;
      text-align: center;
  }
  .image-uploader {
     min-height: 9rem;
  }
  .check-box-fixed {
      position: relative;
  }
</style>
@endsection
@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
    <script src="{{ asset('js/portal/inventory/add.js') }}"></script>
    <script src="{{ asset('js/live-search.js') }}"></script>
    <script src="{{ asset('js/portal/select-live-search.js') }}"></script>
    <script src="{{ asset('js/image-uploader.min.js') }}"></script>
    <script src="{{ asset('js/portal/product/add.js') }}"></script>
@endsection
