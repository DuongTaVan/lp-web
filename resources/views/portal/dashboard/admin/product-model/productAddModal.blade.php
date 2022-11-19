<!-- Modal -->
<div class="modal fade modal-add" id="modalAddProduct" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" id="modal-content">
      <div class="modal-header">
        <h5 class="font-weight-bold">{{ __('labels.products_tab.add.title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" id="form-product" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body body-box ml-3 mr-3">
          <div class="row mb-4">
            <div class="col-12">
              <div class="row mb-4 flex-column">
                  <div class="input-field">
                      <div class="product-images" style="padding-top: .5rem;"></div>
                      @foreach ($errors->get('product_images') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                      @endforeach
                  </div>
              </div>
            </div>
                </div>
          <div class="row mb-4">
            <div class="col-md-5">
              <p class="text-left title">{{ __('labels.products_tab.add.model_no') }} *</p>
              <input class="form-control {{ $errors->get('model_no') ? 'error' : '' }}" name="model_no" value="{{ old('model_no') }}">
              @foreach ($errors->get('model_no') as $errorMsg)
                <label class="form-text text-danger error">{{ $errorMsg }}</label>
              @endforeach
            </div>
            <div class="col-md-7">
              <p class="text-left title">{{ __('labels.products_tab.add.transfer') }} *</p>
              <div class="row">
                <div class="col-md-3 pr-0">
                  <select class="form-control custom-select" name="transfer_month">
                    @foreach(\App\Enums\Constant::TRANSFER_MONTH as $key => $value)
                      <option value="{{ $key }}"
                          {{ old('transfer_month') === $key ? 'selected' : ''  }}
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
                  <input type="number" class="form-control {{ $errors->get('transfer_date') ? 'error' : '' }}" name="transfer_date" value="{{ old('transfer_date') }}">
                  @foreach ($errors->get('transfer_date') as $errorMsg)
                    <label class="form-text text-danger error">{{ $errorMsg }}</label>
                  @endforeach
                </div>
                <div class="col-md-1 pl-0 pt-2">
                  <span>{{ \App\Enums\Constant::DAY }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-5">
              <p class="text-left title" data-brand-search="{{ old('brand_id') }}" id="brand-search">
                  {{ __('labels.products_tab.add.brand_name') }} *
              </p>
                <div class="custom-select2">
                    <select class="live-search form-control custom-select" name="brand_id">
                        <option value=""></option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->brand_id }}"
                                {{ old('brand_id') === $brand->brand_id ? 'selected' : ''  }}
                            >
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                  @foreach ($errors->get('brand_id') as $errorMsg)
                    <label class="form-text text-danger error">{{ $errorMsg }}</label>
                  @endforeach
                </div>
            </div>
            <div class="col-md-7">
              <p class="text-left title">{{ __('labels.products_tab.add.name') }} *</p>
              <input class="form-control {{ $errors->get('name') ? 'error' : '' }}" name="name" value="{{ old('name') }}">
              @foreach ($errors->get('name') as $errorMsg)
                <label class="form-text text-danger error">{{ $errorMsg }}</label>
              @endforeach
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12">
              <p class="text-left title">{{ __('labels.products_tab.add.detail') }} *</p>
              <textarea class="form-control {{ $errors->get('detail') ? 'error' : '' }}" rows="6" name="detail">{{ old('detail') }}</textarea>
              @foreach ($errors->get('detail') as $errorMsg)
                <label class="form-text text-danger error">{{ $errorMsg }}</label>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
          <button class="btn btn-primary" id="add-product">{{ __('labels.button.register_action') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('css')
  <style lang="scss">
      div.modal-header {
          height: 50px;
      }
      img#image-preview {
          cursor: pointer;
          height: 150px;
      }
      select.custom-select {
          width: 100%;
      }
      .title {
          margin-bottom: 5px !important;
      }
  </style>
@endsection
