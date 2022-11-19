<table>
    <tr>
        <th class="w-140">
            <div class="d-flex justify-content-between f-w6 fields">
                サービスID
                <div class="sales.course_schedule_id">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sales.course_schedule_id' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sales.course_schedule_id' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-228">
            <div class="d-flex justify-content-between f-w6 fields">
                売上日
                <div class="target_date">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'target_date' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'target_date' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-228">
            <div class="d-flex justify-content-between f-w6 fields">
                カテゴリ
                <div class="ca.type">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'ca.type' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'ca.type' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-228">
            <div class="d-flex justify-content-between f-w6 fields">
                ジャンル
                <div class="category_name">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'category_name' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'category_name' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-347">
            <div class="d-flex justify-content-between f-w6 fields">
                サービス名
                <div class="cs.title">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'cs.title' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'cs.title' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>

        <th class="w-140">
            <div class="d-flex justify-content-between f-w6 fields">
                出品者ID
                <div class="sales.user_id">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sales.user_id' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sales.user_id' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-148">
            <div class="d-flex justify-content-between f-w6 fields">
                利用時間
                <div class="total_minutes">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_minutes' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_minutes' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                価格
                <div class="base_price">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'base_price' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'base_price' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-213" colspan="2">
            <div class="d-flex justify-content-between f-w6 fields">
                開始日時
                <div class="start_datetime">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'start_datetime' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'start_datetime' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                購入者数
                <div class="total_applicants">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_applicants' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_applicants' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                配信売上
                <div class="sum_course_extension">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sum_course_extension' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sum_course_extension' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                オプション売上
                <div class="option_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'option_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'option_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        {{--        <th class="w-180">--}}
        {{--            <div class="d-flex justify-content-between f-w6 fields">--}}
        {{--                挙手売上--}}
        {{--                <div class="question_sales">--}}
        {{--                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'question_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>--}}
        {{--                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'question_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </th>--}}
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                ギフト売上
                <div class="gift_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'gift_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'gift_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                売上合計
                <div class="total_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                売上手数料
                <div class="sales_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sales_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sales_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                システム手数料
                <div class="system_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'system_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'system_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                キャンセル手数料
                <div class="cancellation_fee">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'cancellation_fee' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'cancellation_fee' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                コイン売上手数料
                <div class="other_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'other_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'other_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                プラットフォーム利益
                <div class="total_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th class="w-180">
            <div class="d-flex justify-content-between f-w6 fields">
                出品者利益
                <div class="teacher_profit">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'teacher_profit' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'teacher_profit' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
    </tr>
    @if (count($data['sales']) > 0)
        @foreach($data['sales'] as $key => $item)
            @php
                $query = app('request')->request->all();
                $result = array_merge(['user_id' => $item['user_id'], 'link'=>'sale-detail'], $query);
            @endphp
            <tr class="f-w3 withdrawal-list-info">
                <td class="text-left">{{$item['course_schedule_id']}}</td>
                <td class="text-left">{{$item['target_date']}}</td>
                <td class="text-left">{{ $item['co_type'] === \App\Enums\DBConstant::COURSE_TYPE_SUB ? '教えて！ライブ配信（個別講座)' : ($item['is_skills_sub'] === \App\Enums\DBConstant::IS_SKILLS_SUB ? '教えて！ライブ配信（個別講座)' :\App\Enums\DBConstant::CATEGORY_LIST[$item['type']])}}</td>
                <td class="text-left">{{$item['category_name']}}</td>
                <td class="text-left">{{$item['course_schedule_title']}}</td>
                <td class="text-left">
                    <a href="{{ route('portal.user.detail', $result) }}">{{ $item['user_id'] }}</a>
                </td>
                <td class="text-left">{{$item['total_minutes']}}分</td>
                <td class="text-left">{{number_format($item['base_price'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{\Illuminate\Support\Carbon::parse($item['course_schedule_start_datetime'])->format('Y-m-d')}}</td>
                <td class="text-left">{{\Illuminate\Support\Carbon::parse($item['course_schedule_start_datetime'])->format('H:i:s')}}</td>
                <td class="text-left">{{$item['total_applicants']}}人</td>
                <td class="text-left">{{number_format($item['sum_course_extension'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['option_sales'])}}{{ __('labels.unit.money') }}</td>
                {{--                <td class="text-left">{{number_format($item['question_sales'])}}{{ __('labels.unit.money') }}</td>--}}
                <td class="text-left">{{number_format($item['gift_sales'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['total_sales'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['sales_commissions'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['system_commissions'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['cancellation_fee'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['other_commissions'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['total_commissions'])}}{{ __('labels.unit.money') }}</td>
                <td class="text-left">{{number_format($item['teacher_profit'])}}{{ __('labels.unit.money') }}</td>
            </tr>
        @endforeach
        <tr class="f-w3 withdrawal-list-info">
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left total-text">{{ number_format((int)($data['total']['total_minutes']/60)) }}
                時間{{ number_format($data['total']['total_minutes']%60) }}分
            </td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left total-text">{{number_format($data['total']['total_applicants'])}}{{ __('labels.unit.human') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['sum_course_extension'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['option_sales'])}}{{ __('labels.unit.money') }}</td>
            {{--            <td class="text-left total-text">{{number_format($data['total']['question_sales'])}}{{ __('labels.unit.money') }}</td>--}}
            <td class="text-left total-text">{{number_format($data['total']['gift_sales'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['total_sales'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['sales_commissions'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['system_commissions'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['cancellation_fee'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['other_commissions'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['total_commissions'])}}{{ __('labels.unit.money') }}</td>
            <td class="text-left total-text">{{number_format($data['total']['teacher_profit'])}}{{ __('labels.unit.money') }}</td>
        </tr>
    @else
        <tr>
            <td colspan="19" class="text-left pl-5">対応するレコードが見つかりませんでした</td>
        </tr>
    @endif
</table>
