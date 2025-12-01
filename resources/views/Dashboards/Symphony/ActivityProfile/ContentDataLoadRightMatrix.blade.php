<div class="progress-bg-card mb-2 p-1">
    <div class="row align-items-center">
        <div class="col-lg-4 col-md-4 col-4 ps-4 pe-lg-0">
            <h6>CONVERSION RATE</h6>
        </div>
        <div class="col-lg-3 col-md-3 col-3 text-center">
            <h6 class="fw-bold fs-3">{{ $success_array['conversion_rate_admitted_count'] }}</h6>
            <span>admitted</span>
        </div>
        <div class="col-lg-5 col-md-5 col-5">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-10">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['conversion_rate_admitted_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['conversion_rate_admitted_percentage'] }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="ed-breach-performance chart-block">
    <div class="progress-bg-card mb-2">
        <div class="rectangle-block-1 mb-2">
           <div class="header-chart">
            <h6 class="title">BREACH PERFORMANCES</h6>
        </div>
            <table class="breach-performance">
                <thead>
                <tr>
                    <th></th>
                    <th>Attendances</th>
                    <th>Breaches</th>
                    <th>Performance</th>
                </tr>
                </thead>
                <tbody>
               
                
                <tr>
                    <td>UTC</td>
                    <td>{{ $success_array["right_matrix_breach"]['utc']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['utc']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['utc']['performance'] }}%</td>
                </tr>
                <tr>
                    <td>MAJORS</td>
                    <td>{{ $success_array["right_matrix_breach"]['majors']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['majors']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['majors']['performance'] }}%</td>
                </tr>
                <tr>
                    <td>RESUS</td>
                    <td>{{ $success_array["right_matrix_breach"]['resus']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['resus']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['resus']['performance'] }}%</td>
                </tr>
                <tr>
                    <td>PAEDS</td>
                    <td>{{ $success_array["right_matrix_breach"]['paed_eds']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['paed_eds']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['paed_eds']['performance'] }}%</td>
                </tr>
                <tr>
                    <td>OTHERS</td>
                    <td>{{ $success_array["right_matrix_breach"]['others']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['others']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['others']['performance'] }}%</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{ $success_array["right_matrix_breach"]['total']['attendance'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['total']['breached'] }}</td>
                    <td>{{ $success_array["right_matrix_breach"]['total']['performance'] }}%</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="progress-bg-card mb-2">
    <div class="row align-items-center">
        <div class="col-lg-4 col-md-4 col-4">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['performance_admitted_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['performance_admitted_percentage'] }}%
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-center mt-20">Admitted</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-4 performance-count">
            <h6 class="mb-2">PERFORMANCE</h6>
            <div class="box-graph-blue">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h6 class="fw-bold mb-0">{{ $success_array["total_admitted_performance"] }}</h6>
                    <h6 class="fw-bold mb-0">|</h6>
                    <h6 class="fw-bold mb-0">{{ $success_array["total_non_admitted_performance"] }}</h6>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-4 pe-lg-0">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['performance_non_admitted_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['performance_non_admitted_percentage'] }}%
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-center mt-20">Non Admitted</h6>
        </div>
    </div>
</div>

<div class="progress-bg-card mb-2">
    <div class="row align-items-center">
        <div class="col-lg-4 col-md-4 col-4">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['ambulance_arrival_admitted_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['ambulance_arrival_admitted_percentage'] }}%
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center">
                <div class="mt-20 me-1">
                    <svg  width="27.991" height="19.471" viewBox="0 0 27.991 19.471">
                        <g id="up-arrow-svgrepo-com" transform="translate(27.991) rotate(90)">
                            <path id="Path_20673" data-name="Path 20673" d="M10.288,27.6l8.633-10.433s1.309-1.238-.111-1.238H13.946V.741S14.138,0,13.02,0H6.173c-.8,0-.783.619-.783.619V15.614H.9c-1.729,0-.427,1.3-.427,1.3s7.344,9.749,8.365,10.773A.965.965,0,0,0,10.288,27.6Z" fill="#ae125b" />
                        </g>
                    </svg>
                </div>
                <h6 class="mb-0 text-center mt-20 me-1"> {{ $success_array['ambulance_arrival_admitted_count'] }}</h6>
                <h6 class="mb-0 text-center mt-20">Admitted</h6>
            </div>


        </div>
        <div class="col-lg-4 col-md-4 col-4 text-center">
            <h6 class="">AMBULANCE ARRIVAL</h6>
            <h6 class="fw-bold fs-3 text-center">{{ $success_array['ambulance_arrival_total_count'] }}</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-4 text-center justify-content-center pe-lg-0">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['ambulance_arrival_home_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['ambulance_arrival_home_percentage'] }}%
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <h6 class="mb-0 text-center mt-20 me-1 ms-2">{{ $success_array['ambulance_arrival_home_count'] }}
                </h6>
                <h6 class="mb-0 text-center mt-20 me-1">Home</h6>
                <div class="mt-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27.991" height="19.471" viewBox="0 0 27.991 19.471">
                        <g id="up-arrow-svgrepo-com" transform="translate(27.991) rotate(90)">
                            <path id="Path_20673" data-name="Path 20673" d="M10.288.4l8.633,10.433s1.309,1.238-.111,1.238H13.946V27.25s.192.741-.925.741H6.173c-.8,0-.783-.619-.783-.619V12.378H.9c-1.729,0-.427-1.3-.427-1.3S7.815,1.333,8.835.308A.965.965,0,0,1,10.288.4Z" transform="translate(0 0)" fill="#0066FF"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="progress-bg-card mb-2">
    <div class="row align-items-center">
        <div class="col-lg-4 col-md-4 col-4">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['walk_in_arrival_admitted_percentage'] }} " data-scale-color="#ffb400">
                         {{ $success_array['walk_in_arrival_admitted_percentage'] }}%
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <div class="mt-20 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27.991" height="19.471" viewBox="0 0 27.991 19.471">
                        <g id="up-arrow-svgrepo-com" transform="translate(27.991) rotate(90)">
                            <path id="Path_20673" data-name="Path 20673" d="M10.288,27.6l8.633-10.433s1.309-1.238-.111-1.238H13.946V.741S14.138,0,13.02,0H6.173c-.8,0-.783.619-.783.619V15.614H.9c-1.729,0-.427,1.3-.427,1.3s7.344,9.749,8.365,10.773A.965.965,0,0,0,10.288,27.6Z" fill="#ae125b" />
                        </g>
                    </svg>
                </div>
                <h6 class="mb-0 text-center mt-20 me-1"> {{ $success_array['walk_in_arrival_admitted_count'] }}</h6>
                <h6 class="mb-0 text-center mt-20">Admitted</h6>
            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-4 text-center">
            <h6 class="">WALK IN </h6>
            <h6 class="fw-bold fs-3 text-center">{{ $success_array['walk_in_arrival_total_count'] }}</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-4 justify-content-center pe-lg-0">
            <div class="round_progress_chart_container_ed_profile  pb-4 pt-4 mt-20">
                <div class="progress_chart_container_box_ed_profile">
                    <div class="circle_progress_chart_easy_pie_ed_profile" data-percent="{{ $success_array['walk_in_arrival_home_percentage'] }}" data-scale-color="#ffb400">
                        {{ $success_array['walk_in_arrival_home_percentage'] }}%
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <h6 class="mb-0 text-center mt-20 me-1 ms-2">{{ $success_array['walk_in_arrival_home_count'] }}</h6>
                <h6 class="mb-0 text-center mt-20 me-1">Home</h6>
                <div class="mt-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27.991" height="19.471" viewBox="0 0 27.991 19.471">
                        <g id="up-arrow-svgrepo-com" transform="translate(27.991) rotate(90)">
                            <path id="Path_20673" data-name="Path 20673" d="M10.288.4l8.633,10.433s1.309,1.238-.111,1.238H13.946V27.25s.192.741-.925.741H6.173c-.8,0-.783-.619-.783-.619V12.378H.9c-1.729,0-.427-1.3-.427-1.3S7.815,1.333,8.835.308A.965.965,0,0,1,10.288.4Z" transform="translate(0 0)" fill="#0066FF"></path>
                        </g>
                    </svg>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="chart-block">
    <div class="progress-bg-card mb-2">
        <div class="header-chart">
            <h6 class="title">ADMITTED BY SPECIALITY</h6>
        </div>
        <div id="special-admit-chart" class=""></div>
    </div>
