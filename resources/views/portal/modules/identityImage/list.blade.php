@extends('portal.layouts.main')
@section('content')
    @if (session('message') != null)
        <div id="show-toast-success" data-msg="{{ session('message') }}"></div>
    @endif
    <div class="image-identity">
        <div class="image-identity__title f-w6">
            <p>本人確認画像承認</p>
        </div>
        <div class="image-identity__content">
            <div class="image-identity__content--form-search">
                <form action="" method="GET" id="search-form">
                    <div class="d-flex text-left f-w3 list-option position-relative">
                        <div>
                            <p class="list-option__title">ユーザーID</p>
                            <input type="text" class="input-user-id" name="userId"
                                   value="{{ array_key_exists('userId', $searchParams) ? $searchParams['userId']: '' }}"/>
                        </div>
                        <div>
                            <p class="list-option__title">ステータス</p>
                            <select class="form-select form-select-lg custom-select status" name="status"
                                    aria-label=".form-select-lg example">
                                <option value=""></option>
                                @foreach(\App\Enums\DBConstant::IMAGE_PATHS_STATUS as $key => $value)
                                    <option value="{{ $key }}"
                                            class="status__option" {{ array_key_exists('status', $searchParams) && $searchParams['status'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f-w3">
                            <button id="search-button" class="btn-search btn-primary">検索</button>
                        </div>
                    </div>
                </form>
                <hr class="devide">
                <div class="table-content">
                    <div class="d-flex justify-content-start align-items-center record">
                        <select id="select-per-page" per-page="{{$data->perPage()}}"
                                current-page="{{$data->currentPage()}}" last-page="{{$data->lastPage()}}"
                                total-record="{{$data->total()}}"
                                class="form-select form-select-lg custom-select record__select"
                                aria-label=".form-select-lg example">
                            @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                                <option value="{{ $value }}"
                                        class="f-w3" {{ array_key_exists('per_page', $searchParams) && $searchParams['per_page'] == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <span class="f-w3">件表示</span>
                        <div class="ml-auto">@include('portal.components.option_search')</div>
                    </div>
                    <div class="table">
                        @include('portal.modules.identityImage.indentityListTable')
                    </div>
                    @include('portal.components.table-footer', ['data' => $data])
                </div>
            </div>
        </div>
@endsection
