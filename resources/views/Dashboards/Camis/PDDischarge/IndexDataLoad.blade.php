
<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <div class="sticky-toprow" id="stickyToprow" >
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_today_dashboard_view') }}">
                        <a class="tab-custom-btn @if(($success_array['tab_type']== null)|| ($success_array['tab_type'] == \Carbon\Carbon::today()->format('l')))active @endif {{ DisabledButtonOnRolePermission('pd_dashboard_today_dashboard_view') }}" onclick="DischargeDay('{{ \Carbon\Carbon::today()->format('l') }}');" data-bs-toggle="tab"
                           href="#dischargeToday">
                            <div class="tab-active">D/P Discharge Today
                            </div> </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type'] == \Carbon\Carbon::tomorrow()->format('l') ? 'active':'' }} {{ DisabledButtonOnRolePermission('pd_dashboard_tomorrow_dashboard_view') }}" data-bs-toggle="tab" href="#dischargeTomorrow" onclick="DischargeDay('{{ \Carbon\Carbon::tomorrow()->format('l') }} ');">
                            <div class="tab-active">D/P Discharge {{ $success_array['tomorrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_day_after_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type'] == \Carbon\Carbon::now()->addDays(2)->format('l') ? 'active':'' }} {{ DisabledButtonOnRolePermission('pd_dashboard_day_after_tomorrow_dashboard_view') }}" data-bs-toggle="tab" href="#dischargeDayAfterTomorrow" onclick="DischargeDay('{{ \Carbon\Carbon::now()->addDays(2)->format('l') }}');">
                            <div class="tab-active">D/P Discharge {{ $success_array['day_after_tommrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharged_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type'] == 'missed_discharged'? 'active':'' }} {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharged_view') }}" data-bs-toggle="tab" href="#dischargeDayAfterTomorrow" onclick="MissedDischarged('1', '0');">
                            <div class="tab-active">Failed Discharges</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharges_performance_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type'] == 'missed_discharged_performance'? 'active':'' }} {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharges_performance_view') }}" data-bs-toggle="tab" href="#dischargeDayAfterTomorrow" onclick="FailedDischargesPerformance('{{ date('Y-m-d', strtotime('-1 day')) }}', '{{ date('Y-m-d', strtotime('-1 day')) }}', 1, 1);">
                            <div class="tab-active">Failed Discharges Performances</div>
                        </a>
                    </li>
                </ul>
                <div class="row g-2 mb-2 pd-top-row">
                    <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4">
                        <select class="3col active"  multiple="multiple" aria-label="Default select example" id="ward_id">
                            <optgroup label="Medical Wards">
                                @foreach ($success_array['medical_wards'] as $ward)
                                <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif >
                                    {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="Surgical Wards">
                                @foreach ($success_array['surgical_wards'] as $ward)
                                <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="Others Wards">
                                @foreach ($success_array['other_wards'] as $ward)
                                <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>

                        </select>
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4">
                        <select name="task_type" id="task_type" class="form-select" aria-label="Default select example">
                            <option {{ request()->task_type == 'all'? "selected": '' }} value="all">All Tasks</option>
                            <option {{ request()->task_type == 'site'? "selected": '' }} value="site">Patients with Site Task</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4">
                        <select name="task_type" id="medfit_type" class="form-select" aria-label="Default select example">
                            <option {{ request()->medfit_type == 'all' ? "selected": '' }} value="all">Med Fit : All</option>
                            <option {{ (!request()->has('medfit_type') || request()->medfit_type == 1) ? "selected": '' }} value="1">Med Fit : Yes</option>
                            <option {{ request()->medfit_type == 0 ? "selected": '' }} value="0">Med Fit : No</option>
                        </select>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="d-flex" id="pdDischargeSection">
                            <button id="definiteButton" type="button" class="btn btn-primary-grey me-2 discharge_type_definite {{ request()->discharge_type == 'definite'? "active":'' }}" data-type="definite">Definite</button>
                            <button id="potentialButton" type="button" class="btn btn-primary-grey discharge_type_potential {{ request()->discharge_type == 'potential'? "active":'' }}" data-type="potentital">Potential</button>
                        </div>

                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="bg-patients-count">
                            <h6>Total Patients</h6>
                            <h5>{{ count($success_array['total_patients']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>


            <input type="hidden" value="{{$success_array['tab_type']}}" id="discharge_day">
            <div class="tab-content" id="tabcontent">
                <div id="dischargeToday" class=" tab-pane active">
                    <div class="other-dashboard-contents">
                        <div class="bg-sticky" id="hideBgSticky" ></div>
                        <div class="patients-details">
                            @if (count($success_array['patient_details']) > 0)
                                @foreach ($success_array['patient_details'] as $ward => $patient_info)

                            <div class="wards-patients-details">
                                <div class="sticky-header">
                                    <div class="name-header">
                                        <span>{{ $ward }} - {{ WardType($ward) }}</span>
                                    </div>
                                </div>
{{--                                @php--}}
{{--                                    $today = $success_array['date']->format('Y-m-d');--}}
{{--                                   $tomorrow = $success_array['date']->addDay()->format('Y-m-d');--}}
{{--                                   $dayAfterTomorrow = $success_array['date']->addDay(1)->format('Y-m-d');--}}
{{--                                @endphp--}}
                                <div class="custom-card">
                                    <table class="breachReasonTable responsiveTable table-custom">
                                        @foreach($patient_info as $patient)
                                            <tbody class="table-patient-tbody">
                                            <tr class="table-patient-row-1">

                                                <td class="pivoted">
                                                    <div class="tdBefore">Bay & Bed</div>
                                                    <span>{{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Name</div>
                                                    {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore"> Hospital Number </div>
                                                    <span>  {{ $patient['camis_patient_pas_number'] }}</span>
                                                </td>



                                                <td class="pivoted">
                                                    <div class="tdBefore">&nbsp;</div>
                                                    <div class="cell-data">
                                                     {{--   {!! GetEwsData($patient['patient_vital_pac_info']['totalews'] ?? null, 30, 1)  !!} --}}
                                                        <div class="data-group">
                                                            @if(isset($patient['board_round_tto']['discharge_planning_tto_status']) && in_array($patient['board_round_tto']['discharge_planning_tto_status'], [1, 2]))
                                                                <div @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) class="bg-tto-yes" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) class="bg-tto-no" @else class="bg-tto-na" @endif data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) title="TTO Required - Completed" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) title="TTO Required - Not Completed" @else  title="TTO Status Not Applicable" @endif>TTO</div>
                                                            @endif
                                                            @if(isset($patient['board_round_edn']['discharge_planning_edn_status']) && in_array($patient['board_round_edn']['discharge_planning_edn_status'], [1, 2]))
                                                                <div class="bg-eds-no" @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) class="bg-eds-yes" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) class="bg-eds-no" @else class="bg-edn-na" @endif data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) title="EDS Required - Completed" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) title="EDS Required - Not Completed" @else  title="EDN Status Not Applicable" @endif>EDS</div>
                                                            @endif
                                                            <div>
                                                                @if($ambo = CheckSpecificBedFlagsExitsOnArrayWithData($patient['patient_wise_flags'], 'ibox_patient_flag_ambo', 'flag_ambo_ref'))

                                                                <span class="bg-ambo" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="{{ strtoupper($ambo) }}"> AMBO </span>
                                                                <span>REF:{{ strtoupper($ambo) }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>



                                                <td class="pivoted">
                                                    <div class="tdBefore">Outlier</div>
                                                    <span>@if($outlier = CheckSpecificBedFlagsExitsOnArrayWithData($patient['patient_wise_flags'], 'ibox_patient_flag_outlier', 'flag_outlier_value'))
                                                        @if($outlier == 'Other') OTHER @else {{ strtoupper($outlier) }} @endif @else -- @endif

                                                </td>





                                                <td class="pivoted">
                                                    <div class="tdBefore">LOS</div>
                                                    <span>{{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) }} {{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) > 1 ? 'Days' : 'Day' }}
                                                </span>
                                                </td>

                                                <td class="pivoted">
                                                    <div class="tdBefore">Consultant</div>
                                                    <span>  {{ $patient['camis_consultant_name'] }}</span>
                                                </td>

                                                <td class="pivoted">
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
                                            <tr class="table-patient-row-2">
                                                <td class="pivoted spl-cell" rowspan="3">
                                                    <div class="header-comment">
                                                        <p class="flex-grow-1">Tasks</p>
                                                        <div class="{{ PermissionDeniedDiv('pd_dashboard_task_management_view') }}">
                                                            <button class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('pd_dashboard_task_management_view') }}" @if(PermitedStatus('pd_dashboard_task_management_view')) onclick="TaskAssignFunction(this.id);" @endif id="{{ $patient['camis_patient_id'] }}" >Task
                                                                Assign</button>
                                                        </div>

                                                        <button
                                                                class="btn btn-assign-task w-auto" onclick="OutStandingTask(this.id, 2,'pd_dashboard_task_management_view');"
                                                                id="{{ $patient['camis_patient_id'] }}">
                                                            <span id="count_outstanding_task_{{ $patient['camis_patient_id'] }}">{{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : "No" }}</span> &nbsp; Outstanding Task
                                                        </button>

                                                        <div class="{{ PermissionDeniedDiv('pd_dashboard_patient_info_view') }}">
                                                            <button class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('pd_dashboard_patient_info_view') }}" @if(PermitedStatus('pd_dashboard_patient_info_view')) onclick="BoardRoundInfo(('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');" @endif id="{{ $patient['camis_patient_id'] }}">Board
                                                                Round Info
                                                            </button>
                                                        </div>


                                                    </div>
                                                    <div class="card-col-grp" id="updated_task_list_{{ $patient['camis_patient_id'] }}">
                                                        {!! GetCamisOutstandingTask($patient['board_round_patient_tasks'], 2, null, 'pd_dashboard_task_management_view') !!}
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
                                <div class="wards-patients-details">
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
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
        if (windowWidth > 1025 && windowWidth < 1200) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("stickyToprow").style.top = "85px";
                if (document.querySelector(".bg-sticky")) {
                    var bgSticky = document.querySelector('.bg-sticky');
                    bgSticky.style.top = '250px';
                    var stickyHeader = document.querySelectorAll('.sticky-header');
                    stickyHeader.forEach(function (header) {
                        header.style.top = '250px';
                    })
                }
            }
            if (document.getElementById("stickyToprow")) {
                if (document.querySelector(".custom_not_found")) {
                    var noRecords = document.querySelector('.custom_not_found');
                    noRecords.style.marginTop = '210px';
                }
            }
        } else if (windowWidth > 1026) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("stickyToprow").style.top = "85px";
                if (document.querySelector(".bg-sticky")) {
                    var bgSticky = document.querySelector('.bg-sticky');
                    bgSticky.style.top = '195px';
                    var stickyHeader = document.querySelectorAll('.sticky-header');
                    stickyHeader.forEach(function (header) {
                        header.style.top = '195px';
                    })
                }
            }
            if (document.getElementById("stickyToprow")) {
                if (document.querySelector(".custom_not_found")) {
                    var noRecords = document.querySelector('.custom_not_found');
                    noRecords.style.marginTop = '100px';
                    if (document.querySelector(".bg-sticky")) {
                    var bgSticky = document.querySelector('.bg-sticky');
                    bgSticky.style.top = '115px';
                    }
                }
            }
        }
</script>
<script>
    var windowWidth = window.innerWidth;
    $("#hideRow").show();
    $("#hideBgSticky").addClass("bg-sticky");

</script>

