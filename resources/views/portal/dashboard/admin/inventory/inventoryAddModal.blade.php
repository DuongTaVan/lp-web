<!-- Modal -->
<div class="modal fade modal-add" id="modalAddInventory" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" id="modal-content-inventory">
      <div class="modal-header">
        <h5 class="font-weight-bold">{{ __('labels.inventory_tab.add.title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-inventory" action="{{ route('inventories.store') }}" method="POST">
        @csrf
        <div class="modal-body body-box ml-3 mr-3">
          <div class="row mb-4">
            <div class="col-md-12 pr-0">
              <p class="text-left title">{{ __('labels.inventory_tab.add.model_no') }} *</p>
              <input class="form-control" id="model_no" name="model_no_inventory" value="{{ session()->get('model_no_inventory') }}" disabled>
              <input class="form-control" id="model_no_inventory" name="model_no_inventory" type="hidden">
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12 pr-0">
              <p class="text-left title" id="client-search" data-client-search="{{ old('client_id') }}">{{ __('labels.inventory_tab.add.name') }} *</p>
                <div class="custom-select2">
                  <select class="form-control live-search-inventory custom-select" name="client_id">
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}"
                            {{ old('client_id') === $client->client_id ? 'selected' : ''  }}
                        >
                            {{ $client->name }}
                        </option>
                    @endforeach
                  </select>
                  @foreach ($errors->get('client_id') as $errorMsg)
                     <label class="form-text text-danger error">{{ $errorMsg }}</label>
                  @endforeach
                </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12 pr-0">
              <p class="text-left title">{{ __('labels.inventory_tab.add.serial_no') }} *</p>
              <input class="form-control" name="serial_no" value="{{ old('serial_no') }}">
              @foreach ($errors->get('serial_no') as $errorMsg)
                <label class="form-text text-danger error">{{ $errorMsg }}</label>
              @endforeach
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2 pr-0">
              <p style="width: 125px;" class="text-left title">{{ __('labels.inventory_tab.add.royalty_rate') }} *</p>
              <input class="form-control" name="royalty_rate" value="{{ old('royalty_rate') }}">
              @foreach ($errors->get('royalty_rate') as $errorMsg)
                <label class="form-text text-danger error">{{ $errorMsg }}</label>
              @endforeach
            </div>
            <div class="col-md-1 pl-2 pt text-left">
              <p></p>
              <span>{{ \App\Enums\Constant::PERCENT_SIGN }}</span>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 mb-4 pt-0">
          <button class="btn btn-primary" id="add-inventory">{{ __('labels.button.register_action') }}</button>
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
  </style>
@endsection
