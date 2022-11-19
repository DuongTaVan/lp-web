@php
    $query = app('request')->request->all();
    $result = array_merge(['user_id' => $data['user_id'], 'link'=>'transfer-histories'], $query);
@endphp
<tr class="f-w3 withdrawal-list-info" id="{{ $data['id'] }}">
    <td class="text-left">{{ $data['id'] }}</td>
    {{--                <td class="text-left text-white-space">{{ now()->parse($data['created_at'])->format('Y-m-d') }}</td>--}}
    {{--                <td class="text-left text-white-space">{{ now()->parse($data['created_at'])->format('H:i:s') }}</td>--}}
    <td class="text-left">
        @if($result['user_id'])
            <a href="{{ route('portal.user.detail', $result) }}">{{ $data['user_id'] }}</a>
        @endif
    </td>
    <td class="text-left">{{ $data['nickname'] }}</td>
    <td class="text-left">{{ $data['last_name_kanji'].$data['first_name_kanji'] }}</td>
    <td class="text-left">{{ number_format($data['transfer_amount']) }} {{ __('labels.unit.money') }}</td>
    @php
        $updateBank = false;
        if ($data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE) {
            $updateBank = true;
        }
    @endphp
    <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $data['bank_name'] }}</td>
    <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $data['branch_name'] }}</td>
    <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $data['account_type'] ? \App\Enums\Constant::BANK_ACCOUNTS_TYPE[$data['account_type']] : '' }}</td>
    <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $data['account_number'] }}</td>
    <td class="text-left {{ $updateBank ? 'scheduled_date' : '' }}">{{ $data['account_name'] }}</td>
    @if((int)$data['status'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_PENDING)
        <td class="text-left">
            {{ $data['created_at'] ? now()->parse($data['created_at'])->format('Y-m-d') : '' }}
        </td>
        <td class="text-left">
            {{ $data['created_at'] ? now()->parse($data['created_at'])->format('H:i:s') : '' }}
        </td>
    @else
        <td class="text-left"></td>
        <td class="text-left"></td>
    @endif
    <td class="text-left scheduled_date">
        {{ $data['transferred_at'] ? now()->parse($data['transferred_at'])->format('Y-m-d') : '' }}
    </td>
    <td class="text-center withdrawal_status">
        <div class="withdrawal_status-content bg-green">承認済み</div>
    </td>
    <td class="text-center withdrawal_status">
        @if ($data['failure_code'] && $data['failure_code'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'] && (
        $data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_PAID ||
        $data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_SENDING ||
        $data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE))
            <div class="withdrawal_status-content bg-red">再依頼完了</div>
        @else
            @switch($data['status'])
                @case(\App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)
                @break
                @default
                <div class="withdrawal_status-content bg-green">振込依頼完了</div>
                @break
            @endswitch
        @endif
    </td>
    <td class="text-center withdrawal_status">
        @switch($data['status'])
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
                            $data['failure_code'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'] ?
                            '残高エラー' : '振込エラー'
                        }}</div>
            @break
        @endswitch
    </td>
    <td class="text-center withdrawal_status">
        @if ($data['failure_code'] && $data['failure_code'] !== \App\Enums\DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'])
            @if ($data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_FAIL)
                <button class="btn_sendmail f-w3" data-id="{{ $data['id'] }}">
                    連絡する
                </button>
            @elseif($data['status'] === \App\Enums\DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)

            @else
                <div class="withdrawal_status-content bg-green">連絡済み</div>
            @endif
        @endif
    </td>
</tr>
