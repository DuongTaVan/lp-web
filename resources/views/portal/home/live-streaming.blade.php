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
        width: 100% !important;
        /* margin-right: 320px; */
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

    .home .mt-18 {
        margin-top: 28px;
    }

    @media only screen and (max-width: 1200px) {
        .panel-body .label, .panel-body .label1, .panel-body .label2 {
            /* margin-left: -82px; */
        }
    }

    @media only screen and (max-width: 1440px) {
        .panel-body .label, .panel-body .label1, .panel-body .label2 {
            /* margin-left: -87px; */
        }
    }

</style>
<div class="mt-18 f-w6 d-flex justify-content-between">
    <div class="panel-body d-flex flex-column align-items-center">
        <h5 class="label f-w6" style="margin-right: 142px;">ジャンル別売上比</h5>
        <div class="chart-container">
            <div id="doughnut-chart1"></div>
        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata1">
            <span>データなし</span>
        </div>
    </div>
    <div class="panel-body d-flex flex-column align-items-center">
        <h5 class="label f-w6" style="margin-right: 108px;">性別比</h5>
        <div class="chart-container">
            <div id="doughnut-chart2"></div>
        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata2">
            <span>データなし</span>
        </div>
    </div>
    <div class="panel-body d-flex flex-column align-items-center">
        <h5 class="label f-w6">年代別比</h5>
        <div class="chart-container">
            <div id="doughnut-chart3"></div>
        </div>
        <div class="absolute-center text-center dp-none" id="chart-nodata3">
            <span>データなし</span>
        </div>
    </div>
