@extends('portal.layouts.main')
@section('styles')
    <style>
        th {
            width: 100%;
            height: 100% !important;
            background-color: #ffffff;
        }

        td {
            background-color: #ffffff;
            background-clip: padding-box;
        }

        .term-statistic__content .table-content .w-213 {
            height: unset;
        }

        .table-content .table {
            margin-bottom: unset;
            max-height: 600px;
            height: 100%;
            padding-bottom: 20px;
        }

        hr {
            margin-top: 0;
        }

        @media only screen and (max-width: 1365px) {
            .term-statistic__content .list-option--bottom .name {
                width: 270px;
            }

            .term-statistic__content .list-option--bottom .type {
                min-width: 270px;
            }
        }

        .icon-arrow {
            transform: scale(2.5);
        }
    </style>
@endsection
@section('content')
    <div class="term-statistic">
        <div class="text-left statistic__title">
            <p class="f-w6">業績データ（上期・下期）</p>
        </div>
        <div class="term-statistic__content">
            <div class="term-statistic__content--form-search">
                <div class="text-left f-w3">
                    <form id="form-search" action="{{ route('portal.term-statistic.index')}}">
                        <div class="select-date__content d-flex align-items-center">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <a href="@if (!$year) {{ request()->fullUrlWithQuery(['year' => now()->year]) }} @else {{ request()->fullUrlWithQuery(['year'=> $year - 1]) }}  @endif">
                                <img style="margin-right: 5px;" class="icon-arrow"
                                     src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt="">
                            </a>
                            <span style="margin: 0 7px">{{ $year }}年</span>
                            @if(now()->year > $year)
                                <a href="@if (!$year) {{ request()->fullUrlWithQuery(['year' => now()->year]) }} @else {{ request()->fullUrlWithQuery(['year' => $year + 1]) }}  @endif"
                                   class="sidebar-right__navbar-order-list__day-year__right">
                                    <img style="margin-left: 4px;" class="icon-arrow"
                                         src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt="">
                                </a>
                            @else
                                <a class="sidebar-right__navbar-order-list__day-year__right opacity-50"><img
                                            style="margin-left: 4px;" class="icon-arrow"
                                            src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></a>
                            @endif
                        </div>
                        <div class="d-flex list-option--bottom flex-wrap">
                            <div class="mr-4">
                                <p>対象期間</p>
                                <select class="form-select form-select-lg custom-select target-month" name="term"
                                        aria-label=".form-select-lg example">
                                    @foreach(\App\Enums\DBConstant::LIST_TARGET_MONTH as $key => $value)
                                        @if($key)
                                            <option value="{{ $key }}" {{ (int)$searchParam['term'] === $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mr-4">
                                <p>カテゴリ</p>
                                <select class="form-select form-select-lg custom-select type" name="category_type"
                                        aria-label=".form-select-lg example">
                                    <option value="0" {{ old('category_type') ? 'selected' : '' }}>全社計</option>
                                    @foreach(\App\Enums\DBConstant::LIST_CATEGORY as $key => $value)
                                        @if($key)
                                            @if($key===1)
                                                <option value="{{ $key }}" {{ isset($searchParam['category_type']) && $searchParam['category_type'] === (string)$key ? 'selected' : '' }}>
                                                    教えて！ライブ配信計
                                                </option>
                                            @else
                                                <option value="{{ $key }}" {{ isset($searchParam['category_type']) && $searchParam['category_type'] === (string)$key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endif
                                        @endif
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
                    @include('portal.modules.term-statistic.table')
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
                    const categoryElement = $('#category_id');
                    categoryElement.append($("<option></option>"));
                    $.each(categories, function (key, value) {
                        $('#category_id')
                            .append($("<option></option>")
                                .attr("value", value.category_id)
                                .text(value.name));
                    });
                    categoryElement.val({{ $searchParam['category_id'] ?? 0 }});
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
