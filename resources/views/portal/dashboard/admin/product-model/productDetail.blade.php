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
        <h3><b class="route-name">{{ __('labels.products_tab.detail.title') }}</b></h3>
      </div>
      <div class="col-lg-6 text-right">
        <a href="{{ route('products.edit', $product->product_model_id) }}">
          <button type="submit" class="btn btn-secondary">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_edit.png' ) }}" alt="" class="icon-edit">
            {{ __('labels.button.save') }}
          </button>
        </a>
        <a href="{{ route('products.index') }}">
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
              <p><b>{{ __('labels.products_tab.detail.basic_title') }}</b></p>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-right"></div>
          </div>
          @if ($product->image_path)
            <div class="row mb-4">
                @foreach ($product->image_path as $path)
                  <div class="col-md-2 images-div">
                    <img src="{{ $path ? $path : asset(config('storage.icon_folder') . 'avatar_user_default.svg') }}"
                       alt="no-image" class="images-product">
                  </div>
                @endforeach
            </div>
          @endif
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.model_no') }}</b>
            </div>
            <div class="col-md-10">
              {{ $product->model_no }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.brand_name') }}</b>
            </div>
            <div class="col-md-10 word-wrap">
              {{ $product->brand->name ?? '' }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.product_model_name') }}</b>
            </div>
            <div class="col-md-10 word-wrap">
              {{ $product->name }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.detail') }}</b>
            </div>
            <div class="col-md-10 word-wrap">
              {{ $product->detail }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.transfer') }}</b>
            </div>
            <div class="col-md-10 word-wrap">
              {{ \App\Enums\Constant::TRANSFER_MONTH[$product->transfer_month] . $product->transfer_date
                . \App\Enums\Constant::DAY }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.pickup_flag') }}</b>
            </div>
            <div class="col-md-10 word-wrap">
              <input class="form-check-input mt-0 ml-0" id="checkbox" type="checkbox"
                 {{ $product->pickup_flag ? 'checked' : '' }} disabled>
            </div>
          </div>
          <div class="row mb-4">

            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.feature_flag') }}</b>
            </div>
            <div class="col-md-10">
              <input class="form-check-input mt-0 ml-0" id="checkbox" type="checkbox"
                 {{ $product->feature_flag ? 'checked' : '' }} disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-2">
              <b>{{ __('labels.products_tab.detail.is_hidden') }}</b>
            </div>
            <div class="col-md-10">
              <input class="form-check-input mt-0 ml-0" id="checkbox" type="checkbox"
                 {{ $product->is_hidden ? 'checked' : '' }} disabled>
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
              @foreach($productPrice as $value)
                @if($value->name)
                  <div class="row mb-4">
                    <div class="col-md-2">
                      {{ $value->name }}
                    </div>
                    <div class="col-md-10 word-wrap">
                      {{ $value->price . \App\Enums\Constant::YEN }}
                    </div>
                  </div>
                @endif
              @endforeach
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
            {{ __('labels.products_tab.modal_confirm_delete.content_title') }}
            <p class="pb-0 mb-0">{{ __('labels.products_tab.modal_confirm_delete.content_body') }}</p>
          </div>
          <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
            <form class="form-delete" action="{{ route('products.destroy', $product->product_model_id) }}" method="POST">
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
      .images-div {
          display: inline-block;
          width: calc(19.9999% - 1rem);
          padding-bottom: calc(16.6666667% - 1rem);
          height: 0;
          position: relative;
          margin: .5rem;
          background: #f3f3f3;
          cursor: default;
      }
      .images-div img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          position: absolute;
          left: 0;
      }
  </style>
@endsection

