@extends('portal.layouts.main')
@section('styles')
    <style>
        .date-time-course {
            position: relative;
            border: 0;
            height: 30px !important;
        }

        .date-time-course > img {
            position: absolute;
            right: 11px;
            cursor: pointer;
            object-fit: cover;
        }

        #search-form {
            padding-left: 15px;
        }

        .course_status {
            width: 100px;
        }


    </style>
@endsection
@section('content')
    @if (session('message') != null)
        <div id="show-toast-success" data-msg="{{ session('message') }}"></div>
    @endif
    <div class="courses-list">
        <div class="text-left withdrawal-list__title">
            <p class="f-w6">新規サービス申請一覧（教えて！ライブ配信）</p>
        </div>
        <div class="courses-list__content">
            <div class="courses-identity__content--form-search">
                <form id="search-form" method="GET" action="">
                    <div class="d-flex flex-wrap list-option--top">
                        <div>
                            <p>申請日(~から)</p>
                            <div class="jquery-datetime-picker datetimepicker date-time-course">
                                <input type="text" class="auto-trim start-datetime" data-input
                                       value="{{ Request::get('start_created_at') ?? null }}" name="start_created_at"
                                       autocomplete="off" data-format="Y-m-d">
                                <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                            </div>

                        </div>
                        <div>
                            <p>申請日(~まで)</p>
                            <div class="jquery-datetime-picker datetimepicker date-time-course">
                                <input type="text" class="auto-trim end-datetime" data-input
                                       value="{{ Request::get('end_created_at') ?? null }}" name="end_created_at"
                                       autocomplete="off" data-format="Y-m-d">
                                <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex list-option--bottom flex-wrap">
                        <div class="status">
                            <p>ステータス</p>
                            <select class="form-select form-select-lg status status-approval"
                                    name="approval_status"
                                    aria-label=".form-select-lg example">
                                <option value=""></option>
                                @foreach(\App\Enums\DBConstant::APPROVAL_STATUS as $key => $value)
                                    <option value="{{ $key }}"
                                            class="status__option" @if(Request::get('approval_status') != null)
                                        {{Request::get('approval_status') == $key ? 'selected' : '' }}
                                            @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="category">
                            <p>サブカテゴリ</p>
                            <select class="form-select form-select-lg  status status-approval" name="category"
                                    aria-label=".form-select-lg example">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                            class="status__option" {{Request::get('category') == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="seller">
                            <p>出品者</p>
                            <input style="height: 30px" type="text" value="{{ Request::get('seller') ?? null }}"
                                   name="seller"
                                   class="form-control"
                            />
                        </div>
                        <div class="f-w3">
                            <button id="search-button" class="btn-search btn-primary">検索
                            </button>
                        </div>
                    </div>
                    <input name="per_page" type="hidden" value="{{Request::get('per_page') ?? null}}">
                </form>
                <hr class="devide">
                <div class="table-content">
                    <div class="d-flex justify-content-start align-items-center record">
                        <select id="select-per-page" name="per_page" per-page="{{$courses->perPage()}}"
                                current-page="{{$courses->currentPage()}}" last-page="{{$courses->lastPage()}}"
                                total-record="{{$courses->total()}}"
                                class="form-select form-select-lg custom-select record__select"
                                aria-label=".form-select-lg example">
                            @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                                <option value="{{ $value }}"
                                        class="f-w3" {{ $courses->perPage() == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <span class="f-w3">件表示</span>
                    </div>
                    <div class="table">
                        @include('portal.modules.courses.table')
                    </div>
                    @include('portal.components.table-footer', ['data' => $courses])
                </div>
            </div>
        </div>
@endsection
