@include('Common.Modals.CommonModals')

<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('stranded_dashboard_0_to_6_days_view') }}">
                        <a class="tab-custom-btn  @if ($success_array['los_type'] == '0-6') active @endif {{ DisabledButtonOnRolePermission('stranded_dashboard_0_to_6_days_view') }}" @if (DisabledButtonOnRolePermission('stranded_dashboard_0_to_6_days_view') != 'permission_restricted') onclick="LosType('0-6');" @endif data-bs-toggle="tab" href="#stranded">
                            <div class="tab-active">LOS 0 To 6 </div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('stranded_dashboard_7_to_13_days_view') }}">
                        <a class="tab-custom-btn  @if ($success_array['los_type'] == '7-13') active @endif {{ DisabledButtonOnRolePermission('stranded_dashboard_7_to_13_days_view') }}" @if (DisabledButtonOnRolePermission('stranded_dashboard_7_to_13_days_view') != 'permission_restricted') onclick="LosType('7-13');" @endif data-bs-toggle="tab" href="#stranded">
                            <div class="tab-active">LOS 7 To 13 </div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('stranded_dashboard_14_to_20_days_view') }}">
                        <a class="tab-custom-btn  @if ($success_array['los_type'] == '14-20') active @endif {{ DisabledButtonOnRolePermission('stranded_dashboard_14_to_20_days_view') }}" @if (DisabledButtonOnRolePermission('stranded_dashboard_14_to_20_days_view') != 'permission_restricted') onclick="LosType('14-20');" @endif data-bs-toggle="tab" href="#stranded">
                            <div class="tab-active">LOS 14 To 20 </div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('stranded_dashboard_super_stranded_view') }}">
                        <a class="tab-custom-btn {{ $success_array['los_type'] == '21+' ? 'active' : '' }} {{ DisabledButtonOnRolePermission('stranded_dashboard_super_stranded_view') }}" data-bs-toggle="tab" @if (DisabledButtonOnRolePermission('stranded_dashboard_super_stranded_view') != 'permission_restricted') onclick="LosType('21+');" @endif href="#superStranded">
                            <div class="tab-active">LOS 21+</div>
                        </a>
                    </li>
                </ul>
                <div class="row row-cols-lg-5 row-cols-md-3 row-cols-1 gx-2">
                    <div class="col mb-2">
                        {!! AllWardListDropdown('ward_id') !!}
                    </div>
                    <div class="col mb-2">
                        <select name="task_type" id="task_type" class="form-select"
                        aria-label="Default select example">
                            <option {{ $success_array['task_type'] == 'all' ? 'selected' : '' }} value="all">All
                                Patients</option>
                            <option {{ $success_array['task_type'] == 'site' ? 'selected' : '' }} value="site">
                                Patients With Site Task</option>
                        </select>
                    </div>
                    <div class="col mb-2">
                        <select name="task_type" id="medfit_type" class="form-select" aria-label="Default select example">
                            <option {{ $success_array['medfit_type'] == 'all' ? 'selected' : '' }} value="all">Med Fit : All</option>
                            <option {{ $success_array['medfit_type'] == 1 ? 'selected' : '' }} value="1">Med Fit : Yes</option>
                            <option {{ $success_array['medfit_type'] == 0 ? 'selected' : '' }} value="0">Med Fit : No</option>
                        </select>
                    </div>
                    <div class="col mb-2">
                      <div class="bg-patients-count">
                        <h6>Total Patients</h6>
                        <h5>{{ count($success_array['total_patients']) }}</h5>
                      </div>
                    </div>
                    <div class="col mb-2">
                      <div class="text-end">
                        <a class="btn btn-export w-100" href="{{ route('site.stranded_patients.export') }}?ward_id={{ request()->has('ward_id') ? implode(',', (array) request()->ward_id) : '' }}&task_type={{ request()->task_type }}&los_type={{ $success_array['los_type'] }}&medfit_type={{ request()->medfit_type }}"><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" width="16" class="me-3">Export</a>
                      </div>
                    </div>
                  </div>

            </div>




            <input type="hidden" id="los_type" value="{{ $success_array['los_type'] }}">
            <div class="tab-content" id="tabcontent">
                <div id="stranded" class=" tab-pane active">
                    <div class="other-dashboard-contents">
                        <div class="bg-sticky"></div>
                        <div class="patients-details">

                            @if (count($success_array['patient_details']) > 0)
                                @foreach ($success_array['patient_details'] as $ward => $patient_info)
                                <div class="wards-patients-details">
                                    <div class="sticky-header">
                                        <div class="name-header">
                                           <span>{{ $ward }} -
                                                {{ WardType($ward) }}</span>
                                        </div>
                                    </div>
                                    <div class="custom-card">
                                        <table class="breachReasonTable responsiveTable table-custom">
                                            @foreach ($patient_info as $patient)
                                               <tbody class="table-custom-tbody">
                                                <tr class="table-col-1">
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Bed & Bay</div>
                                                        <span>{{ $patient['ibox_actual_bed_full_name'] }} </span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Name</div>
                                                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore"> Hospital Number </div>
                                                        <span>
                                                                {{ $patient['camis_patient_pas_number'] }}</span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Consultant</div>
                                                        <span> {{ $patient['camis_consultant_name'] }}</span>
                                                    </td>

                                                    <td class="pivoted">
                                                        <div class="tdBefore">Outlier</div>
                                                        <span>{{ $patient['camis_outlier_name'] != null ?$patient['camis_outlier_name']:'--' }} </span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">LOS</div>
                                                        <span>{{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) }}
                                                            {{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) > 1 ? 'Days' : 'Day' }}
                                                            </span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">EDD</div>
                                                        @if (isset($patient['board_round_estimated_discharge_date']) &&
                                                                !empty($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']))
                                                            <span>{{ PredefinedDateFormatShowOnCalendarDashboard($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) }}</span>
                                                        @else
                                                            <span>Not Set</span>
                                                        @endif

                                                    </td>

                                                    <td class="pivoted">
                                                        <div class="tdBefore">Med Fit</div>
                                                        <span
                                                            class="medfit-text-{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'success' : 'danger' }}">{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'Yes' : 'No' }}</span>
                                                    </td>
                                                </tr>
                                                <tr class="table-col-2">
                                                    <td class="pivoted cell-flags">
                                                        <div class="tdBefore"></div>
                                                        <div class="flags-table">
                                                            @php
                                                                $flag_list_show_array = PatientWiseFlagsUrlForWardSummaryGetAllFlags($patient['patient_wise_flags'], $success_array['show_on_ward_summary_status_check'], 12);
                                                            @endphp
                                                            @if (count($flag_list_show_array) > 0)
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            @foreach ($flag_list_show_array as $key => $flag)
                                                                                <td>{!! GetWardSummaryBedFlagImages($flag) !!}</td>
                                                                            @endforeach
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                <div class="no-flag-message">
                                                                    No Flag Set
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="table-col-3">
                                                    <td class="pivoted spl-cell" rowspan="3">
                                                        <div class="header-comment">
                                                            <p class="flex-grow-1">Tasks</p>
                                                            <div class="{{ PermissionDeniedDiv('strand_dashboard_task_management_view') }}">
                                                                <button
                                                                    class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('strand_dashboard_task_management_view') }}"
                                                                    @if (PermitedStatus('strand_dashboard_task_management_view')) onclick="TaskAssignFunction(this.id);" @endif
                                                                    id="{{ $patient['camis_patient_id'] }}"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#camis_patient_ward_summary_boardround_assign_task"
                                                                    aria-controls="offcanvasRight">Task
                                                                    Assign</button>
                                                            </div>
                                                            <div>
                                                                <button

                                                                    class="btn btn-assign-task w-auto"
                                                                    onclick="OutStandingTask(this.id, 2,'strand_dashboard_task_management_view');"
                                                                    id="{{ $patient['camis_patient_id'] }}">
                                                                    <span id="count_outstanding_task_{{ $patient['camis_patient_id'] }}" class="pe-1">{{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : 'No' }}</span>
                                                                    Outstanding Task
                                                                </button>
                                                            </div>
                                                            <div class="{{ PermissionDeniedDiv('strand_dashboard_patient_info_view') }}">
                                                                <button
                                                                    class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('strand_dashboard_patient_info_view') }}"
                                                                    @if (PermitedStatus('strand_dashboard_patient_info_view')) onclick="BoardRoundData('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');" @endif>Board
                                                                    Round Info
                                                                </button>
                                                            </div>
                                                            <div class="{{ PermissionDeniedDiv('discharge_tracker_discharge_info_popup_view') }}">
                                                                <button
                                                                    class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('discharge_tracker_discharge_info_popup_view') }}"
                                                                    @if (PermitedStatus('discharge_tracker_discharge_info_popup_view')) onclick="DtocModal('{{ $patient['camis_patient_id'] }}');" @endif>Discharge Tracker Info
                                                                </button>
                                                            </div>

                                                        </div>
                                                        <div class="card-col-grp"
                                                             id="updated_task_list_{{ $patient['camis_patient_id'] }}">
                                                            {!! GetCamisOutstandingTask(
                                                                $patient['board_round_patient_tasks'],
                                                                2,
                                                                null,
                                                                'strand_dashboard_task_management_view',
                                                            ) !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>

                                            @endforeach

                                        </table>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="custom_not_found">
                                    {{ NotFoundMessage() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '185px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '185px';
            })
            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');

                if(noRecords){
                    bgSticky.style.top = '140px';
                    noRecords.style.marginTop = '40px';
                }

            }
        }
        else{

            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '160px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '160px';
            })
            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');

                if(noRecords){
                    bgSticky.style.top = '115px';
                    noRecords.style.marginTop = '40px';
                }

            }
        }


    }
</script>
