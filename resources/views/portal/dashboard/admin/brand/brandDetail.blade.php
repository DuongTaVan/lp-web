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
                <h3><b class="route-name">{{ __('labels.brand_tab.list.title') }}</b></h3>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('brands.edit', $brand->brand_id) }}">
                    <button type="submit" class="btn btn-secondary">
                        <img src="{{ asset(config('storage.icon_folder') . 'ico_edit.png' ) }}" alt="" class="icon-edit">
                        {{ __('labels.button.save') }}
                    </button>
                </a>
                <a href="{{ route('brands.index') }}">
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
                            <p><b>{{ __('labels.brand_tab.detail.title') }}</b></p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.brand_tab.list.brand_name') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap text-content">
                            {{ $brand->brand_name }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <b>{{ __('labels.brand_tab.list.display_order') }}</b>
                        </div>
                        <div class="col-md-10 word-wrap text-content">
                            {{ $brand->display_order }}
                        </div>
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
        .title-user {
            border-bottom: 1px solid #CCCCCC;
            margin-left: -3rem;
            margin-right: 0;
            padding-left: 3rem;
        }
        .text-content {
            margin-left: -5.5rem;
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
