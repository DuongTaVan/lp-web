@extends('portal.dashboard.base')
@section('content')
  @if (!is_null(session()->get('dataSuccess')))
    <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
  @elseif (!is_null(session()->get('dataError')))
    <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
  @endif
  <div class="container-fluid">
    <form method="POST" action="{{ route('products.update', $product->product_model_id) }}" enctype="multipart/form-data">
      @method('PATCH')
      @csrf
      <div class="row">
        <div class="col-lg-6">
          <h3><b class="route-name">{{ __('labels.products_tab.detail.title') }}</b></h3>
        </div>
        <div class="col-lg-6 text-right">
          <a href="{{ route('products.show', $product->product_model_id) }}">
            <button type="button" class="btn btn-secondary">{{ __('labels.button.cancel') }}</button>
          </a>
          <button type="submit" class="btn btn-primary btn-update">{{ __('labels.button.update') }}</button>
        </div>
      </div>
      <div class="animated fadeIn body-card mt-3 pt-3 box-shadow">
        <div class="row pl-5">
          <div class="col-sm-12">
            <div class="row mb-3 title-user">
              <div class="col-md-5 pl-0">
                <p><b>{{ __('labels.products_tab.detail.basic_title') }}</b></p>
              </div>
              <div class="col-md-4"></div>
              <div class="col-md-3 text-right"></div>
            </div>
            <div class="row mb-4">
              <div class="col-12 word-wrap">
                  <div class="input-field">
                      <div class="product-images" style="padding-top: .5rem;"></div>
                      @foreach ($errors->get('product_images') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                      @endforeach
                  </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.model_no') }}</b>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control {{ $errors->get('model_no') ? 'error' : '' }}" name="model_no" value="{{ old('model_no', $product->model_no) }}">
                @foreach ($errors->get('model_no') as $errorMsg)
                  <label class="form-text text-danger error">{{ $errorMsg }}</label>
                @endforeach
              </div>
              <div class="col-md-7">
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b data-brand-edit-search="{{ old('brand_id', $product->brand_id) }}" id="brand-edit-search">
                    {{ __('labels.products_tab.detail.brand_name') }}
                </b>
              </div>
              <div class="col-md-3">
                  <div class="custom-select2">
                      <select class="live-search-edit form-control custom-select" name="brand_id">
                          <option value=""></option>
                          @foreach($brands as $brand)
                              <option value="{{ $brand->brand_id }}"
                                  {{ old('brand_id', $product->brand_id) === $brand->brand_id ? 'selected' : ''  }}
                              >
                                  {{ $brand->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                @foreach ($errors->get('brand_id') as $errorMsg)
                  <label class="form-text text-danger error">{{ $errorMsg }}</label>
                @endforeach
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.product_model_name') }}</b>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control {{ $errors->get('name') ? 'error' : '' }}" name="name" value="{{ old('name', $product->name) }}">
                @foreach ($errors->get('name') as $errorMsg)
                  <label class="form-text text-danger error">{{ $errorMsg }}</label>
                @endforeach
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.detail') }}</b>
              </div>
              <div class="col-md-10 word-wrap">
                <textarea class="form-control {{ $errors->get('detail') ? 'error' : '' }}" rows="6" name="detail">{{ old('detail', $product->detail) }}</textarea>
                @foreach ($errors->get('detail') as $errorMsg)
                  <label class="form-text text-danger error">{{ $errorMsg }}</label>
                @endforeach
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.transfer') }}</b>
              </div>
              <div class="col-md-3 word-wrap">
                <div class="row">
                  <div class="col-md-4 pr-0">
                    <select class="form-control custom-select" name="transfer_month">
                      @foreach(\App\Enums\Constant::TRANSFER_MONTH as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('transfer_month', $product->transfer_month) === $key ? 'selected' : ''  }}
                        >
                          {{ $value }}
                        </option>
                      @endforeach
                    </select>
                    @foreach ($errors->get('transfer_month') as $errorMsg)
                      <label class="form-text text-danger error">{{ $errorMsg }}</label>
                    @endforeach
                  </div>
                  <div class="col-md-3 pr-0">
                    <input class="form-control {{ $errors->get('transfer_date') ? 'error' : '' }}" name="transfer_date"
                       value="{{ old('transfer_date', $product->transfer_date) }}">
                    @foreach ($errors->get('transfer_date') as $errorMsg)
                      <label class="form-text text-danger error">{{ $errorMsg }}</label>
                    @endforeach
                  </div>
                  <div class="col-md-1 pl-3 pt-2">
                    <span>{{ \App\Enums\Constant::DAY }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.pickup_flag') }}</b>
              </div>
              <div class="col-md-3 word-wrap">
                <input class="form-check-input mt-0 ml-0" type="checkbox" name="pickup_flag"
                   {{ old('pickup_flag', $product->pickup_flag) ? 'checked' : '' }}>
              </div>
            </div>
            <div class="row mb-4">

              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.feature_flag') }}</b>
              </div>
              <div class="col-md-3">
                <input class="form-check-input mt-0 ml-0" type="checkbox" name="feature_flag"
                   {{ old('feature_flag', $product->feature_flag) ? 'checked' : '' }}>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-2">
                <b>{{ __('labels.products_tab.detail.is_hidden') }}</b>
              </div>
              <div class="col-md-3">
                <input class="form-check-input mt-0 ml-0" type="checkbox" name="is_hidden"
                   {{ old('is_hidden', $product->is_hidden) ? 'checked' : '' }}>
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
                <p><b>{{ __('labels.products_tab.detail.price_title') }}</b></p>
              </div>
              <div class="col-md-4"></div>
              <div class="col-md-3 text-right"></div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                @foreach(\App\Enums\Constant::PLAN as $key => $value)
                  <div class="row mb-4">
                  <div class="col-md-2">
                    <b>{{ $value }}</b>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control {{ $errors->get('plan' . $key) ? 'error' : '' }}" name="{{ 'plan' . $key}}" value="{{ old('plan' . $key, $plan[$key] ?? '') }}">
                    @foreach ($errors->get('plan' . $key) as $errorMsg)
                      <label class="form-text text-danger error">{{ $errorMsg }}</label>
                    @endforeach
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    @if ($product->image_path)
      @foreach ($product->image_path as $key => $value)
          <input type="hidden" class="id" value="{{ $key }}">
          <input type="hidden" class="image" value="{{ $value }}">
      @endforeach
    @endif
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
      .word-wrap {
          padding-right: 3.5rem;
      }
  </style>
@endsection
@section('javascript')
    <script src="{{ asset('js/image-uploader.min.js') }}"></script>
    <script src="{{ asset('js/portal/product/edit.js') }}"></script>
    <script src="{{ mix('js/live-search.js') }}"></script>
    <script src="{{ asset('js/portal/select-live-search.js') }}"></script>
@endsection
