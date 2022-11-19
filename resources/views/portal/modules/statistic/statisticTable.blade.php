<table>
    <tr>
        <th id="date" class="fixed fixed-left fixed-topt fixed-tr pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t col-fixed-ht">
                日付
                <div class="target_date">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'target_date' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'target_date' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                GMV 流通総額（①＋②＋③）
                <div class="total_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_total_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_total_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_total_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ①( 配信売上) 延長含む
                <div class="sum_course_extension">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sum_course_extension' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sum_course_extension' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_course_extension">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_course_extension' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_course_extension' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ②( オプション売上 )
                <div class="option_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'option_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'option_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_option_sales">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_option_sales' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_option_sales' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>

        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ③(ギフト合計)
                <div class="sum_question_gift">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sum_question_gift' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sum_question_gift' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_question_gift">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_question_gift' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_question_gift' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                総売上（④ + ⑤ + ⑥)
                <div class="total_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'total_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'total_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_total_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_total_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_total_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ④売上手数料22％
                <div class="sales_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'sales_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'sales_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_sales_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_sales_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_sales_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ⑤コイン分配収益
                <div class="other_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'other_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'other_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_other_commission">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_other_commission' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_other_commission' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                コイン分配金
                <div class="coin_distribution">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'coin_distribution' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'coin_distribution' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_coin_distribution">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_coin_distribution' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_coin_distribution' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                客数（購入者数）
                <div class="num_of_applicants">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'num_of_applicants' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'num_of_applicants' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_num_of_applicants">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_num_of_applicants' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_num_of_applicants' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                客単価（売上÷客数）
                <div class="ratio_total_sales_num_of_applicants">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'ratio_total_sales_num_of_applicants' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'ratio_total_sales_num_of_applicants' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_total_sales_num_of_applicants">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_total_sales_num_of_applicants' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_total_sales_num_of_applicants' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                販売サービス数
                <div class="num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                サービス単価（１配信）
                <div class="ratio_total_sales_num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'ratio_total_sales_num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'ratio_total_sales_num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_total_sales_num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_total_sales_num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_total_sales_num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                平均利用時間（1配信/分）
                <div class="ratio_streaming_minutes_num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'ratio_streaming_minutes_num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'ratio_streaming_minutes_num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_streaming_minutes_num_of_courses">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_streaming_minutes_num_of_courses' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_streaming_minutes_num_of_courses' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                ⑥システム利用料計
                <div class="system_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'system_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'system_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_system_commissions">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_system_commissions' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_system_commissions' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                総配信時間
                <div class="streaming_minutes">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'streaming_minutes' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'streaming_minutes' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_streaming_minutes">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_streaming_minutes' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_streaming_minutes' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                キャンセル手数料
                <div class="cancellation_fee">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'cancellation_fee' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'cancellation_fee' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_cancellation_fee">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_cancellation_fee' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_cancellation_fee' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="price" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                出品者支払い報酬料（消費税引き後）
                <div class="teacher_profit_exc_tax">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'teacher_profit_exc_tax' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'teacher_profit_exc_tax' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
        <th id="YonY" class="fixed fixed-topt pd-0">
            <div class="d-flex justify-content-between f-w6 fields border-t">
                YonY
                <div class="percent_teacher_profit_exc_tax">
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'percent_teacher_profit_exc_tax' && Request::get('sort_by') === 'ASC') active @endif"></i>
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'percent_teacher_profit_exc_tax' && Request::get('sort_by') === 'DESC') active @endif"></i>
                </div>
            </div>
        </th>
    </tr>
    @if (count($data['statistic']) > 0)
        @foreach($data['statistic'] as $key => $item)
            <tr class="f-w3 withdrawal-list-info <?php if ($item['holiday']) echo 'tr-holiday' ?>">
                <td class="text-center fixed fixed-left pd-0 <?php if ($item['holiday']) echo 'td-holiday' ?>">
                    <div class="col-fixed-hbt">{{$item['target_date']}}</div>
                </td>

                <!-- <td class="text-center">{{ number_format((int)($item['total_sales']/11*10)) }}円</td> -->
                <td class="text-center">{{ number_format(floor($item['total_sales']/11*10), 0) }}円</td>
                <td class="text-center">{{$item['percent_total_sales'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['sum_course_extension']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_course_extension'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['option_sales']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_option_sales'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['sum_question_gift']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_question_gift'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['total_commissions']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_total_commissions'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['sales_commissions']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_sales_commissions'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['other_commissions']/11*10)), 0) }}円</td>
                <td class="text-center">{{number_format($item['percent_other_commission'], 1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['coin_distribution']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_coin_distribution'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format($item['num_of_applicants']) }}人</td>
                <td class="text-center">{{$item['percent_num_of_applicants'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['ratio_total_sales_num_of_applicants'])) }}円</td>
                <td class="text-center">{{$item['percent_total_sales_num_of_applicants'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['num_of_courses'])) }}</td>
                <td class="text-center">{{$item['percent_num_of_courses'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['ratio_total_sales_num_of_courses'])) }}円</td>
                <td class="text-center">{{$item['percent_total_sales_num_of_courses'] ?? number_format(0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['ratio_streaming_minutes_num_of_courses'])) }}分
                </td>
                <td class="text-center">
                    {{$item['percent_streaming_minutes_num_of_courses'] ?? number_format(0.0,1)}}%
                </td>

                <td class="text-center">{{ number_format(floor(((int)$item['system_commissions']/11*10)), 0) }}円</td>
                <td class="text-center">{{$item['percent_system_commissions'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['streaming_minutes'])) }}分</td>
                <td class="text-center">{{$item['percent_streaming_minutes'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format((int)($item['cancellation_fee']/11*10)) }}円</td>
                <td class="text-center">{{$item['percent_cancellation_fee'] ?? number_format(0.0,1)}}%</td>

                <td class="text-center">{{ number_format(floor(((int)$item['teacher_profit_exc_tax'])), 0) }}円</td>
                <td class="text-center">{{$item['percent_teacher_profit_exc_tax'] ?? number_format(0.0,1)}}%</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center fixed fixed-left pd-0">
                <div class="col-fixed-hbt f-w6 font-total" style="padding: 0.9rem">合計</div>
            </td>
            <td class="text-center font-total">{{number_format(floor($data['total']['total_sales']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['sum_course_extension']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['option_sales']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['sum_question_gift']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['total_commissions']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['sales_commissions']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['other_commissions']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-left"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['coin_distribution']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format($data['total']['num_of_applicants'])}} {{ __('labels.unit.human') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{$data['total']['num_of_applicants'] !== 0 ? number_format(floor(($data['total']['total_sales']/11*10) / $data['total']['num_of_applicants'])) : 0}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format($data['total']['num_of_courses'])}}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{$data['total']['num_of_courses'] !== 0 ? number_format(floor(($data['total']['total_sales']/11*10) / $data['total']['num_of_courses'])) : 0}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{$data['total']['total_record_have_time'] !== 0 ? number_format(floor($data['total']['ratio_streaming_minutes_num_of_courses'] / $data['total']['total_record_have_time'])) : 0}} {{ __('labels.unit.minute') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format(floor($data['total']['system_commissions']/11*10), 0)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{floor($data['total']['streaming_minutes'] / 60)}}
                時間{{$data['total']['streaming_minutes'] % 60}}分
            </td>
            <td class="text-center"></td>
            <td class="text-center font-total">{{number_format($data['total']['cancellation_fee']/11*10)}} {{ __('labels.unit.money') }}</td>
            <td class="text-center"></td>
{{--            <td class="text-center font-total">{{number_format(floor($data['total']['teacher_profit_exc_tax']), 0)}} {{ __('labels.unit.money') }}</td>--}}
            <td class="text-center font-total">{{number_format(floor(($data['total']['total_sales'] - $data['total']['total_commissions'])/1.1), 0)}} {{ __('labels.unit.money') }}</td>
        </tr>
    @else
        <tr>
            <td colspan="21" class="text-left pl-5">対応するレコードが見つかりませんでした</td>
        </tr>
    @endif
</table>
