<input type="hidden" id="task_category" value="">
<input type="hidden" id="filtered_task_id" value="6">
<input type="hidden" id="camis_comment_user_id" value="">
<input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">


<div class="col-lg-12">
    <div class="count-details-row">
        <div class="count-details-col">
                {!! AllWardListDropdown() !!}
        </div>
        <div class="count-details-col">
                <select class="form-select w-100" aria-label="Default select example" id="sort_by">
                    <option value="" selected>Sort By</option>
                    <option value="surname_asc"
                        {{ isset($selected_sort_by) && $selected_sort_by == 'surname_asc' ? 'selected' : '' }}>
                        Surname(asc)</option>
                    <option value="surname_desc"
                        {{ isset($selected_sort_by) && $selected_sort_by == 'surname_desc' ? 'selected' : '' }}>
                        Surname(desc)</option>
                    <option value="ews_asc" {{ isset($selected_sort_by) && $selected_sort_by == 'ews_asc' ? 'selected' : '' }}>EWS(asc)</option>
                    <option value="ews_desc" {{ isset($selected_sort_by) && $selected_sort_by == 'ews_desc' ? 'selected' : '' }}>EWS(desc)</option>
                </select>
        </div>

        <div class="count-details-col">
            <div class="bg-ash">
                <h6>New Patients</h6>
                <h6 class="count" id="new_count">{{ $new_patients }}</h6>
            </div>
        </div>
        <div class="count-details-col">
            <div class="bg-dark ">
                <h6>In Groups</h6>
                <h6 class="count " id="group_count">{{ $total_patients }}</h6>
            </div>
        </div>
        <div class="count-details-col">
            <div class="bg-primary ">
                <h6>Seen</h6>
                <h6 class="count " id="seen_count">{{ $seen_patients }}</h6>
            </div>
        </div>

        <div class="count-details-col-2">
            <div class="bg-darkcyan">
                <h6>Discharged to Ward</h6>
                <h6 class="count " id="discharged_to_count">{{ $discharge_dp }}</h6>
            </div>

        </div>
        <div class="count-details-col">
            <div class="bg-maroon">
                <h6>Not for DP</h6>
                <h6 class="count"  id="not_for_dp_count">{{ $not_for_dp }}</h6>
            </div>
        </div>
        <div class="count-details-col">
            <div class="bg-purple ">
                <h6>Monthly Total</h6>
                <h6 class="count "  id="this_month_count">{{ $this_month }}</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if (count($patient_data) > 0)
        <div class="col-lg-12" id="count_content">
            @foreach ($patient_data as $patient)

                <div class="card-details mb-2 remove_patients" id="remove_row_{{ $patient['camis_patient_id'] }}">
                    <div class="deteriorating-content">
                        <div class="row deteriorating-row">
                            <div class="col-xxl-5 pe-xxl-1">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-4">
                                        <div class="data-set">
                                            <ul>
                                                <li>Ward</li>
                                                <li>{{ $patient['ibox_ward_name'] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <div class="data-set">
                                            <ul>
                                                <li>Name</li>
                                                <li>{!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-4 ps-lg-0">
                                        <div class="data-set">
                                            <ul>
                                                <li>Hospital Number</li>
                                                <li>{{ $patient['camis_patient_pas_number'] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <hr class="mt-1 mb-1 w-90">

                                    @if(isset($patient['d_p_virtual_ward_status']['entry_type']))

                                        @if($patient['d_p_virtual_ward_status']['entry_type'] == 1)


                                            <div class="shape-hex">
                                                <div class="flag-icon-nc"></div>
                                                <span>Nurse Concern</span>
                                            </div>
                                        @elseif($patient['d_p_virtual_ward_status']['entry_type'] == 2)
                                            <div class="shape-hex">
                                                <div class="flag-icon-sd"></div>
                                                <span>Step Down</span>
                                            </div>
                                        @elseif($patient['d_p_virtual_ward_status']['entry_type'] == 3)
                                                <div class="shape-hex">
                                                <div class="flag-icon-dp"></div>
                                                <span class="dp-text">DP</span>
                                            </div>
                                        @endif

                                    @else
                                        <div class="shape-hex">
                                            <div class="flag-icon-nc"></div>
                                            <span>Nurse Concern</span>
                                        </div>

                                    @endif
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-4 col-md-4 col-4 pe-lg-1">
                                        <div class="data-set">
                                            <ul>
                                                <li>Bed & Bay</li>
                                                <li>{{ $patient['ibox_actual_bed_full_name'] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-8">
                                        <div class="data-set">
                                            <ul>
                                                <li>Consultant</li>
                                                <li>{{ $patient['camis_consultant_name'] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-primary mt-2 mb-2">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-1">
                                            {!! GetEwsData($patient['patient_vital_pac_info']['totalews'] ?? null, 30,'ews') !!}

                                        </div>
                                        <div class="col-lg-11 col-md-11 col-11 ">
                                            <div class="patients-medical-results">
                                                <ul>
                                                    <li>Heart  Rate</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['herat_rate_val']) && $patient['patient_vital_pac_info']['herat_rate_val'] > 0) {{   $patient['patient_vital_pac_info']['herat_rate_val'] }} @else -- @endif</li>
                                                </ul>
                                                <ul>
                                                    <li>Temperature</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['temperature_val']) && $patient['patient_vital_pac_info']['temperature_val'] > 0) {{ VitalPacTemperatureFormat($patient['patient_vital_pac_info']['temperature_val'] ?? null) }} @else -- @endif</li>
                                                </ul>
                                                <ul>
                                                    <li>Respiratory  Rate</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['respiratory_rate_val']) && $patient['patient_vital_pac_info']['respiratory_rate_val'] >0) {{ $patient['patient_vital_pac_info']['respiratory_rate_val'] ?? '0' }} @else -- @endif </li>
                                                </ul>
                                                <ul>
                                                    <li>BP  Systolic</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['bp_systolic_val']) && $patient['patient_vital_pac_info']['bp_systolic_val'] > 0) {{ $patient['patient_vital_pac_info']['bp_systolic_val'] ?? '0' }} @else -- @endif</li>
                                                </ul>
                                                <ul>
                                                    <li>Oxygen</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['oxygen_val']) && $patient['patient_vital_pac_info']['oxygen_val'] > 0) {{ $patient['patient_vital_pac_info']['oxygen_val'] ?? '0' }}L @else -- @endif </li>
                                                </ul>
                                                <ul>
                                                    <li>ACVPU</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['avpu_val']) &&  $patient['patient_vital_pac_info']['avpu_val']) {{ $patient['patient_vital_pac_info']['avpu_val'] ?? '0' }} @else -- @endif</li>
                                                </ul>
                                                <ul>
                                                    <li>SATS</li>
                                                    <li>@if(isset($patient['patient_vital_pac_info']['sats_val']) && $patient['patient_vital_pac_info']['sats_val']>0) {{ $patient['patient_vital_pac_info']['sats_val'] ?? '0' }}  @else -- @endif </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-2 col-md-2 col-6">
                                        <div class="data-set">
                                            <ul>
                                                <li>Med Fit</li>

                                                <li class="{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'text-success' : 'text-red' }}">@if(isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                  Yes @if(isset($patient['board_round_medically_fit_data']['updated_at']))- {{ PredefinedDateFormatWithoutYear($patient['board_round_medically_fit_data']['updated_at']) }} @endif
                                                @else
                                                No
                                                @endif</li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="data-set">
                                            <ul>
                                                <li>LOS</li>
                                                <li>{{ PatientLos($patient['camis_patient_admission_date_time']) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <div class="data-set">
                                            <ul>
                                                <li>Added at </li>
                                                <li>@if(isset($patient['d_p_virtual_ward_status'])) {{ $patient['d_p_virtual_ward_status']['dp_virtual_ward_entry_time'] ? PredefinedDateFormatBoardRoundTaskToBeCompleted($patient['d_p_virtual_ward_status']['dp_virtual_ward_entry_time']) : '--' }} @else -- @endif</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-6">
                                        <div class="data-set">
                                            <ul>
                                                <li>OBS Last Updated Time</li>
                                                <li>@if(isset($patient['patient_vital_pac_info'])) {{ $patient['patient_vital_pac_info']['time_started_obs'] ? PredefinedDateFormatBoardRoundTaskToBeCompleted($patient['patient_vital_pac_info']['time_started_obs']) : '--' }} @else -- @endif</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xxl-7 ps-xxl-1">
                                <div class="card-inner">
                                    <div class="row gx-1">
                                        <div class="col-lg-5 mb-2 mb-lg-0 patient_task_list_{{ $patient['camis_patient_id'] }}">

                                            {!! GetCamisOutstandingTask($patient['board_round_patient_tasks'], 6, 6, 'dp_dashboard_task_management_view') !!}
                                        </div>
                                        <div class="col-lg-7 ps-lg-1">
                                            <div class="mb-2">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <p class="fs-14 mb-0">Comments</p>
                                                    <button class="btn btn-view-all w-auto view_all_comments" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">View All
                                                    </button>
                                                </div>
                                                <div
                                                    class="card-col-grp updated_comment_list_{{ $patient['camis_patient_id'] }}">
                                                    @foreach($patient['d_p_virtual_ward_comment'] as $comment)
                                                    <div class="row gx-1 align-items-center">
                                                        <div class="col-comment">
                                                            <span class="">{{ $comment['additional_comment'] }}</span>
                                                        </div>
                                                        <div class="col-icons">
                                                            <a href="#" class="comment_upadate_delete_check_status  {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_update') }}"  data-comment-create-status="edit" data-comment-id="{{$comment['id']}}" data-comment-text="{{$comment['additional_comment']}}" data-comment-patient-id="{{$comment['patient_id']}}"  data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="EDIT"><i class="bi bi-pencil-square "></i></a>
                                                            <a href="" class="comment_upadate_delete_check_status {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_delete') }}" data-comment-create-status="delete" data-comment-id="{{$comment['id']}}" data-comment-text="{{$comment['additional_comment']}}" data-comment-patient-id="{{$comment['patient_id']}}"  data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="DELETE"><i class="bi bi-trash3"></i></a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row gx-2 wrap-btn">
                                                @if(isset($patient['d_p_virtual_ward_status']) && $patient['d_p_virtual_ward_status']['type'] == 1 && $tab_name != 'all_patient')
                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_discharge_action_update') }}">
                                                        <button class="btn btn-grey discharge_to_ward discharge_ward_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_discharge_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="2"><img
                                                                src="{{ asset('asset_v2/Template/icons/discharge.svg') }}"
                                                                alt="" width="12">DISCHARGE TO
                                                            WARD</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2  {{ PermissionDeniedDiv('dp_dashboard_patient_remove_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_remove_patient action_remove_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_remove_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="1"><img
                                                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                                                                alt="" width="10">REMOVE FROM
                                                            DP</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_review_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_reviewed_patient action_reviewed_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_review_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="0"><img
                                                                src="{{ asset('asset_v2/Template/icons/star.svg') }}"
                                                                alt="">PATIENT
                                                            REVIEWED</button>
                                                    </div>
                                                @elseif(isset($patient['d_p_virtual_ward_status']) && $patient['d_p_virtual_ward_status']['type'] == 2 && $tab_name != 'all_patient')
                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_discharge_action_update') }}">
                                                        <button class="btn btn-grey discharge_to_ward discharge_ward_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_discharge_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="2"><img
                                                                src="{{ asset('asset_v2/Template/icons/discharge.svg') }}"
                                                                alt="" width="12">DISCHARGE TO
                                                            WARD</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2  {{ PermissionDeniedDiv('dp_dashboard_patient_remove_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_remove_patient action_remove_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_remove_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="1"><img
                                                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                                                                alt="" width="10">REMOVE FROM
                                                            DP</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2 permission_restricted {{ PermissionDeniedDiv('dp_dashboard_patient_review_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_reviewed_patient action_reviewed_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_review_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="0"><img
                                                                src="{{ asset('asset_v2/Template/icons/star.svg') }}"
                                                                alt="">PATIENT
                                                            REVIEWED</button>
                                                    </div>
                                                @elseif(isset($patient['d_p_virtual_ward_status']) && $patient['d_p_virtual_ward_status']['type'] == 3 && $tab_name != 'all_patient')
                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_discharge_action_update') }}">
                                                        <button class="btn btn-grey discharge_to_ward discharge_ward_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_discharge_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="2"><img
                                                                src="{{ asset('asset_v2/Template/icons/discharge.svg') }}"
                                                                alt="" width="12">DISCHARGE TO
                                                            WARD</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2 permission_restricted  {{ PermissionDeniedDiv('dp_dashboard_patient_remove_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_remove_patient action_remove_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_remove_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="1"><img
                                                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                                                                alt="" width="10">REMOVE FROM
                                                            DP</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2 permission_restricted {{ PermissionDeniedDiv('dp_dashboard_patient_review_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_reviewed_patient action_reviewed_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_review_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="0"><img
                                                                src="{{ asset('asset_v2/Template/icons/star.svg') }}"
                                                                alt="">PATIENT
                                                            REVIEWED</button>
                                                    </div>
                                                @elseif(isset($patient['d_p_virtual_ward_status']) && $patient['d_p_virtual_ward_status']['type'] == 5 && $tab_name != 'all_patient')
                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_discharge_action_update') }}">
                                                        <button class="btn btn-grey discharge_to_ward discharge_ward_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_discharge_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="2"><img
                                                                src="{{ asset('asset_v2/Template/icons/discharge.svg') }}"
                                                                alt="" width="12">DISCHARGE TO
                                                            WARD</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2   {{ PermissionDeniedDiv('dp_dashboard_patient_remove_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_remove_patient action_remove_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_remove_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="1"><img
                                                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                                                                alt="" width="10">REMOVE FROM
                                                            DP</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2  {{ PermissionDeniedDiv('dp_dashboard_patient_review_action_update') }}">
                                                        <button class="btn btn-grey retrigger_button action_reviewed_patient action_reviewed_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_review_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="0"><img
                                                                src="{{ asset('asset_v2/Template/icons/star.svg') }}"
                                                                alt="">PATIENT
                                                            REVIEWED</button>
                                                    </div>
                                                @elseif($tab_name == 'all_patient')

                                                    <div class="col-md-4 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_discharge_action_update') }} permission_restricted">
                                                        <button class="btn btn-grey discharge_to_ward discharge_ward_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_discharge_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="2"><img
                                                                src="{{ asset('asset_v2/Template/icons/discharge.svg') }}"
                                                                alt="" width="12">DISCHARGE TO
                                                            WARD</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2   {{ PermissionDeniedDiv('dp_dashboard_patient_remove_action_update') }} permission_restricted">
                                                        <button class="btn btn-grey retrigger_button action_remove_patient action_remove_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_remove_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="1"><img
                                                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                                                                alt="" width="10">REMOVE FROM
                                                            DP</button>
                                                    </div>
                                                    <div class="col-md-4 col-6 mb-2  {{ PermissionDeniedDiv('dp_dashboard_patient_review_action_update') }} permission_restricted">
                                                        <button class="btn btn-grey retrigger_button action_reviewed_patient action_reviewed_{{ $patient['camis_patient_id'] }} {{ DisabledButtonOnRolePermission('dp_dashboard_patient_review_action_update') }}"
                                                            data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                            data-patient-status="0"><img
                                                                src="{{ asset('asset_v2/Template/icons/star.svg') }}"
                                                                alt="">PATIENT
                                                            REVIEWED</button>
                                                    </div>
                                                @endif


                                                <div class="col-md-3 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_task_management_view') }}">
                                                    <button class="btn btn-grey {{ DisabledButtonOnRolePermission('dp_dashboard_task_management_view') }} click_open_patient_task"
                                                        data-camis-patient-id="{{ $patient['camis_patient_id'] }}"
                                                       ><img
                                                            src="{{ asset('asset_v2/Template/icons/checkmark.svg') }}"
                                                            alt=""> MANAGE TASK
                                                        </button>
                                                </div>
                                                <div class="col-md-3 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_patient_info_view') }}">
                                                    <button class="btn btn-grey {{ DisabledButtonOnRolePermission('dp_dashboard_patient_info_view') }}"
                                                        onclick="BoardRoundInfo(this.id, '{{ strtolower($patient['ibox_ward_short_name']) }}');"
                                                        id="{{ $patient['camis_patient_id'] }}"><img
                                                            src="{{ asset('asset_v2/Template/icons/info.svg') }}"
                                                            alt="">BOARD
                                                        ROUND
                                                        INFO</button>
                                                </div>
                                                <div class="col-md-3 col-6 mb-2 {{ PermissionDeniedDiv('dp_dashboard_dashboard_comment_add') }}">
                                                    <button class="btn btn-grey add_comment_dp cursor_pointer {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_add') }}"
                                                        data-id="{{ $patient['camis_patient_id'] }}"><img
                                                            src="{{ asset('asset_v2/Template/icons/comment.svg') }}"
                                                            alt="">ADD
                                                        COMMENT</button>
                                                </div>
                                                <div class="col-md-3 col-6 mb-2">
                                                    <button class="btn btn-grey board_round_hitory_show_all"
                                                        data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                        data-patient-ward="{{ $patient['ibox_ward_name'] }}"><img
                                                            src="{{ asset('asset_v2/Template/icons/history.svg') }}"
                                                            alt="" width="12">HISTORY</button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="col-lg-12">
            <div class="custom_not_found">
                {{ NotFoundMessage() }}
            </div>
        </div>
    @endif
</div>

