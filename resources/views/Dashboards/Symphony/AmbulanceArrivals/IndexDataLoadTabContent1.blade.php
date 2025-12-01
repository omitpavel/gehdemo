@php $box_plot_generate_array                = array(); @endphp
@php $box_plot_generate_index                = 1; @endphp
@if(CheckDashboardPermission('ambulance_dashboard_live'))
<link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <div class="row mb-1">
        <div class="container-fluid">
            <div class="col-lg-12  ">
                <div class="row gx-2">
                    <div class="col-lg-3 ">
                        <div class="mb-2" id="daily-count">
                            <div class="d-flex align-items-center tile-shape"  id="daterangepicker">
                                <svg xmlns="http://www.w3.org/2000/svg" id="calendar-svgrepo-com" width="30" height="30" viewBox="0 0 42.079 42.078">
                                    <g id="Group_1533" data-name="Group 1533">
                                        <g id="Group_1532" data-name="Group 1532">
                                            <path id="Path_20481" data-name="Path 20481" d="M40.706,2.744H33.846V1.372a1.372,1.372,0,1,0-2.744,0V2.744H10.977V1.372a1.372,1.372,0,1,0-2.744,0V2.744H1.372A1.372,1.372,0,0,0,0,4.116v36.59a1.372,1.372,0,0,0,1.372,1.372H40.706a1.372,1.372,0,0,0,1.372-1.372V4.116A1.372,1.372,0,0,0,40.706,2.744Zm-1.372,36.59H2.744v-24.7h36.59v24.7Zm0-27.442H2.744v-6.4H8.233V6.861a1.372,1.372,0,0,0,2.744,0V5.489H31.1V6.861a1.372,1.372,0,1,0,2.744,0V5.489h5.489v6.4Z" />
                                        </g>
                                    </g>
                                </svg>
                                <input type="hidden" value="{{ $success_array['filter_value_selected'] }}" class="ambulance_tab_1_date_selected" id="ambulance_tab_1_date_selected">
                                <div class="date-box w-90 ms-2">
                                    <input type="text" placeholder="{{ $success_array['date_filter_tab_1_date_to_show'] }}" class="datepickerInput" value=""/>
                                </div>
                            </div>
                            <div class="tile-bottom">
                                <h6 class="mb-1 pt-2 ">TODAY
                                    AMBULANCE ARRIVALS</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 weekly-ambulance-count">
                        <div class="row row-cols-7 gx-2 " id="week-details">
                            <div class="col mb-2 mb-xxl-0">

                                <div class="@if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'monday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l'))== 'monday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">MONDAY </h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Mon'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Mon'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'tuesday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l'))== 'tuesday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">TUESDAY</h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Tue'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Tue'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'wednesday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'wednesday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">WEDNESDAY</h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Wed'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Wed'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'thursday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'thursday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">THURSDAY </h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Thu'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Thu'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'friday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'friday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">FRIDAY</h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Fri'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Fri'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'saturday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'saturday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">SATURDAY</h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Sat'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Sat'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mb-xxl-0">
                                <div class=" @if($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'sunday') d-flex justify-content-between @endif blue-top">
                                    @if ($success_array['filter_value_selected'] == date('Y-m-d') && strtolower(date('l')) == 'sunday')
                                        <h6 class="bg-live-yellow">Live</h6>
                                    @endif
                                    <h6 class="text-end">SUNDAY</h6>
                                </div>
                                <div class="tile-shape-bottom">
                                    <div class="d-flex justify-content-between border-bottom">
                                        <h6>ACTUAL</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_actual_value']['Sun'] }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h6>PREDICTED</h6>
                                        <h6 class="fw-bold text-end">{{ $success_array['ambulance_week_predicted_value']['Sun'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-ambulance-chart">
                    <div class="card-grey">
                        <div class="row">
                            <div id="ambulance_arrivals_count_tab_1"></div>
                        </div>
                    </div>
                </div>
                <div class="row gx-2">
                    <div class="col-xxl-6 mb-2 pe-1">
                        <div class="card-grey">
                            <div class="header-section">
                                <div class="d-flex justify-content-md-between justify-content-center">
                                    <h6 class="text-center text-md-start">ADMITTED</h6>
                                    <h6 class="d-none d-md-block">{{ $success_array['admitted_non_admitted_section']['admitted_total'] }}/{{ $success_array['admitted_non_admitted_section']['non_admitted_total'] }}</h6>
                                    <h6 class="d-none d-md-block">NON-ADMITTED</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center set_height">
                                    <div class="col-lg-6 ">
                                        <p class="mb-0 ps-4">Average time per ambulance arrived
                                        </p>
                                        <h6 class="fw-bold  ps-4">{{ !empty($success_array['admitted_non_admitted_section']['admitted']['box_plot_average_time']) ? $success_array['admitted_non_admitted_section']['admitted']['box_plot_average_time'] : '00 Hr & 00 Min' }}</h6>
                                        <div id="admitted_non_admitted_box_plot_1_tab_1"></div>
                                        <div id="ambulance_admitted_barchart_tab_1" class="pt-3"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bg-sm-header ">
                                            <h6 class="d-md-none mb-0">NON-ADMITTED</h6>
                                        </div>
                                        <p class="mb-0  ps-4">Average time per ambulance arrived
                                        </p>
                                        <h6 class="fw-bold  ps-4">{{ !empty($success_array['admitted_non_admitted_section']['non_admitted']['box_plot_average_time']) ? $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_average_time'] : '00 Hr & 00 Min' }}</h6>
                                        <div id="admitted_non_admitted_box_plot_2_tab_1"> </div>
                                        <div id="ambulance_non_admitted_barchart_tab_1" class="pt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card-grey">
                            <div class="header-section">
                                <div class="d-flex justify-content-md-between justify-content-center">
                                    <h6 class="text-center text-md-start">ADMITTED</h6>
                                    <h6 class="d-none d-md-block">BREACHES</h6>
                                    <h6 class="d-none d-md-block">NON-ADMITTED</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center" id="fs-sm">
                                    <div class="col-lg-4 col-md-4">
                                    </div>
                                    <div class="col-lg-4 col-md-4 offset-md-4 order-2 order-md-0">
                                        <div class="bg-sm-header ">
                                            <h6 class="d-md-none mb-0">NON-ADMITTED</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 order-0 order-md-1">
                                        <div class="round_progress_chart_container">
                                            <div class="progress_chart_container_box">
                                                <div class="circle_progress_chart_easy_pie" data-percent="{{ $success_array['admitted_non_admitted_breached_section']['admitted_donut']['breach'] }}" data-scale-color="#0066FF">
                                                    {{ $success_array['admitted_non_admitted_breached_section']['admitted_donut']['breach'] }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-6 offset-3 offset-md-0 align-self-center order-1 order-md-2 mb-2 mb-md-0">
                                        <div class="d-flex justify-content-between box-graph-white mb-2 ">
                                            <p class="mb-0 ">Total</p>
                                            <h6 class="fw-bold  mb-0">{{ $success_array['admitted_non_admitted_breached_section']['breached_total'] }}</h6>
                                        </div>
                                        <div class="box-graph-blue">
                                            <h6 class="fw-bold mb-0">{{ $success_array['admitted_non_admitted_breached_section']['breached_admitted_total'] }} | {{ $success_array['admitted_non_admitted_breached_section']['breached_non_admitted_total'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 order-3 order-md-3">
                                        <div class="round_progress_chart_container">
                                            <div class="progress_chart_container_box">
                                                <div class="circle_progress_chart_easy_pie" data-percent="{{ $success_array['admitted_non_admitted_breached_section']['non_admitted_donut']['breach'] }}" data-scale-color="#0066FF">
                                                    {{ $success_array['admitted_non_admitted_breached_section']['non_admitted_donut']['breach'] }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 ">
                                <div class="col-lg-4 col-md-4 ">
                                    <div class="text-center">
                                        <p class="mb-0">Median Time</p>
                                        <h6 class="fs-5 fw-bold">{{ !empty($success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_average_time']) ? $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_average_time'] : '00 Hr & 00 Min' }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 ">
                                    <div class="text-center">
                                        <p class="mb-0">Average Time In ED</p>
                                        <h6 class="fs-5 fw-bold">{{ !empty($success_array['admitted_non_admitted_breached_section']['overall']['box_plot_average_time']) ? $success_array['admitted_non_admitted_breached_section']['overall']['box_plot_average_time']  : '00 Hr & 00 Min' }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 ">
                                    <div class="text-center">
                                        <p class="mb-0">Median Time</p>
                                        <h6 class="fs-5 fw-bold">{{ !empty($success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_average_time']) ? $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_average_time'] : '00 Hr & 00 Min' }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div id="admitted_non_admitted_box_plot_3_tab_1"></div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div id="admitted_non_admitted_box_plot_4_tab_1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<button class="d-none" id="start_date_day_summary"></div>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

        @if(!empty($success_array['filter_value_selected']))
            var start = moment('{{$success_array['filter_value_selected']}}', 'YYYY-MM-DD');
        @else
            var start = moment().endOf('day');
        @endif

        function cb(start) {
            $('.date-box').html(start.format('ddd MMMM D, YYYY'));
            $('#ambulance_tab_1_date_selected').val(start.format('YYYY-MM-DD'));
            if(start.format('YYYY-MM-DD') != '{{$success_array['filter_value_selected']}}'){
                $("#start_date_day_summary").click();
            }

        }


        $('#daterangepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        startDate: start,
        maxDate: moment().endOf('day'),
        locale: {
            format: 'ddd MMMM D, YYYY'
        }
        }, cb);



    });
</script>
<script>
    var obj_ambulance_arrivals_count_tab_1 = '';
    var obj_admitted_non_admitted_box_plot_1_tab_1 = '';
    var obj_admitted_non_admitted_box_plot_2_tab_1 = '';
    var obj_admitted_non_admitted_box_plot_3_tab_1 = '';
    var obj_admitted_non_admitted_box_plot_4_tab_1 = '';
    var obj_ambulance_admitted_barchart_tab_1 = '';
    var obj_ambulance_non_admitted_barchart_tab_1 = '';

    function AmbulanceArrivalApexChartDestroyTab1() {
        if (typeof obj_ambulance_arrivals_count_tab_1 === 'object') {
            obj_ambulance_arrivals_count_tab_1.destroy();
        }
        if (typeof obj_admitted_non_admitted_box_plot_1_tab_1 === 'object') {
            obj_admitted_non_admitted_box_plot_1_tab_1.destroy();
        }
        if (typeof obj_admitted_non_admitted_box_plot_2_tab_1 === 'object') {
            obj_admitted_non_admitted_box_plot_2_tab_1.destroy();
        }
        if (typeof obj_admitted_non_admitted_box_plot_3_tab_1 === 'object') {
            obj_admitted_non_admitted_box_plot_3_tab_1.destroy();
        }
        if (typeof obj_admitted_non_admitted_box_plot_4_tab_1 === 'object') {
            obj_admitted_non_admitted_box_plot_4_tab_1.destroy();
        }
        if (typeof obj_ambulance_admitted_barchart_tab_1 === 'object') {
            obj_ambulance_admitted_barchart_tab_1.destroy();
        }
        if (typeof obj_ambulance_non_admitted_barchart_tab_1 === 'object') {
            obj_ambulance_non_admitted_barchart_tab_1.destroy();
        }
    }





    var apex_chart_settings_options_temp = ambulance_arrival_hourly_graph_options;
    apex_chart_settings_options_temp['series'] = [{

         name: 'Actual Count',
        type: 'column',
        data: <?php echo json_encode($success_array['ambulance_arrival_hour_hour_bar_graph_associative_array']); ?>,

    }, {

         name: 'Predicted Count',
        type: 'line',
        data: <?php echo json_encode($success_array['ambulance_arrival_hour_hour_line_graph_associative_array']); ?>,
        color: '#0066FF'

    }];
    apex_chart_settings_options_temp.markers = {
    size: 6,
    colors: ['#fff'],
    strokeColors: ['#FF5733'],
    strokeWidth: 2,
    };
    if (document.querySelector("#ambulance_arrivals_count_tab_1")) {
        obj_ambulance_arrivals_count_tab_1 = new ApexCharts(document.querySelector("#ambulance_arrivals_count_tab_1 "), apex_chart_settings_options_temp);
        obj_ambulance_arrivals_count_tab_1.render();
    }

    //Admitted Box Plot
    var apex_chart_settings_options_temp = admitted_non_admitted_box_plot_options;
    apex_chart_settings_options_temp['series'] = [{
        data: [{
            x: '',
            y: [{{ $success_array['admitted_non_admitted_section']['admitted']['box_plot_minimum'] }}, {{ $success_array['admitted_non_admitted_section']['admitted']['box_plot_lower_quartile'] }}, {{ $success_array['admitted_non_admitted_section']['admitted']['box_plot_median'] }}, {{ $success_array['admitted_non_admitted_section']['admitted']['box_plot_upper_quartile'] }}, {{ $success_array['admitted_non_admitted_section']['admitted']['box_plot_maximum'] }}]
        }]
    }];
    if (document.querySelector("#admitted_non_admitted_box_plot_1_tab_1")) {
        obj_admitted_non_admitted_box_plot_1_tab_1 = new ApexCharts(document.querySelector("#admitted_non_admitted_box_plot_1_tab_1"), apex_chart_settings_options_temp);
        obj_admitted_non_admitted_box_plot_1_tab_1.render();
    }

    //Non Admitted Box Plot
    var apex_chart_settings_options_temp = admitted_non_admitted_box_plot_options;
    apex_chart_settings_options_temp['series'] = [{
        data: [{
            x: '',
            y: [{{ $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_minimum'] }}, {{ $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_lower_quartile'] }}, {{ $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_median'] }}, {{ $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_upper_quartile'] }},
                {{ $success_array['admitted_non_admitted_section']['non_admitted']['box_plot_maximum'] }}
            ]
        }]
    }];
    if (document.querySelector("#admitted_non_admitted_box_plot_2_tab_1")) {
        obj_admitted_non_admitted_box_plot_2_tab_1 = new ApexCharts(document.querySelector("#admitted_non_admitted_box_plot_2_tab_1"), apex_chart_settings_options_temp);
        obj_admitted_non_admitted_box_plot_2_tab_1.render();
    }

    //Breach Admitted Box Plot
    var apex_chart_settings_options_temp = admitted_non_admitted_box_plot_options;
    apex_chart_settings_options_temp['series'] = [{
        data: [{
            x: '',
            y: [{{ $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_minimum'] }}, {{ $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_lower_quartile'] }}, {{ $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_median'] }}, {{ $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_upper_quartile'] }},
                {{ $success_array['admitted_non_admitted_breached_section']['admitted']['box_plot_maximum'] }}
            ]
        }]
    }];

    if (document.querySelector("#admitted_non_admitted_box_plot_3_tab_1")) {
        obj_admitted_non_admitted_box_plot_3_tab_1 = new ApexCharts(document.querySelector("#admitted_non_admitted_box_plot_3_tab_1"), apex_chart_settings_options_temp);
        obj_admitted_non_admitted_box_plot_3_tab_1.render();
    }

    //Breach Non Admitted Box Plot
    var apex_chart_settings_options_temp = admitted_non_admitted_box_plot_options;
    apex_chart_settings_options_temp['series'] = [{
        data: [{
            x: '',
            y: [{{ $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_minimum'] }}, {{ $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_lower_quartile'] }}, {{ $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_median'] }}, {{ $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_upper_quartile'] }},
                {{ $success_array['admitted_non_admitted_breached_section']['non_admitted']['box_plot_maximum'] }}
            ]
        }]
    }];
    if (document.querySelector("#admitted_non_admitted_box_plot_4_tab_1")) {
        obj_admitted_non_admitted_box_plot_4_tab_1 = new ApexCharts(document.querySelector("#admitted_non_admitted_box_plot_4_tab_1"), apex_chart_settings_options_temp);
        obj_admitted_non_admitted_box_plot_4_tab_1.render();
    }

    // Ambulance dashboard Column chart-1
    var apex_chart_settings_options_temp = admitted_non_admitted_barchart_options;
    apex_chart_settings_options_temp['series'] = [{
        name: 'Admitted Patients',
        type: 'column',
        data: <?php echo json_encode($success_array['admitted_non_admitted_section']['admitted_arrival_to_departure_associative_array']); ?>
    }];
    if (document.querySelector("#ambulance_admitted_barchart_tab_1")) {
        obj_ambulance_admitted_barchart_tab_1 = new ApexCharts(document.querySelector("#ambulance_admitted_barchart_tab_1"), apex_chart_settings_options_temp);
        obj_ambulance_admitted_barchart_tab_1.render();
    }

    // Ambulance dashboard Column chart-2
    var apex_chart_settings_options_temp = admitted_non_admitted_barchart_options;
    apex_chart_settings_options_temp['series'] = [{
        name: '',
        data: <?php echo json_encode($success_array['admitted_non_admitted_section']['non_admitted_arrival_to_departure_associative_array']); ?>
    }];
    if (document.querySelector("#ambulance_non_admitted_barchart_tab_1")) {
        obj_ambulance_non_admitted_barchart_tab_1 = new ApexCharts(document.querySelector("#ambulance_non_admitted_barchart_tab_1"), apex_chart_settings_options_temp);
        obj_ambulance_non_admitted_barchart_tab_1.render();
    }

    // Ambulance dashboard  Donut Chart
    $(function() {
        $('.circle_progress_chart_easy_pie').easyPieChart({
            size: 160,
            barColor: "#0066FF",
            scaleLength: 0,
            lineWidth: 25,
            trackColor: "#373737",
            lineCap: "circle",
            animate: 2000,
        });
    });
</script>
