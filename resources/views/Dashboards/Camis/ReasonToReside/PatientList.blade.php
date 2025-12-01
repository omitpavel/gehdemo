
<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<input type="hidden" id="tab_type" value="{{ $success_array['tab_type'] }}">

<div class="col-lg-12">
    <div class="row  top-carts-section">
        <div class="col-lg-12" id="custom-tab">
            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('r_to_r_view_summery_dashboard_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type']  != 'patient_list'? 'active':'' }} {{ DisabledButtonOnRolePermission('r_to_r_view_summery_dashboard_view') }}"   id="reason_summary" data-value="reason_summary" onclick="ReasonToResideTab('summery',this.id);" data-bs-toggle="tab"
                           href="#summary"><div class="tab-active">Summary
                                            </div> </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('r_to_r_view_patient_list_dashboard_view') }}">
                        <a class="tab-custom-btn {{ $success_array['tab_type']  == 'patient_list'? 'active':'' }}  {{ DisabledButtonOnRolePermission('r_to_r_view_patient_list_dashboard_view') }}"  id="reason_patients_list" data-value="reason_patients_list" onclick="ReasonToResideTab('patient_list',this.id);" data-bs-toggle="tab" href="#patientList">
                            <div class="tab-active">Patient List</div>
                        </a>
                    </li>
                </ul>

                <div class="row gx-2" id="hideRow">
                    <div class="col-lg-3 col-md-4 mb-2">
                        {!! AllWardListDropdown('ward_id') !!}
                    </div>
                    <div class="col-lg-3 col-md-4 mb-2">


                        <select class="form-select" aria-label="Default select example" id="reason_id">
                            <option value="">All Reason</option>
                            @php
                                $currentGroup = '';
                            @endphp
                            @foreach( $success_array['reason_list'] as $key => $value)
                                @php
                                    $group = '';
                                    if (stripos($value, 'Physiology') === 0) {
                                        $group = 'Physiology';
                                    } elseif (stripos($value, 'Physiology') === 0) {
                                        $group = 'Physiology';
                                    } elseif (stripos($value, 'Recovery') === 0) {
                                        $group = 'Recovery';
                                    } elseif (stripos($value, 'Treatment') === 0) {
                                        $group = 'Treatment';
                                    } elseif (stripos($value, 'Function') === 0) {
                                        $group = 'Function';
                                    } elseif (stripos($value, 'low clinical') === 0 || stripos($value, 'high clinical')) {
                                        $group = 'Primary_Reason_-_Criteria_to_Reside';
                                    } else {
                                        $group = 'Rehabilitation._Reablement_And_Recovery_Stage';
                                    }
                                @endphp
                                @if ($group != $currentGroup)

                                    <option label="{{ $group }}" class="optionGroup" value="@php echo $currentGroup = $group; @endphp" @if (request()->reason_id == $currentGroup || request()->reason_id == $group) selected @endif>
                                        @php
                                            $currentGroup = $group;
                                        @endphp
                                        {{ \Illuminate\Support\Str::words(str_replace('.', ',', str_replace('_', ' ', $group)), 3, '...') }}
                                    </option>
                                @endif
                                <option value="{{ $key }}" @if (request()->reason_id == $key) selected @endif>
                                    {{ $value }}</option>
                            @endforeach

                        </select>


                    </div>
                    <div class="col-lg-3 col-md-4 mb-2 offset-lg-3">
                        <div class="bg-patients-count">
                            <h6>Total Patients</h6>
                            <h5>{{ count($success_array['total_patients']) }}</h5>
                        </div>
                    </div>
                </div>
            </div>




            <div class="tab-content" id="tabcontent">
                <input type="hidden" value="{{ $success_array['tab_type'] }}" id="tab_type">


                    <div id="patientList" class=" tab-pane active">
                        <div class="other-dashboard-contents">
                            <div class="bg-sticky" id="hideBgSticky"></div>
                            <div class="patients-details">

                                @if (count($success_array['patient_details']) > 0)
                                    @foreach ($success_array['patient_details'] as $ward => $patient_info)
                                <div class="wards-patients-details">
                                    <div class="sticky-header">
                                        <div class="name-header">
                                            <span>{{ $ward }} - {{ WardType($ward) }}</span>
                                        </div>
                                    </div>
                                    <div class="custom-card">
                                        <table class="breachReasonTable responsiveTable table-custom">
                                            @foreach($patient_info as $patient)

                                                <tbody class="table-custom-tbody">
                                                <tr class="table-col-1">
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Bay &amp; Bed</div>
                                                        <span>{{ $patient['ibox_actual_bed_full_name'] }}</span>
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
                                                        <div class="tdBefore">Consultant</div>
                                                        <span>{{ $patient['camis_consultant_name'] }}</span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Med Fit</div>
                                                        <span class="medfit-text-{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'success' : 'danger' }}">{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'Yes' : 'No' }} @if(isset($patient['board_round_medically_fit_data']['updated_at']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)- {{ PredefinedDateFormatWithoutYear($patient['board_round_medically_fit_data']['updated_at']) }} @endif</span>

                                                    </td>

                                                    <td class="pivoted">
                                                        <div class="tdBefore">LOS</div>
                                                        <span>{{ PatientLos($patient['camis_patient_admission_date_time']) }} </span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Reason to Reside</div>

                                                        <span> {{ isset($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value']) ? $patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value'] : 'No Reason To Reside' }} </span>
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
                                                        <div class="header-comment {{ PermissionDeniedDiv('r_to_r_task_management_view') }}">
                                                            <p class="flex-grow-1">Tasks</p>
                                                            <div class="">
                                                                <button class="btn btn-assign-task w-auto" @if(PermitedStatus('r_to_r_task_management_view')) onclick="TaskAssignFunction(this.id);" id="{{ $patient['camis_patient_id'] }}" @endif  data-bs-target="#camis_patient_ward_summary_boardround_assign_task"  data-bs-toggle="offcanvas" aria-controls="offcanvasRight">Task
                                                                    Assign</button>
                                                            </div>

                                                            <div class="">
                                                                <button  class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('r_to_r_task_management_view') }}" data-bs-toggle="offcanvas"
                                                                         data-bs-target="#camis_patient_outstanding_task"
                                                                         aria-controls="offcanvasRight"  onclick="OutStandingTask(this.id, 2,'strand_dashboard_task_management_view');"
                                                                         id="{{ $patient['camis_patient_id'] }}"

                                                                ><span id="count_outstanding_task_{{ $patient['camis_patient_id'] }}" class="pe-1">{{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : "No" }}</span> Outstanding
                                                                    Tasks
                                                                </button>
                                                            </div>
                                                            <div class="">
                                                                <button class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('r_to_r_patient_info_view') }}" style="cursor: pointer;"  @if(DisabledButtonOnRolePermission('r_to_r_patient_info_view') != 'permission_restricted') onclick="BoardRoundInfo('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');" @endif id="{{ $patient['camis_patient_id'] }}">Board
                                                                    Round Info
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-col-grp"  id="updated_task_list_{{ $patient['camis_patient_id'] }}">

                                                            {!!  GetCamisOutstandingTask($patient['board_round_patient_tasks'], 2,null,'r_to_r_task_management_view') !!}

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
                                    <div class="custom_not_found" >
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
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '185px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '185px';
            })
        }
        if (document.getElementById("stickyToprow")) {
            var noRecords = document.querySelector('.custom_not_found');
            if(noRecords){
                bgSticky.style.top = '140px';
                noRecords.style.marginTop = '40px';
            }

        }
    }
</script>
<script>
    var windowWidth = window.innerWidth;
    $("#hideRow").show();
    $("#hideBgSticky").addClass("bg-sticky");

</script>
