@extends('client.base.base')
@section('css')
    <style>
        .dashboard-wrapper .messages-wrapper .message-menu .item {
            max-width: max-content;
            padding: 4px 15px;
        }

        .dashboard-wrapper .messages-wrapper .message-menu .item.active {
            padding-top: 7px;
        }

        .none-pc {
            display: none;
        }

        @media (max-width: 414px) {
            .none-mobile {
                display: none;
            }
            .none-pc {
                display: block;
                margin-left: 10px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-wrapper messages-course-purchase custom-dashboard custom-purchase">
        @include('client.student-mypage.sidebar-left')
        <div class="messages-wrapper main-content">
            @include('client.common.dashboard-role')
            <div class="message-title">
                メッセージ
            </div>
            <ul class="nav message-menu sidebar-right__navbar-order-list" role="tablist">
                <div class="overflow-nav">
                    <li class="item item-link {{(isset($_GET['option']) && $_GET['option'] == 1) || !isset($_GET['option']) ? 'active' :''}}"
                        data-value="1">
                        <a class="f-w3"
                           href="{{route('client.student.message.list', array_merge(Request::all(), ['option' => 1, 'page' => 1]))}}">
                            購入中({{ $unreadMessage['purchasedOpen'] ?? 0 }})
                        </a>
                    </li>
                    <li class="item item-link {{isset($_GET['option']) && $_GET['option'] == 3 ? 'active' :''}}"
                        data-value="3">
                        <a class="f-w3"
                           href="{{route('client.student.message.list', array_merge(Request::all(), ['option' => 3, 'page' => 1]))}}">
                            購入済み({{ $unreadMessage['purchasedNotOpen'] ?? 0 }})
                        </a>
                    </li>
                    <li class="item item-link {{isset($_GET['option']) && $_GET['option'] == 4 ? 'active' :''}}"
                        data-value="2">
                        <a class="f-w3"
                           href="{{route('client.student.message.list', array_merge(Request::all(), ['option' => 4, 'page' => 1]))}}">
                            お問い合わせ({{ $unreadMessage['notPurchase'] ?? 0 }})
                        </a>
                    </li>
                    <li class="item item-link {{isset($_GET['option']) && $_GET['option'] == 5 ? 'active' :''}}"
                        data-value="3">
                        <a class="f-w3"
                           href="{{route('client.student.message.list', array_merge(Request::all(), ['option' => 5, 'page' => 1]))}}">
                            お知らせ({{ $unreadMessage['promotion'] ?? 0 }})
                        </a>
                    </li>
                </div>
                <div class="none-mobile">@include('client.common.year-search',['yearOption'=> $data])</div>
            </ul>
            <div class="tab-content">
                @if (isset($data['option']) && (int)$data['option'] === 1)
                    <div class="tab-pane p-0 active show home-tab"
                         id="tab_default_1">
                        <div class="list-services d-flex align-items-center">
                            <div class="title d-flex flex-row align-items-center">
                                <span class="title-table">@lang('labels.messages-course-purchase.service-list')</span>
                                <div class="none-pc">
                                    @include('client.common.year-search',['yearOption'=> $data])
                                </div>
                            </div>
                            @include('client.student-mypage.courses.sort_purchase', ['query' => [['sort' => \App\Enums\Constant::SORT_DATETIME_DESC], ['sort' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                        </div>
                        @include('client.student-mypage.courses.course-purchasing', ['data' => $data])
                    </div>
                @elseif (isset($data['option']) && (int)$data['option'] === 2)
                    <div class="tab-pane active show fade"
                         id="tab_default_2">
                        <div class="list-services d-flex align-items-center">
                            <div class="title">
                                <div class="d-flex align-items-center">
                                    <span class="title-table">@lang('labels.messages-course-purchase.service-list')</span>
                                    <div class="none-pc">
                                        @include('client.common.year-search',['yearOption'=> $data])
                                    </div>
                                </div>
{{--                                <span class="notice-end">@lang('labels.messages-course-purchase.notice-end-message')</span>--}}
                            </div>
                            @include('client.student-mypage.courses.sort_purchase', ['query' => [['sort' => \App\Enums\Constant::SORT_DATETIME_DESC], ['sort' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                        </div>
                        @include('client.student-mypage.courses.course-not-purchase', compact('data'))
                    </div>
                @elseif (isset($data['option']) && (int)$data['option'] === 3)
                    <div class="tab-pane fade active show"
                         id="tab_default_3">
                        <div class="list-services d-flex align-items-center">
                            <div class="title">
                                <div class="d-flex align-items-center">
                                    <span class="title-table">@lang('labels.messages-course-purchase.service-list')</span>
                                    <div class="none-pc">
                                        @include('client.common.year-search',['yearOption'=> $data])
                                    </div>
                                </div>
                                <span class="notice-end">@lang('labels.messages-course-purchase.notice-end-message')</span>
                            </div>
                            @include('client.student-mypage.courses.sort_purchase', ['query' => [['sort' => \App\Enums\Constant::SORT_DATETIME_DESC], ['sort' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                        </div>
                        @include('client.student-mypage.courses.purchased', compact('data'))
                    </div>
                @elseif (isset($data['option']) && (int)$data['option'] === 5)
                    <div class="tab-pane fade active show"
                         id="tab_default_4">
                        <div class="list-services d-flex align-items-center">
                            <div class="title">
                                <div class="d-flex align-items-center">
                                    <span class="title-table">@lang('labels.messages-course-purchase.inquiry-list')</span>
                                    <div class="none-pc">
                                        @include('client.common.year-search',['yearOption'=> $data])
                                    </div>
                                </div>
                            </div>
                            @include('client.student-mypage.courses.sort_purchase', ['query' => [['sort' => \App\Enums\Constant::SORT_DATETIME_DESC], ['sort' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                        </div>
                        @include('client.student-mypage.courses.promotion', compact('data'))
                    </div>
                @else
                    <div class="tab-pane fade active show"
                         id="tab_default_4">
                        <div class="list-services d-flex align-items-center">
                            <div class="title">
                                <div class="d-flex align-items-center">
                                    <span class="title-table">@lang('labels.messages-course-purchase.inquiry-list')</span>
                                    <div class="none-pc">
                                        @include('client.common.year-search',['yearOption'=> $data])
                                    </div>
                                </div>
                            </div>
                            @include('client.student-mypage.courses.sort_purchase', ['query' => [['sort' => \App\Enums\Constant::SORT_DATETIME_DESC], ['sort' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                        </div>
                        @include('client.student-mypage.courses.sellers', compact('data'))
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ mix('js/clients/student/courses-purchasing.js') }}"></script>
    <script src="{{ mix('js/clients/commons/firebase-messaging.js') }}"></script>
@endsection
