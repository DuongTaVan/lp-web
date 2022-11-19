@extends('client.base.base')
@section('css')
    <style>
        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td {
            padding: 17px 0;
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__navbar-order-list" style="margin-top: 20px">
                                <div class="teacher-sidebar-right__navbar-order-list__flex" style="width: 91px">
                                    <div class="teacher-sidebar-right__navbar-order-list__cancel active f-w6" style="margin-right: unset; padding-bottom: 12px;">@lang('labels.follower.follower')</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" style="margin-top: 10px;">
                                @include('client.common.option-search')
                            </div>
                            <div style="overflow-x: auto">
                                <table class="table table-follower">
                                    @if($follows->total())
                                        <tr>
                                            <th>@lang('labels.follower.registration_date')</th>
                                            <th>@lang('labels.follower.nickname')</th>
                                            <th>@lang('labels.follower.sex')</th>
                                            <th>@lang('labels.follower.age')</th>
                                            <th>@lang('labels.follower.purchase_history')</th>
                                            <th>@lang('labels.follower.last_purchase_date')</th>
                                        </tr>

                                        @foreach($follows as $follow)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>{{Carbon\Carbon::parse($follow->created_at)->format('Y/m/d')}}</td>
                                                <td>{{$follow->full_name}}</td>
                                                <td style="white-space: nowrap">{{$follow->sex_text}}</td>
                                                <td>{{$follow->current_age - $follow->current_age % 10}}</td>
                                                <td>{{$follow->teacher_repeat_count}}</td>
                                                @if($follow->last_purchased_at == null)
                                                    <td>{{$follow->last_purchased_at}}</td>
                                                @else
                                                    <td>{{Carbon\Carbon::parse($follow->last_purchased_at)->format('Y/m/d')}}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            @if(!empty($follows))
                                {{$follows->appends(request()->query())->links('client.layout.paginate')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section("script")
    <script>
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
    </script>
@endsection
