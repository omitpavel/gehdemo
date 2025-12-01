
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
                <div id="weekly" class="tab-pane active show" role="tabpanel">
                    <div class="row">
                      <div class="container-fluid">
                        <div class="col-lg-12">
                          <div class="row gx-2  align-items-center">
                            <div class="col-xl-3 col-md-4 mb-2">
                                <div>
                                    <select class="form-select w-100" aria-label="Default select example"  name="tab1_search_month" id="selected_date">
                                        @foreach($success_array['last_12_month'] as $month)
                                            <option value="{{ $month }}" @if($success_array['selected_date'] == $month) selected @endif>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6 mb-2 offset-lg-4 offset-xl-6 offset-md-2">
                              <div class="filter-btn-grp">
                                <h6 class="mb-0 me-2">Include Weekends</h6>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                  <button type="button" class="btn btn-grp-info include_weekend {{ ($success_array['include_weekend'] == 1) ? 'active' : '' }}" data-include_type="1">YES</button>
                                  <button type="button" class="btn btn-grp-light include_weekend {{ ($success_array['include_weekend'] == 0) ? 'active' : '' }}" data-include_type="0">NO</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-board-round-table">
                            <div class="monthly-board-round">
                              <table class="responsiveTable table-board-round">
                                <thead>
                                  <tr class="position-relative">
                                    <th rowspan="2"></th>
                                    <th colspan="2" class="text-center">
                                      Completed
                                    </th>
                                    <th colspan="2" class="text-center">
                                      Partial
                                    </th>
                                    <th class="text-center">
                                      Not Started
                                    </th>
                                    <th colspan="3" class="text-center">
                                      Completion
                                    </th>
                                  </tr>
                                  <tr>
                                    <th class="bgblue-column">AM</th>
                                    <th class="bgblue-column">PM</th>
                                    <th class="bgblue-column">AM</th>
                                    <th class="bgblue-column">PM</th>
                                    <th class="bgblue-column">Days</th>
                                    <th class="bgblue-column">Total</th>
                                    <th class="bgblue-column">AM</th>
                                    <th class="bgblue-column">PM</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  @foreach ($success_array['month_report'] as $key => $reports)

                                    @php
                                        $number_of_days = ($success_array['number_of_days'] * count($reports));
                                        $completed_boardround = ($number_of_days-array_sum(array_map(function($unit) {
                                        return $unit['not_start']['total'];
                                    }, $reports)));


                                    $overall_pm = ceil((array_sum(array_map(function($unit) {
                                            return $unit['percent']['pm_percent'];
                                        }, $reports)) / $number_of_days) * 100);

                                    $overall_am = ceil((array_sum(array_map(function($unit) {
                                            return $unit['percent']['am_percent'];
                                        }, $reports)) / $number_of_days) * 100);

                                    $overall_total = ceil(($completed_boardround / $number_of_days) * 100);



                                    @endphp


                                  <tr class="ward-header">
                                    <td class="pivoted">
                                      <div class="tdBefore"></div>
                                      {{ ucwords($key) }}
                                    </td>
                                    <td class="pivoted">
                                      <div class="tdBefore">Completed AM</div>
                                      {{ array_sum(array_map(function($unit) {
                                        return $unit['completed']['am'];
                                    }, $reports)) }}
                                    </td>
                                    <td class="pivoted">
                                      <div class="tdBefore">Completed PM</div>
                                      {{ array_sum(array_map(function($unit) {
                                        return $unit['completed']['pm'];
                                    }, $reports)) }}
                                    </td>
                                    <td class="pivoted">
                                      <div class="tdBefore">Partial AM</div>
                                      {{ array_sum(array_map(function($unit) {
                                        return $unit['partial']['am'];
                                    }, $reports)) }}
                                    </td>
                                    <td class="pivoted">
                                      <div class="tdBefore">Partial PM</div>
                                      {{ array_sum(array_map(function($unit) {
                                        return $unit['partial']['pm'];
                                    }, $reports)) }}
                                    </td>
                                    <td class="pivoted">
                                      <div class="tdBefore">Board Round Not Started</div>
                                      {{ array_sum(array_map(function($unit) {
                                        return $unit['not_start']['total'];
                                    }, $reports)) }}

                                    </td>
                                    <td class="completion-row pivoted">
                                      <div class="tdBefore">Completion Total</div>
                                      {{ $overall_total }} %
                                    </td>
                                    <td class="completion-row pivoted">
                                      <div class="tdBefore">Completion AM</div>
                                      {{ $overall_am }} %
                                    </td>
                                    <td class="completion-row pivoted">
                                      <div class="tdBefore">Completion PM</div>
                                      {{ $overall_pm }} %
                                    </td>
                                  </tr>
                                    @foreach ($reports as $ward_name => $report)
                                    <tr>
                                        <td class="pivoted">
                                          <div class="tdBefore"></div>
                                          {{ $ward_name }}
                                        </td>
                                        <td class="pivoted">
                                          <div class="tdBefore">Completed AM</div>
                                          {{ $report['completed']['am'] }}
                                        </td>
                                        <td class="pivoted">
                                          <div class="tdBefore">Completed PM</div>
                                          {{ $report['completed']['pm'] }}
                                        </td>
                                        <td class="pivoted">
                                          <div class="tdBefore">Partial AM</div>
                                          {{ $report['partial']['am'] }}
                                        </td>
                                        <td class="pivoted">
                                          <div class="tdBefore">Partial PM</div>
                                          {{ $report['partial']['pm'] }}
                                        </td>
                                        <td class="pivoted">
                                          <div class="tdBefore">Not Started</div>
                                          {{ $report['not_start']['total'] }}
                                        </td>
                                        <td class="completion-row pivoted">
                                          <div class="tdBefore">Completion Total</div>
                                          {{ $report['percent']['total'] }} %
                                        </td>
                                        <td class="completion-row pivoted">
                                          <div class="tdBefore">Completion AM</div>
                                          {{ $report['percent']['am'] }} %
                                        </td>
                                        <td class="completion-row pivoted">
                                          <div class="tdBefore">Completion PM</div>
                                          {{ $report['percent']['pm'] }} %
                                        </td>
                                      </tr>
                                    @endforeach
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

