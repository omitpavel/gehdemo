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
                        <div id="attendance" class=" tab-pane active">
                            <div class="row mb-3">
                                <div class="container-fluid">
                                    <div class="col-lg-12">
                                        <div class="row mb-2">
                                            <div class="col-lg-3">
                                                <div>
                                                    <select class="form-select" id="attendence_week_data"
                                                            aria-label="Default select example">
                                                        @foreach($success_array['last_12_weeks'] as $week)
                                                            <option value="{{ $week->format('Y-m-d') }}" {{ request()->attendence_week_data == $week->format('Y-m-d') ? 'selected':'' }} >{{PredefinedDateFormatShowOnCalendarDashboard($week)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="board-round-attendance">
                                            <table
                                                class="breachReasonTable responsiveTable table-round-attendance">
                                                <thead>
                                                <tr class="position-relative">
                                                    <th></th>
                                                    @foreach( $success_array['table_heads'] as $key => $table_head)
                                                        <th>
                                                            {{ $table_head['title'] }}
                                                            <span class="sub-title">Min {{ $table_head['min_value'] }} Per Week</span>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="ward-header">
                                                        <td class="pivoted">
                                                          <div class="tdBefore"></div>
                                                          Medical Wards
                                                        </td>
                                                        @foreach( $success_array['roles'] as $roles)
                                                            @php
                                                                $avg_amt = (array_sum(array_column($success_array['attendance']['medical'], $roles))/count($success_array['attendance']['medical']));
                                                            @endphp
                                                        <td class="pivoted @if($avg_amt < ($success_array['table_heads'][$roles]['min_value']*count($success_array['attendance']['medical']))) bg-amber-cell @else bg-green-cell  @endif ">
                                                            <div class="tdBefore">
                                                              {{ $success_array['table_heads'][$roles]['title'] }}
                                                            </div>
                                                            {{ceil($avg_amt)}}
                                                        </td>
                                                        @endforeach
                                                      </tr>
                                                @foreach( $success_array['attendance']['medical'] as $ward => $attendece_data)
                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore"></div>
                                                            {{ $ward }}
                                                        </td>
                                                        @foreach( $success_array['table_heads'] as $key => $roles)
                                                            <td class="pivoted @if($attendece_data[$key] < $roles['min_value']) bg-amber-cell @else bg-green-cell  @endif ">
                                                                <div class="tdBefore">
                                                                  {{ $success_array['table_heads'][$key]['title'] }}
                                                                </div>
                                                                {{$attendece_data[$key]}}
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                                <tr class="ward-header">
                                                    <td class="pivoted">
                                                      <div class="tdBefore"></div>
                                                      Surgical Wards
                                                    </td>
                                                    @foreach( $success_array['roles'] as $roles)
                                                        @php
                                                            $avg_amt = (array_sum(array_column($success_array['attendance']['surgical'], $roles))/count($success_array['attendance']['surgical']));
                                                        @endphp
                                                    <td class="pivoted @if($avg_amt < ($success_array['table_heads'][$roles]['min_value']*count($success_array['attendance']['surgical']))) bg-amber-cell @else bg-green-cell  @endif ">
                                                        <div class="tdBefore">
                                                          {{ $success_array['table_heads'][$roles]['title'] }}
                                                        </div>
                                                        {{ceil($avg_amt)}}
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                @foreach( $success_array['attendance']['surgical'] as $ward => $attendece_data)
                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore"></div>
                                                            {{ $ward }}
                                                        </td>

                                                        @foreach( $success_array['table_heads'] as $key => $roles)
                                                            <td class="pivoted @if($attendece_data[$key] < $roles['min_value']) bg-amber-cell @else bg-green-cell  @endif ">
                                                                <div class="tdBefore">
                                                                  {{ $success_array['table_heads'][$key]['title'] }}
                                                                </div>
                                                                {{$attendece_data[$key]}}
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                                <tr class="ward-header">
                                                    <td class="pivoted">
                                                      <div class="tdBefore"></div>
                                                      Others Wards
                                                    </td>
                                                    @foreach( $success_array['roles'] as $roles)
                                                        @php
                                                            $avg_amt = (array_sum(array_column($success_array['attendance']['others'], $roles))/count($success_array['attendance']['others']));
                                                        @endphp
                                                    <td class="pivoted @if($avg_amt < ($success_array['table_heads'][$roles]['min_value']*count($success_array['attendance']['others']))) bg-amber-cell @else bg-green-cell  @endif ">
                                                        <div class="tdBefore">
                                                          {{ $success_array['table_heads'][$key]['title'] }}
                                                        </div>
                                                        {{ceil($avg_amt)}}
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                @foreach( $success_array['attendance']['others'] as $ward => $attendece_data)
                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore"></div>
                                                            {{ $ward }}
                                                        </td>

                                                        @foreach( $success_array['table_heads'] as $key => $roles)
                                                            <td class="pivoted @if($attendece_data[$key] < $roles['min_value']) bg-amber-cell @else bg-green-cell  @endif ">
                                                                <div class="tdBefore">
                                                                  {{ $success_array['table_heads'][$key]['title'] }}
                                                                </div>
                                                                {{$attendece_data[$key]}}
                                                            </td>
                                                        @endforeach

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




