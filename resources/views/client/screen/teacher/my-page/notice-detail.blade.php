@extends('client.base.base')
@section('css')
{{--    <style>--}}
{{--        @media only screen and (max-width: 414px) {--}}
{{--            .layout-content {--}}
{{--                padding-top: 65px !important;--}}
{{--            }--}}
{{--        }--}}

{{--        @media only screen and (max-width: 1024px) {--}}
{{--            .layout-content {--}}
{{--                padding-top: 80px !important;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
@endsection
@section('content')
    <div class="wrapper">
        <div class="notice-header">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="notice-title">{{__('labels.users.notice.label')}}</h1>
                </div>
            </div>
        </div>
        <div class="notice-body">
            <div class="notice-outline">
                @if(!empty($result) && $result['is_read'] === \App\Enums\DBConstant::BOX_NOTIFICATION_IS_READ['not_read'])
                    <div class="notice-paragraph notice-paragraph--unread position-relative">
                        <div class="d-flex">
                            <div class="notice-image">
                                <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                            </div>
                            <div class="notice-content d-flex flex-row">
                                <div class="notice-content__title">{{ '['.$result['title'].']' ?? null }}
                                    <span class="notice-content__body">{!! $result['body'] ?? null !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 notice-time-outline text-right">
                            <h3 class="notice-time">{{ \Carbon\Carbon::parse($result->created_at)->format('Y/m/d') ?? null }}
                                &nbsp;{{ \Carbon\Carbon::parse($result->created_at)->format('H:i') ?? null }}</h3>
                        </div>
                    </div>
                @else
                    <div class="notice-paragraph position-relative">
                        <div class="d-flex">
                            <div class="notice-image">
                                <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                            </div>
                            <div class="notice-content d-flex flex-row">
                                <div class="notice-content__title">{{ '['.$result['title'].']' ?? null }}
                                    <span class="notice-content__body">{!! $result['body'] ?? null !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 notice-time-outline text-right">
                            <h3 class="notice-time">{{ \Carbon\Carbon::parse($result->created_at)->format('Y/m/d') ?? null }}
                                &nbsp;{{ \Carbon\Carbon::parse($result->created_at)->format('H:i') ?? null }}</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
