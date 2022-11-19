{{-- TODO --}}
@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }

        .sidebar-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student">
        <div class="container px-0">
            <div class="row">
                <div class="col-md-3 col-sm-3 mw-300">
                    @include('client.student-mypage.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right main_content">
                    <div class="sidebar-right delete-account-wrap">
                        @include('client.common.dashboard-role')
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                @lang('labels.delete-account.unsubscribed')
                            </div>
                        </div>
                        <div class="delete-account">
                            <form action="{{ route('client.student.my-page.delete-account-post') }}" method="POST">
                                @csrf
                                <div class="main-content">
                                    <div class="main-content__text">
                                        <div class="main-content__text__title">
                                            @lang('labels.delete-account.to_unsubscribe')
                                        </div>
                                        <div class="main-content__text__list">
                                            <ul>
                                                <li>@lang('labels.delete-account.unsubscribe_1')</li>
                                                <li>@lang('labels.delete-account.unsubscribe_2')</li>
                                                <li>@lang('labels.delete-account.unsubscribe_3')</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="main-content__text">
                                        <div class="main-content__text__title">
                                            @lang('labels.delete-account.conditions')
                                        </div>
                                        <div class="main-content__text__list">
                                            <ul>
                                                <li>@lang('labels.delete-account.conditions_1')</li>
                                                <li>@lang('labels.delete-account.conditions_2')</li>
                                                <li>@lang('labels.delete-account.conditions_3')</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="main-content__select">
                                        <div class="title">@lang('labels.delete-account.select_reason')</div>
                                        <div id="select-delete">
                                            <div class="select-delete-custom">
                                                @php
                                                    $archiveReasonValue = $user->archive_reason ? $user->archive_reason : '';
                                                    switch ($archiveReasonValue) {
                                                        case 1:
                                                            $archiveReason = '使い方がよく分からなかった';
                                                        break;
                                                        case 2:
                                                            $archiveReason = '利用したいサービスがなかった';
                                                        break;
                                                        case 3:
                                                            $archiveReason = 'トラブルがあった（出品者・運営者）';
                                                        break;
                                                        case 4:
                                                            $archiveReason = 'トラブルがあった（購入者）';
                                                        break;
                                                        case 5:
                                                            $archiveReason = '収益が上がらない';
                                                        break;
                                                        case 6:
                                                            $archiveReason = 'その他';
                                                        break;
                                                        default:
                                                            $archiveReason = '選択してください';
                                                            break;
                                                    }
                                                @endphp
                                                <input type="text" class="select-delete-custom__value f-w3 mt-0"
                                                       readonly=""
                                                       value="{{ $archiveReason }}">
                                                <input type="hidden" name="archive_reason" id="usage_details"
                                                       class="hidden_input f-w3"
                                                       readonly=""
                                                       value="{{ old('archive_reason', $archiveReasonValue) }}">
                                                <img src="{{ url('/assets/img/student/my-page/icon/triangleupanddown.svg') }}"
                                                     class="arrow-down" alt="">
                                                <div class="select-delete-custom__options">
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="1">@lang('labels.delete-account.reason_2') </div>
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="2">@lang('labels.delete-account.reason_3') </div>
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="3">@lang('labels.delete-account.reason_4') </div>
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="4">@lang('labels.delete-account.reason_5') </div>
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="5">@lang('labels.delete-account.reason_6') </div>
                                                    <div class="select-delete-custom__item f-w3"
                                                         data-close-account="6">@lang('labels.delete-account.reason_7') </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="main-content__select__input">
                                            <div class="select_reason">
                                                <select name="archive_reason" id="input" class="form-control">
                                                    <option value="">@lang('labels.delete-account.reason_1')</option>
                                                    <option value="1" @if(old('archive_reason') == '1' || (!old('archive_reason') && $user->archive_reason == 1)) selected @endif>@lang('labels.delete-account.reason_2')</option>
                                                        <option value="2" @if(old('archive_reason') == '2' || (!old('archive_reason') && $user->archive_reason == 2)) selected @endif>@lang('labels.delete-account.reason_3')</option>
                                                        <option value="3" @if(old('archive_reason') == '3' || (!old('archive_reason') && $user->archive_reason == 3)) selected @endif>@lang('labels.delete-account.reason_4')</option>
                                                        <option value="4" @if(old('archive_reason') == '4' || (!old('archive_reason') && $user->archive_reason == 4)) selected @endif>@lang('labels.delete-account.reason_5')</option>
                                                        <option value="5" @if(old('archive_reason') == '5' || (!old('archive_reason') && $user->archive_reason == 5)) selected @endif>@lang('labels.delete-account.reason_6')</option>
                                                        <option value="6" @if(old('archive_reason') == '6' || (!old('archive_reason') && $user->archive_reason == 6)) selected @endif>@lang('labels.delete-account.reason_7')</option>
                                                </select>
                                            </div>
                                            <div class="img"><img src="{{asset('assets/img/student/my-page/icon/triangleupanddown.svg')}}" class="img-responsive" alt="Image"></div>
                                        </div> --}}
                                        @if($errors->has('archive_reason'))
                                            <small class="error text-danger">
                                                {{ $errors->first('archive_reason') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="main-content__input">
                                        <div class="title">@lang('labels.delete-account.detailed_reason')</div>
                                        <textarea name="archive_reason_text" class="form-control"
                                                  rows="5">{{ old('archive_reason_text', $user->archive_reason_text ?? null) }}</textarea>
                                        @if($errors->has('archive_reason_text'))
                                            <small class="error text-danger">
                                                {{ $errors->first('archive_reason_text') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="main-content__button">
                                        <button style="font-weight: 600" type="submit"
                                                @if ($user->archive_reason && $user->is_archived === 1) class="btn-disable"
                                                disabled @endif>
                                            @lang('labels.delete-account.button')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // select close-account required
        $('#select-delete').on('click', '.select-delete-custom', function (e) {
            let parentSelect = e.currentTarget;
            let valueSelected = e.currentTarget.querySelector(".select-delete-custom__value");
            let valueOptions = e.currentTarget.querySelectorAll(".select-delete-custom__item");
            for (let i = 0; i < valueOptions.length; i++) {
                valueOptions[i].classList.remove('item-active');
                if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '')) {
                    valueOptions[i].classList.add('item-active');
                }
            }
            parentSelect.classList.toggle("active");
        })

        $('#select-delete').on('click', '.select-delete-custom__item', function (e) {
            let data = e.currentTarget.getAttribute("data-id");
            $(this).parent().parent().children()[1].setAttribute("value", data);
            e.currentTarget.parentElement.parentElement.querySelector(".select-delete-custom__value").value = e.currentTarget.textContent;
            if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input")) {
                e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value = $(this).data('close-account');
            }
        })

        document.body.addEventListener('mouseup', function (e) {
            if (e.target.closest('.select-delete-custom') === null) {
                let selectBox = document.querySelectorAll('.select-delete-custom')
                for (let i = 0; i < selectBox.length; i++) {
                    selectBox[i].classList.remove('active');
                }
            }
        });
    </script>
@endsection
