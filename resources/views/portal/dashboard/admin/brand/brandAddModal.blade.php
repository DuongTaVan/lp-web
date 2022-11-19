
<!-- Modal -->
<div class="modal fade modal-add" id="brandAddModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="font-weight-bold">{{ __('labels.brand_tab.add.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('brands.store') }}">
                    @csrf
                  <div class="modal-body body-box ml-3 mr-3 mt-4">
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <p class="text-left title">{{ __('labels.brand_tab.add.name') }} *</p>
                        <input class="form-control {{ $errors->get('name') ? 'error' : '' }}" name="name" value="{{ old('name') }}">
                        @foreach ($errors->get('name') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <p class="text-left title">{{ __('labels.brand_tab.add.display_order') }} *</p>
                        <input class="form-control {{ $errors->get('display_order') ? 'error' : '' }}"
                          name="display_order" value="{{ old('display_order') }}"
                          oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                          maxlength="11"
                        >
                        @foreach ($errors->get('display_order') as $errorMsg)
                          <label class="form-text text-danger error">{{ $errorMsg }}</label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer border-top-0 mb-4 pt-0 mr-3">
                    <button type="submit" class="btn btn-primary" id="btn-add">{{ __('labels.button.register_action') }}</button>
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
      width: 35%;
    }
    .title {
      margin-bottom: 5px !important;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
@endsection
