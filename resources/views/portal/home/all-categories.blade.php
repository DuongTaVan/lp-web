<style>
    .chart-container {
        display: flex;
    }

    #doughnut-chart1, #doughnut-chart2, #doughnut-chart3 {
        height: 220px;
    }

    .panel-body {
        /* width: calc((100% - 900px) / 3) !important; */
        height: 100%;
        margin-right: -104px;
        /* margin-right: 320px; */
    }

    .panel-body.chart-one {
        /* margin-right: -20px!important; */
    }


    .panel-body .label {
        margin-left: 0;
        font-size: 16px;
        color: #2A3242 !important;
        text-align: center;
        /* width: calc(100vh - 650px); */
        width: max-content;
        margin-right: 118px;
    }

    .panel-body .label1 {
        margin-left: 0;
        font-size: 16px;
        color: #2A3242;
        text-align: center;
        width: calc(100vh - 650px);
    }

    .panel-body .label2 {
        margin-left: 0;
        font-size: 16px;
        color: #2A3242;
        text-align: center;
        width: calc(100vh - 650px);
    }

    .chart-container ul {
        display: unset !important;
        min-width: 200px;
    }

    .chart-container ul li span {
        width: 26px !important;
        height: 12px !important;
    }

    .chart-container ul li p {
        font-size: 12px !important;
        color: #2A3242 !important;
        font-weight: 300;
    }

    #legend-container, #legend-container1, #legend-container2 {
        display: flex;
        flex-direction: column-reverse;
    }

    svg > g > g:last-child {
        pointer-events: none
    }

    rect {
        fill: #F5F5F5;
    }

    text {
        font-size: 12px;
        fill: #2A3242;
        font-weight: 300;
    }

    .wrap-common-3 {
        margin-left: 45px;
    }

    .home .mt-18 {
        margin-top: 28px;
    }

    @media only screen and (max-width: 1440px) {
        .panel-body .label, .panel-body .label1, .panel-body .label2 {
            /* margin-left: -87px; */
        }
    }

    @media only screen and (max-width: 1200px) {
        .panel-body .label, .panel-body .label1, .panel-body .label2 {
            /* margin-left: -82px; */
        }
    }
</style>
<div class="mt-18 f-w6 d-flex justify-content-between">
    <div class="panel-body d-flex flex-column align-items-center chart-one w-100">
        <h5 class="label f-w6 label-chart" style="margin-right: 142px;">カテゴリ別売上比</h5>
        <div class="chart-container">
            <div id="doughnut-chart1">
            </div>

        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata1">
            <span>データなし</span>
        </div>
    </div>
    <div class="panel-body d-flex flex-column align-items-center w-100">
        <h5 class="label f-w6 label-chart" style="margin-right: 108px;">性別比</h5>
        <div class="chart-container">
            <div id="doughnut-chart2"></div>
        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata2">
            <span>データなし</span>
        </div>
    </div>
    <div class="panel-body d-flex flex-column align-items-center w-100">
        <h5 class="label f-w6 label-chart">年代別比</h5>
        <div class="chart-container">
            <div id="doughnut-chart3"></div>
        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata3">
            <span>データなし</span>
        </div>

    </div>
