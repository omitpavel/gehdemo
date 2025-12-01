

@php
    use Carbon\Carbon;
@endphp
<div class="row mb-3">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12" id="custom-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_current_week_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_current_week_view') }} tab-custom-btn @if ( $success_array['tab_type'] == 'current') active @endif"
                               onclick="TabType('current');" data-bs-toggle="tab" href="#current">
                                <div class="tab-active">Current
                                    Week</div> </a>
                        </li>

                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_week_summary_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_week_summary_view') }} tab-custom-btn @if ($success_array['tab_type'] == 'week') active @endif" data-bs-toggle="tab"
                               href="#weekly" onclick="TabType('week');">
                                <div class="tab-active" >Week Summary</div>

                            </a>
                        </li>
                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_month_summary_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_month_summary_view') }} tab-custom-btn @if ($success_array['tab_type'] == 'month') active @endif" data-bs-toggle="tab"
                               href="#weekly" onclick="MonthSummaryTabClick(1);">
                                <div class="tab-active" >Month Summary</div>

                            </a>
                        </li>
                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_attendance_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_attendance_view') }} tab-custom-btn @if ($success_array['tab_type'] == 'attendence') active @endif" data-bs-toggle="tab"
                               onclick="TabType('attendence');" href="#attendance"><div class="tab-active">Attendance
                                </div>
                            </a>
                        </li>
                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_today_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_today_view') }} tab-custom-btn @if ($success_array['tab_type'] == 'today') active @endif" data-bs-toggle="tab"
                               href="#today" onclick="TabType('today');">
                                <div class="tab-active">Today</div>
                            </a>
                        </li>
                        <li class="mb-2 {{ PermissionDeniedDiv('board_round_dashboard_all_view') }}">
                            <a class="{{ DisabledButtonOnRolePermission('board_round_dashboard_all_view') }} tab-custom-btn @if ($success_array['tab_type'] == 'all') active @endif" data-bs-toggle="tab"
                               href="#all" onclick="TabType('all');">
                                <div class="tab-active">All</div>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabcontent">
                        <input type="hidden" id="tab_type" value="{{  $success_array['tab_type'] }}">
                        <div id="weekly" class=" tab-pane active ">
                            <div class="row mb-3">
                                <div class="container-fluid">
                                    <div class="col-lg-12">
                                        <div class="row mb-2">
                                            <div class="col-lg-3">
                                                <div>
                                                    <select class="form-select" id="attendence_week_date"
                                                            aria-label="Default select example">
                                                        @foreach($success_array['last_12_weeks'] as $week)
                                                            <option value="{{ $week->format('Y-m-d') }}" {{ request()->attendence_week_date == $week->format('Y-m-d') ? 'selected':'' }} >{{PredefinedDateFormatShowOnCalendarDashboard($week)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-board-round-table">
                                            <div class="board-round">
                                                <table
                                                    class="breachReasonTable responsiveTable table-board-round">
                                                    <thead>
                                                        <tr class="position-relative">
                                                            <th rowspan="2"></th>
                                                            @foreach($success_array['weekly_days'] as $week_day)

                                                            <th colspan="2" @if((date('Y-m-d', strtotime($week_day)) === date('Y-m-d'))) class="current-date" @endif>{{PredefinedDateFormatShowOnCalendarDashboard($week_day)}}</th>
                                                            @endforeach

                                                            <th colspan="3" class="text-center">Competition
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th> AM </th>
                                                            <th> PM </th>
                                                            <th> AM </th>
                                                            <th> PM </th>
                                                            <th> AM </th>
                                                            <th> PM </th>
                                                            <th> AM </th>
                                                            <th> PM </th>
                                                            <th> AM </th>
                                                            <th> PM </th>
                                                            <th class="bgblue-column">Total</th>
                                                            <th class="bgblue-column">AM</th>
                                                            <th class="bgblue-column">PM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                                $medical_am_total = 0;
                                                                $medical_pm_total = 0;
                                                                $medical_avg_total = 0;
                                                                $medical_week_days = 0;
                                                                $medical_am_total_current = 0;
                                                                $medical_pm_total_current = 0;
                                                                $medical_avg_total_current = 0;
                                                        @endphp
                                                    @foreach ($success_array['weekly_summery_data']['medical'] as $ward => $week_data)


                                                    @foreach ($week_data as $key => $each)
                                                            @php
                                                                $medical_overall[$each['date']]['am_status'][] = $each['am_status'];
                                                                $medical_overall[$each['date']]['pm_status'][] = $each['pm_status'];


                                                            @endphp
                                                        @endforeach
                                                    @endforeach

                                                    <tr class="ward-header">
                                                        <td class="pivoted">
                                                            <div class="tdBefore"></div>
                                                            Medical Wards
                                                        </td>

                                                        @foreach ($medical_overall as $date_key =>  $med_data)

                                                            @php
                                                                if (!ContainsNumberInAmStatus($med_data, 'am', 0)){
                                                                    $medical_am_total += 20;
                                                                    if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                        $medical_am_total_current++;
                                                                    }


                                                                }
                                                                if (!ContainsNumberInAmStatus($med_data, 'pm', 0)){
                                                                    $medical_pm_total += 20;
                                                                    if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                        $medical_pm_total_current++;
                                                                    }
                                                                }
                                                                if(!ContainsNumberInAmStatus($med_data, 'am', 0) || !ContainsNumberInAmStatus($med_data, 'pm', 0)){
                                                                    $medical_avg_total += 20;
                                                                    if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                        $medical_avg_total_current++;
                                                                    }

                                                                }
                                                            @endphp




                                                            <td class="pivoted">
                                                                <div class="tdBefore">
                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                    - AM
                                                                </div>
                                                                @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                                <div class="column-1" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="N/A">   -- </div>
                                                                @else
                                                                    @if (ContainsNumberInAmStatus($med_data, 'am', 0))
                                                                        <div class="column-1" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                alt="">
                                                                            <span>None</span>
                                                                        </div>
                                                                    @elseif (ContainsNumberInAmStatus($med_data, 'am', 2) && !ContainsNumberInAmStatus($med_data, 'am', 0) )
                                                                        <div class="column-1 "  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Partial Board Round">
                                                                            <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Partial</span>
                                                                        </div>
                                                                    @elseif (!ContainsNumberInAmStatus($med_data, 'am', 2) && !ContainsNumberInAmStatus($med_data, 'am', 0))
                                                                            <div class="column-1"  data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                    alt="">
                                                                                <span>Complete</span>
                                                                            </div>
                                                                    @endif
                                                                    @php
                                                                        $medical_week_days++;
                                                                    @endphp
                                                                @endif

                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">
                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                    - PM
                                                                </div>
                                                                @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                                <div class="column-2" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="N/A">  -- </div>
                                                                @else
                                                                    @if (ContainsNumberInAmStatus($med_data, 'pm', 0))
                                                                        <div class="column-2" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                alt="">
                                                                            <span>None</span>
                                                                        </div>
                                                                    @elseif (ContainsNumberInAmStatus($med_data, 'pm', 2) && !ContainsNumberInAmStatus($med_data, 'pm', 0) )
                                                                        <div class="column-2 "  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Partial Board Round">
                                                                            <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Partial</span>
                                                                        </div>
                                                                    @elseif (!ContainsNumberInAmStatus($med_data, 'pm', 2) && !ContainsNumberInAmStatus($med_data, 'pm', 0))
                                                                            <div class="column-2"  data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                    alt="">
                                                                                <span>Complete</span>
                                                                            </div>
                                                                    @endif
                                                                @endif
                                                            </td>

                                                        @endforeach



                                                            @php
                                                                $medical_totals_current = PercentageCalculationOfValues($medical_avg_total_current, $medical_week_days, 2);
                                                                $medical_totals_am_current = PercentageCalculationOfValues($medical_am_total_current, $medical_week_days, 2);
                                                                $medical_totals_pm_current = PercentageCalculationOfValues($medical_pm_total_current, $medical_week_days, 2);
                                                            @endphp

                                                            <td class="completion-row pivoted text-center">
                                                                <div class="tdBefore">
                                                                    Total
                                                                </div>
                                                                {{$medical_totals_current}}%
                                                            </td>
                                                            <td class="completion-row pivoted text-center">
                                                                <div class="tdBefore">
                                                                AM
                                                                </div>
                                                                {{$medical_totals_am_current}}%
                                                            </td>
                                                            <td class="completion-row pivoted text-center">
                                                                <div class="tdBefore">
                                                                    PM
                                                                </div>
                                                                {{$medical_totals_pm_current }}%
                                                            </td>


                                                        </tr>

                                                        </tr>

                                                            @foreach ($success_array['weekly_summery_data']['medical'] as $ward => $week_data)

                                                                <tr>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore"></div>
                                                                        {{ $ward }}
                                                                    </td>
                                                                    @php
                                                                        $total_am           = 0;
                                                                        $total_pm           = 0;
                                                                        $totals             = 0;
                                                                        $current_am         = 0;
                                                                        $current_pm         = 0;
                                                                        $current_total      = 0;
                                                                    @endphp

                                                                    @foreach ($week_data as $key => $each)

                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - AM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-1" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A">  -- </div>
                                                                                @else
                                                                                    @if ($each['am'] == '00:00' || $each['am'] == '00:00:00')
                                                                                        <div class="column-1" data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                alt="">
                                                                                            <span>None</span>
                                                                                        </div>
                                                                                    @else

                                                                                        @if ($each['am_status'] == 1)
                                                                                            <div class="column-1"  data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['am'] }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="column-1 @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"  data-time="am">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['am'] }}</span>
                                                                                            </div>
                                                                                        @endif

                                                                                    @endif
                                                                                @endif

                                                                            </td>
                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - PM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-2" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A"> -- </div>
                                                                                @else
                                                                                    @if ($each['pm'] == '00:00' || $each['pm'] == '00:00:00')
                                                                                        <div class="column-2" data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                alt="">
                                                                                            <span>None</span>
                                                                                        </div>
                                                                                    @else
                                                                                        @if ($each['pm_status'] == 1)
                                                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['pm'] }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="column-2  @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"   data-time="pm">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['pm'] }}</span>
                                                                                            </div>
                                                                                        @endif

                                                                                    @endif
                                                                                @endif
                                                                            </td>
                                                                            @php
                                                                                $total_am           += $each['am_percentage_total'];
                                                                                $total_pm           += $each['pm_percentage_total'];
                                                                                $totals             += $each['total'];
                                                                                if ($each['am_status'] != 0){
                                                                                    $current_am++;
                                                                                }
                                                                                if ($each['pm_status'] != 0){
                                                                                    $current_pm++;
                                                                                }
                                                                                if ($each['am_status'] != 0 || $each['pm_status'] != 0){
                                                                                    $current_total++;
                                                                                }
                                                                            @endphp
                                                                    @endforeach

                                                                    @php
                                                                        $totals_current = PercentageCalculationOfValues($current_total, $medical_week_days, 2);
                                                                        $totals_am_current = PercentageCalculationOfValues($current_am, $medical_week_days, 2);
                                                                        $totals_pm_current = PercentageCalculationOfValues($current_pm, $medical_week_days, 2);


                                                                        if ((int) $totals_current >= 100) {
                                                                            $class_1 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_current >= 70) {
                                                                            $class_1 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_1 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_am_current >= 100) {
                                                                            $class_2 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_am_current >= 70) {
                                                                            $class_2 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_2 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_pm_current >= 100) {
                                                                            $class_3 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_pm_current >= 70) {
                                                                            $class_3 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_3 = 'percentage_red_am';
                                                                        }
                                                                    @endphp

                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            Total</div>
                                                                        {{ $totals_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            AM</div>
                                                                        {{ $totals_am_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            PM</div>
                                                                        {{ $totals_pm_current }}%
                                                                    </td>
                                                                </tr>
                                                            @endforeach



                                                            @php
                                                                $surgical_am_total = 0;
                                                                $surgical_pm_total = 0;
                                                                $surgical_avg_total = 0;
                                                                $surgical_am_total_current = 0;
                                                                $surgical_pm_total_current = 0;
                                                                $surgical_avg_total_current = 0;
                                                        @endphp
                                                @foreach ($success_array['weekly_summery_data']['surgical'] as $ward => $week_data)


                                                @foreach ($week_data as $key => $each)
                                                        @php
                                                            $surgical_overall[$each['date']]['am_status'][] = $each['am_status'];
                                                            $surgical_overall[$each['date']]['pm_status'][] = $each['pm_status'];


                                                        @endphp
                                                    @endforeach
                                                @endforeach

                                                <tr class="ward-header">
                                                    <td class="pivoted">
                                                        <div class="tdBefore"></div>
                                                        Surgical Wards
                                                    </td>


                                                    @foreach ($surgical_overall as $date_key =>  $surg_data)

                                                        @php
                                                            if (!ContainsNumberInAmStatus($surg_data, 'am', 0)){
                                                                $surgical_am_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $surgical_am_total_current++;
                                                                }
                                                            }
                                                            if (!ContainsNumberInAmStatus($surg_data, 'pm', 0)){
                                                                $surgical_pm_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $surgical_pm_total_current++;
                                                                }
                                                            }
                                                            if(!ContainsNumberInAmStatus($surg_data, 'am', 0) || !ContainsNumberInAmStatus($surg_data, 'pm', 0)){
                                                                $surgical_avg_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $surgical_avg_total_current++;
                                                                }
                                                            }
                                                        @endphp
                                                          <td class="pivoted">
                                                            <div class="tdBefore">
                                                                {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                - AM
                                                            </div>
                                                            @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                            <div class="column-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="N/A">   -- </div>
                                                            @else
                                                                @if (ContainsNumberInAmStatus($surg_data, 'am', 0))
                                                                    <div class="column-1" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="No Board Round ">
                                                                        <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                            alt="">
                                                                        <span>None</span>
                                                                    </div>
                                                                @elseif (ContainsNumberInAmStatus($surg_data, 'am', 2) && !ContainsNumberInAmStatus($surg_data, 'am', 0) )
                                                                    <div class="column-1 "  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Partial Board Round">
                                                                        <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                            alt="">
                                                                        <span>Partial</span>
                                                                    </div>
                                                                @elseif (!ContainsNumberInAmStatus($surg_data, 'am', 2) && !ContainsNumberInAmStatus($surg_data, 'am', 0))
                                                                        <div class="column-1"  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Board Round Completed">
                                                                            <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Complete</span>
                                                                        </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">
                                                                {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                - PM
                                                            </div>
                                                            @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="N/A">   -- </div>
                                                            @else
                                                                @if (ContainsNumberInAmStatus($surg_data, 'pm', 0))
                                                                    <div class="column-2" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="No Board Round ">
                                                                        <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                            alt="">
                                                                        <span>None</span>
                                                                    </div>
                                                                @elseif (ContainsNumberInAmStatus($surg_data, 'pm', 2) && !ContainsNumberInAmStatus($surg_data, 'pm', 0) )
                                                                    <div class="column-2 "  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Partial Board Round">
                                                                        <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                            alt="">
                                                                        <span>Partial</span>
                                                                    </div>
                                                                @elseif (!ContainsNumberInAmStatus($surg_data, 'pm', 2) && !ContainsNumberInAmStatus($surg_data, 'pm', 0))
                                                                        <div class="column-2"  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Board Round Completed">
                                                                            <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Complete</span>
                                                                        </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endforeach



                                                    @php
                                                        $surgical_totals_current = PercentageCalculationOfValues($surgical_avg_total_current, $medical_week_days, 2);
                                                        $surgical_totals_am_current = PercentageCalculationOfValues($surgical_am_total_current, $medical_week_days, 2);
                                                        $surgical_totals_pm_current = PercentageCalculationOfValues($surgical_pm_total_current, $medical_week_days, 2);
                                                    @endphp

                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                            Total
                                                        </div>
                                                        {{$surgical_totals_current}}%
                                                    </td>
                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                        AM
                                                        </div>
                                                        {{$surgical_totals_am_current}}%
                                                    </td>
                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                            PM
                                                        </div>
                                                        {{$surgical_totals_pm_current}}%
                                                    </td>

                                                </tr>




                                                            @foreach ($success_array['weekly_summery_data']['surgical'] as $ward => $week_data)

                                                                <tr>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore"></div>
                                                                        {{ $ward }}
                                                                    </td>
                                                                    @php
                                                                        $total_am           = 0;
                                                                        $total_pm           = 0;
                                                                        $totals             = 0;
                                                                        $current_am         = 0;
                                                                        $current_pm         = 0;
                                                                        $current_total      = 0;
                                                                    @endphp

                                                                    @foreach ($week_data as $key => $each)

                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - AM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-1" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A">   -- </div>
                                                                                @else
                                                                                    @if ($each['am'] == '00:00' || $each['am'] == '00:00:00')
                                                                                        <div class="column-1" data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                alt="">
                                                                                            <span>None</span>
                                                                                        </div>
                                                                                    @else

                                                                                        @if ($each['am_status'] == 1)
                                                                                            <div class="column-1"  data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['am'] }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="column-1 @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"  data-time="am">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['am'] }}</span>
                                                                                            </div>
                                                                                        @endif

                                                                                    @endif
                                                                                @endif

                                                                            </td>
                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - PM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-2" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A">   --</div>
                                                                                @else
                                                                                    @if ($each['pm'] == '00:00' || $each['pm'] == '00:00:00')
                                                                                        <div class="column-2" data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom" title="No Board Round ">
                                                                                            <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                alt="">
                                                                                            <span>None</span>
                                                                                        </div>
                                                                                    @else
                                                                                        @if ($each['pm_status'] == 1)
                                                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Board Round Completed">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['pm'] }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="column-2  @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"   data-time="pm">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>{{ $each['pm'] }}</span>
                                                                                            </div>
                                                                                        @endif

                                                                                    @endif
                                                                                @endif
                                                                            </td>
                                                                            @php
                                                                                $total_am           += $each['am_percentage_total'];
                                                                                $total_pm           += $each['pm_percentage_total'];
                                                                                $totals             += $each['total'];
                                                                                if ($each['am_status'] != 0){
                                                                                    $current_am++;
                                                                                }
                                                                                if ($each['pm_status'] != 0){
                                                                                    $current_pm++;
                                                                                }
                                                                                if ($each['am_status'] != 0 || $each['pm_status'] != 0){
                                                                                    $current_total++;
                                                                                }

                                                                            @endphp
                                                                    @endforeach

                                                                    @php
                                                                        $totals_current = PercentageCalculationOfValues($current_total, $medical_week_days, 2);
                                                                        $totals_am_current = PercentageCalculationOfValues($current_am, $medical_week_days, 2);
                                                                        $totals_pm_current = PercentageCalculationOfValues($current_pm, $medical_week_days, 2);


                                                                        if ((int) $totals_current >= 100) {
                                                                            $class_1 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_current >= 70) {
                                                                            $class_1 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_1 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_am_current >= 100) {
                                                                            $class_2 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_am_current >= 70) {
                                                                            $class_2 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_2 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_pm_current >= 100) {
                                                                            $class_3 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_pm_current >= 70) {
                                                                            $class_3 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_3 = 'percentage_red_am';
                                                                        }
                                                                    @endphp

                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            Total</div>
                                                                        {{ $totals_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            AM</div>
                                                                        {{ $totals_am_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            PM</div>
                                                                        {{ $totals_pm_current }}%
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            @php
                                                            $others_am_total = 0;
                                                            $others_pm_total = 0;
                                                            $others_avg_total = 0;
                                                            $others_am_total_current = 0;
                                                            $others_pm_total_current = 0;
                                                            $others_avg_total_current = 0;
                                                    @endphp
                                                @foreach ($success_array['weekly_summery_data']['others'] as $ward => $week_data)


                                                @foreach ($week_data as $key => $each)
                                                        @php
                                                            $others_overall[$each['date']]['am_status'][] = $each['am_status'];
                                                            $others_overall[$each['date']]['pm_status'][] = $each['pm_status'];


                                                        @endphp
                                                    @endforeach
                                                @endforeach

                                                <tr class="ward-header">
                                                    <td class="pivoted">
                                                        <div class="tdBefore"></div>
                                                        Others Wards
                                                    </td>


                                                    @foreach ($others_overall as $date_key =>  $oth_data)
                                                        @php
                                                            if (!ContainsNumberInAmStatus($oth_data, 'am', 0)){
                                                                $others_am_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $others_am_total_current++;
                                                                }
                                                            }
                                                            if (!ContainsNumberInAmStatus($oth_data, 'pm', 0)){
                                                                $others_pm_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $others_pm_total_current++;
                                                                }
                                                            }
                                                            if(!ContainsNumberInAmStatus($oth_data, 'am', 0) || !ContainsNumberInAmStatus($oth_data, 'pm', 0)){
                                                                $others_avg_total += 20;
                                                                if (Carbon::parse($date_key)->lte(Carbon::today())){
                                                                    $others_avg_total_current++;
                                                                }
                                                            }
                                                        @endphp
                                                          <td class="pivoted">
                                                            <div class="tdBefore">
                                                                {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                - AM
                                                            </div>
                                                            @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                            <div class="column-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="N/A"> --</div>
                                                            @else
                                                                @if (ContainsNumberInAmStatus($oth_data, 'am', 0))
                                                                    <div class="column-1" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="No Board Round ">
                                                                        <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                            alt="">
                                                                        <span>None</span>
                                                                    </div>
                                                                @elseif (ContainsNumberInAmStatus($oth_data, 'am', 2) && !ContainsNumberInAmStatus($oth_data, 'am', 0) )
                                                                    <div class="column-1 "  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Partial Board Round">
                                                                        <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                            alt="">
                                                                        <span>Partial</span>
                                                                    </div>
                                                                @elseif (!ContainsNumberInAmStatus($oth_data, 'am', 2) && !ContainsNumberInAmStatus($oth_data, 'am', 0))
                                                                        <div class="column-1"  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Board Round Completed">
                                                                            <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Complete</span>
                                                                        </div>
                                                                @endif
                                                            @endif

                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">
                                                                {{ PredefinedDateFormatShowOnCalendarDashboard($date_key) }}
                                                                - PM
                                                            </div>
                                                            @if (Carbon::parse($date_key)->gt(Carbon::today()))
                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="N/A">  --</div>
                                                            @else
                                                                @if (ContainsNumberInAmStatus($oth_data, 'pm', 0))
                                                                    <div class="column-2" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="No Board Round ">
                                                                        <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                            alt="">
                                                                        <span>None</span>
                                                                    </div>
                                                                @elseif (ContainsNumberInAmStatus($oth_data, 'pm', 2) && !ContainsNumberInAmStatus($oth_data, 'pm', 0) )
                                                                    <div class="column-2 "  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Partial Board Round">
                                                                        <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                            alt="">
                                                                        <span>Partial</span>
                                                                    </div>
                                                                @elseif (!ContainsNumberInAmStatus($oth_data, 'pm', 2) && !ContainsNumberInAmStatus($oth_data, 'pm', 0))
                                                                        <div class="column-2"  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Board Round Completed">
                                                                            <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                alt="">
                                                                            <span>Complete</span>
                                                                        </div>
                                                                @endif
                                                            @endif
                                                        </td>

                                                    @endforeach



                                                    @php
                                                        $others_totals_current = PercentageCalculationOfValues($others_avg_total_current, $medical_week_days, 2);
                                                        $others_totals_am_current = PercentageCalculationOfValues($others_am_total_current, $medical_week_days, 2);
                                                        $others_totals_pm_current = PercentageCalculationOfValues($others_pm_total_current, $medical_week_days, 2);
                                                    @endphp

                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                            Total
                                                        </div>
                                                        {{$others_totals_current}}%
                                                    </td>
                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                        AM
                                                        </div>
                                                        {{$others_totals_am_current}}%
                                                    </td>
                                                    <td class="completion-row pivoted text-center">
                                                        <div class="tdBefore">
                                                            PM
                                                        </div>
                                                        {{$others_totals_pm_current}}%
                                                    </td>

                                                </tr>
                                                            @foreach ($success_array['weekly_summery_data']['others'] as $ward => $week_data)

                                                                <tr>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore"></div>
                                                                        {{ $ward }}
                                                                    </td>
                                                                    @php
                                                                        $total_am           = 0;
                                                                        $total_pm           = 0;
                                                                        $totals             = 0;
                                                                        $current_am         = 0;
                                                                        $current_pm         = 0;
                                                                        $current_total      = 0;
                                                                    @endphp

                                                                    @foreach ($week_data as $key => $each)

                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - AM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-1" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A">  -- </div>
                                                                                @else
                                                                                        @if ($each['am'] == '00:00' || $each['am'] == '00:00:00')
                                                                                            <div class="column-1" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="No Board Round ">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>None</span>
                                                                                            </div>
                                                                                        @else

                                                                                            @if ($each['am_status'] == 1)
                                                                                                <div class="column-1"  data-bs-toggle="tooltip"
                                                                                                data-bs-placement="bottom" title="Board Round Completed">
                                                                                                    <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                        alt="">
                                                                                                    <span>{{ $each['am'] }}</span>
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="column-1 @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                                data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"  data-time="am">
                                                                                                    <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                        alt="">
                                                                                                    <span>{{ $each['am'] }}</span>
                                                                                                </div>
                                                                                            @endif

                                                                                        @endif
                                                                                @endif
                                                                            </td>
                                                                            <td class="pivoted">
                                                                                <div class="tdBefore">
                                                                                    {{ PredefinedDateFormatShowOnCalendarDashboard($each['date']) }}
                                                                                    - PM
                                                                                </div>
                                                                                @if (Carbon::parse($key)->gt(Carbon::today()))
                                                                                <div class="column-2" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="N/A"> --</div>
                                                                                @else
                                                                                        @if ($each['pm'] == '00:00' || $each['pm'] == '00:00:00')
                                                                                            <div class="column-2" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="bottom" title="No Board Round ">
                                                                                                <img src="{{ asset('asset_v2/Template/icons/red-circle.svg') }}"
                                                                                                    alt="">
                                                                                                <span>None</span>
                                                                                            </div>
                                                                                        @else
                                                                                            @if ($each['pm_status'] == 1)
                                                                                                <div class="column-2" data-bs-toggle="tooltip"
                                                                                                data-bs-placement="bottom" title="Board Round Completed">
                                                                                                    <img src="{{ asset('asset_v2/Template/icons/green-circle.svg') }}"
                                                                                                        alt="">
                                                                                                    <span>{{ $each['pm'] }}</span>
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="column-2  @if(!empty($each['board_round_session'])) click_view_parital_data cursor_pointer @endif" @if(empty($each['board_round_session'])) onclick="toastr.warning('No Data Exists');" @endif data-bs-toggle="tooltip"
                                                                                                data-bs-placement="bottom" title="Partial Board Round"  data-date="{{ $each['date'] }}"  data-ward-id="{{ $each['ward_id'] }}" data-session-id="{{ $each['board_round_session'] }}"   data-time="pm">
                                                                                                    <img src="{{ asset('asset_v2/Template/icons/amber-circle.svg') }}"
                                                                                                        alt="">
                                                                                                    <span>{{ $each['pm'] }}</span>
                                                                                                </div>
                                                                                            @endif

                                                                                        @endif
                                                                                @endif
                                                                            </td>
                                                                            @php
                                                                                $total_am           += $each['am_percentage_total'];
                                                                                $total_pm           += $each['pm_percentage_total'];
                                                                                $totals             += $each['total'];
                                                                                if ($each['am_status'] != 0){
                                                                                        $current_am++;
                                                                                    }
                                                                                    if ($each['pm_status'] != 0){
                                                                                        $current_pm++;
                                                                                    }
                                                                                    if ($each['am_status'] != 0 || $each['pm_status'] != 0){
                                                                                        $current_total++;
                                                                                    }
                                                                            @endphp
                                                                    @endforeach

                                                                    @php
                                                                        $totals_current = PercentageCalculationOfValues($current_total, $medical_week_days, 2);
                                                                        $totals_am_current = PercentageCalculationOfValues($current_am, $medical_week_days, 2);
                                                                        $totals_pm_current = PercentageCalculationOfValues($current_pm, $medical_week_days, 2);


                                                                        if ((int) $totals_current >= 100) {
                                                                            $class_1 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_current >= 70) {
                                                                            $class_1 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_1 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_am_current >= 100) {
                                                                            $class_2 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_am_current >= 70) {
                                                                            $class_2 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_2 = 'percentage_red_am';
                                                                        }
                                                                        if ((int) $totals_pm_current >= 100) {
                                                                            $class_3 = 'percentage_green_total';
                                                                        } elseif ((int) $totals_pm_current >= 70) {
                                                                            $class_3 = 'percentage_yellow_total';
                                                                        } else {
                                                                            $class_3 = 'percentage_red_am';
                                                                        }
                                                                    @endphp

                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            Total</div>
                                                                        {{ $totals_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            AM</div>
                                                                        {{ $totals_am_current }}%
                                                                    </td>
                                                                    <td class="completion-row pivoted text-center">
                                                                        <div class="tdBefore">
                                                                            PM</div>
                                                                        {{ $totals_pm_current }}%
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



