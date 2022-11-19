<table>
    <tr>
        <th id="withdrawal_id">
            <div class="d-flex justify-content-between f-w6 fields">
                申請ID
                <div class="id">
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'id' && Request::get('sort_by') === 'DESC') active @endif"></i>
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'id' && Request::get('sort_by') === 'ASC') active @endif"></i>
                </div>
            </div>
        </th>
        {{--        <th id="application-date" colspan="2">--}}
        {{--            <div class="d-flex justify-content-between f-w6 fields">--}}
        {{--                申請日時--}}
        {{--                <div class="created_at">--}}
        {{--                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'ASC') active @endif"></i>--}}
        {{--                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'DESC') active @endif"></i>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </th>--}}
        <th id="userID">
            <div class="d-flex justify-content-between f-w6 fields">
                ユーザーID
                <div class="user_id" style="margin-left: 10px">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'user_id' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'user_id' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="username">
            <div class="d-flex justify-content-between f-w6 fields">
                ニックネーム
                <div class="nickname">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'nickname' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'nickname' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="type">
            <div class="d-flex justify-content-between f-w6 fields">
                氏名
                <div class="full_name_kanji">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'full_name_kanji' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'full_name_kanji' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="transfer-amount-of-money">
            <div class="d-flex justify-content-between f-w6 fields">
                振込金額
                <div class="transfer_amount">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'transfer_amount' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'transfer_amount' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="bank-name">
            <div class="d-flex justify-content-between f-w6 fields">
                銀行名
                <div class="bank_name">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'bank_name' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'bank_name' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="branch-name">
            <div class="d-flex justify-content-between f-w6 fields">
                支店名
                <div class="branch_name">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'branch_name' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'branch_name' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="account-type">
            <div class="d-flex justify-content-between f-w6 fields">
                口座種別
                <div class="account_type">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'account_type' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'account_type' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="account-number">
            <div class="d-flex justify-content-between f-w6 fields">
                口座番号
                <div class="account_number">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'account_number' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'account_number' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="account-holder">
            <div class="d-flex justify-content-between f-w6 fields">
                口座名義
                <div class="account_name">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'account_name' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'account_name' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="transferred-registration-date-and-time" colspan="2">
            <div class="d-flex justify-content-between f-w6 fields">
                振込予約完了日時
                <div class="created_at">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="transfer-date">
            <div class="d-flex justify-content-between f-w6 fields">
                振込実施日
                <div class="transferred_at">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'transferred_at' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'transferred_at' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="operation">
            <div class="d-flex justify-content-between f-w6 fields">
                ステータス
            </div>
        </th>
        <th class="operation operation-custom">
            <div class="d-flex justify-content-between f-w6 fields">
                振込
            </div>
        </th>
        <th class="operation">
            <div class="d-flex justify-content-between f-w6 fields">
                入金状況
            </div>
        </th>
        <th class="operation">
            <div class="d-flex justify-content-between f-w6 fields">
                出品者へ連絡
            </div>
        </th>
    </tr>
    <tbody class="content-table-data">
    @if (count($data['withdrawalRequests']) > 0)
        @foreach($data['withdrawalRequests'] as $key => $item)
            @php
                $query = app('request')->request->all();
                $result = array_merge(['user_id' => $item['user_id'], 'link'=>'transfer-histories'], $query);
            @endphp
            <tr class="f-w3 withdrawal-list-info" id="{{ $item['id'] }}">
                <td class="text-left">{{ $item['id'] }}</td>
                {{--                <td class="text-left text-white-space">{{ now()->parse($item['created_at'])->format('Y-m-d') }}</td>--}}
                {{--                <td class="text-left text-white-space">{{ now()->parse($item['created_at'])->format('H:i:s') }}</td>--}}
                <td class="text-left">
                    @if($result['user_id'])
                        <a href="{{ route('portal.user.detail', $result) }}">{{ $item['user_id'] }}</a>
                    @endif
                </td>
                <td class="text-left">{{ $item['nickname'] }}</td>
                <td class="text-left">{{ $item['last_name_kanji'].$item['first_name_kanji'] }}</td>
                <td class="text-left">{{ number_format($item['transfer_amount']) }} {{ __('labels.unit.money') }}</td>
                @php
                    $updateBank = false;
                    if ($item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE) {
                        $updateBank = true;
                    }
                @endphp
                <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $item['bank_name'] }}</td>
                <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $item['branch_name'] }}</td>
                <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $item['account_type'] ? \App\Enums\Constant::BANK_ACCOUNTS_TYPE[$item['account_type']] : '' }}</td>
                <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $item['account_number'] }}</td>
                <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $item['account_name'] }}</td>
                @if((int)$item['status'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_PENDING)
                    <td class="text-left">
                        {{ $item['created_at'] ? now()->parse($item['created_at'])->format('Y-m-d') : '' }}
                    </td>
                    <td class="text-left">
                        {{ $item['created_at'] ? now()->parse($item['created_at'])->format('H:i:s') : '' }}
                    </td>
                @else
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                @endif
                <td class="text-left scheduled_date">
                        {{ $item['transferred_at'] ? now()->parse($item['transferred_at'])->format('Y-m-d') : '' }}
                </td>
                <td class="text-center withdrawal_status">
                    <div class="withdrawal_status-content bg-green">承認済み</div>
                </td>
                <td class="text-center withdrawal_status">
                    @if ($item['failure_code'] && $item['failure_code'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'] && (
                    $item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_PAID ||
                    $item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_SENDING ||
                    $item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE))
                        <div class="withdrawal_status-content bg-red">再依頼完了</div>
                    @else
                        @switch($item['status'])
                            @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)
                                @break
                            @default
                                <div class="withdrawal_status-content bg-green">振込依頼完了</div>
                                @break
                        @endswitch
                    @endif
                </td>
                <td class="text-center withdrawal_status">
                    @switch($item['status'])
                        @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)
                            @break
                        @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_SENDING)
                        @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE)
                            <div class="withdrawal_status-content bg-blue">入金待ち</div>
                            @break
                        @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_PAID)
                            <div class="withdrawal_status-content bg-green">入金済み</div>
                            @break
                        @default
                            <div class="withdrawal_status-content bg-red">{{
                            $item['failure_code'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'] ?
                            '残高エラー' : '振込エラー'
                        }}</div>
                            @break
                    @endswitch
                </td>
                <td class="text-center withdrawal_status">
                    @if ($item['failure_code'] && $item['failure_code'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'])
                        @if ($item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_FAIL)
                            <button class="btn_sendmail f-w3" data-id="{{ $item['id'] }}">
                                連絡する
                            </button>
                        @elseif($item['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)

                        @else
                            <div class="withdrawal_status-content bg-green">連絡済み</div>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="15" class="text-left pl-5">対応するレコードが見つかりませんでした</td>
        </tr>
    @endif
    </tbody>
</table>

<div class="modal fade" id="transfer-dialog" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-withdrawal" role="document">
        <div class="modal-content modal-content-withdrawal">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="padding: 13px;">
                    <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center box_title">
                <p>振込依頼を実行してもよろしいでしょうか。</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="{{ route('portal.transfer.update') }}" method="POST" class="modal-form-footer">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" class="transfer-id">
                    <button type="submit" class="btn button button--left">実行する</button>
                </form>
                <button type="button" class="btn button button--right"
                        data-dismiss="modal">キャンセル
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sendmail-dialog" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-withdrawal" role="document">
        <div class="modal-content modal-content-withdrawal">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="padding: 13px;">
                    <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center box_title">
                <p>出品者へ連絡をしてもよろしいでしょうか。</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="{{ route('portal.transfer.send-mail') }}" method="POST" class="modal-form-footer">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" class="sendmail-id">
                    <button type="submit" class="btn button button--left">連絡する</button>
                </form>
                <button type="button" class="btn button button--right"
                        data-dismiss="modal">キャンセル
                </button>
            </div>
        </div>
    </div>
</div>
