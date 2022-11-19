@extends('portal.layouts.main')
@section('styles')
    <style>
        @media only screen and (max-width: 1365px) {
            .user-list__content form .form-search__input--id {
                width: 120px;
            }

            .user-list__content form .form-search__input--user-name {
                width: 120px;
            }

            .user-list__content form .form-search__input--email {
                width: 276px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="user-list">
        <label class="f-w6" for="">ユーザー管理</label>
        <div class="user-list__content">
            <form method="GET" id="search-form1" action="">
                <div class="form-search d-flex align-items-center flex-wrap f-w3">
                    <div>
                        <p class="form-search__label">ユーザーID</p>
                        <input type="text" name="userId" class="form-search__input form-search__input--id"
                               value="{{ Request::get('userId') ? Request::get('userId') : '' }}"/>
                    </div>
                    <div>
                        <p class="form-search__label">種別</p>
                        <select class="form-select form-select-lg custom-select status form-search__input form-search__input--type"
                                name="user_type" aria-label=".form-select-lg example">
                            <option value=""></option>
                            @foreach(\App\Enums\DBConstant::USER_TYPE as $key => $value)
                                <option value="{{ $key }}" {{ Request::get('user_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p class="form-search__label">カテゴリ</p>
                        <select class="form-select form-select-lg custom-select status form-search__input form-search__input--category"
                                name="teacher_category" aria-label=".form-select-lg example">
                            <option value="">全社計</option>
                            @foreach(\App\Enums\DBConstant::LIST_CATEGORY as $key => $value)
                                @if($key)
                                    @if($key === 1)
                                    <option value="{{ $key }}" {{ Request::get('teacher_category') == $key ? 'selected' : '' }}>教えて！ライブ配信計</option>
                                    @else
                                    <option value="{{ $key }}" {{ Request::get('teacher_category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p class="form-search__label">ニックネーム</p>
                        <input type="text" name="nickname" class="form-search__input form-search__input--user-name"
                               value="{{ Request::get('nickname') }}"/>
                    </div>
                    <div>
                        <p class="form-search__label">姓</p>
                        <input type="text" name="last_name_kanji" class="form-search__input form-search__input--surname"
                               value="{{ Request::get('last_name_kanji') }}"/>
                    </div>
                    <div>
                        <p class="form-search__label">名</p>
                        <input type="text" name="first_name_kanji" class="form-search__input form-search__input--name"
                               value="{{ Request::get('first_name_kanji') }}"/>
                    </div>
                </div>
                <div class="form-search d-flex align-items-end flex-wrap f-w3">
                    <div>
                        <p class="form-search__label">性別</p>
                        <select class="form-select form-select-lg custom-select status form-search__input form-search__input--sex"
                                name="sex" aria-label=".form-select-lg example">
                            <option value="" {{ request('sex') ? 'selected' : '' }}></option>
                            @foreach(\App\Enums\DBConstant::SEX as $key => $value)
                                <option value="{{ $key }}" {{ request('sex') !== null ? ((int) request('sex') === (int) $key ? 'selected' : '') : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p class="form-search__label">Eメール</p>
                        <input type="text" name="email" class="form-search__input form-search__input--email"
                               value="{{ Request::get('email') }}"/>
                    </div>
                    <div>
                        <p class="form-search__label">本人確認</p>
                        <select class="form-select form-select-lg custom-select status form-search__input form-search__input--indenttification"
                                name="identity_verification_status" aria-label=".form-select-lg example">
                            <option value=""></option>
                            @foreach(\App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS as $key => $value)
                                <option value="{{ $key }}" {{ Request::get('identity_verification_status') == $key && Request::get('identity_verification_status') != '' ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p class="form-search__label">資格確認</p>
                        <select class="form-select form-select-lg custom-select status form-search__input form-search__input--confirm"
                                name="business_card_verification_status" aria-label=".form-select-lg example">
                            <option value=""></option>
                            @foreach(\App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS as $key => $value)
                                <option value="{{ $key }}" {{ Request::get('business_card_verification_status') == $key && Request::get('business_card_verification_status') != '' ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="f-w3">検索</button>
                </div>
            </form>
            <div class="horizontal-line"></div>
            <div class="user-table-wrap">
                <div class="d-flex justify-content-start align-items-center record">
                    <select
                            id="select-per-page"
                            per-page="{{$data['users']->perPage()}}"
                            current-page="{{$data['users']->currentPage()}}"
                            last-page="{{$data['users']->lastPage()}}"
                            total-record="{{$data['users']->total()}}"
                            aria-label=".form-select-lg example"
                            class="form-select form-select-lg custom-select record__total"
                    >
                        @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                            <option value="{{ $value }}"
                                    class="f-w3" {{ Request::get('per_page') == $key ? 'selected' : '' }} >{{ $value }}</option>
                        @endforeach
                    </select>
                    <span class="f-w3">件表示</span>
                </div>
                <table class="user-table">
                    <tr>
                        <th id="user_id" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                ユーザーID
                                <div class="user_id">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'user_id' && Request::get('sort_by') === 'DESC') active @endif">
                                    </i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'user_id' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_type" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                種別
                                <div class="user_type">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'user_type' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'user_type' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_category" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                カテゴリ
                                <div class="teacher_category">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'teacher_category' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'teacher_category' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_username" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                ニックネーム
                                <div class="nickname">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'nickname' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'nickname' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_surname" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                姓
                                <div class="last_name_kanji">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'last_name_kanji' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'last_name_kanji' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>

                        <th id="user_name" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                名
                                <div class="first_name_kanji">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'first_name_kanji' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'first_name_kanji' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_sex" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                性別
                                <div class="sex">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sex' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc  @if(Request::get('sort_column') === 'sex' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_login-type" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                ログイン種別
                                <div class="login_type">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'login_type' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc  @if(Request::get('sort_column') === 'login_type' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_email" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                Eメール
                                <div class="email">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'email' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc  @if(Request::get('sort_column') === 'email' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_cash-held" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                保有現金
                                <div class="cash_balance">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'cash_balance' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc  @if(Request::get('sort_column') === 'cash_balance' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_owned-points" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                保有ポイント
                                <div class="points_balance">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'points_balance' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'points_balance' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_identification" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                本人確認
                                <div class="identity_verification_status">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'identity_verification_status' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'identity_verification_status' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_confirm" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                資格確認
                                <div class="business_card_verification_status">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'business_card_verification_status' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'business_card_verification_status' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th id="user_last-login" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                最終ログイン
                                <div class="last_login">
                                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'last_login' && Request::get('sort_by') === 'DESC') active @endif"></i>
                                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'last_login' && Request::get('sort_by') === 'ASC') active @endif"></i>
                                </div>
                            </div>
                        </th>
                        <th class="user_operation" class="user-table__label">
                            <div class="d-flex justify-content-between f-w6 fields">
                                基本情報
                            </div>
                        </th>
                    </tr>
                    @if (count($data['users']) > 0)
                        @php
                            $result = [];
                        @endphp
                        @foreach($data['users'] as $key => $item)
                            @php
                                $query = app('request')->request->all();
                                $result = array_merge(['user_id' => $item->user_id, 'link'=>'user'], $query);
                            @endphp
                            <tr class="f-w3 withdrawal-list-info">
                                <td class="text-left">{{$item['user_id']}}</td>
                                <td class="text-left">
                                    @if ($item['user_type'] == 1)
                                        購入者
                                    @elseif ($item['user_type'] == 2)
                                        出品者
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if ($item['teacher_category_skills'])
                                        教えて！ライブ配信
                                    @elseif ($item['teacher_category_consultation'])
                                        オンライン悩み相談
                                    @elseif ($item['teacher_category_fortunetelling'])
                                        オンライン占い
                                    @endif
                                </td>
                                <td class="text-left">{{$item['nickname']}}</td>
                                <td class="text-left">{{$item['last_name_kanji']}}</td>
                                <td class="text-left">{{$item['first_name_kanji']}}</td>
                                <td class="text-left">
                                    @if ($item['sex'] == 1)
                                        男性
                                    @elseif ($item['sex'] == 2)
                                        女性
                                    @elseif ($item['sex'] == 9)
                                        その他
                                    @else
                                        無回答
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if ($item['login_type'] == 'EMAIL')
                                        Eメール
                                    @elseif ($item['login_type'] == 'LINE')
                                        LINE
                                    @elseif ($item['login_type'] == 'FACEBOOK')
                                        Facebook
                                    @elseif ($item['login_type'] == 'GOOGLE')
                                        Google
                                    @endif
                                </td>
                                <td class="text-left">{{$item['email']}}</td>
                                <td class="text-left">{{ number_format($item['cash_balance']) }} 円</td>
                                <td class="text-left">{{ number_format($item['points_balance']) }} pt</td>
                                <td class="text-left indentity-user">
                                    @if ($item['identity_verification_status'] == 0)
                                        <div class="indentity-user-content"></div>
                                    @elseif ($item['identity_verification_status'] == 1)
                                        <div class="indentity-user-content approval">承認待ち</div>
                                    @elseif ($item['identity_verification_status'] == 2)
                                        <div class="indentity-user-content rejected">否認</div>
                                    @elseif ($item['identity_verification_status'] == 3)
                                        <div class="indentity-user-content approved">承認済み</div>
                                    @endif
                                </td>
                                <td class="text-left indentity-user">
                                    @if ($item['business_card_verification_status'] == 0)
                                        <div class="indentity-user-content"></div>
                                    @elseif ($item['business_card_verification_status'] == 1)
                                        <div class="indentity-user-content approval">承認待ち</div>
                                    @elseif ($item['business_card_verification_status'] == 2)
                                        <div class="indentity-user-content rejected">否認</div>
                                    @elseif ($item['business_card_verification_status'] == 3)
                                        <div class="indentity-user-content approved">承認済み</div>
                                    @endif
                                </td>
                                <td class="text-left">
                                    {{ $item['last_login'] }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('portal.user.detail', $result) }}"
                                       class="d-flex justify-content-center align-items-center">
                                        <button class="btn-detail f-w3" data-target="#transfer{{ $item['user_id'] }}">
                                            詳細
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 2px solid #CCCCCC">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['total']['sum_cash_balance']) }} 円</td>
                            <td>{{ number_format($data['total']['sum_points_balance']) }} pt</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="15" class="text-left pl-5">対応するレコードが見つかりませんでした。</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div style="margin: 0 30px">
                @include('portal.components.table-footer', ['data' => $data['users']])
            </div>
        </div>
    </div>
@endsection
