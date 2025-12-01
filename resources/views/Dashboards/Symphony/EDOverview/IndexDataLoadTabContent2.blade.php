 @php $box_plot_generate_array                = array(); @endphp
 @php $box_plot_generate_index                = 1; @endphp

 <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
 <div class="row gx-2 ed-overview-today">
     <div class="col-xxl-7">
         <div class="ed-overview-top-today">
             <div class="row gx-3">
                 <div class="ed-overview-top-row-left pe-md-0">
                     <div class="d-flex align-items-center">
                         <div class="orange-shape text-center">
                             <i class="bi bi-calendar3 "></i>
                         </div>
                         <div class="date-box w-90">
                             <input type="hidden" value="{{ $success_array['filter_value_selected'] }}"
                                 class="start_date_day_summary_val" id="start_date_day_summary_val">
                             <input type="text" name="datepicker"
                                 placeholder="{{ $success_array['date_filter_tab_2_date_to_show'] }}"
                                 class="datepickerInput" value="" id="start_date_day_summary"
                                 readonly='readonly' />
                         </div>
                     </div>
                 </div>
                 <div class="ed-overview-top-row-right ps-0">
                     <div class="row gx-2 align-items-center card-body">
                         <div class="ed-overview-top-col-1"></div>
                         <div class="ed-overview-top-col-2">
                             <div class="top-label">
                                 <h6 class="mb-0">ARRIVED FROM MIDNIGHT TODAY TO
                                     NOW</h6>
                             </div>
                         </div>
                         <div class="ed-overview-top-col-3">
                             <div class="top-label">
                                 <h6 class="mb-0">AVG TIME IN DEPT. <br> <span>
                                         FROM
                                         ARRIVAL</span></h6>
                             </div>
                         </div>
                         <div class="ed-overview-top-col-4">
                             <div class="top-label">
                                 <h6 class="mb-0">AVG TIME IN DEPT. <br> <span>
                                         (LAST 100
                                         DISCHARGES)</span></h6>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="overview-details-section">
             <div class="attendance-type-block">
                 @if (count($success_array['ed_overview_speciality_row_data']['admission_type']) > 0)
                     @foreach ($success_array['ed_overview_speciality_row_data']['admission_type'] as $row)
                         <div class="row gx-3 align-items-center mb-2">
                             <div class="col-overview-left">
                                 <div class="left-header-wrap blue-left-header summary_data_load_of_ed_overview_tab_2"
                                     data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                     <h6>{{ $row['speciality'] }} <span>{{ $row['speciality_bottom_text'] }}</span></h6>
                                 </div>
                             </div>
                             <div class="col-overview-right">
                                 <div class="overview-card">
                                     <div class="card-body">
                                         <div class="row gx-md-2 align-items-center" id="overview-boxes">
                                             <div class="col-right-1">
                                                 <div class="overall summary_data_load_of_ed_overview_tab_2"
                                                     data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                                     <h6 class="d-md-none">{{ $row['speciality'] }}
                                                         <span>{{ $row['speciality_bottom_text'] }}</span>
                                                     </h6>
                                                     <h5 class="mb-0"> {{ $row['time_series']['total'] }}</h5>
                                                 </div>
                                             </div>
                                             <div class="col-right-2">
                                                 <div class="d-md-none timing-header">
                                                     <h6 class="text-center">ARRIVED FROM MIDNIGHT TODAY TO NOW </h6>
                                                 </div>
                                                 <div
                                                     class="row row-cols-5 gx-2 align-items-center height-tile mb-2 mb-lg-0">
                                                     <div class="col ">
                                                         <div class="shape-square ">
                                                             <div>
                                                                 <p>{{ $row['time_series']['green_time'] }}</p>
                                                             </div>
                                                             <div>
                                                                 <h6 class="fw-bold mb-0 ">
                                                                     {{ $row['time_series']['green_value'] }} </h6>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col ">
                                                         <div class="shape-square-brown ">
                                                             <div>
                                                                 <p>{{ $row['time_series']['yellow_time'] }}</p>
                                                             </div>
                                                             <div>
                                                                 <h6 class="fw-bold mb-0 ">
                                                                     {{ $row['time_series']['yellow_value'] }} </h6>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col ">
                                                         <div class="shape-square-orange ">
                                                             <div>
                                                                 <p>{{ $row['time_series']['orange_time'] }}</p>
                                                             </div>
                                                             <div>
                                                                 <h6 class="fw-bold mb-0 ">
                                                                     {{ $row['time_series']['orange_value'] }} </h6>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col ">
                                                         <div class="shape-square-red ">
                                                             <div>
                                                                 <p>{{ $row['time_series']['red_time'] }} </p>
                                                             </div>
                                                             <div>
                                                                 <h6 class="fw-bold mb-0 ">
                                                                     {{ $row['time_series']['red_value'] }} </h6>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col ">
                                                         <div class="shape-square-black ">
                                                             <div>
                                                                 <p class="mb-0">
                                                                     {{ $row['time_series']['purple_time'] }} </p>
                                                             </div>
                                                             <div>
                                                                 <h6 class="fw-bold mb-0 ">
                                                                     {{ $row['time_series']['purple_value'] }} </h6>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-right-3">
                                                 <div class="d-md-none timing-header">
                                                     <h6 class="text-center">AVG TIME IN DEPT. <br> <span> FROM
                                                             ARRIVAL</span> </h6>
                                                 </div>
                                                 <div class="time-section">
                                                     <div class="time-stamp-1">
                                                         <span>Avg Time In Dept Now</span>
                                                         <h6 class="fw-bold">{{ $row['arrival']['average_time'] }}</h6>
                                                     </div>
                                                     <div class="border-bottom w-95"></div>
                                                     <div class="time-stamp-2">
                                                         <span>Longest Waiter</span>
                                                         <h6 class="fw-bold">({{ $row['arrival']['longest_wait'] }})
                                                         </h6>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-right-4">
                                                 <div class="d-md-none timing-header">
                                                     <h6 class="text-center">AVG TIME IN DEPT. <br> <span> (LAST 100
                                                             DISCHARGES)</span> </h6>
                                                 </div>
                                                 <div class="time-section">
                                                     <div class='edoverview_box_plot_head_top'>
                                                         {{ $row['last_discharge']['box_plot_average_time'] }}</div>
                                                     <div class="edoverview_dashboard_box_pot_container"
                                                         id="atd_type_tab_2_{{ $box_plot_generate_index }}"></div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         @php
                             $box_plot_generate_array[$box_plot_generate_index][
                                 'box_plot_id'
                             ] = "atd_type_tab_2_$box_plot_generate_index";
                             $box_plot_generate_array[$box_plot_generate_index]['minimum'] =
                                 $row['last_discharge']['box_plot_minimum'];
                             $box_plot_generate_array[$box_plot_generate_index]['lower_quartile'] =
                                 $row['last_discharge']['box_plot_lower_quartile'];
                             $box_plot_generate_array[$box_plot_generate_index]['median'] =
                                 $row['last_discharge']['box_plot_median'];
                             $box_plot_generate_array[$box_plot_generate_index]['upper_quartile'] =
                                 $row['last_discharge']['box_plot_upper_quartile'];
                             $box_plot_generate_array[$box_plot_generate_index]['maximum'] =
                                 $row['last_discharge']['box_plot_maximum'];
                             $box_plot_generate_index++;
                         @endphp
                     @endforeach
                 @endif
             </div>
             <div class="attendance-type-block">
                @if (count($success_array['ed_overview_speciality_row_data']['discharge_type']) > 0)
                    @foreach ($success_array['ed_overview_speciality_row_data']['discharge_type'] as $row)
                        <div class="row gx-3 align-items-center mb-2">
                            <div class="col-overview-left">
                                <div class="left-header-wrap blue-left-header summary_data_load_of_ed_overview_tab_2"
                                    data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                    <h6>{{ $row['speciality'] }} <span>{{ $row['speciality_bottom_text'] }}</span></h6>
                                </div>
                            </div>
                            <div class="col-overview-right">
                                <div class="overview-card">
                                    <div class="card-body">
                                        <div class="row gx-md-2 align-items-center" id="overview-boxes">
                                            <div class="col-right-1">
                                                <div class="overall summary_data_load_of_ed_overview_tab_2"
                                                    data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                                    <h6 class="d-md-none">{{ $row['speciality'] }}
                                                        <span>{{ $row['speciality_bottom_text'] }}</span>
                                                    </h6>
                                                    <h5 class="mb-0"> {{ $row['time_series']['total'] }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-right-2">
                                                <div class="d-md-none timing-header">
                                                    <h6 class="text-center">ARRIVED FROM MIDNIGHT TODAY TO NOW </h6>
                                                </div>
                                                <div
                                                    class="row row-cols-5 gx-2 align-items-center height-tile mb-2 mb-lg-0">
                                                    <div class="col ">
                                                        <div class="shape-square ">
                                                            <div>
                                                                <p>{{ $row['time_series']['green_time'] }}</p>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 ">
                                                                    {{ $row['time_series']['green_value'] }} </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col ">
                                                        <div class="shape-square-brown ">
                                                            <div>
                                                                <p>{{ $row['time_series']['yellow_time'] }}</p>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 ">
                                                                    {{ $row['time_series']['yellow_value'] }} </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col ">
                                                        <div class="shape-square-orange ">
                                                            <div>
                                                                <p>{{ $row['time_series']['orange_time'] }}</p>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 ">
                                                                    {{ $row['time_series']['orange_value'] }} </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col ">
                                                        <div class="shape-square-red ">
                                                            <div>
                                                                <p>{{ $row['time_series']['red_time'] }} </p>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 ">
                                                                    {{ $row['time_series']['red_value'] }} </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col ">
                                                        <div class="shape-square-black ">
                                                            <div>
                                                                <p class="mb-0">
                                                                    {{ $row['time_series']['purple_time'] }} </p>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 ">
                                                                    {{ $row['time_series']['purple_value'] }} </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-right-3">
                                                <div class="d-md-none timing-header">
                                                    <h6 class="text-center">AVG TIME IN DEPT. <br> <span> FROM
                                                            ARRIVAL</span> </h6>
                                                </div>
                                                <div class="time-section">
                                                    <div class="time-stamp-1">
                                                        <span>Avg Time In Dept Now</span>
                                                        <h6 class="fw-bold">{{ $row['arrival']['average_time'] }}</h6>
                                                    </div>
                                                    <div class="border-bottom w-95"></div>
                                                    <div class="time-stamp-2">
                                                        <span>Longest Waiter</span>
                                                        <h6 class="fw-bold">({{ $row['arrival']['longest_wait'] }})
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-right-4">
                                                <div class="d-md-none timing-header">
                                                    <h6 class="text-center">AVG TIME IN DEPT. <br> <span> (LAST 100
                                                            DISCHARGES)</span> </h6>
                                                </div>
                                                <div class="time-section">
                                                    <div class='edoverview_box_plot_head_top'>
                                                        {{ $row['last_discharge']['box_plot_average_time'] }}</div>
                                                    <div class="edoverview_dashboard_box_pot_container"
                                                        id="atd_type_tab_2_{{ $box_plot_generate_index }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $box_plot_generate_array[$box_plot_generate_index][
                                'box_plot_id'
                            ] = "atd_type_tab_2_$box_plot_generate_index";
                            $box_plot_generate_array[$box_plot_generate_index]['minimum'] =
                                $row['last_discharge']['box_plot_minimum'];
                            $box_plot_generate_array[$box_plot_generate_index]['lower_quartile'] =
                                $row['last_discharge']['box_plot_lower_quartile'];
                            $box_plot_generate_array[$box_plot_generate_index]['median'] =
                                $row['last_discharge']['box_plot_median'];
                            $box_plot_generate_array[$box_plot_generate_index]['upper_quartile'] =
                                $row['last_discharge']['box_plot_upper_quartile'];
                            $box_plot_generate_array[$box_plot_generate_index]['maximum'] =
                                $row['last_discharge']['box_plot_maximum'];
                            $box_plot_generate_index++;
                        @endphp
                    @endforeach
                @endif
            </div>
         </div>
     </div>
     <div id='content_load_summary_data_load_of_ed_overview_tab_2' class="col-xxl-5">
         @include('Dashboards.Symphony.EDOverview.IndexDataLoadBxPlotRightCommonTab2')
     </div>
 </div>
 <button class="d-none ed_overview_day_summary_search"></div>

     <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
     <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
     <script>
         $(function() {

             @if (!empty($success_array['filter_value_selected']))
                 var start = moment('{{ $success_array['filter_value_selected'] }}', 'YYYY-MM-DD');
             @else
                 var start = moment().endOf('day');
             @endif

             function cb(start) {
                 $('#start_date_day_summary_val').val(start.format('MMMM D, YYYY'));
                 $('#start_date_day_summary').val(start.format('ddd MMMM D, YYYY'));
                 if (start.format('YYYY-MM-DD') != '{{ $success_array['filter_value_selected'] }}') {
                     $(".ed_overview_day_summary_search").click();
                 }
             }


             $('#start_date_day_summary').daterangepicker({
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

     @if (count($box_plot_generate_array) > 0)
         @foreach ($box_plot_generate_array as $key => $row)
             <script>
                 DrawBoxPlotCharts("<?php echo $row['box_plot_id']; ?>", <?php echo $row['minimum']; ?>, <?php echo $row['lower_quartile']; ?>, <?php echo $row['median']; ?>,
                     <?php echo $row['upper_quartile']; ?>, <?php echo $row['maximum']; ?>);
             </script>
         @endforeach
     @endif
