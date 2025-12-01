
<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<input type="hidden" id="camis_comment_user_id" value="">
<input type="hidden" id="surgical_comment_id" value="">
<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12">
            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('flow_dashboard_red_bed_view') }}">
                      <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_view') }}"  onclick="ReasonListLoad();">
                        <div class="tab-active">Red Reasons</div>
                      </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('flow_dashboard_redbed_performance_view') }}">
                      <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('flow_dashboard_redbed_performance_view') }}" onclick="PerformanceTabReset();">
                        <div class="tab-active">Performance</div>
                      </a>
                    </li>
                </ul>
                <div class="filters-red-reason" id="filtersRedReasons">
                    <div class="row gx-2 ">
                        <div class="col-lg-3 col-md-3 mb-2">
                            {!! AllWardListDropdown('ward_id') !!}
                        </div>
                        <div class="col-lg-3 col-md-3 mb-2">
                            <select class="form-select" aria-label="Default select example" id="reason_id">
                                <option value="">All Reason</option>
                                @php
                                    $currentGroup = '';
                                @endphp

                                @foreach ($success_array['red_bed_reason'] as $key => $value)
                                    @php
                                        $group = '';
                                        if (strpos($value, 'Diagnostics') === 0) {
                                            $group = 'Diagnostics';
                                        } elseif (strpos($value, 'Discharge Plan') === 0) {
                                            $group = 'Discharge Plan';
                                        } elseif (strpos($value, 'Clinical Review') === 0) {
                                            $group = 'Clinical Review';
                                        } elseif (strpos($value, 'No Reason') === 0) {
                                            $group = 'No Reason';
                                        }
                                    @endphp
                                    @if ($group != $currentGroup)
                                        @if(!empty($group))
                                            <option label="{{ $group }}" class="optionGroup" value="@php echo $currentGroup = $group; @endphp" @if ($success_array['selected_reason_id'] == $currentGroup || $success_array['selected_reason_id'] == $group) selected @endif>
                                                @php
                                                    $currentGroup = $group;
                                                @endphp
                                                {{ $group }}
                                            </option>
                                        @endif
                                    @endif
                                    @if(!empty($key))
                                        <option value="{{ $key }}" @if ($success_array['selected_reason_id'] == $key) selected @endif>
                                            {{ $value }}</option>
                                    @endif
                                @endforeach

                            </select>




                        </div>
                        <div class="col-lg-3 col-md-4 col-8 offset-lg-1 mb-2">
                            <div class="bg-patients-count">
                                <h6>Total Patients</h6>
                                <h5>{{ $success_array['total_patient'] }}</h5>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-4 mb-2">
                            <a class="btn btn-export w-100" href="{{ route('red.bed.export') }}?ward_id={{ implode(',', $success_array['selected_ward_id']) }}&reason_id={{ $success_array['selected_reason_id'] }}"><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" width="16"
                                class="me-3">Export</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tabcontent">
                <div id="redReasons" class=" tab-pane active">
                    @if (!empty($success_array['patients_list']))
                        <div class="other-dashboard-contents">
                            <div class="bg-sticky" id="hideBgSticky"></div>
                            @foreach ($success_array['patients_list'] as $ward => $patient_details)
                                <div class="patients-details">
                                    <div class="wards-patients-details ward_id_{{ str_replace(' ', '_', $ward) }}">
                                        <div class="sticky-header">
                                            <div class="name-header">
                                                <span>{{ $ward }}</span>
                                            </div>
                                        </div>
                                        <div class="custom-card">
                                            <table class="breachReasonTable responsiveTable table-custom patient_list_{{ str_replace(' ', '_', $ward) }}" id="count_content">
                                                @foreach ($patient_details as $patient)

                                                    <tbody class="table-patient-tbody remove_patient_id_{{ $patient['camis_patient_id'] }}">
                                                        <tr class="table-patient-row-1">

                                                            <td class="pivoted">
                                                                <div class="tdBefore">Bay & Bed</div>
                                                                <span> {{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Name</div>
                                                                {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore"> Hospital Number </div>
                                                                <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                                            </td>


                                                            <td class="pivoted">
                                                                <div class="tdBefore">Med Fit</div>
                                                                <span class="{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'medifit-text-success' : 'medifit-text-danger' }}">{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'YES' : 'No' }} @if(isset($patient['board_round_medically_fit_data']['updated_at']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)- {{ PredefinedDateFormatWithoutYear($patient['board_round_medically_fit_data']['updated_at']) }} @endif</span>
                                                            </td>

                                                            <td class="pivoted">
                                                                <div class="tdBefore">LOS</div>
                                                                <span>{{ PatientLos($patient['camis_patient_admission_date_time']) }}
                                                                    Days</span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">EDD</div>
                                                                <span>{{ @$patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date'] ? PredefinedDateFormatShowOnCalendarDashboard($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) : 'Not Set' }}</span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Consultant</div>
                                                                <span> {{ $patient['camis_consultant_name'] }}</span>
                                                            </td>

                                                        </tr>

                                                        <tr class="table-patient-row-2">
                                                            <td class="pivoted spl-cell" rowspan="3"  id="updated_reason_list_{{ $patient['camis_patient_id'] }}">

                                                                    @include('Dashboards.Camis.RedBed.Partials.ReasonList')

                                                            </td>
                                                        </tr>

                                                        <tr class="table-patient-row-3">
                                                            <td class="pivoted spl-cell" rowspan="3">
                                                                <div class="header-comment">
                                                                    <p class="flex-grow-1">Tasks</p>
                                                                    <button class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_task_management_view') }}"  onclick="TaskAssignFunction(this.id);" id="{{ $patient['camis_patient_id'] }}" data-bs-toggle="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_assign_task" aria-controls="offcanvasRight"> Task
                                                                        Assign
                                                                    </button>
                                                                    <button data-bs-toggle="offcanvas"
                                                                    data-bs-target="#camis_patient_outstanding_task"
                                                                    aria-controls="offcanvasRight"
                                                                    onclick="OutStandingTask(this.id, 2, 'flow_dashboard_red_bed_task_management_view');"
                                                                    id="{{ $patient['camis_patient_id'] }}" class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_task_management_view') }}"><span id="count_outstanding_task_{{ $patient['camis_patient_id'] }}" class="pe-1">{{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : "No" }}</span>
                                                                        Outstanding
                                                                        Tasks
                                                                    </button>
                                                                    <button class="btn btn-board-round w-auto" onclick="BoardRoundInfo('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');"
                                                                    id="{{ $patient['camis_patient_id'] }}">Board
                                                                        Round Info
                                                                    </button>
                                                                </div>

                                                                <div class="card-col-grp"  id="updated_task_list_{{ $patient['camis_patient_id'] }}">
                                                                    {!! GetCamisOutstandingTask($patient['board_round_patient_tasks'], 2, null, 'flow_dashboard_red_bed_task_management_view') !!}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="custom-card">
                            <div class="custom_not_found">
                                {{ NotFoundMessage() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>


    $(document).ready(function() {
        var windowWidth = window.innerWidth;
        if (windowWidth > 1026) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("stickyToprow").style.top = "85px";
                if (document.querySelector(".bg-sticky")) {
                    var bgSticky = document.querySelector(".bg-sticky");
                    bgSticky.style.top = "185px";
                    var stickyHeader = document.querySelectorAll(".sticky-header");
                    stickyHeader.forEach(function (header) {
                        header.style.top = "186px";
                    });
                }
            } else {
                document.getElementById("stickyToprow").style.top = "62px";
                if (document.querySelector(".bg-sticky")) {
                    var bgSticky = document.querySelector(".bg-sticky");
                    bgSticky.style.top = "162px";
                    var stickyHeader = document.querySelectorAll(".sticky-header");
                    stickyHeader.forEach(function (header) {
                        header.style.top = "162px";
                    });
                }
            }
            if (document.getElementById("stickyToprow")) {
                if (document.querySelector(".custom_not_found")) {
                    var noRecords = document.querySelector(".custom_not_found");
                    noRecords.style.marginTop = "90px";
                }
            }
        }
        $('#reason_id').on('click', '.selectable-optgroup', function() {
            var options = $(this).find('option');

            options.prop('selected', true);

            $(this).parent().find('.selectable-optgroup').not(this).find('option').prop('selected', false);
            alert('click');
        });
    });

</script>

