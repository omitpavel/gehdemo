


<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12">
            <div class="sticky-toprow" id="stickyToprow">
                <div class="row g-2 mb-2">
                    <div class="col-lg-3 col-md-4">
                        {!! AllWardListDropdown('ward_id') !!}

                    </div>
                </div>
            </div>

            @if (count($success_array['patient_details']) > 0)
            <div class="virtual-ward-contents">
                <div class="bg-sticky"></div>
                <div class="patients-details">
                    @foreach ($success_array['patient_details'] as $ward => $patient_details)

                            <div class="wards-patients-details">

                                <div class="sticky-header">
                                    <div class="name-header">
                                        <span>{{ $ward }}</span>
                                    </div>
                                </div>
                                <div class="custom-card">
                                    <table class="breachReasonTable responsiveTable table-custom">
                                        @foreach ($patient_details as $patient)
                                            <tbody class="table-patient-tbody">
                                                <tr class="table-patient-row-1">
                                                    <td class="pivoted">
                                                        <div class="tdBefore"> Bay & Bed </div>

                                                        @php
                                                            $bed_group_name = $patient['patient_position']['sdec_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                            $bed_actual_name = $patient['patient_position']['sdec_position']['bed_actual_name'] ?? '';
                                                            $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                        @endphp

                                                        @if(stripos($patient['camis_patient_ward'] ?? '', 'RLTSDECIP') !== false)
                                                            @php
                                                                $bed_group_name = $patient['patient_position']['sdec_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                                $bed_actual_name = $patient['patient_position']['sdec_position']['bed_actual_name'] ?? '';
                                                                $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                            @endphp

                                                            <span> {{ $current_area}}</span>
                                                        @elseif(stripos($patient['camis_patient_ward'] ?? '', 'RLTFAU') !== false)
                                                            @php
                                                                $bed_group_name = $patient['frailty_position']['frailty_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                                $bed_actual_name = $patient['frailty_position']['frailty_position']['bed_actual_name'] ?? '';
                                                                $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                            @endphp
                                                            <span> {{ $current_area}}</span>

                                                        @else
                                                            <span> {{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Name</div>
                                                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore"> Hospital Number </div>
                                                        <span> {{ $patient['camis_patient_pas_number'] }}</span>
                                                    </td>

                                                    <td class="pivoted">
                                                        <div class="tdBefore">&nbsp;</div>
                                                        <div class="cell-data">

                                                            <div class="data-group">
                                                                @if(isset($patient['board_round_tto']['discharge_planning_tto_status']) && in_array($patient['board_round_tto']['discharge_planning_tto_status'], [1, 2]))
                                                                    <div @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) class="bg-tto-yes" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) class="bg-tto-no" @else class="bg-tto-na" @endif data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) title="TTO Required - Completed" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) title="TTO Required - Not Completed" @else  title="TTO Status Not Applicable" @endif>TTO</div>
                                                                @endif
                                                                @if(isset($patient['board_round_edn']['discharge_planning_edn_status']) && in_array($patient['board_round_edn']['discharge_planning_edn_status'], [1, 2]))
                                                                    <div
                                                                        @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) class="bg-eds-yes" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) class="bg-eds-no" @else class="bg-edn-na" @endif data-bs-toggle="tooltip"
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
                                                        <span>{{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date'], date('Y-m-d')) }}
                                                            Days</span>
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Consultant</div>
                                                        <span>{{ $patient['camis_consultant_name'] }}</span>
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
                                                            @if ($success_array['ward'] == 'frailty')
                                                                <div class="{{ PermissionDeniedDiv('virtual_ward_task_management_view') }}">
                                                                    <button class="btn btn-assign-task w-auto {{ DisabledButtonOnRolePermission('virtual_ward_task_management_view') }}" @if(PermitedStatus('virtual_ward_task_management_view')) onclick="TaskAssignFunction(this.id);" @endif id="{{ $patient['camis_patient_id'] }}" >Task
                                                                        Assign</button>

                                                                </div>

                                                                <button
                                                                    onclick="OutStandingTask(this.id, 4, 'virtual_ward_task_management_view');"
                                                                    id="{{ $patient['camis_patient_id'] }}"
                                                                    class="btn btn-assign-task w-auto">
                                                                    <span id="count_outstanding_task_{{ $patient['camis_patient_id'] }}" class="pe-1">{{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : 'No' }}</span>
                                                                    Outstanding
                                                                    Tasks
                                                                </button>
                                                                <div
                                                                    class="{{ PermissionDeniedDiv('virtual_ward_patient_info_view') }}">
                                                                    <button
                                                                        class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('virtual_ward_patient_info_view') }}"
                                                                        onclick="BoardRoundInfo('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');"
                                                                        id="{{ $patient['camis_patient_id'] }}">Board
                                                                        Round Info
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <button
                                                                    onclick="OutStandingTask(this.id, null, '{{ Sentinel::getUser()->hasAccess('virtual_ward_task_management_view') ? 'virtual_ward_task_management_view' : '' }}');"
                                                                    id="{{ $patient['camis_patient_id'] }}"
                                                                    class="btn btn-assign-task w-auto">
                                                                    {{ $patient['board_round_patient_tasks_count'] > 0 ? $patient['board_round_patient_tasks_count'] : 'No' }}
                                                                    Outstanding
                                                                    Tasks
                                                                </button>
                                                                <div
                                                                    class="{{ PermissionDeniedDiv('virtual_ward_patient_info_view') }}">
                                                                    <button
                                                                        class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('virtual_ward_patient_info_view') }}"
                                                                        onclick="BoardRoundInfo('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');"
                                                                        id="{{ $patient['camis_patient_id'] }}">Board
                                                                        Round Info
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="card-col-grp"
                                                            id="updated_task_list_{{ $patient['camis_patient_id'] }}">
                                                            @if ($success_array['ward'] == 'frailty')
                                                                {!! GetCamisOutstandingTask($patient['board_round_patient_tasks'], 4, null, 'virtual_ward_task_management_view') !!}
                                                            @else
                                                                {!! GetCamisOutstandingTask(
                                                                    $patient['board_round_patient_tasks'],
                                                                    null,
                                                                    null,
                                                                    'virtual_ward_task_management_view',
                                                                ) !!}
                                                            @endif

                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                    @endforeach
                </div>
            </div>
            @else
                <div class="custom_not_found">
                    {{ NotFoundMessage() }}
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '135px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function (header) {
                    header.style.top = '135px';
                })
            }
        }
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '45px';
            }
        }
    }

</script>
