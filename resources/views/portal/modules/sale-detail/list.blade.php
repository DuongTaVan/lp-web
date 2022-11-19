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
        }

        .total-text {
            font-weight: bold;
        }

        hr {
            margin-top: 0;
        }

        @media only screen and (max-width: 1365px) {
            .sale-detail__content .list-option--bottom .name {
                width: 350px;
            }

            .sale-detail__content .list-option--bottom .type {
                width: 260px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="sale-detail">
        <div class="text-left statistic__title">
            <p class="f-w6">売上明細</p>
        </div>
        <div class="sale-detail__content">
            <div class="sale-detail__content--form-search">
                <div class="text-left f-w3">
                    <form id="form-search" action="{{ route('portal.sale.index')}}">
                        <div class="d-flex flex-wrap list-option--top">
                            <div>
                                <p>売上日（開始）</p>

                                <div class="jquery-datetime-picker datetimepicker date-time-course">
                                    <input type="text" data-input class="auto-trim start-datetime" name="start_date"
                                           data-max="{{ $searchParam['end_date'] ?? null}}"
                                           value="{{old('start_date')}}" autocomplete="off"
                                           data-format="Y-m-d">
                                    <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt=""
                                         data-toggle>
                                </div>
                            </div>
                            <div>
                                <p>売上日（終了）</p>
                                <div class="jquery-datetime-picker datetimepicker date-time-course">
                                    <input type="text" data-input class="auto-trim end-datetime" name="end_date"
                                           data-min="{{ $searchParam['start_date'] ?? null}}"
                                           value="{{old('end_date')}}" autocomplete="off" data-format="Y-m-d">
                                    <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt=""
                                         data-toggle>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex list-option--bottom flex-wrap">
                            <div class="mr-4">
                                <p>カテゴリ</p>
                                <select class="form-select form-select-lg custom-select type" name="category_type"
                                        aria-label=".form-select-lg example">
                                    <option value="0" {{ old('category_type') ? 'selected' : '' }}>全社計</option>
                                    <span>
                                        @foreach(\App\Enums\DBConstant::LIST_CATEGORY as $key => $value)
                                            @if($key)
                                                @if($key===1)
                                                    <option value="{{ $key }}" {{ old('category_type') === (string)$key ? 'selected' : '' }}>教えて！ライブ配信計</option>
                                                @else
                                                    <option value="{{ $key }}" {{ old('category_type') === (string)$key ? 'selected' : '' }}>{{ $value }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </span>
                                </select>
                            </div>
                            <div class="mr-4">
                                <p>ジャンル</p>
                                <select class="form-select form-select-lg custom-select name" id="category_id"
                                        name="category_id" aria-label=".form-select-lg example">
                                </select>
                            </div>
                            <div>
                                <p>出品者ID</p>
                                <input type="text" name="userId" value="{{old('userId')}}" class="user_id"/>
                            </div>
                            <div class="f-w3">
                                <button id="search-button" class="btn-search btn-primary">検索</button>
                            </div>
                        </div>
                        <div class="f-w6">※表示は消費税込み</div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="table-content">
                <div class="d-flex justify-content-start align-items-center record">
                    <select
                            id="select-per-page"
                            per-page="{{$data['sales']->perPage()}}"
                            current-page="{{$data['sales']->currentPage()}}"
                            last-page="{{$data['sales']->lastPage()}}"
                            total-record="{{$data['sales']->total()}}"
                            class="form-select form-select-lg custom-select record__select"
                            aria-label=".form-select-lg example"
                    >
                        @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                            <option value="{{ $value }}"
                                    class="f-w3" {{ array_key_exists('per_page', $searchParam) && $searchParam['per_page'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <span class="f-w3">件表示</span>
                </div>
                <div class="table">
                    @include('portal.modules.sale-detail.table')
                </div>
            </div>
            @include('portal.components.table-footer', ['data' => $data['sales']])
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.type').change(function () {
            let accountType = $(this).val();
            $('#category_id').empty();
            $.ajax({
                url: '/portal/categories/type/' + accountType,
                type: 'GET',
                success: function (data) {
                    let categories = data.categories;
                    $('#category_id').append($("<option></option>"));
                    $.each(categories, function (key, value) {
                        $('#category_id')
                            .append($("<option></option>")
                                .attr("value", value.category_id)
                                .text(value.name));
                    });
                    $('#category_id').val({{ $searchParam['category_id'] ?? 0 }});
                }
            })
        });
        $(document).ready(function () {
            const type = $('.type');
            if (type.val()) {
                type.trigger('change');
            }
        });
    </script>
@endsection
