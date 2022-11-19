@extends('portal.dashboard.base')

@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{ route('inventories.update', $inventory->product_instance_id) }}" id="formUserUpdate">
            @method('PATCH')
            @csrf
        <div class="row mt-2">
            <div class="col-lg-6">
                <h3><b class="route-name">{{ __('labels.inventory_tab.detail.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('inventories.show', $inventory->product_instance_id) }}">
                    <button type="button" class="btn btn-secondary">{{ __('labels.button.cancel') }}</button>
                </a>
                <button type="submit" class="btn btn-primary btn-update">{{ __('labels.button.update') }}</button>
            </div>
        </div>
        <div class="animated fadeIn body-card mt-3 pt-4">
            <div class="row pl-5">
                <div class="col-sm-12">
                <div class="row mb-3 title-user">
                    <div class="col-md-5 pl-0">
                        <p><b>{{ __('labels.inventory_tab.detail.basic_title') }}</b></p>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-3 text-right"></div>
                </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.serial_no') }}</b>
                    </div>
                    <div class="col-md-4">
                        <input type="text" value="{{ $inventory->serial_no }}" name="serial_no" class="form-control" disabled>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.client_name') }}</b>
                    </div>
                    <div class="col-md-4 word-wrap">
                        <input type="text" value="{{ $inventory->client_name }}" name="client_name" class="form-control" disabled>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.model_no') }}</b>
                    </div>
                    <div class="col-md-4 word-wrap">
                        <input type="text" value="{{ $inventory->model_no }}" name="model_no" class="form-control" disabled>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.brand_name') }}</b>
                    </div>
                    <div class="col-md-4 word-wrap">
                        <input type="text" value="{{ $inventory->brand_name }}" name="brand_name" class="form-control" disabled>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.name') }}</b>
                    </div>
                    <div class="col-md-4 word-wrap">
                        <input type="text" value="{{ $inventory->product_model_name }}" name="product_model_name" class="form-control" disabled>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-2">
                      <b>{{ __('labels.inventory_tab.detail.royalty_rate') }}</b>
                    </div>
                    <div class="col-md-1 word-wrap pr-0">
                        <input type="text" value="{{ old('royalty_rate', $inventory->royalty_rate)}}" name="royalty_rate" class="form-control">
                        @foreach ($errors->get('royalty_rate') as $errorMsg)
                          <label class="form-text text-danger error label-royalty-rate">{{ $errorMsg }}</label>
                        @endforeach
                    </div>
                    <div class="col-md-1 pl-2 pt">
                      <span>{{ \App\Enums\Constant::PERCENT_SIGN }}</span>
                    </div>
                  </div>
            </div>
        </form>
    </div>
@endsection
@section('css')
    <style lang="scss">
        .body-card {
            background: #ffffff;
        }
        input {
            height: 40px;
        }
        .title-user {
            border-bottom: 1px solid #CCCCCC;
            margin-left: -3rem;
            margin-right: 0;
            padding-left: 3rem;
        }
        .pt {
          line-height: 35px;
        }
        .label-royalty-rate {
            width: 450px;
        }
    </style>
@endsection