</div>
<div class="mb-13 mt-18 d-flex f-w6 justify-content-between flex-wrap">
    <div class="wrap-common-3">
        <div class="label-common text-center">配信サービス売上計</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@money($data['sales']['course_sales'])
                <div class="text-center">(入場料＋個別講座)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">ギフト売上計</div>
        <div class="wrap-content">
            <div class="content d-flex justify-content-center align-items-center">
                ¥@money($data['sales']['gift_sales'])
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">売上構成比</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                <div class="d-none">
                    {{ $sum = $data['sales']['course_sales'] + $data['sales']['question_sales'] + $data['sales']['gift_sales'] }}
                </div>
                @percent($data['sales']['course_sales'], $sum)% /
                {{--                @percent($data['sales']['question_sales'], $sum)% /--}}
                @percent($data['sales']['gift_sales'], $sum)%
                <div class="text-center">(配信/ギフト)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">客数</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['sales']['skills_applicants'])人 /
                @money($data['sales']['skills_sub_applicants'])人
                <div class="text-center">(ライブ配信/個別講座)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">購入者</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['sales']['skills_applicants_teacher_new'] +
                $data['sales']['skills_sub_applicants_teacher_new'])人 /
                @money($data['sales']['skills_applicants_teacher_repeater'] +
                $data['sales']['skills_sub_applicants_teacher_repeater'])人
                <div class="text-center">(新規/リピータ)</div>
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
        <div class="label-common text-center">配信サービス実績</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @money($data['sales']['is_skills'])回 /
                @money($data['sales']['is_skills_sub'])回
                <div class="text-center">(ライブ配信/個別講座)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center">平均利用時間(1配信)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @ratio($data['sales']['minutes_skills'], $data['sales']['is_skills'])分 /
                @ratio($data['sales']['minutes_skills_sub'], $data['sales']['is_skills_sub'])分
                <div class="text-center">(ライブ配信/個別講座)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">平均参加人数(1配信)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @ratio($data['sales']['skills_applicants'], $data['sales']['is_skills'])人
                <div class="text-center">(個別講座除く)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">ライブ配信平均単価(1配信)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@ratio($data['sales']['total_sales_skills'], $data['sales']['is_skills'])
                <div class="text-center">（配信売上＋ギフト)÷配信回数</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">ライブ配信平均単価(1人)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@ratio($data['sales']['total_sales_skills'], $data['sales']['skills_applicants'])
                <div class="text-center">（配信売上＋ギフト)÷参加人数</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">個人講座平均客単価(1人)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                ¥@ratio($data['sales']['total_sales_skills_sub'], $data['sales']['skills_sub_applicants'])
                <div class="text-center">(配信売上÷参加人数)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">平均ギフト獲得(1配信)</div>
        <div class="wrap-content">
            <div class="content d-flex justify-content-center align-items-center">
                @if ((int)$data['sales']['is_skills'] !== 0)
                    {{ number_format($data['sales']['gift_count'] / $data['sales']['is_skills'], 1) }}個 /
                    {{ number_format(($data['sales']['gift_sales'] / 10) / $data['sales']['is_skills'], 1) }}
                @else
                    0個 / 0
                @endif<span class="f-w3"
                            style="font-size: 16px; line-height: 24px; color: #273546; font-weight: 300">コイン</span>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">平均ギフト獲得率(1配信)</div>
        <div class="wrap-content">
            <div class="content d-flex flex-column justify-content-center align-items-center">
                @percent($data['sales']['total_number_give_gift'], $data['sales']['skills_applicants'])%
                <div class="text-center">(ギフト送った人数÷参加者数)</div>
            </div>
        </div>
    </div>
    <div class="wrap-common-3">
        <div class="label-common text-center d-flex flex-column">総配信時間</div>
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
                @ratio($data['page_views']['is_skills'], $data['day_of_month'])PV /
                @money($data['page_views']['is_skills'])PV
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
    <div class="wrap-common-3" style="opacity: 0">
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var ctx = $('#doughnut-chart1');
    ctx.attr('height', 190);

    window.onload = function () {
        let doughnut1 = document.getElementById('doughnut-chart1');
        let doughnut2 = document.getElementById('doughnut-chart2');
        let doughnut3 = document.getElementById('doughnut-chart3');
        let app1 = @json($data['chartLive1']);
        let app2 = @json($data['chartLive2']);
        let app3 = @json($data['chartLive3']);
        var positionChart;
        var alignChart;
        var heightChart;
        var widthChart;
        var chartAreaLeft;
        positionChart = 'right';
        alignChart = 'center';
        heightChart = '100%';
        widthChart = '80%';

        //Chart 1
        let dataCategory1 = ['お仕事', 'マネー', '恋愛・婚活', 'SNS', '就活・転職', '健康・病気', '起業・独立', '副業',
          '税金・助成金・補助金', '海外の事 (留学・移住・転職・企業)', 'ビジネススキル', 'ライフハック', 'その他（ライブ配信)'];

        let dataCategory1_1 = [];
        var valueToPush1 = new Array();
        valueToPush1.push(['Task', 'Hours per Day']);
        for (var i = 0; i < app1.length; i++) {
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
                colors: ['#40aae7', '#d74b90', '#f2664e', '#F1C40F', '#F39C12', '#2ECC71', '#EBDEF0', '#E74C3C']
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
                colors: ["#41AAE5", "#D64A8F", "#F4664E", "#8E84CB",]
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

        // function formatLabel(context) {
        //     let sum = 0;
        //     for (let i = 0; i < context.dataset.data.length; i++) {
        //         sum += parseInt(context.dataset.data[i]);
        //     }
        //     let dataset = context.datasetIndex;
        //     let label = context.label;
        //     let value = context.parsed;
        //     return label + '(' + (value / sum * 100).toFixed(2) + '%)'
        // };
        //
        // function checkProperties(obj) {
        //     for (let key in obj) {
        //         if (obj[key] !== null && obj[key] != "" && obj[key] != 0)
        //             return false;
        //     }
        //     return true;
        // }
        //
        //
        // if (checkProperties(app1)) {
        //     // document.getElementById("chart-nodata1").style.display = "block";
        //     document.getElementById("legend-container").style.display = "none";
        // }
        // if (checkProperties(app2)) {
        //     // document.getElementById("chart-nodata2").style.display = "block";
        //     document.getElementById("legend-container1").style.display = "none";
        // }
        // if (checkProperties(app3)) {
        //     // document.getElementById("chart-nodata3").style.display = "block";
        //     document.getElementById("legend-container2").style.display = "none";
        // }
        // const getOrCreateLegendList = (chart, id) => {
        //     const legendContainer = document.getElementById(id);
        //     let listContainer = legendContainer.querySelector('ul');
        //
        //     if (!listContainer) {
        //         listContainer = document.createElement('ul');
        //         listContainer.style.display = 'flex';
        //         listContainer.style.flexDirection = 'row';
        //         listContainer.style.margin = 0;
        //         listContainer.style.padding = 0;
        //
        //         legendContainer.appendChild(listContainer);
        //     }
        //
        //     return listContainer;
        // };
        //
        // const htmlLegendPlugin = {
        //     id: 'htmlLegend',
        //     afterUpdate(chart, args, options) {
        //         const ul = getOrCreateLegendList(chart, options.containerID);
        //
        //         // Remove old legend items
        //         while (ul.firstChild) {
        //             ul.firstChild.remove();
        //         }
        //
        //         // Reuse the built-in legendItems generator
        //         const items = chart.options.plugins.legend.labels.generateLabels(chart);
        //
        //         items.forEach(item => {
        //             const li = document.createElement('li');
        //             li.style.alignItems = 'center';
        //             li.style.cursor = 'pointer';
        //             li.style.display = 'flex';
        //             li.style.flexDirection = 'row';
        //             li.style.marginLeft = '10px';
        //
        //             li.onclick = () => {
        //                 const {type} = chart.config;
        //                 if (type === 'pie' || type === 'doughnut') {
        //                     // Pie and doughnut charts only have a single dataset and visibility is per item
        //                     chart.toggleDataVisibility(item.index);
        //                 } else {
        //                     chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
        //                 }
        //                 chart.update();
        //             };
        //
        //             // Color box
        //             const boxSpan = document.createElement('span');
        //             boxSpan.style.background = item.fillStyle;
        //             boxSpan.style.borderColor = item.strokeStyle;
        //             boxSpan.style.borderWidth = item.lineWidth + 'px';
        //             boxSpan.style.display = 'inline-block';
        //             boxSpan.style.height = '20px';
        //             boxSpan.style.marginRight = '10px';
        //             boxSpan.style.width = '20px';
        //
        //             // Text
        //             const textContainer = document.createElement('p');
        //             textContainer.style.color = item.fontColor;
        //             textContainer.style.margin = 0;
        //             textContainer.style.padding = 0;
        //             textContainer.style.textDecoration = item.hidden ? 'line-through' : '';
        //
        //             const text = document.createTextNode(item.text);
        //             textContainer.appendChild(text);
        //
        //             li.appendChild(boxSpan);
        //             li.appendChild(textContainer);
        //             ul.appendChild(li);
        //         });
        //     }
        // };
        // let myChart = new Chart(doughnut1, {
        //     type: 'pie',
        //     data: {
        //         labels: ['お仕事', 'マネー', 'SNS', '就活、転職', '副業', 'ビジネススキル', '恋愛、結婚', 'その他計'],
        //         datasets: [{
        //             data: app1,
        //             backgroundColor: [
        //                 '#f2664e',
        //                 '#d74b90',
        //                 '#40aae7',
        //                 '#F1C40F',
        //                 '#F39C12',
        //                 '#2ECC71',
        //                 '#EBDEF0',
        //                 '#E74C3C'
        //             ],
        //             hoverOffset: 4
        //         }],
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero: true
        //                     }
        //                 }]
        //             }
        //         },
        //     },
        //     options: {
        //         plugins: {
        //             tooltip: {
        //                 callbacks: {
        //                     label: formatLabel
        //                 }
        //             },
        //             elements: {
        //                 arc: {
        //                     borderWidth: 0
        //                 }
        //             },
        //             htmlLegend: {
        //                 // ID of the container to put the legend in
        //                 containerID: 'legend-container',
        //             },
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //     },
        //     plugins: [htmlLegendPlugin],
        // });
        // let myChart2 = new Chart(doughnut2, {
        //     type: 'pie',
        //     data: {
        //         labels: ["男性", "女性", "無回答", "その他"],
        //         datasets: [{
        //             data: app2,
        //             backgroundColor: [
        //                 "#41AAE5",
        //                 "#D64A8F",
        //                 "#F4664E",
        //                 "#8E84CB",
        //             ],
        //             hoverOffset: 4
        //         }],
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero: true
        //                     }
        //                 }]
        //             }
        //         }
        //     },
        //     options: {
        //         plugins: {
        //             tooltip: {
        //                 callbacks: {
        //                     label: formatLabel
        //                 }
        //             },
        //             elements: {
        //                 arc: {
        //                     borderWidth: 0
        //                 }
        //             },
        //             htmlLegend: {
        //                 // ID of the container to put the legend in
        //                 containerID: 'legend-container1',
        //             },
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //     },
        //     plugins: [htmlLegendPlugin],
        // });
        // let myChart3 = new Chart(doughnut3, {
        //     type: 'pie',
        //     data: {
        //         labels: ['10代', '20代', '30代', '40代', '50代', '60代'],
        //         datasets: [{
        //             data: app3,
        //             backgroundColor: [
        //                 '#f2664e',
        //                 '#d74b90',
        //                 '#40aae7',
        //                 '#F1C40F',
        //                 '#F39C12',
        //                 '#2ECC71'
        //             ],
        //             hoverOffset: 4
        //         }],
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero: true
        //                     }
        //                 }]
        //             }
        //         }
        //     },
        //     options: {
        //         plugins: {
        //             tooltip: {
        //                 callbacks: {
        //                     label: formatLabel
        //                 }
        //             },
        //             elements: {
        //                 arc: {
        //                     borderWidth: 0
        //                 }
        //             },
        //             htmlLegend: {
        //                 // ID of the container to put the legend in
        //                 containerID: 'legend-container2',
        //             },
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //     },
        //     plugins: [htmlLegendPlugin],
        // });
    };
</script>
