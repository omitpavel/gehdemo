 @php $box_plot_generate_array                = array(); @endphp
 @php $box_plot_generate_index                = 1; @endphp


 <div class="row  gx-2">
     <div class="col-xxl-7">
         <div class="ed-overview-top-row">
             <div class="row gx-3 align-items-center">
                 <div class="ed-overview-top-row-left">
                     <div class="live">
                         <div class="circle"></div>LIVE
                     </div>
                 </div>

                 <div class="ed-overview-top-row-right">
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
             @if (count($success_array['ed_overview_speciality_row_data']['admission_type']) > 0)
             <div class="attendance-type-block">
                 @foreach ($success_array['ed_overview_speciality_row_data']['admission_type'] as $row)

                         <div class="row gx-3 align-items-center mb-2">
                             <div class="col-overview-left">
                                 <div class="left-header-wrap blue-left-header summary_data_load_of_ed_overview_tab_1"
                                     data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                     <h6>{{ $row['speciality'] }} <span>{{ $row['speciality_bottom_text'] }}</span></h6>
                                 </div>
                             </div>
                             <div class="col-overview-right">
                                 <div class="overview-card">
                                     <div class="card-body">
                                         <div class="row gx-md-2 align-items-center" id="overview-boxes">
                                             <div class="col-right-1">
                                                 <div class="overall summary_data_load_of_ed_overview_tab_1"
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
                                                         id="atd_type_tab_1_{{ $box_plot_generate_index }}"></div>

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
                         ] = "atd_type_tab_1_$box_plot_generate_index";
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
                </div>
             @endif
             @if (count($success_array['ed_overview_speciality_row_data']['discharge_type']) > 0)
             <div class="attendance-type-block">
                 @foreach ($success_array['ed_overview_speciality_row_data']['discharge_type'] as $row)

                         <div class="row gx-3 align-items-center mb-2">
                             <div class="col-overview-left">
                                 <div class="left-header-wrap blue-left-header summary_data_load_of_ed_overview_tab_1"
                                     data-spec-click-ajax-load='{{ $row['speciality'] }}'>
                                     <h6>{{ $row['speciality'] }} <span>{{ $row['speciality_bottom_text'] }}</span></h6>
                                 </div>
                             </div>
                             <div class="col-overview-right">
                                 <div class="overview-card">
                                     <div class="card-body">
                                         <div class="row gx-md-2 align-items-center" id="overview-boxes">
                                             <div class="col-right-1">
                                                 <div class="overall summary_data_load_of_ed_overview_tab_1"
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
                                                         id="atd_type_tab_1_{{ $box_plot_generate_index }}"></div>

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
                         ] = "atd_type_tab_1_$box_plot_generate_index";
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
                </div>
             @endif
         </div>
     </div>
     <div id='content_load_summary_data_load_of_ed_overview_tab_1' class="col-xxl-5">
         @include('Dashboards.Symphony.EDOverview.IndexDataLoadBxPlotRightCommonTab1')
     </div>
 </div>
 @if (count($box_plot_generate_array) > 0)
     @foreach ($box_plot_generate_array as $key => $row)
         <script>
             DrawBoxPlotCharts("<?php echo $row['box_plot_id']; ?>", <?php echo $row['minimum']; ?>, <?php echo $row['lower_quartile']; ?>, <?php echo $row['median']; ?>,
                 <?php echo $row['upper_quartile']; ?>, <?php echo $row['maximum']; ?>);
         </script>
     @endforeach
 @endif
