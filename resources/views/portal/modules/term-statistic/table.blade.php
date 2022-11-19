<table>
    <tbody style="position: sticky; top: 0; z-index: 999">
    <tr class="index-tr">
        <th class="w-319 fixed fixed-left fixed fixed-tr fixed-top1">
            <div class="f-w6 size-16 border-t col-fixed-ht">
                @if((int)request('term') === 2)
                    下
                @else
                    上
                @endif半期
            </div>
        </th>
        @foreach($data['statistic'] as $item)
            <th colspan="3" class="w-549 text-center">
                <div class=" f-w6 size-16 border-t @if ($item['title'] === '上半期計') echo 'bg-highlight'; @endif">
                    {{ $item['title'] }}
                </div>
            </th>
        @endforeach
    </tr>
    <tr class="index-tr high-light-1">
        <td class="w-319 fixed fixed-left fixed-tr1 fixed-top2" rowspan="2" style="line-height: 53px">
            項目
        </td>
        @foreach($data['statistic'] as $item)
            <td class="w-213" rowspan="2" style="line-height: 53px">
                実績
            </td>
            <td class="w-213" colspan="2">
                前年同期
            </td>
        @endforeach
    </tr>
    <tr class="index-tr high-light-2">
        @foreach($data['statistic'] as $item)
            <td class="w-213 row-header-custom fixed fixed-tr2">
                実績
            </td>
            <td class="w-123 row-header-custom" style="height: 26px;">
                YonY
            </td>
        @endforeach
    </tr>
    @if (count($data['statistic']) > 0)
        <tr>
            <td class="f-w6 fixed fixed-left fixed-col1 fixed-col1-left">
                <div class="col-fixed">GMV 流通総額（①＋②＋③）</div>
            </td>
            @foreach($data['statistic'] as $item)
                <td class="text-center">{{ number_format(bcdiv($item['data']['total_sales'], 1100, 0)) }}千円</td>
                <td class="text-center">{{ number_format(bcdiv($item['data']['total_sales_ly'], 1100,0)) }}千円</td>
                <td class="text-center">{{ number_format($item['data']['percent_total_sales']) ?? number_format(0.0,1) }}
                    %
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="f-w6 fixed fixed-left fixed-col2-left">
                <div class="col-fixed bg-gray">①(配信売上) 延長含む</div>
            </td>
            @foreach($data['statistic'] as $item)
                <td class="bg-gray text-center">{{ number_format(bcdiv($item['data']['sum_course_extension'], 1100, 0)) }}
                    千円
                </td>
                <td class="bg-gray text-center">{{ number_format(bcdiv($item['data']['sum_course_extension_ly'], 1100, 0)) }}
                    千円
                </td>
                <td class="bg-gray text-center">
                    {{ number_format($item['data']['percent_course_extension']) ?? number_format(0.0,1) }}%
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="f-w6 fixed fixed-left fixed-col3-left">
                <div class="col-fixed bg-gray">②( オプション売上 )</div>
            </td>
            @foreach($data['statistic'] as $item)
                <td class="bg-gray text-center">{{ number_format(bcdiv($item['data']['option_sales'], 1100, 0)) }}千円
                </td>
                <td class="bg-gray text-center">{{number_format( bcdiv($item['data']['option_sales_ly'], 1100, 0)) }}
                    千円
                </td>
                <td class="bg-gray text-center">
                    {{ number_format($item['data']['percent_option_sales']) ?? number_format(0.0,1) }}%
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="f-w6 fixed fixed-left fixed-col4-left">
                <div class="col-fixed bg-gray">③( ギフト合計 )</div>
            </td>
            @foreach($data['statistic'] as $item)
                <td class="bg-gray text-center">{{ number_format(bcdiv($item['data']['sum_question_gift'], 1100, 0)) }}
                    千円
                </td>
                <td class="bg-gray text-center">{{ number_format(bcdiv($item['data']['sum_question_gift_ly'], 1100, 0)) }}
                    千円
                </td>
                <td class="bg-gray text-center">
                    {{ number_format($item['data']['percent_question_gift']) ?? number_format(0.0,1) }}%
                </td>
            @endforeach
        </tr>
    </tbody>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">総売上（④ + ⑤ + ⑥)</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv($item['data']['total_commissions'], 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format(bcdiv($item['data']['total_commissions_ly'], 1100, 0)) }}千円
            </td>
            <td class="text-center">{{ number_format($item['data']['percent_total_commissions']) ?? number_format(0.0,1) }}
                %
            </td>
        @endforeach
    </tr>

    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">④売上手数料22％</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv($item['data']['sales_commissions'], 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format(bcdiv($item['data']['sales_commissions_ly'], 1100, 0)) }}千円
            </td>
            <td class="text-center">{{ number_format($item['data']['percent_sales_commissions']) ?? number_format(0.0,1) }}
                %
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">⑤コイン分配収益</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv(($item['data']['other_commissions'])/1100,1,0)) }}千円
            </td>
            <td class="text-center">{{ number_format(bcdiv(($item['data']['other_commissions_ly'])/1100,1,0)) }}
                千円
            </td>
            <td class="text-center">{{ number_format($item['data']['percent_other_commission'])??number_format(0.0,1) }}
                %
            </td>
        @endforeach
    </tr>

    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">コイン分配金</div>
            {{--                <div class="col-fixed">手数料（コイン売上）</div>--}}
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv(($item['data']['coin_distribution'] ), 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format(bcdiv(($item['data']['coin_distribution_ly'] ), 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format($item['data']['percent_coin_distribution']) ?? number_format(0.0,1)}}
                %
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">客数（購入者数）</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format($item['data']['num_of_applicants']) }}人</td>
            <td class="text-center">{{ number_format($item['data']['num_of_applicants_ly']) }}人</td>
            <td class="text-center">{{ number_format($item['data']['percent_num_of_applicants']) ?? number_format(0.0,1) }}
                %
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">客単価（売上÷客数）</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format($item['data']['ratio_total_sales_num_of_applicants']) }}円</td>
            <td class="text-center">{{ number_format($item['data']['ratio_total_sales_num_of_applicants_ly']) }}円
            </td>
            <td class="text-center">
                {{ $item['data']['percent_total_sales_num_of_applicants'] ?? number_format(0.0,1) }}%
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">販売サービス数</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format($item['data']['num_of_courses']) }}</td>
            <td class="text-center">{{ number_format($item['data']['num_of_courses_ly']) }}</td>
            <td class="text-center">{{ $item['data']['percent_num_of_courses'] ?? number_format(0.0,1) }}%</td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">サービス単価（１配信)</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format($item['data']['ratio_total_sales_num_of_courses']) }}円</td>
            <td class="text-center">{{ number_format($item['data']['ratio_total_sales_num_of_courses_ly']) }}円</td>
            <td class="text-center">
                {{ $item['data']['percent_total_sales_num_of_courses'] ?? number_format(0.0,1) }}%
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">平均利用時間（1配信/分）</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format( $item['data']['ratio_streaming_minutes_num_of_courses']) }}分
            </td>
            <td class="text-center">{{ number_format( $item['data']['ratio_streaming_minutes_num_of_courses_ly']) }}
                分
            </td>
            <td class="text-center">
                {{ $item['data']['percent_streaming_minutes_num_of_courses'] ?? number_format(0.0,1) }}%
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">⑥システム利用料計</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv($item['data']['system_commissions'], 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format(bcdiv($item['data']['system_commissions_ly'], 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format($item['data']['percent_system_commissions']) ?? number_format(0.0,1) }}
                %
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">総配信時間</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">
                {{ (int)($item['data']['streaming_minutes']/60) }}
                時間{{ $item['data']['streaming_minutes']%60 }}分
            </td>
            <td class="text-center">
                {{ (int)($item['data']['streaming_minutes_ly']/60) }}
                時間{{ $item['data']['streaming_minutes_ly']%60 }}分
            </td>
            <td class="text-center">{{ $item['data']['percent_streaming_minutes'] ?? number_format(0.0,1) }}%</td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">キャンセル手数料</div>
        </td>
        @foreach($data['statistic'] as $item)
            <td class="text-center">{{ number_format(bcdiv($item['data']['cancellation_fee'], 1100, 0)) }}千円</td>
            <td class="text-center">{{ number_format(bcdiv($item['data']['cancellation_fee_ly'], 1100, 0)) }}千円</td>
            <td class="text-center">
                {{ number_format($item['data']['percent_cancellation_fee'], 1) ?? number_format(0.0,1)}}%
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">出品者支払い報酬料（消費税引き後）</div>
        </td>
        @foreach($data['statistic'] as $item)
            {{--                <td class="text-center">{{ bcdiv($item['data']['teacher_profit_exc_tax'], 1000, 0) }}千円</td>--}}
            <td class="text-center">{{ number_format(bcdiv(($item['data']['total_sales'] - $item['data']['total_commissions']), 1100, 0)) }}
                千円
            </td>
            <td class="text-center">{{ number_format(bcdiv(($item['data']['total_sales_ly'] - $item['data']['total_commissions_ly']), 1100, 0)) }}
                千円
            </td>
            <td class="text-center">
                {{ number_format($item['data']['percentOtherTotalSalesLy'], 1) }}%
            </td>
            <!-- <td class="text-center">{{ bcdiv($item['data']['teacher_profit_exc_tax_ly'], 1000, 0) }}千円</td>
                <td class="text-center">
                    {{ number_format($item['data']['percent_teacher_profit_exc_tax']) ?? number_format(0.0,1) }}%
                </td> -->
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">当月振込合計金額（出品者報酬）</div>
        </td>
        @foreach($data['amountTransferred'] as $item)
            <td class="text-center">
                {{ number_format($item['data'] / 1000) }}千円
            </td>
            <td class="text-center">{{ number_format($item['data_ly'] / 1000) }}千円</td>
            <td class="text-center">
                @if($item['data_ly'] != 0)
                    {{ number_format(($item['data'] / $item['data_ly'] * 1000) / 10, 1) }}%
                @else
                    0.0%
                @endif
            </td>
        @endforeach
    </tr>
    <tr>
        <td class="f-w6 fixed fixed-left">
            <div class="col-fixed">保有現金合計金額（出品者報酬）</div>
        </td>
        @foreach($data['amountNotTransferred'] as $item)
            <td class="text-center">
                {{ number_format((int)$item['data']) }}千円
            </td>
            <td class="text-center">{{ number_format((int)$item['data_ly']) }}千円
            </td>
            <td class="text-center">
                @if($item['data_ly'] != 0)
                    {{ number_format(($item['data'] / $item['data_ly'] * 1000) / 10, 1) }}%
                @else
                    0.0%
                @endif
            </td>
        @endforeach
    </tr>
    @else
        *
        <tr>
            <td colspan="7" class="text-left pl-5">対応するレコードが見つかりませんでした</td>
        </tr>
    @endif
</table>