</div>
<div class="mt-18 mb-13 f-w6 d-flex flex-wrap" style="margin-left: -45px">
    <div class="wrap-common-3">
        <div class="label-common text-center">教えて！ライブ配信売上計</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@money($data['sales']['total_sales_skills'] + $data['sales']['total_sales_skills_sub'])
                <div class="text-center">（配信売上＋ギフト売上）</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">オンライン悩み相談売上計</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@money($data['sales']['total_sales_consultation'])
                <div class="text-center">（配信売上＋延長売上）</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">オンライン占い売上計</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@money($data['sales']['total_sales_fortunetelling'])
                <div class="text-center">（配信売上＋延長売上＋オプション売上）</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">ユーザー登録数</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['new_students'])人 / @money($data['registered_students'])人
                <div class="text-center">（新規/累計）</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">出品者登録数</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['new_teachers'])人 / @money($data['registered_teachers'])人
                <div class="text-center">(新規/累計)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">客単価</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@ratio($data['sales']['total_sales'], $data['sales']['total_applicants'])
                <div class="text-center">(1人当り平均購入金額)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">客数</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['sales']['total_applicants'])人
                <div class="text-center">(購入者数)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">購入者</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['sales']['total_applicants_lappi_new'])人 /
                @money($data['sales']['total_applicants_lappi_repeater'])人
                <div class="text-center">(新規/リピータ)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">平均利用時間</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @ratio($data['sales']['total_minutes'], $data['numOfSales'])分
                <div class="text-center">(利用時間合計÷配信数合計)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">総配信時間</div>
        <div class="wrap-content">
            <div class="content d-flex justify-content-center align-items-center">
                @ratio($data['sales']['total_minutes'], 60)時間{{ $data['sales']['total_minutes']%60 }}分
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">閲覧数</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @ratio($data['page_views']['view_count'], $data['day_of_month'])PV /
                @money($data['page_views']['view_count'])PV
                <div class="text-center">(1日平均/合計)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">キャンセル</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['total_cancellation_students'])回 /
                @money($data['total_cancellation_teachers'])回
                <div class="text-center">(購入者/出品者)</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    window.onload = function () {
        let app1 = @json($data['chartDefault1']);
        let app2 = @json($data['chartDefault2']);
        let app3 = @json($data['chartDefault3']);
        var positionChart;
        var alignChart;
        var heightChart;
        var widthChart;
        positionChart = 'right';
        alignChart = 'center';
        heightChart = '100%';
        widthChart = '80%';

        //Chart 1
        let dataCategory1 = ['占い', '悩み相談', 'ライブ配信'];
        let dataCategory1_1 = [];
        var valueToPush1 = new Array();
        valueToPush1.push(['Task', 'Hours per Day']);
        for (var i = app1.length; i >= 0; i--) {
            dataCategory1_1 = [dataCategory1[i], parseInt(app1[i])];
            valueToPush1.push(dataCategory1_1);
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart1);

        function drawChart1() {

            var data = google.visualization.arrayToDataTable(valueToPush1);

            var options = {
                chartArea: {top: 0, right: 50, width: widthChart, height: heightChart},
                legend: {position: positionChart, alignment: alignChart},
                // tooltip: { trigger: 'none' },
                colors: ['#f2664e', '#40aae7', '#d74b90']
            };

            const chartElm = document.getElementById('doughnut-chart1');
            var chart = new google.visualization.PieChart(document.getElementById('doughnut-chart1'));

            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'click', clearSelection);
            document.body.addEventListener('click', clearSelection, false);

            function clearSelection(e) {
                if (!chartElm.contains(e.srcElement)) {
                    chart.setSelection();
                }
            }
        }


        //Chart 2
        let dataCategory2 = ["男性", "女性", "無回答", "その他"];
        let dataCategory2_2 = [];
        var valueToPush2 = new Array();
        valueToPush2.push(['Task', 'Hours per Day']);
        for (var i = 0; i < app2.length; i++) {
            dataCategory2_2 = [dataCategory2[i], parseInt(app2[i])];
            valueToPush2.push(dataCategory2_2);
        }
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart2() {

            var data = google.visualization.arrayToDataTable(valueToPush2);

            var options = {
                chartArea: {top: 0, right: 33, width: widthChart, height: heightChart},
                legend: {position: positionChart, alignment: alignChart},
                // tooltip: { trigger: 'none' },
                colors: ["#41AAE5", "#D64A8F", "#F4664E", "#8E84CB"]
            };

            const chartElm = document.getElementById('doughnut-chart2');
            var chart = new google.visualization.PieChart(document.getElementById('doughnut-chart2'));

            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'click', clearSelection);
            document.body.addEventListener('click', clearSelection, false);

            function clearSelection(e) {
                if (!chartElm.contains(e.srcElement)) {
                    chart.setSelection();
                }
            }
        }

        //Chart 3
        let dataCategory3 = ['10代', '20代', '30代', '40代', '50代', '60代'];
        let dataCategory3_3 = [];
        var valueToPush3 = new Array();
        valueToPush3.push(['Task', 'Hours per Day']);
        for (var i = 0; i < app3.length; i++) {
            dataCategory3_3 = [dataCategory3[i], parseInt(app3[i])];
            valueToPush3.push(dataCategory3_3);
        }
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart3);

        function drawChart3() {

            var data = google.visualization.arrayToDataTable(valueToPush3);

            var options = {
                chartArea: {top: 0, width: widthChart, height: heightChart},
                legend: {position: positionChart, alignment: alignChart},
                // tooltip: { trigger: 'none' },
                colors: ['#f2664e', '#d74b90', '#40aae7', '#F1C40F', '#F39C12', '#2ECC71']
            };

            const chartElm = document.getElementById('doughnut-chart3');
            var chart = new google.visualization.PieChart(document.getElementById('doughnut-chart3'));

            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'click', clearSelection);
            document.body.addEventListener('click', clearSelection, false);

            function clearSelection(e) {
                if (!chartElm.contains(e.srcElement)) {
                    chart.setSelection();
                }
            }
        }
    };
</script>
