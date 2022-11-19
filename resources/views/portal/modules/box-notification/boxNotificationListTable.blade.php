<table>
    <tr>
        <th class="date-wrapper" colspan="2">
            <div class="d-flex justify-content-between f-w6 fields">
                配信日時
                <div class="delivered_at">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'delivered_at' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'delivered_at' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="to_type-wrapper">
            <div class="d-flex justify-content-between f-w6 fields">
                宛先
                <div class="to_type">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'to_type' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc  @if(Request::get('sort_column') === 'to_type' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <style>
            .box-notification-trans-list .title-wrapper {
                min-width: 220px;
            }
        </style>
        <th class="title-wrapper">
            <div class="d-flex justify-content-between f-w6 fields">
                タイトル
                <div class="title">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'title' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc  @if(Request::get('sort_column') === 'title' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="delivered-wrapper">
            <div class="d-flex justify-content-between f-w6 fields">
                ステータス
                <div class="is_delivered">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'is_delivered' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc  @if(Request::get('sort_column') === 'is_delivered' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="option-wrapper">
            <div class="d-flex justify-content-between f-w6 fields">
                操作
            </div>
        </th>
    </tr>
    @if (count($data) > 0)
        @foreach($data as $key => $item)
            <tr class="f-w3 box-notification-trans-info">
                <td class="date-wrapper">
                    {{ $item->delivered_at ? Carbon\Carbon::parse($item->delivered_at)->format('Y/m/d') : null }}
                </td>
                <td class="date-wrapper">
                    {{ $item->delivered_at ? Carbon\Carbon::parse($item->delivered_at)->format('H:i:s') : null }}
                </td>
                <td class="to_type-wrapper">
                    {{ $item->to_type_text }}
                </td>
                <td class="box-notification-trans-info__title title-wrapper"><span>{{ $item->title }}</span></td>
                <td class="delivered-wrapper">
                    {{ $item->is_delivered_text }}
                </td>
                <td class="text-center">
                    <a href="{{ route('portal.box-notification-trans-contents.show', ['id' => $item->box_notification_trans_content_id]) }}">
                        <button class="box-notification-trans-btn-detail">
                            詳細
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-left pl-5">{{ __('labels.common.no_data_2') }}</td>
        </tr>
    @endif
</table>
