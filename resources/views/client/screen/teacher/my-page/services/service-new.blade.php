@extends('client.base.base')
<link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/service-list.css')  }}"/>
@section('css')
    <style>
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

        .main-mypage-teacher.custom-service .main-mypage-teacher__content .teacher-sidebar-right .service-new-table tr td {
            overflow: unset;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__list__option {
            padding: unset;
        }

        .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right__table table th:nth-child(1) {
            width: 132px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td:nth-child(1) {
            padding: 7px 10px;
        }

        .main-mypage-teacher__content .mrt {
            margin-top: 5px;
        }

        .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right__table table th:nth-child(3) {
            width: 196px;
            word-break: break-all;
        }

        .link-popup {
            color: #2979E6 !important;
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher custom-service ">
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
                                    @lang('labels.service-list.sales_service_management')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list ml-0">
                                @include('client.screen.teacher.my-page.services.tab')
                            </div>
                            <div class="mrt   d-flex justify-content-center">
                                @if (auth('client')->user()->identity_verification_status != \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <a class="btn teacher-sidebar-right__title__create show-identity">
                                        <span>
                                            <img src="{{ asset('assets/img/teacher-page/icon/add.svg')}}" alt=""/>
                                        </span> @lang('labels.service-list.create_new_service')
                                    </a>
                                @else
                                    <a href="{{ route('client.teacher.courses.create') }}"
                                       class="btn teacher-sidebar-right__title__create">
                                        <span>
                                            <img src="{{ asset('assets/img/teacher-page/icon/add.svg')}}" alt=""/>
                                        </span> @lang('labels.service-list.create_new_service')
                                    </a>
                                @endif

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
                                <table class="service-new-table">
                                    @if($services->total())
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>前回公開日</th>
                                            <th>申請日</th>
                                            <th>サービスタイトル</th>
                                            <th>結果通知</th>
                                            <th>審査結果</th>
                                            <th>公開回数</th>
                                            <th>サービスの出品</th>
                                        </tr>
                                        @foreach($services as $item)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>
                                                    @if($item->approval_status === \App\Enums\DBConstant::COURSE_APPROVED)
                                                        {{ $item->last_public_datetime ? now()->parse($item->last_public_datetime)->format('Y/m/d') : '' }}
                                                    @endif
                                                </td>
                                                <td>{{ now()->parse($item->created_at)->format('Y/m/d') }}</td>
                                                <td class="text-left">
                                                    {{ $item->title }}
                                                </td>
                                                <td>
                                                    @if($item->approval_status != \App\Enums\DBConstant::COURSE_NOT_REVIEW)
                                                        <img src="{{ url('assets/img/common/email.svg') }}"
                                                             data-toggle="modal"
                                                             data-target="#popupNoticeCreate{{$item->course_id}}">
                                                        <div class="modal fade custom-modal"
                                                             id="popupNoticeCreate{{$item->course_id}}" tabindex="-1"
                                                             role="dialog"
                                                             aria-labelledby="exampleModalCenterTitle"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered notice-popup-paragraph"
                                                                 role="document">
                                                                <div class="modal-content notice-popup-paragraph__content">
                                                                    <div class="modal-body modal-content">
                                                                        <div class="notification-content">
                                                                            @if($item->approval_status == \App\Enums\DBConstant::COURSE_APPROVED)
                                                                                <div>
                                                                                    <div class="text-center f-w6 mb-2">
                                                                                        【お知らせ】
                                                                                    </div>
                                                                                    <div class="d-flex flex-column">
                                                                                        <div>新規サービスの承認がされましたので</div>
                                                                                        <div>お知らせいたします。</div>
                                                                                        <div>
                                                                                            引き続きサービスの出品（編集画面へ）より
                                                                                        </div>
                                                                                        <div>
                                                                                            新規サービスの作成（STEP２,３）へ進み
                                                                                        </div>
                                                                                        <div>サービスを公開して下さい。</div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div>
                                                                                    <div class="text-center f-w6 mb-2">
                                                                                        【お知らせ】
                                                                                    </div>
                                                                                    <div class="d-flex flex-column">
                                                                                        <div>新規サービスの申請が否認されましたので
                                                                                        </div>
                                                                                        <div>お知らせいたします。</div>
                                                                                        <div>
                                                                                            下記の「出品者ガイドライン」をご参照頂き
                                                                                        </div>
                                                                                        <div>
                                                                                            公開申請をお断りする場合をご確認ください。
                                                                                        </div>
                                                                                        <div>【出品者ガイドライン】はこちら</div>
                                                                                        <a class="link-popup"
                                                                                           href="{{route('client.seller-guidelines')}}">{{route('client.seller-guidelines')}}</a>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <button class="btn-close" data-dismiss="modal">
                                                                            閉じる
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->approval_status == \App\Enums\DBConstant::COURSE_REJECT)
                                                        <span>否認</span>
                                                    @elseif($item->approval_status == \App\Enums\DBConstant::COURSE_APPROVED)
                                                        <div>承認</div>
                                                    @else
                                                        <div>申請中</div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->count_public }}</td>
                                                <td class="btn-block">
                                                    @if($item->approval_status === \App\Enums\DBConstant::COURSE_APPROVED)
                                                        <a href="{{ $item->minutes_required ? route('client.teacher.courses.clone', $item->course_id) : route('client.teacher.courses.show', $item->course_id) }}"
                                                           class="btn btn-custom btn-status button-status-disabled @if($item->course_schedules_count >= \App\Enums\DBConstant::MAX_COURSE_SCHEDULE) btn-disable @endif">編集画面へ</a>
                                                        <span class="tooltiptext">公開中の同じサービスの開催日程は最大１０件までしか作成できません。</span>
                                                    @endif
                                                </td>
                                                <input type="hidden" id="user-identify-status"
                                                       value="{{ auth('client')->user()->identity_verification_status }}">
                                            </tr>
                                        @endforeach
                                    @endif
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

        $(document).ready(() => {
            if ($('#user-identify-status').val() == 3) {
                $('a').removeClass('button-status-disabled');
            }
        });

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

<style>
    td {
        padding: 7px;
    }
</style>