</div>
<div class="chart-block">
    <div class="progress-bg-card mb-2">
        <div class="header-chart">
            <h6 class="title">DTA Waits</h6>
        </div>
        <div id="dta-chart" class=""></div>
    </div>
</div>
<div class="chart-block">
    <div class="progress-bg-card mb-2">
        <div class="header-chart">
            <h6 class="title">TRIAGE CATEGORY</h6>
        </div>
        <div id="triage-chart" class=""></div>
    </div>
</div>

<script>
    var chartAdmitChart = '';
    var chartPerformanceAdmit = '';
    var chartchartPerformanceNonAdmit = '';
    var chartAmbulanceChartDischarged = '';
    var chartAmbulanceChartAdmitted = '';
    var chartWalkInDischarged = '';
    var chartWalkInAdmitted = '';
    var specialityAdmittedChart = '';
    var TriageChart = '';
    var DtaChart = '';

    function EdActivityChartApexChartDestroy() {
        if (typeof specialityAdmittedChart === 'object') {
            specialityAdmittedChart.destroy();
        }
        if (typeof TriageChart === 'object') {
            TriageChart.destroy();
        }
        if (typeof DtaChart === 'object') {
            DtaChart.destroy();
        }
    }

    function EdActivityChartLoadAfterScriptGraph() {
        // ED Activity ADMITTED BY SPECIALITY chart



       var options1 = {
            series: [{
                data: <?php echo $success_array['admitted_by_speciality_y']; ?>,
            }],
            chart: {
                toolbar: {
                    show: false
                },
                type: 'bar',
                fontFamily: 'Poppins, sans-serif',
                height: 350
            },
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 2,
                }
            },
            colors: ['#A2BBD2', '#891E55', '#8C21EF', '#008D9A', '#AF8CCE', '#5F87F6', '#918624'],
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.6,
                    gradientToColors: ['#515E69', '#450F2B', '#382C44', '#00474D', '#584667', '#30447B', '#494312'], // optional, if not defined - uses the shades of same color in series
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 80, 100],
                    colorStops: []
                },
            },
            legend: {
                show: false
            },
            grid: {
                show: false,
            },
            xaxis: {
                categories: <?php echo $success_array['admitted_by_speciality_x']; ?>,
                min: 0,
                tickAmount: 13,
                axisBorder: {
                    show: true,
                    color: '#707070',
                    height: 1,
                    width: '100%',
                    offsetX: 0,
                    offsetY: 0
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    maxWidth: 30,
                    rotate: -45,
                    hideOverlappingLabels: true,
                    maxHeight: 100,
                    trim: false,
                    style: {
                        colors: [],
                        fontSize: '10px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                },
            },
            yaxis: {
                tooltip: {
                    enabled: false
                },
                labels: {
                    formatter: (value) => {
                        return value.toFixed(0)
                    },
                },
            },
            dataLabels: {
                style: {
                    colors: ['#FFFFFF']
                },
                formatter: function(val) {
                    if (val > 0) {
                        return val;
                    }
                },
                offsetY: 5, // play with this value
            },
            tooltip: {
                enabled: false,
            },
        };
        if (document.querySelector("#special-admit-chart")) {
            console.log(specialityAdmittedChart)
            if(specialityAdmittedChart)
            {

                specialityAdmittedChart.destroy();
            }
            specialityAdmittedChart = new ApexCharts(document.querySelector("#special-admit-chart"), options1);
            specialityAdmittedChart.render();
        }
        // ED Activity TRIAGE CATEGORY chart


         var options2 = {
            tooltip: {
                enabled: false,
            },
            series: [{
                data: <?php echo $success_array['triage_category_y']; ?>,
            }],
            chart: {
                toolbar: {
                    show: false
                },
                type: 'bar',
                fontFamily: 'Poppins, sans-serif',
                height: 253
            },
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 2,
                }
            },
            colors: ['#382C44', '#891E55', '#008D9A', '#584667', '#30447B', '#494312', '#382C44', '#891E55', '#008D9A', '#584667', '#30447B', '#494312'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.6,
                    gradientToColors: ['#8C21EF', '#891E55', '#00474D', '#AF8CCE', '#5F87F6', '#918624'], // optional, if not defined - uses the shades of same color in series
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 80, 100],
                    colorStops: []
                },
            },
            legend: {
                show: false
            },
            grid: {
                show: false,
            },
            yaxis: {
                tooltip: {
                    enabled: false
                },
                labels: {
                    formatter: (value) => {
                        return value.toFixed(0)
                    },
                },
            },
            xaxis: {
                categories: <?php echo $success_array['triage_category_x']; ?>,
                min: 0,
                axisBorder: {
                    show: true,
                    color: '#707070',
                    height: 1,
                    width: '100%',
                    offsetX: 0,
                    offsetY: 0
                },
                labels: {
                    maxWidth: 50,
                    rotate: -90,
                    style: {
                        fontSize: '10px'
                    }
                },
            },
            dataLabels: {
                formatter: function(val) {
                    if (val > 0) {
                        return val;
                    }
                },
                style: {
                    colors: ['#FFFFFF']
                },
                offsetY: 0, // play with this value
            },
        };
        if (document.querySelector("#triage-chart")) {
            if(TriageChart)
            {
                TriageChart.destroy();
            }
            TriageChart = new ApexCharts(document.querySelector("#triage-chart"), options2);
            TriageChart.render();
        }
        // ED Activity DTA Waits chart

        var options3 = {
            tooltip: {
                enabled: false,
            },
            series: [{
                name: 'DTA Waits',
                data: <?php echo $success_array['dta_waits_y']; ?>
            }],
            chart: {
                toolbar: {
                    show: false
                },
                type: 'bar',
                fontFamily: 'Poppins, sans-serif',
                height: 220
            },
            plotOptions: {
                bar: {
                    borderRadius: 3,
                },
            },
            colors: ['#9DB6CD'],

            grid: {
                show: true,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "horizontal",
                    shadeIntensity: 0.6,
                    gradientToColors: ['#C2DAF2'], // optional, if not defined - uses the shades of same color in series
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 70, 100],
                    colorStops: []
                },
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {

                categories: <?php echo $success_array['dta_waits_x']; ?>,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    rotate: 0,
                    style: {
                        fontSize: '10px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: ''
                },
                labels: {
                    formatter: (value) => {
                        return value.toFixed(0)
                    },
                },
                tickAmount: 10,
                min: 0,
                axisBorder: {
                    show: true,
                    color: '#707070',
                    offsetX: 0,
                    offsetY: 0
                },

            },
            legend: {
                show: false
            },
            dataLabels: {
                style: {
                    colors: ['#000']
                },
                formatter: function(val) {
                    if (val > 0) {
                        return val;
                    }
                },
                offsetY: 5, // play with this value
            },
        };
        if (document.querySelector("#dta-chart")) {
            if(DtaChart)
            {
                DtaChart.destroy();
            }
            DtaChart = new ApexCharts(document.querySelector("#dta-chart"), options3);
            DtaChart.render();
        }
        $(function() {
            $('.circle_progress_chart_easy_pie_ed_profile').easyPieChart({
                size: 75,
                barColor: "#0066FF",
                scaleLength: 0,
                lineWidth: 15,
                trackColor: "#d0e4f9",
                lineCap: "circle",
                animate: 2000,
            });
        });
    }
</script>
