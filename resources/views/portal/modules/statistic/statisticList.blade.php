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

        .statistic__content .table .border-t {
            min-height: 50px;
        }

        hr {
            margin-top: 0;
        }
    </style>
@endsection
@section('content')
    <div class="statistic">
        <div class="text-left statistic__title">
            <p class="f-w6">当月業績速報</p>
        </div>
        <div class="statistic__content">
            <div class="statistic__content--form-search">
                <div class="text-left f-w3">
                    <form id="form-search" action="{{ route('portal.statistic.index')}}">
                        <div class="d-flex flex-wrap list-option--top">
                            <div>
                                <p>売上日（開始）</p>
                                <div class="jquery-datetime-picker datetimepicker date-time-course">
                                    <input type="text" data-input class="auto-trim start-datetime" name="start_date"
                                           data-max="{{ $searchParam['end_date'] ?? null}}"
                                           value="{{ $searchParam['start_date'] ?? null }}" autocomplete="off"
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
                                           value="{{ $searchParam['end_date'] }}" autocomplete="off"
                                           data-format="Y-m-d">
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
                                    @foreach(\App\Enums\DBConstant::LIST_CATEGORY as $key => $value)
                                        <option value="{{ $key }}" {{ Request::get('category_type') == $key ? 'selected' : '' }}>{{ $value ?? '全社計' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <p>ジャンル</p>
                                <select class="form-select form-select-lg custom-select name" id="category_id"
                                        name="category_id"
                                        aria-label=".form-select-lg example">
                                </select>
                            </div>
                            <div class="f-w3">
                                <button id="search-button" class="btn-search btn-primary">検索</button>
                            </div>
                        </div>
                        <div class="f-w6">※表示は消費税抜き</div>
                    </form>
                </div>
            </div>

            <hr>
            <div class="table-content">
                <div class="table">
                    @include('portal.modules.statistic.statisticTable')
                </div>
            </div>
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
