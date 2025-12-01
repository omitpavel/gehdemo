<div class="col-lg-12">
    <div class="row gx-2">
        <div class="col-xxl-8">
            <div class="card-leaflet-table">
                <div class="allebone-weekly-discharge">


                    @php
                        use Carbon\Carbon;
                        $week_keys = ['previous_week_5', 'previous_week_4', 'previous_week_3', 'previous_week_2', 'previous_week_1', 'current_week'];
                        $time_ranges = ['midnight_midday', 'midday_4pm', '4pm_midnight'];
                    @endphp

                    <table class="breachReasonTable responsiveTable table-weekly-discharges">
                        <thead>
                            <tr class="position-relative">
                                <th>WEEKLY DISCHARGES</th>
                                @foreach($week_keys as $week_key)
                                    <th>
                                        @if($week_key === 'current_week')
                                            Current Week
                                        @else
                                            -{{ Str::replace('previous_week_', '', $week_key) }} Week
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Loop each time range row --}}
                            @foreach($time_ranges as $time_range)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">WEEKLY DISCHARGES</div>
                                        <span>Discharges ({{ Str::title(str_replace('_', ' to ', $time_range)) }})</span>
                                    </td>

                                    @foreach($week_keys as $week_key)
                                        <td class="pivoted">
                                            <div class="tdBefore">
                                                @if($week_key === 'current_week')
                                                    Current Week
                                                @else
                                                    -{{ Str::replace('previous_week_', '', $week_key) }} Week
                                                @endif
                                            </div>
                                            {{ $success_array['dischagre_by_week'][$week_key][$time_range] ?? 0 }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                            {{-- TOTAL DISCHARGES --}}
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">WEEKLY DISCHARGES</div>
                                    <span>TOTAL DISCHARGES</span>
                                </td>
                                @foreach($week_keys as $week_key)
                                    <td class="pivoted">
                                        <div class="tdBefore">
                                            @if($week_key === 'current_week')
                                                Current Week
                                            @else
                                                -{{ Str::replace('previous_week_', '', $week_key) }} Week
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            @if(array_sum($success_array['dischagre_by_week'][$week_key] ?? []) >= $success_array["board_round_target"])
                                                <img src="{{ asset('asset_v2/Template/icons/tick-circle-white.svg')}}"  alt="" class="me-2" width="18"/>
                                            @endif
                                            {{ array_sum($success_array['dischagre_by_week'][$week_key] ?? []) }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">WEEKLY DISCHARGES</div>
                                    <span>Discharges Target</span>
                                </td>
                                @foreach($week_keys as $week_key)
                                    <td class="pivoted">
                                        <div class="tdBefore">
                                            @if($week_key === 'current_week')
                                                Current Week
                                            @else
                                                -{{ Str::replace('previous_week_', '', $week_key) }} Week
                                            @endif
                                        </div>
                                        {{($success_array["board_round_target"]*6)}}
                                    </td>
                                @endforeach
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-leaflet-table">
                <div class="allebone-board-round">
                    <table class="breachReasonTable responsiveTable table-weekly-discharges">
                        <thead>
                            <tr class="position-relative">
                                <th>BOARD ROUND</th>
                                <th></th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th class="bg-table-maroon">TOTAL</th>
                                <th class="bg-table-maroon">AM</th>
                                <th class="bg-table-maroon">PM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                unset($success_array["board_store_search_array"]['current_week_partial']);
                            @endphp
                            @foreach($success_array["board_store_search_array"] as $key=>$value)

                                @php
                                    $total_am           = 0;
                                    $total_pm           = 0;
                                    $totals             = 0;
                                    $current_am           = 0;
                                    $current_pm           = 0;
                                    $current_total        = 0;
                                    $week_days        = 0;
                                @endphp
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">BOARD ROUND </div>
                                        <span>{{ucwords(str_replace("_", ' ', $key))}}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore"></div>
                                        AM <br> PM
                                    </td>

                                    @foreach($value as $date_value => $each)
                                    @php
                                        $total_am           += $each['am_percentage_total'];
                                        $total_pm           += $each['pm_percentage_total'];
                                        $totals             += $each['total'];
                                        if ($key == 'current_week' && $each['am_percentage_total'] != 0){
                                            $current_am++;
                                        }
                                        if ($key == 'current_week' && $each['pm_percentage_total'] != 0){
                                            $current_pm++;
                                        }
                                        if ($key == 'current_week' && $each['total'] != 0){
                                            $current_total++;
                                        }

                                    @endphp
                                        <td class="pivoted">
                                            <div class="tdBefore">{{ date('l', strtotime($each['date'])) }}</div>
                                            <div class="">
                                                @if ($key == 'current_week' && Carbon::parse($date_value)->gt(Carbon::today()))
                                                    --

                                                @else
                                                    @if($each['am']=='00:00' || $each['am']=='00:00:00')
                                                        <div class="column-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="No Board Round ">
                                                            <span class="dot-red"></span>
                                                            <span>None </span>

                                                        </div>
                                                    @else
                                                        @if ($each['am_status'] == 1)
                                                            <div class="column-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                <span class="dot-green"></span>
                                                                <span> {{$each['am']}} </span>
                                                            </div>
                                                        @else
                                                            <div class="column-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Partial Board Round">
                                                                <span class="dot-amber"></span>
                                                                <span> {{$each['am']}} </span>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if($each['pm']=='00:00' || $each['pm']=='00:00:00')
                                                        <div class="column-2" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="No Board Round ">
                                                            <span class="dot-red"></span>
                                                            <span>None </span>

                                                        </div>
                                                    @else
                                                        @if ($each['pm_status'] == 1)
                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                <span class="dot-green"></span>
                                                                <span> {{$each['pm']}} </span>
                                                            </div>
                                                        @else
                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Partial Board Round">
                                                                <span class="dot-amber"></span>
                                                                <span> {{$each['pm']}} </span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @php
                                                        $week_days++;
                                                    @endphp
                                                @endif
                                            </div>
                                        </td>

                                    @endforeach
                                    @if ($key == 'current_week')

                                        @php
                                            $totals_current = PercentageCalculationOfValues($current_total, $week_days, 2);
                                            $totals_am_current = PercentageCalculationOfValues($current_am, $week_days, 2);
                                            $totals_pm_current = PercentageCalculationOfValues($current_pm, $week_days, 2);
                                        @endphp
                                        @if((int)$totals_current>=100) @php $class_1 = "text-success"; @endphp @elseif((int)$totals_current>=70) @php $class_1 = "text-warning"; @endphp @else @php $class_1 = "text-danger"; @endphp @endif
                                        @if((int)$totals_am_current>=100) @php $class_2 = "text-success"; @endphp @elseif((int)$totals_am_current>=70) @php $class_2 = "text-warning"; @endphp @else @php $class_2 = "text-danger"; @endphp @endif
                                        @if((int)$totals_pm_current>=100) @php $class_3 = "text-success"; @endphp @elseif((int)$totals_pm_current>=70) @php $class_3 = "text-warning"; @endphp @else @php $class_3 = "text-danger"; @endphp @endif
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">Total</div>
                                            <span class="{{$class_1}}">{{$totals_current}} %</span>
                                        </td>
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">AM</div>
                                            <span class="{{$class_2}}">{{$totals_am_current}} %</span>
                                        </td>
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">PM</div>
                                            <span class="{{$class_3}}">{{$totals_pm_current}} %</span>
                                        </td>
                                    @else
                                        @if((int)$totals>=100) @php $class_1 = "text-success"; @endphp @elseif((int)$totals>=70) @php $class_1 = "text-warning"; @endphp @else @php $class_1 = "text-danger"; @endphp @endif
                                        @if((int)$total_am>=100) @php $class_2 = "text-success"; @endphp @elseif((int)$total_am>=70) @php $class_2 = "text-warning"; @endphp @else @php $class_2 = "text-danger"; @endphp @endif
                                        @if((int)$total_pm>=100) @php $class_3 = "text-success"; @endphp @elseif((int)$total_pm>=70) @php $class_3 = "text-warning"; @endphp @else @php $class_3 = "text-danger"; @endphp @endif
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">Total</div>
                                            <span class="{{$class_1}}">{{$totals}} %</span>
                                        </td>
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">AM</div>
                                            <span class="{{$class_2}}">{{$total_am}} %</span>
                                        </td>
                                        <td class="pivoted text-red">
                                            <div class="tdBefore">PM</div>
                                            <span class="{{$class_3}}">{{$total_pm}} %</span>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-leaflet-table">
                <div class="allebone-staff-details">
                    <table class="breachReasonTable responsiveTable table-weekly-discharges">
                        <thead>
                            <thead>
                                <tr class="position-relative">
                                    <th></th>
                                    @foreach ($success_array["attendance_roles_designations"] as $role_name => $role_data)
                                    <th>{{ $role_data['title'] }}</th>
                                    @endforeach

                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach ($success_array["attendance_roles_designations"] as $role_name => $role_data)
                                    <th>Min {{ $role_data['min_value'] }} Per Week</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </thead>
                        <tbody>
                            @foreach($success_array['boardround_attendance_array'] as $week_name => $attendance_data)
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">BOARD ROUND</div>
                                    {{ucwords(str_replace("_", ' ', $week_name))}}
                                </td>

                                @foreach ($success_array["attendance_roles_designations"] as $key_role => $roles)

                                    <td class="pivoted @if($attendance_data[$key_role] < $roles['min_value'])  bg-performance-amber @else bg-performance-green  @endif ">
                                        <div class="tdBefore">
                                            {{ $roles['title'] }} <span>Min {{ $roles['min_value'] }} Per Week</span></div>
                                            {{$attendance_data[$key_role]}}
                                    </td>
                                @endforeach

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="allebone-patients-card">
                <div class="row gx-2">
                    <div class="col-md-6 mb-2">
                        <div class="box-1">
                            <div class="header">
                                <h6 class="mb-0">Patient LOS</h6>
                            </div>
                            <div class="tasks">
                                <ul>
                                    <li>
                                        <span>LOS 7 To 13 Days</span>
                                        <span>{{ $success_array["total_7_13_count"] }}</span>
                                    </li>
                                    <li>
                                        <span>LOS 14 To 20 Days</span>
                                        <span>{{ $success_array["total_13_20_count"] }}</span>
                                    </li>
                                    <li>
                                        <span>LOS 21+ Days</span>
                                        <span>{{ $success_array["total_21_more_count"] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="box-2">
                            <div class="header">
                                <h6 class="mb-0">Tasks</h6>
                            </div>
                            <div class="tasks">
                                <ul>
                                    <li>
                                        <span>Created</span>
                                        <span>{{$success_array["task_count"]['created']}}</span>
                                    </li>
                                    <li>
                                        <span>Completed</span>
                                        <span>{{$success_array["task_count"]['completed']}}</span>
                                    </li>
                                    <li>
                                        <span>Outstanding</span>
                                        <span>{{$success_array["task_count"]['outstanding']}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mt-1">
                    <div id="ward-data"></div>
                </div>
            </div>
            <div class="allebone-patients-card pb-0">
                <div class="row">
                    <div class="col-lg-4 col-md-4 mb-2 pe-md-1">
                        <div class="avg-los-box">
                            <ul>
                                <li>Average LOS of current inpatients</li>
                                <li>{{$success_array['average_inpatient_los'] ?? '0'}} DAYS</li>
                            </ul>
                            <div class="borderline"></div>
                            <ul>
                                <li>Last 100 Discharges Average LOS</li>
                                <li>{{$success_array['average_outpatient_los'] ?? '0'}} DAYS</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 mb-2 ps-md-1">
                        <div class="row">
                            <div id="patients-data"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 ps-1 pe-1">
                        <div class="content-wrapper">
                            <div class="section-1">
                                <ul>
                                    <li class="main-header">Male</li>
                                    <li class="sub-header">
                                        <div class="cell">
                                            <span>Avg LOS <br> (Last 100 Discharges)</span>
                                        </div>
                                        <div class="cell">
                                            <span>Avg LOS <br> (Current Inpatients)</span>
                                        </div>
                                        <div class="cell">
                                            <span>Inpatients <br> currently on the ward</span>
                                        </div>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["avg_male_disch"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["avg_male"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["male_total"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["avg_male_disch"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["avg_male"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["male_total"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["avg_male_disch"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["avg_male"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["male_total"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["avg_male_disch"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["avg_male"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["male_total"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["avg_male_disch"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["avg_male"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["male_total"] ?? '0'}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="section-2">
                                <ul>
                                    <li></li>
                                    <li class="main-header">
                                        <div>
                                            <span>AGE</span>
                                        </div>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">00 - 25</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">26 - 49</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">50 - 74</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">75 - 84</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">85+</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="section-3">
                                <ul>
                                    <li class="main-header">Female</li>
                                    <li class="sub-header">
                                        <div class="cell">
                                            <span>Inpatients <br> currently on the ward</span>
                                        </div>
                                        <div class="cell">
                                            <span>Avg LOS <br> (Current Inpatients)</span>
                                        </div>
                                        <div class="cell">
                                            <span>Avg LOS <br> (Last 100 Discharges)</span>
                                        </div>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["female_total"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["avg_female"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_25"]["avg_female_disch"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["female_total"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["avg_female"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_26_49"]["avg_female_disch"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["female_total"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["avg_female"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_50_74"]["avg_female_disch"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["female_total"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["avg_female"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_75_84"]["avg_female_disch"] ?? '0'}}</span>
                                    </li>
                                    <li class="row-list">
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["female_total"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["avg_female"] ?? '0'}}</span>
                                        <span class="row-cell">{{$success_array["male_female_wise_data"]["below_85"]["avg_female_disch"] ?? '0'}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Dashboards.Camis.WardPerformance.Script')

