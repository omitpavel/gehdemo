

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
                        <div id="today" class=" tab-pane active">
                            <div class="row mb-3">
                                <div class="container-fluid">
                                    <div class="col-lg-12">
                                        <div class="row gx-2 date-range">
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <div>
                                                    {!! AllWardListDropdown('ward_id') !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Date From
                                                    </span>
                                                    <input type="text" class="form-control" aria-describedby="basic-addon1"
                                                           id="daterangepicker">
                                                    <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
                                                    <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div >
                                            <div class="board-round-today">
                                                <table
                                                    class="breachReasonTable responsiveTable table-round-attendance">
                                                    <thead>
                                                    <tr class="position-relative">
                                                        <th>User Name</th>
                                                        <th>Ward</th>
                                                        <th>Status</th>
                                                        <th>Role</th>
                                                        <th>Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($success_array['ward_round_history'] as $data)
                                                        <tr>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">User Name</div>
                                                                {{ Sentinel::findById($data->user_id)->username }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Ward</div>
                                                                {{ $data->Ward->ward_name }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Status</div>
                                                                {{ $data->status == 1 ? "Completed":"Partial" }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Role</div>
                                                                {{ str_replace(',', ', ', $data->role)  }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Time</div>
                                                                {{PredefinedDateFormatFor24Hour($data->created_at)}}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="pivoted text-center message-no-data">
                                                                No Records Found!
                                                            </td>
                                                        </tr>
                                                    @endforelse

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


