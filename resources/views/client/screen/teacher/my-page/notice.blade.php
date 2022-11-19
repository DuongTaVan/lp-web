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
    <div class="notice-header">
        <h1 class="notice-title">{{__('labels.users.notice.label')}}</h1>
    </div>
    <div class="wrapper">
        <div class="notice-body">
            <div class="notice-outline" id="notice-paragraph">
                @if (!$data->isEmpty())
                    @forelse ($data as $item)
                        @if($item->is_read == 1)
                            <div class="notice-paragraph position-relative">
                                <div class="d-flex d-block">
                                    <div class="notice-image">
                                        <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                                    </div>
                                    <div class="notice-content d-flex flex-row d-block">
                                        <div class="notice-content__title">{!! '['.$item['title'].']' ?? null !!}
                                            <span class="notice-content__body">{!! $item['body'] ?? null !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 notice-time-outline text-right">
                                    <h3 class="notice-time">{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d') ?? null }}
                                        &nbsp;{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') ?? null }}</h3>
                                </div>
                            </div>
                        @else
                            <div class="notice-paragraph notice_unread position-relative">
                                <div class="d-flex d-block">
                                    <div class="notice-image">
                                        <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                                    </div>
                                    <div class="notice-content d-flex flex-row d-block">
                                        <div class="notice-content__title">{!! '['.$item['title'].']' ?? null !!}
                                            <span class="notice-content__body">{!! $item['body'] ?? null !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right notice-time-outline">
                                    <h3 class="notice-time">{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d') ?? null }}
                                        &nbsp;{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') ?? null }}</h3>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-center">@lang('labels.search.no_data')</p>
                    @endforelse
                @endif
            </div>
            @if (!$data->isEmpty() && count($data) > 6)
                <div class="load-more-link row text-center" id="load" data-pageCourse="1" style="width: 100%">
                    <div class="col-md-12">
                        <a href="#" class="see_more_noti"
                           data-lastPage>{{__('labels.users.teacher_screen.see_more')}}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript" src="{{ mix('js/clients/commons/noti.js') }}"></script>
@endsection
