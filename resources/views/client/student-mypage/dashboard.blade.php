@extends('client.base.base')
@section('css')
    <style>
        .card__content__rate__rating {
            margin-top: -6px;
        }
        .list-star li{
            margin-right: 4px;
        }
        @media (max-width: 414px) {
            .mx-mobile-10 {
                margin: 0 10px;
            }
            .main-mypage-teacher__header {
                margin-right: 10px;
                margin-left: 10px;
            }
        }
    </style>
@endsection
@section('lib-js')
    <script src="/js/lappi-slider.js"></script>
@endsection
@section('content')
    @php
        $userLogin = auth()->guard('client')->user()
    @endphp
    <div class="dashboard-wrapper custom-dashboard">
        @include('client.student-mypage.sidebar-left')
        <div class="main_content">
            @include('client.common.dashboard-role')
            <div class="main_content__title d-flex" style="margin-bottom: 15px;">
                <span class="dashboard_title">@lang('labels.dashboard.title')</span>
                @include('client.common.year-search',['yearOption'=>$purchaseHistories])
            </div>
            <div class="main_content__block d-flex flex-wrap">
                <div class="block col-md-4 col5">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.purchase_service')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="sub_block_left d-flex flex-column">
                            <span class="text-course f-w3">済み</span>
                            <div class="d-flex block-course-detail">
                                <a href="{{route('client.student.my-page.list', ['year' => Request::get('year')])}}" class="text-course f-w3">
                                    {{isset($purchaseHistories['listPurchaseHistory']) ?$purchaseHistories['listPurchaseHistory']->total() :0}}

                                </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.my-page.list', ['year' => Request::get('year')])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.my-page.list', ['year' => Request::get('year')])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sub_block_right d-flex flex-column">
                            <span class="text-course f-w3">購入中</span>
                            <div class="d-flex block-course-detail">
                                <a href="{{route('client.student.my-page.purchase-service', ['year' => Request::get('year')])}}"
                                   class="text-course f-w3">
                                    {{isset($purchase) ? $purchase->total() :0}}
                                </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.my-page.purchase-service', ['year' => Request::get('year')])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.my-page.purchase-service', ['year' => Request::get('year')])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block col-md-4 col5">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.message')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="sub_block_left d-flex flex-column">
                            <span class="text-course f-w3">購入中</span>
                            <div class="d-flex block-course-detail">
                                <a href="{{route('client.student.message.list', ['year' => Request::get('year')])}}" class="text-course d-flex f-w3">
                                    {{ $messageUnread['purchasedOpen'] ?? 0 }}

                                </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.message.list',['option' => 1, 'year' => Request::get('year')])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.message.list',['option' => 1, 'year' => Request::get('year')])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sub_block_right d-flex flex-column">
                            <span class="text-course f-w3">お問い合わせ</span>
                            <div class="d-flex block-course-detail">
                                <a href="{{route('client.student.message.list',['option' => 4, 'year' => Request::get('year')])}}"
                                   class="text-course d-flex f-w3">{{ $messageUnread['notPurchase'] ?? 0 }}
                                    </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.message.list',['option' => 4,'sort' => 1, 'perPage' => 10, 'page' => 1, 'year' => Request::get('year') ])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.message.list',['option' => 4,'sort' => 1, 'perPage' => 10, 'page' => 1, 'year' => Request::get('year') ])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block col-md-4 col5 ">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.review')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="sub_block_left d-flex flex-column">
                            <span class="text-course f-w3">済み</span>
                            <div class="d-flex block-course-detail">

                                <a href="{{route('client.student.my-page.review', ['tab' => 'reviewed', 'year' => Request::get('year')])}}" class="text-course d-flex f-w3">
                                    {{$totalReviews['reviewed'] ?? 0}}
                                </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.my-page.review',['tab' => 'reviewed', 'year' => Request::get('year')])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.my-page.review',['tab' => 'reviewed', 'year' => Request::get('year')])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sub_block_right d-flex flex-column">
                            <span class="text-course f-w3">評価待ち</span>
                            <div class="d-flex block-course-detail">
                                <a href="{{route('client.student.my-page.review', ['tab' => 'not-review', 'year' => Request::get('year')])}}" class="text-course d-flex f-w3">
                                    {{$totalReviews['notReviewed']}}
                                </a>
                                <div class="sub-course-detail">
                                    <span onclick="window.location.href = '{{route('client.student.my-page.review',['tab' => 'not-review', 'year' => Request::get('year')])}}'"
                                          class="text-course f-w3">件</span>
                                    <svg onclick="window.location.href = '{{route('client.student.my-page.review',['tab' => 'not-review', 'year' => Request::get('year')])}}'"
                                         width="8" height="12" viewBox="0 0 8 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path class="arrow-icon"
                                              d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                              fill="#4E5768" fill-opacity="0.2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block col-md-4 col5 ">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.point')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="d-flex block-course-detail">
                            <a href="{{route('client.student.my-page.point', ['year' => Request::get('year')])}}" class="text-course f-w3">
                                {{$user['points_balance'] ?? 0}}
                            </a>
                            <div class="sub-course-detail">
                                <span onclick="window.location.href = '{{route('client.student.my-page.point', ['year' => Request::get('year')])}}'"
                                      class="text-course f-w3 text-space-m">pt</span>
                                <svg onclick="window.location.href = '{{route('client.student.my-page.point', ['year' => Request::get('year')])}}'"
                                     width="8" height="12" viewBox="0 0 8 12" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path class="arrow-icon"
                                          d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                          fill="#4E5768" fill-opacity="0.2"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block col-md-4 col5 ">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.coupon')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="d-flex block-course-detail">
                            <a href="{{route('client.student.my-page.coupon', ['year' => Request::get('year')])}}"
                               class="text-course d-flex f-w3">0</a>
                            <div class="sub-course-detail">
                                <span onclick="window.location.href = '{{route('client.student.my-page.coupon', ['year' => Request::get('year')])}}'"
                                      class="text-course f-w3">件</span>
                                <svg onclick="window.location.href = '{{route('client.student.my-page.coupon', ['year' => Request::get('year')])}}'"
                                     width="8" height="12" viewBox="0 0 8 12" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path class="arrow-icon"
                                          d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                          fill="#4E5768" fill-opacity="0.2"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block col-md-4 col5 ">
                    <div class="block-title d-flex justify-content-center align-items-center">
                        @lang('labels.dashboard.follow')
                    </div>
                    <div class="block-content d-flex justify-content-center align-items-center">
                        <div class="d-flex block-course-detail">
                            <a href="{{route('client.student.my-page.follow')}}"
                               class="text-course d-flex f-w3">{{$follows['follows']->total() ?? 0}}</a>
                            <div class="sub-course-detail">
                                <span onclick="window.location.href = '{{route('client.student.my-page.follow')}}'"
                                      class="text-course f-w3">人</span>
                                <svg onclick="window.location.href = '{{route('client.student.my-page.follow')}}'"
                                     width="8" height="12" viewBox="0 0 8 12" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path class="arrow-icon"
                                          d="M0.321303 10.161L4.59037 5.9944L0.321303 1.82776C0.219438 1.72834 0.138634 1.61031 0.0835047 1.48041C0.0283754 1.35051 1.36763e-08 1.21128 1.01913e-08 1.07068C6.70628e-09 0.930074 0.0283754 0.790847 0.0835047 0.660947C0.138634 0.531046 0.219438 0.413016 0.321303 0.313594C0.423169 0.214172 0.544101 0.135307 0.677195 0.0815002C0.810288 0.0276936 0.952937 9.33785e-09 1.097 1.31614e-08C1.24106 1.69849e-08 1.38371 0.0276936 1.5168 0.0815002C1.64989 0.135307 1.77083 0.214172 1.87269 0.313594L6.92295 5.24269C7.35206 5.6615 7.35206 6.33805 6.92295 6.75686L1.87269 11.686C1.7709 11.7855 1.64999 11.8645 1.51689 11.9184C1.38378 11.9723 1.2411 12 1.097 12C0.952896 12 0.81021 11.9723 0.677106 11.9184C0.544002 11.8645 0.423094 11.7855 0.321303 11.686C-0.0968012 11.2671 -0.107804 10.5799 0.321303 10.161Z"
                                          fill="#4E5768" fill-opacity="0.2"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="history_web d-flex">
                <div class="border-rotate"></div>
                <p class="history_title f-w6">閲覧履歴</p>

            </div>
            <div class="main_content__history">
                @if(count($courseViewedRecently))
                    @include('client.common.home-slider', [
                        'items' => $courseViewedRecently,
                        'user' => $userLogin,
                        'index' => 0,
                        'type' => 'DEFAULT'
                    ])
                @endif
            </div>
        </div>
    </div>
@endsection
