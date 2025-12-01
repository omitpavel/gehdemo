 @php $box_plot_generate_array                = array(); @endphp
 @php $box_plot_generate_index                = 1; @endphp
 @php $box_plot_filter_mode                   = $success_array["filter_mode"]; @endphp



 <div class="row mb-3">
     <div class="container-fluid">
         <div class="col-lg-12  ">
             @if ($box_plot_filter_mode == 1 || $box_plot_filter_mode == 2)
                 <div class="row gx-2">
                     <div class="col-xl-4 mb-2">
                         <div class="">
                                @if($box_plot_filter_mode == 1)
                                     <select name="data_summary_filter_1" id="data_summary_filter_1">
                                         @if (count($success_array['filter_array']))
                                             @foreach ($success_array['filter_array'] as $key => $row)
                                                 <option value="{{ $row['filter_value'] }}" @if ($row['filter_value'] == $success_array['filter_value_selected']) selected @endif>
                                                     {{ $row['filter_text'] }}
                                                 </option>
                                             @endforeach
                                         @endif
                                     </select>
                                 @else
                                     <select name="data_summary_filter_2" id="data_summary_filter_2">
                                     @if (count($success_array['filter_array']))
                                         @foreach ($success_array['filter_array'] as $key => $row)
                                             <option value="{{ $row['filter_value'] }}" @if ($row['filter_value'] == $success_array['filter_value_selected']) selected @endif>
                                                 {{ $row['filter_text'] }}
                                             </option>
                                         @endforeach
                                     @endif
                                    </select>
                                 @endif
                         </div>
                     </div>
                 </div>
             @endif
             <div class="row">
                 <div class="col-lg-4 pe-lg-1">
                     <div class="referral-card">
                         <h6>OVERALL</h6>
                     </div>
                     @if (count($success_array['data_summary']['overall_data_values_with_speciality']))
                         @foreach ($success_array['data_summary']['overall_data_values_with_speciality'] as $key => $row)
                             <div class="referral-card pb-lg-0">
                                 <div class="row align-items-center mt-2 mb-2">
                                     <div class="col-lg-6 col-md-6 col-6">
                                         <h6>{{ $row['symphony_specialty'] }}</h6>
                                     </div>
                                     <div class="col-lg-6 col-md-6 col-6 text-end">
                                         <h6 class="fw-bold ">{{ $row['box_plot_average_time'] }}</h6>
                                     </div>
                                 </div>
                                 <div class="border-bottom"></div>
                                 <div class="row align-items-center">
                                     <div class="col-lg-7 col-md-7 ps-md-0">
                                         <div class="referral_dashboard_box_pot_container"  id="box_plot_{{ $box_plot_filter_mode }}_summary_{{ $box_plot_generate_index }}"></div>
                                     </div>
                                     <div class="col-lg-5 col-md-5 ps-md-0">
                                         <div class="row">
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">BREACHES</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['breached'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">ADMITTED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['admitted'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">DISCHARGED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['discharged'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             @php
                                 $box_plot_generate_array[$box_plot_generate_index]['box_plot_id'] = 'box_plot_' . $box_plot_filter_mode . '_summary_' . $box_plot_generate_index;
                                 $box_plot_generate_array[$box_plot_generate_index]['minimum'] = $row['box_plot_minimum'];
                                 $box_plot_generate_array[$box_plot_generate_index]['lower_quartile'] = $row['box_plot_lower_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['median'] = $row['box_plot_median'];
                                 $box_plot_generate_array[$box_plot_generate_index]['upper_quartile'] = $row['box_plot_upper_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['maximum'] = $row['box_plot_maximum'];
                                 $box_plot_generate_index++;
                             @endphp
                         @endforeach
                     @else
                         <span class="nodataMessage">{{ NotFoundMessage() }}</span>
                     @endif
                 </div>
                 <div class="col-lg-4 ps-lg-1 pe-lg-1">
                     <div class="referral-card">
                         <h6>AMBULANCE</h6>
                     </div>
                     @if (count($success_array['data_summary']['ambulance_data_values_with_speciality']))
                         @foreach ($success_array['data_summary']['ambulance_data_values_with_speciality'] as $key => $row)
                             <div class="referral-card pb-lg-0">
                                 <div class="row align-items-center mt-2 mb-2">
                                     <div class="col-lg-6 col-md-6 col-6">
                                         <h6>{{ $row['symphony_specialty'] }}</h6>
                                     </div>
                                     <div class="col-lg-6 col-md-6 col-6 text-end">
                                         <h6 class="fw-bold ">{{ $row['box_plot_average_time'] }}</h6>
                                     </div>
                                 </div>
                                 <div class="border-bottom"></div>
                                 <div class="row align-items-center">
                                     <div class="col-lg-7 col-md-7 ps-md-0">
                                         <div class="referral_dashboard_box_pot_container" id="box_plot_{{ $box_plot_filter_mode }}_summary_{{ $box_plot_generate_index }}"></div>
                                     </div>
                                     <div class="col-lg-5 col-md-5 ps-md-0">
                                         <div class="row">
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">BREACHES</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['breached'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">ADMITTED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['admitted'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">DISCHARGED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['discharged'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             @php
                                 $box_plot_generate_array[$box_plot_generate_index]['box_plot_id'] = 'box_plot_' . $box_plot_filter_mode . '_summary_' . $box_plot_generate_index;
                                 $box_plot_generate_array[$box_plot_generate_index]['minimum'] = $row['box_plot_minimum'];
                                 $box_plot_generate_array[$box_plot_generate_index]['lower_quartile'] = $row['box_plot_lower_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['median'] = $row['box_plot_median'];
                                 $box_plot_generate_array[$box_plot_generate_index]['upper_quartile'] = $row['box_plot_upper_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['maximum'] = $row['box_plot_maximum'];
                                 $box_plot_generate_index++;
                             @endphp
                         @endforeach
                     @else
                         <span class="nodataMessage">{{ NotFoundMessage() }}</span>
                     @endif

                 </div>
                 <div class="col-lg-4 ps-lg-1">
                     <div class="referral-card">
                         <h6>WALK IN</h6>
                     </div>
                     @if (count($success_array['data_summary']['walkin_data_values_with_speciality']))
                         @foreach ($success_array['data_summary']['walkin_data_values_with_speciality'] as $key => $row)
                             <div class="referral-card pb-lg-0">
                                 <div class="row align-items-center mt-2 mb-2">
                                     <div class="col-lg-6 col-md-6 col-6">
                                         <h6>{{ $row['symphony_specialty'] }}</h6>
                                     </div>
                                     <div class="col-lg-6 col-md-6 col-6 text-end">
                                         <h6 class="fw-bold ">{{ $row['box_plot_average_time'] }}</h6>
                                     </div>
                                 </div>
                                 <div class="border-bottom"></div>
                                 <div class="row align-items-center">
                                     <div class="col-lg-7 col-md-7 ps-md-0">
                                         <div class="referral_dashboard_box_pot_container" id="box_plot_{{ $box_plot_filter_mode }}_summary_{{ $box_plot_generate_index }}"></div>
                                     </div>
                                     <div class="col-lg-5 col-md-5 ps-md-0">
                                         <div class="row">
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">BREACHES</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['breached'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">ADMITTED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['admitted'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-4 ps-lg-1 pe-lg-1">
                                                 <div class="">
                                                     <div class="blue-referral-box">
                                                         <h6 class="mb-2">DISCHARGED</h6>
                                                     </div>
                                                     <div class="blue-referral-bottom-box ">
                                                         <h5 class="mb-0">{{ $row['discharged'] }}</h5>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             @php
                                 $box_plot_generate_array[$box_plot_generate_index]['box_plot_id'] = 'box_plot_' . $box_plot_filter_mode . '_summary_' . $box_plot_generate_index;
                                 $box_plot_generate_array[$box_plot_generate_index]['minimum'] = $row['box_plot_minimum'];
                                 $box_plot_generate_array[$box_plot_generate_index]['lower_quartile'] = $row['box_plot_lower_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['median'] = $row['box_plot_median'];
                                 $box_plot_generate_array[$box_plot_generate_index]['upper_quartile'] = $row['box_plot_upper_quartile'];
                                 $box_plot_generate_array[$box_plot_generate_index]['maximum'] = $row['box_plot_maximum'];
                                 $box_plot_generate_index++;
                             @endphp
                         @endforeach
                     @else
                         <span class="nodataMessage">{{ NotFoundMessage() }}</span>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </div>
 @if (count($box_plot_generate_array) > 0)
     @foreach ($box_plot_generate_array as $key => $row)
         <script>
             DrawBoxPlotCharts("<?php echo $row['box_plot_id']; ?>", <?php echo $row['minimum']; ?>, <?php echo $row['lower_quartile']; ?>, <?php echo $row['median']; ?>, <?php echo $row['upper_quartile']; ?>, <?php echo $row['maximum']; ?>);
         </script>
     @endforeach
 @endif
