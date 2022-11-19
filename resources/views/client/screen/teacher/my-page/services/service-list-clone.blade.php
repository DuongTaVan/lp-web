@extends('client.base.base')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/service-list.css')  }}"/>
    <style>
        .service-clone-custom {
            margin-top: 5px;
            position: relative;
            z-index: 2;
        }

        .btn-block {
            position: relative;
            display: table-cell !important;
        }

        .btn-disable {
            background-color: #9B9F9E !important;
        }

        .tooltiptext {
            padding-left: 5px;
            background-color: #4e5768;
            color: #fff !important;
            font-weight: 400;
            line-height: 24px;
            display: none;
            width: max-content;
            text-align: center;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            height: max-content;
            right: 8px;
            top: -13px;
        }

        .tooltiptext::after {
            border-color: #4e5768 #0000 #0000 #0000;
            content: "";
            position: absolute;
            top: 100%;
            right: 50px;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
        }

        .teacher-sidebar-right__table table td {
            padding-top: 17px;
            padding-bottom: 17px;
        }

        .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right__table table th:nth-child(1) {
            width: 168px;
        }

        .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right__table table th:nth-child(2) {
            width: 504px;
        }

        .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right__table table th:nth-child(4) {
            width: 122px;
        }

        .main-mypage-teacher.custom-service .main-mypage-teacher__content .teacher-sidebar-right .new-service-table-clone .text-left {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td {
            padding: 7px;
        }
    </style>
@endsection

@section('content')
    <div class="main-mypage-teacher custom-service">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="teacher-sidebar-right">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text-header">
                                    {{ __('labels.service-list.sales_service_management') }}
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list ml-0">
                                @include('client.screen.teacher.my-page.services.tab')
                            </div>
                            <div class="d-flex justify-content-center service-clone-nav service-clone-custom">
                                @if (auth('client')->user()->identity_verification_status !== \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <a class="teacher-sidebar-right__title__create show-identity">
                                        @else
                                            <a href="{{ route('client.teacher.courses.create') }}"
                                               class="teacher-sidebar-right__title__create">
                                                @endif
                                                <span>
                                        <img src="{{ asset('assets/img/teacher-page/icon/add.svg')}}" alt=""/>
                                    </span>{{ __('labels.service-list.create_new_service') }}
                                            </a>
                                            <div class="teacher-sidebar-right__title__text-notice ml-2">
                                                <span class="color-default">２回目以降の同じサービスの作成は下記、サービスの出品「編集画面へ」から公開して下さい。</span>
                                                <br/>
                                                ※同じサービスを「+新規サービス作成」から公開した場合は（開催実績・レビュー）も別々に表示されます。
                                            </div>
                                    @include('client.common.option-search', ['query' => [['option' => \App\Enums\Constant::SORT_DATETIME_DESC], ['option' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                            </div>
                            <div class="dp-none teacher-sidebar-right__title__text-notice teacher-sidebar-right__title__text-notice__mobile">
                                <span class="color-default">２回目以降の同じサービスの作成は下記、サービスの出品「編集画面へ」から公開して下さい。</span>
                                <br/>
                                ※同じサービスを「+新規サービス作成」から公開した場合は（開催実績・レビュー）も別々に表示されます。
                            </div>
                            <div class="teacher-sidebar-right__table mt-0">
                                <table class="new-service-table-clone">
                                    @if($services->total())
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>前回公開日</th>
                                            <th>サービスタイトル</th>
                                            <th>公開回数</th>
                                            <th>サービスの出品</th>
                                        </tr>
                                        @foreach($services as $item)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>
                                                    {{ $item->last_public_datetime ? now()->parse($item->last_public_datetime)->format('Y/m/d') : '' }}
                                                </td>
                                                <td class="text-left">
                                                    {{ $item->title }}
                                                </td>
                                                <td>{{ $item->count_public }}</td>
                                                <td class="btn-block">
                                                    <a href="{{ route('client.teacher.courses.clone', $item->course_id) }}"
                                                       class="btn btn-custom btn-status button-status-disabled @if($item->course_schedules_count >= \App\Enums\DBConstant::MAX_COURSE_SCHEDULE) btn-disable @endif">編集画面へ</a>
                                                    <span class="tooltiptext">公開中の同じサービスの開催日程は最大１０件までしか作成できません。</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                        <input type="hidden" id="user-identify-status"
                                               value="{{ auth('client')->user()->identity_verification_status }}">
                                </table>
                            </div>
                            {{ $services->appends(request()->query())->links('client.layout.paginate') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.screen.teacher.course-preview.popup-identity-verify', ['notShow' => 0])

@endsection
@section("script")
    <script>
        $(document).ready(() => {
            if ($('#user-identify-status').val() == 3) {
                $('a').removeClass('button-status-disabled');
            }
        });
        $('body').on('click', '.button-status-disabled', function (e) {
            e.preventDefault();
            $('.show-identity').trigger('click')
        })
        let radioButton = document.querySelectorAll('.button-radio');
        radioButton.forEach(el => {
            el.addEventListener('click', () => {
                removeClassActive();
                el.classList.add('active-radio')
            })
        })

        function removeClassActive() {
            radioButton.forEach(el => {
                el.classList.remove('active-radio')
            })
        }

        $('.show-identity').click(() => {
            $('#popup-identity-verify').modal('show');
        })

        $('.btn-disable').click(function (e) {
            e.preventDefault();
        })
        $(".btn-disable").hover(
            function () {
                $(this).parent('.btn-block').find('.tooltiptext').css('display', 'block')
            }, function () {
                $(this).parent('.btn-block').find('.tooltiptext').css('display', 'none')
            }
        );
    </script>
@endsection
