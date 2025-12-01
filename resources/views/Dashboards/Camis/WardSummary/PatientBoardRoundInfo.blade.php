
<input type="hidden" name="ibox_board_round_popup_opened_patient_flag_name" id="ibox_board_round_popup_opened_patient_flag_name" class="ibox_board_round_popup_opened_patient_flag_name" value="" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_id_prev" id='ward_summary_boardround_modal_popup_camis_patient_id_prev' value="{{ $success_array['prev_patient'] }}" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_id_next" id='ward_summary_boardround_modal_popup_camis_patient_id_next' value="{{ $success_array['next_patient'] }}" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_pass_number" id='ward_summary_boardround_modal_popup_camis_patient_pass_number' value="{{ $success_array['patient_details']['camis_patient_pas_number'] }}" />
<input type="hidden" id='current_therapy_status' value="{{ isset($success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status']) ? $success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status'] : '' }}" />

<input type="hidden" id='pd_discharge_date' value="{{ isset($success_array['patient_details']['potential_definite']['potential_definite_date']) ? date('Y-m-d', strtotime($success_array['patient_details']['potential_definite']['potential_definite_date'])) : '' }}" />
<input type="hidden" id='pd_discharge_type' value="{{ $success_array['patient_details']['potential_definite']['type'] ?? 0 }}" />

<input type="hidden" id="current_edn_status" value="{{ $success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] ?? 0 }}">
<input type="hidden" id="current_tto_status" value="{{ $success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] ?? 0 }}">

<input type="hidden" id='ward_summary_boardround_modal_popup_camis_patient_pmi_link' value="{{ $success_array['patient_details']['camis_patient_pmi_link'] }}" />

<input type="hidden" id="camis_patient_current_ward" value="{{ strtolower($success_array['patient_details']['ibox_ward_short_name']) }}">

<input type="hidden" id="old_antibiotic_iv_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) : '' }}">
<input type="hidden" id="old_antibiotic_iv_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}" @else value="" @endif>
<input type="hidden" id="old_antibiotic_oral_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) : '' }}">
<input type="hidden" id="old_antibiotic_oral_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}" @else value="" @endif>
<input type="hidden" name="is_next_popup_need_to_open" id='is_next_popup_need_to_open' value="0" />

<div class="row gx-2 align-items-center" id="camis_patient_boardroundbody_modal">



    @if(!request()->has('stranded_patient'))
    <div class="locked_area col-lg-2 col-md-6 order-1 order-lg-0 mb-1 {{ PermissionDeniedDiv('camis_next_of_kin_view') }}">
        <div class="btn-col click_popup_open_ibox_board_round_nok {{ DisabledButtonOnRolePermission('camis_next_of_kin_view') }}">
            <button class="btn btn-allebone w-100 "><svg xmlns="http://www.w3.org/2000/svg" width="17.002" height="18" viewBox="0 0 17.002 22.745" class="btn-icon">
                    <path id="Union_20" data-name="Union 20" d="M5.486,22.745H4.418a2,2,0,0,1-2-2V19.191H1.7a1.705,1.705,0,0,1-1.7-1.7V14.082A4.262,4.262,0,0,1,4.257,9.825h2.2a3.39,3.39,0,0,1,1.333.271V9.814a3,3,0,0,1,3-3H14a3,3,0,0,1,3,3V16.19a3.005,3.005,0,0,1-2.609,2.975v1.579a2,2,0,0,1-2,2H11.328l-.374-3.972A1.65,1.65,0,0,0,9.38,17.059H7.5a1.65,1.65,0,0,0-1.574,1.714l-.439,3.972h0Zm1.269-8.112a1.731,1.731,0,0,0,1.651,1.8,1.8,1.8,0,0,0,0-3.6A1.731,1.731,0,0,0,6.755,14.633ZM1.727,5.842A2.957,2.957,0,1,1,4.684,8.8,2.957,2.957,0,0,1,1.727,5.842ZM9.634,2.957A2.957,2.957,0,1,1,12.59,5.914,2.957,2.957,0,0,1,9.634,2.957Z"></path>
                </svg><span>Next of
                    Kin</span>
            </button>
        </div>
    </div>
    <div class="locked_area col-lg-8 order-0 order-lg-1  mb-1">
        <div class="btn-col ">
            <button class="btn btn-allebone-center w-100">
                <div class="d-flex align-items-center justify-content-md-between flex-md-row flex-column">
                    <div>
                        <span>{{ $success_array['patient_details']['patient_ward_bed_info'] }} </span>
                    </div>
                    <div>
                        <span>{{ $success_array['patient_details']['patient_name_age'] }}</span>
                    </div>
                    <div>
                        @if(strtolower($success_array['patient_details']['ibox_ward_short_name']) != 'rltsauip')
                            <span>LOS {{ PatientLos($success_array['patient_details']['camis_patient_admission_date_time']) }} Total With {{ !empty($success_array['patient_details']['camis_patient_ward_start_date']) ? PatientLos($success_array['patient_details']['camis_patient_ward_start_date']) : PatientLos($success_array['patient_details']['camis_patient_admission_date_time']) }} On This Ward</span>
                        @else

                            @php
                                $ward_start = $success_array['patient_details']['camis_patient_ward_start_date'] ?? null;
                                $admission = $success_array['patient_details']['camis_patient_admission_date_time'];
                                $start = (!empty($ward_start) && strtotime($ward_start)) ? $ward_start : $admission;
                                $los_min = NumberOfMinutesBetweenTwoDates($start, CurrentDateOnFormat());
                            @endphp

                            <span>LOS {{ floor($los_min / 60) }} Hours {{ $los_min % 60 }} Minutes</span>

                        @endif
                    </div>
                </div>

            </button>
        </div>
    </div>
    <div class="col-lg-2 col-md-6 order-2 order-lg-2  mb-1">
        <div class="btn-col ">
            <button class="btn btn-allebone w-100" id="board_round_close" onclick="CloseBoardRound('{{ strtolower($success_array['patient_details']['ibox_ward_short_name']) }}')"><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg"
                                                        class="btn-icon" alt="" width="14"><span>Close</span>
            </button>
        </div>
    </div>
    @else
    <div class="locked_area col-lg-2 col-md-2 mb-1 order-md-1 order-2 {{ PermissionDeniedDiv('camis_next_of_kin_view') }}">
        <div class="btn-col click_popup_open_ibox_board_round_nok {{ DisabledButtonOnRolePermission('camis_next_of_kin_view') }}">
            <button class="btn btn-allebone w-100 "><svg xmlns="http://www.w3.org/2000/svg" width="17.002" height="18" viewBox="0 0 17.002 22.745" class="btn-icon">
                    <path id="Union_20" data-name="Union 20" d="M5.486,22.745H4.418a2,2,0,0,1-2-2V19.191H1.7a1.705,1.705,0,0,1-1.7-1.7V14.082A4.262,4.262,0,0,1,4.257,9.825h2.2a3.39,3.39,0,0,1,1.333.271V9.814a3,3,0,0,1,3-3H14a3,3,0,0,1,3,3V16.19a3.005,3.005,0,0,1-2.609,2.975v1.579a2,2,0,0,1-2,2H11.328l-.374-3.972A1.65,1.65,0,0,0,9.38,17.059H7.5a1.65,1.65,0,0,0-1.574,1.714l-.439,3.972h0Zm1.269-8.112a1.731,1.731,0,0,0,1.651,1.8,1.8,1.8,0,0,0,0-3.6A1.731,1.731,0,0,0,6.755,14.633ZM1.727,5.842A2.957,2.957,0,1,1,4.684,8.8,2.957,2.957,0,0,1,1.727,5.842ZM9.634,2.957A2.957,2.957,0,1,1,12.59,5.914,2.957,2.957,0,0,1,9.634,2.957Z"></path>
                </svg><span>Next of
                    Kin</span>
            </button>
        </div>
    </div>
    <div class="locked_area col-lg-10 col-md-10 mb-1 order-md-2 order-1">
        <div class="btn-col ">
            <button class="btn btn-allebone-center w-100">
                <div class="d-flex align-items-center justify-content-md-between flex-md-row flex-column">
                    <div>
                        <span>{{ $success_array['patient_details']['patient_ward_bed_info'] }} </span>
                    </div>
                    <div>
                        <span>{{ $success_array['patient_details']['patient_name_age'] }}</span>
                    </div>
                    <div>
                        @if(strtolower($success_array['patient_details']['ibox_ward_short_name']) != 'rltsauip')
                            <span>LOS {{ PatientLos($success_array['patient_details']['camis_patient_admission_date_time']) }} Total With {{ !empty($success_array['patient_details']['camis_patient_ward_start_date']) ? PatientLos($success_array['patient_details']['camis_patient_ward_start_date']) : PatientLos($success_array['patient_details']['camis_patient_admission_date_time']) }} On This Ward</span>
                        @else

                            @php
                                $ward_start = $success_array['patient_details']['camis_patient_ward_start_date'] ?? null;
                                $admission = $success_array['patient_details']['camis_patient_admission_date_time'];
                                $start = (!empty($ward_start) && strtotime($ward_start)) ? $ward_start : $admission;
                                $los_min = NumberOfMinutesBetweenTwoDates($start, CurrentDateOnFormat());
                            @endphp

                            <span>LOS {{ floor($los_min / 60) }} Hours {{ $los_min % 60 }} Minutes</span>
                        @endif
                    </div>
                </div>

            </button>
        </div>
    </div>
    @endif
</div>
<div class="row gx-2 locked_area">
    <div class="col-xxl-6">
        <div class="row gx-2">
            <div class="col-lg-6">
                <button  class="btn btn-allebone w-100 mb-1  search_ane_patient_history_symphony {{ DisabledButtonOnRolePermission('camis_ane_discharge_summary_view') }}">
                    <img src="{{ asset('asset_v2/Template') }}/icons/gist.svg" alt="" class="btn-icon"><span>VIEW A&E DISCHARGE
                                            SUMMARY</span>
                </button>
                <div class="mb-1">
                    <div class="card-medical-reports {{ PermissionDeniedDiv('camis_admitting_reason_update') }}">
                        <div class="header-reports">
                            <p class="header-texarea mb-0">Admitting Reason
                            </p>
                            <span class="update-time camis_popup_ibox_board_round_admitting_reason_date" >@isset($success_array['patient_details']['board_round_admitting_reason']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_admitting_reason']['updated_at'])}} @endisset</span>
                        </div>
                        <div class="reports-content cursor_pointer {{ DisabledButtonOnRolePermission('camis_admitting_reason_update') }}" id="admitting_reason_modal" >
                            <span class="camis_popup_ibox_board_round_admitting_reason_data_show">@isset($success_array['patient_details']['board_round_admitting_reason']['patient_admitting_reason']) {{$success_array['patient_details']['board_round_admitting_reason']['patient_admitting_reason']}} @endisset</span>
                        </div>
                    </div>
                    <div class="card-medical-reports {{ PermissionDeniedDiv('camis_past_medical_history_update') }}">
                        <div class="header-reports">
                            <p class="header-texarea mb-0">Past Medical History
                            </p>
                            <span class="update-time camis_popup_ibox_board_round_past_medical_history_date" >@isset($success_array['patient_details']['board_round_past_medical_history']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_past_medical_history']['updated_at'])}} @endisset</span>
                        </div>
                        <div class="reports-content cursor_pointer {{ DisabledButtonOnRolePermission('camis_past_medical_history_update') }}" id="past_medical_history_modal" >
                            <span class="camis_popup_ibox_board_round_past_medical_history_data_show">@isset($success_array['patient_details']['board_round_past_medical_history']['patient_past_medical_history']) {{$success_array['patient_details']['board_round_past_medical_history']['patient_past_medical_history']}} @endisset</span>
                        </div>
                    </div>
                    <div class="card-medical-reports {{ PermissionDeniedDiv('camis_social_history_update') }}">
                        <div class="header-reports">
                            <p class="header-texarea mb-0">Social History
                            </p>
                            <span class="update-time camis_popup_ibox_board_round_social_history_date">@isset($success_array['patient_details']['board_round_social_history']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_social_history']['updated_at'])}} @endisset</span>
                        </div>
                        <div class="reports-content cursor_pointer {{ DisabledButtonOnRolePermission('camis_social_history_update') }}" id="social_history_modal">
                            <span class="camis_popup_ibox_board_round_social_history_data_show" >@isset($success_array['patient_details']['board_round_social_history']['patient_social_history']) {{$success_array['patient_details']['board_round_social_history']['patient_social_history']}} @endisset</span>
                        </div>
                    </div>
                    <div class="card-medical-reports {{ PermissionDeniedDiv('camis_patient_goal_update') }}">
                        <div class="header-reports">
                            <p class="header-texarea mb-0">Patient Goal
                            </p>
                            <span class="update-time camis_popup_ibox_board_round_patient_goal_date">@isset($success_array['patient_details']['board_round_patient_goal']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_patient_goal']['updated_at'])}} @endisset</span>
                        </div>
                        <div class="reports-content cursor_pointer {{ DisabledButtonOnRolePermission('camis_patient_goal_update') }}" id="patient_goal_modal">
                            <span class="camis_popup_ibox_board_round_patient_goal_data_show" >@isset($success_array['patient_details']['board_round_patient_goal']['patient_patient_goal']) {{$success_array['patient_details']['board_round_patient_goal']['patient_patient_goal']}} @endisset</span>
                        </div>
                    </div>

                    <div class="">
                        <div class="card-table">
                            <div>
                                <table class="table-allebone">
                                    <tbody>
                                    <tr class="bg-white">
                                        <td class=" border-end">Hospital Number</td>
                                        <td class="">{{ $success_array['patient_details']['camis_patient_pas_number'] }}</td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="border-end">Consultant</td>
                                        <td class="boardround_patient_consultant_full_name_show">{{ $success_array['patient_details']['camis_consultant_name'] }}</td>
                                    </tr>
                                    <tr class="bg-white">
                                        <td class="border-end">Speciality</td>
                                        <td class="position-relative">{{ $success_array['patient_details']['camis_consultant_code_description'] .' (' .$success_array['patient_details']['camis_consultant_specialty'] .')' }} @if($success_array['patient_details']['camis_outlier_status'] == 1) <span class="bg-outlier"> Outlier </span> @endif </td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="border-end">Admission Type</td>
                                        <td class="position-relative"> @if(isset($success_array['patient_details']['ip_admission_type_description'])) {{  ucwords($success_array['patient_details']['ip_admission_type_description']) }}   @endif  </td>
                                    </tr>
                                    <tr class="bg-white @if(strtolower($success_array['patient_details']['ibox_ward_short_name']) == 'rltsauip') board_round_done @endif">
                                        <td class="border-end">EDD</td>
                                        <td class="{{ PermissionDeniedDiv('camis_edd_update') }}">
                                            @if(!isset($success_array['patient_details']['board_round_estimated_discharge_date']['patient_estimated_discharge_date']))
                                                <button name="board_round_edd_button  " class="btn btn-edd w-100 click_popup_open_ibox_board_round_edd {{ DisabledButtonOnRolePermission('camis_edd_update') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign EDD">
                                                    CLICK TO
                                                    ENTER EDD
                                                </button>
                                            @else
                                                <button name="" class="btn btn-edd w-100 click_popup_open_ibox_board_round_edd {{ DisabledButtonOnRolePermission('camis_edd_update') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Re Assign EDD">
                                                    {{ IboxEstimatedDischargeDateShowBoardround($success_array['patient_details']['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) }}
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="border-end"> PatienTrack </td>
                                        <td class="pac-data-cell">
                                            <table class="virtual-pac-data">
                                                <tbody><tr>
                                                    <td>
                                                        <div class="pac-data ews-section">

                                                            @if(isset($success_array['patient_details']['patient_vital_pac_info']['totalews']) && $success_array['patient_details']['patient_vital_pac_info']['totalews'] >= 5)

                                                            <div class="ews-wrapper ews-high-value">
                                                                <span class="ews-text">{{ $success_array['patient_details']['patient_vital_pac_info']['totalews'] }}</span>
                                                            </div>
                                                            @elseif(isset($success_array['patient_details']['patient_vital_pac_info']['totalews']) && $success_array['patient_details']['patient_vital_pac_info']['totalews'] < 5)
                                                                <div class="ews-wrapper ews-low-value">
                                                                    <span class="ews-text">{{ $success_array['patient_details']['patient_vital_pac_info']['totalews'] }}</span>
                                                                </div>
                                                            @else
                                                                <div class="ews-wrapper ews-low-value">
                                                                    <span class="ews-text">--</span>
                                                                </div>
                                                            @endif
                                                            <span class="vitals">EWS</span>

                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="pac-data">
                                                            @if(isset($success_array['patient_details']['patient_vital_pac_info']['alert_value']) && $success_array['patient_details']['patient_vital_pac_info']['alert_value'] >0)
                                                            <span class="pac-count">{{ $success_array['patient_details']['patient_vital_pac_info']['alert_value'] ?? 0 }}</span>
                                                            <div>AKI</div>
                                                            @else
                                                                <span class="pac-count"> --  </span>
                                                                <div>AKI</div>
                                                            @endif
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="pac-data">
                                                            @if(isset($success_array['patient_details']['patient_vital_pac_info']['oxygen_val']) && $success_array['patient_details']['patient_vital_pac_info']['oxygen_val'] > 0)
                                                                <span class="pac-count">{{ $success_array['patient_details']['patient_vital_pac_info']['oxygen_val'] ?? '--' }}</span>
                                                            @else
                                                                <span class="pac-count">--</span>
                                                            @endif
                                                            <div>OXYGEN<br>SATURATION </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="pac-data">
                                                            @if(isset($success_array['patient_details']['patient_vital_pac_info']['temperature_val']) && $success_array['patient_details']['patient_vital_pac_info']['temperature_val'] > 0)
                                                                <span class="pac-count">{{ VitalPacTemperatureFormat($success_array['patient_details']['patient_vital_pac_info']['temperature_val'] ?? '--') }}</span>
                                                            @else
                                                                <span class="pac-count">--</span>
                                                            @endif
                                                            <div>TEMPERATURE</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    <tr class="bg-white">
                                        <td class="border-end">Obs Taken</td>
                                        @if(isset($success_array['patient_details']['patient_vital_pac_info']['time_started_obs']) && !empty($success_array['patient_details']['patient_vital_pac_info']['time_started_obs']))
                                            <td>{{ PredefinedDateFormatFor24Hour($success_array['patient_details']['patient_vital_pac_info']['time_started_obs']) }}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="border-end">Obs Due</td>
                                        @if(isset($success_array['patient_details']['patient_vital_pac_info']['next_obs_due']) && !empty($success_array['patient_details']['patient_vital_pac_info']['next_obs_due']))
                                            <td>{{ PredefinedDateFormatFor24Hour($success_array['patient_details']['patient_vital_pac_info']['next_obs_due']) }}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                    </tr>


                                    <tr class="bg-white cursor_pointer ward_movement_history_details {{ PermissionDeniedDiv('camis_movement_history_view') }}">
                                        <td class=" border-end">Ward Movement</td>
                                        <td class="{{ DisabledButtonOnRolePermission('camis_movement_history_view') }}">{{ $success_array['patient_details']['camis_patient_ward_stay_number'] }} Moves</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="covid_status_bg" class="@if($success_array['camis_ic_status'] != 'none') {{ $success_array['camis_ic_status'] == 'posetive' ? 'bg-covid-positive' : 'bg-covid-negative' }}  w-100 mb-1 @else btn w-100 mb-1 d-none @endif">
                     <span id="covid_status_text">{{ $success_array['camis_ic_text'] ?? '' }}</span>
                </div>
                <div class="btn btn-boardround-tasks w-100 mb-1 click_open_boardround_outstanding_task_offcanvas">
                    <span>Outstanding Results</span>
                </div>
                <div class="ward-icons-wrapper">
                    @foreach ($success_array['show_flag_list'] as $flags)
                        <div class="card-hex-icons mb-1 {{ DisabledButtonOnRolePermission('camis_flag_update') }}">
                            <div class="icon-wrap">
                                <div class="d-flex align-items-start">
                                    @foreach($flags['flag_list'] as $flag)
                                        <div class="icon-col @if (!in_array($flag['patient_flag_stored_name'], ['ibox_patient_flag_dementia', 'ibox_patient_flag_palliative_care', 'ibox_patient_flag_diabetic', 'ibox_patient_flag_end_of_life'])) cursor_pointer ibox_board_round_patient_flag_list_assign @else button_disabled  @endif ibox_board_round_patient_flag_active_{{ $flag['patient_flag_stored_name'] }} @if(CheckSpecificBedFlagsExitsOnArray($success_array['patient_details']['patient_wise_flags'], $flag['patient_flag_stored_name'])) flag_active @else flag_inactive @endif"  data-patient-flag-show-name="{{ $flag['patient_flag_name'] }}" data-patient-flag-stored-name="{{ $flag['patient_flag_stored_name'] }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $flag['patient_flag_name'] }}">
                                            <img  src="{{ asset('asset_v2/Template/icons/ward_icons/'.str_replace('ibox_patient_flag_', '', $flag['patient_flag_stored_name']).'.png') }}" alt="" id="assign_bed_flag" >
                                            <p >{{ $flag['patient_flag_name'] }}</p>
                                        </div>
                                        @if($loop->parent->last && $loop->last)
                                        @if(isset($success_array['patient_details']['patient_vital_pac_info']['alert_value']) && in_array($success_array['patient_details']['patient_vital_pac_info']['alert_value'], ['Stage 1', 'Stage 2','Stage 3', 'Stage DNR']))
                                                <div class="icon-col " data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $flag['patient_flag_name'] }}">
                                                    <img src="{{ asset('asset_v2/Template/icons/ward_icons/'.str_replace(' ', '_', $success_array['patient_details']['patient_vital_pac_info']['alert_value']).'.png') }}" alt="" >
                                                    <p>AKI</p>
                                                </div>
                                            @else
                                                <div class="icon-col  flag_inactive " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Stage 0">
                                                    <img src="{{ asset('asset_v2/Template/icons/ward_icons/Stage_AKI.png') }}" alt="" id="assign_bed_flag">
                                                    <p>AKI</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    @endforeach
            </div>
            <div class="card-icons mb-1">


                <div class="row gx-2">
                    <div class="col-lg-12 mb-1">
                        <div class="rectangle-block-1 therapy-section">
                            <div class="row gx-2 align-items-center w-100">
                                <div class="col-4 ">
                                    <h6 class="mb-0">Therapy fit</h6>
                                </div>
                                <div class="col-8 gx-0 text-end" id="therapyFitSection">
                                    <button name="" data-therapy-fit="0" class="btn btn-medfit-no click_open_patient_therapy_status  @if((isset($success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status']) && $success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status'] == 0) || !isset($success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status'])) active @else @endif">NO</button>
                                    <button data-therapy-fit="1"  class="btn btn-medfit-yes click_open_patient_therapy_status  @if(isset($success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status']) && $success_array['patient_details']['board_round_therapy_fit_data']['patient_therapy_fit_status'] == 1) active @else  @endif">
                                        YES
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="rectangle-block-1 medfit-section">
                            <div class="row gx-2 align-items-center w-100 medfit_div_area">
                                <div class="col-4  ">
                                    <h6 class="mb-0">Medically Fit</h6>
                                </div>
                                <div class="col-8 gx-0 text-end" id="medfitSection">
                                    <button name="" class="btn btn-medfit-no {{ DisabledButtonOnRolePermission('camis_reason_to_reside_update') }} click_popup_open_ibox_board_round_medfit_no @if((isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 0) || !isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'])) active @else @endif">
                                        No</button>
                                    <button class="{{ DisabledButtonOnRolePermission('camis_medfit_yes_update') }} btn btn-medfit-yes click_popup_open_ibox_board_round_medfit_yes @if(isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) active @else  @endif" name=""
                                            data-bs-dismiss="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_reason_to_reside" aria-label="Close">
                                        Yes
                                    </button>

                                </div>
                            </div>
                        </div>


                        <div class="reason-reside">
                            <div class="rectangle-block-1">
                                <div class="row gx-2 align-items-center w-100 {{ PermissionDeniedDiv('camis_reason_to_reside_update') }}">
                                    <div class="col-md-4">
                                        <div class="reason-reside-header">
                                            <p class="mb-0">Reason to Reside</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 cursor_pointer click_popup_open_ibox_board_round_medfit_no {{ DisabledButtonOnRolePermission('camis_reason_to_reside_update') }}">
                                        <div class="card-boxes">
                                            @if(isset($success_array['patient_details']['board_round_reason_to_reside']) && isset($success_array['patient_details']['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']))

                                                <a class="btn mb-0 click_popup_open_ibox_board_round_reason_to_reside_show_category">{{str_replace('.', ',',str_replace('_', ' ', ucwords($success_array['patient_details']['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category'])))}}

                                                </a>
                                            @else
                                                <a class="btn mb-0 click_popup_open_ibox_board_round_reason_to_reside_show_category">No Reason To Reside</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    @if(!request()->has('stranded_patient'))

                    <div class="col-lg-12 mb-1 {{ PermissionDeniedDiv('camis_bed_red_green_update') }}">
                        <div class="card-R2G cursor-pointer {{ DisabledButtonOnRolePermission('camis_bed_red_green_update') }} click_popup_open_ibox_board_round_green_red_reason" >
                            <div class="row gx-2 align-items-center ">
                                <div class="col-lg-5 col-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="90" height="40" viewBox="0 0 71.397 32.863">
                                        <path id="Subtraction_64" data-name="Subtraction 64" d="M57.453,32.863a19.5,19.5,0,0,1-2.98-.225l.027.036H45.048V27.3H30.613v-.135l7.8-7.595c3.5-3.518,6.188-6.532,6.188-10.6,0-3.991-2.494-7.213-6.673-8.618H53.261l-.052.1A18.058,18.058,0,0,1,57.3,0c7.32,0,12.871,4.343,13.812,10.807h-6.6A7.117,7.117,0,0,0,57.322,5.5c-5.2,0-8.3,4.017-8.3,10.746,0,6.842,3.272,11.093,8.541,11.093,4.3,0,7.279-2.654,7.408-6.6l.021-.507H58.149V15.386H71.4v3.589C71.4,27.671,66.185,32.863,57.453,32.863ZM6.7,32.675H0V.344H13.221c.33,0,.655.008.965.024L14.177.352H28.56a9.961,9.961,0,0,0-7.153,9.714v.111h6.209v-.111a5.079,5.079,0,0,1,1.529-3.7A5.518,5.518,0,0,1,33.006,4.89c2.9,0,5.08,1.869,5.08,4.346,0,2.23-.95,3.833-4.237,7.149L21.784,28.129v4.545H18.143l-5.962-11.83H6.7v11.83Zm0-27.044V15.938h5.877c3.347,0,5.346-1.927,5.346-5.156,0-3.129-2.123-5.151-5.41-5.151Z"></path>
                                    </svg>
                                </div>
                                <div class="col-lg-7 col-8 text-end">
                                    <button class="btn btn-danger width-btn-adjust mb-xxl-1"><img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" class="me-2" width="18" height="18"  id="red_bed" @if(isset($success_array['patient_details']['red_green_bed']['patient_red_green_status']) && $success_array['patient_details']['red_green_bed']['patient_red_green_status'] == 1) style="display:inline;" @else style="display:none;" @endif> Red
                                        Bed</button>
                                    <button class="btn btn-success width-btn-adjust"><img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" id="green_bed"  class="me-2" width="18" height="18" @if(isset($success_array['patient_details']['red_green_bed']['patient_red_green_status']) && $success_array['patient_details']['red_green_bed']['patient_red_green_status'] == 2) style="display:inline;" @else style="display:none;" @endif>Green Bed</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else

                    <div class="col-12 mb-1 {{ PermissionDeniedDiv('camis_bed_red_green_update') }}">
                        <div class="card-R2G cursor-pointer {{ DisabledButtonOnRolePermission('camis_bed_red_green_update') }} click_popup_open_ibox_board_round_green_red_reason" >
                            <div class="row gx-2 align-items-center ">
                                <div class="col-lg-5 col-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="90" height="40" viewBox="0 0 71.397 32.863">
                                        <path id="Subtraction_64" data-name="Subtraction 64" d="M57.453,32.863a19.5,19.5,0,0,1-2.98-.225l.027.036H45.048V27.3H30.613v-.135l7.8-7.595c3.5-3.518,6.188-6.532,6.188-10.6,0-3.991-2.494-7.213-6.673-8.618H53.261l-.052.1A18.058,18.058,0,0,1,57.3,0c7.32,0,12.871,4.343,13.812,10.807h-6.6A7.117,7.117,0,0,0,57.322,5.5c-5.2,0-8.3,4.017-8.3,10.746,0,6.842,3.272,11.093,8.541,11.093,4.3,0,7.279-2.654,7.408-6.6l.021-.507H58.149V15.386H71.4v3.589C71.4,27.671,66.185,32.863,57.453,32.863ZM6.7,32.675H0V.344H13.221c.33,0,.655.008.965.024L14.177.352H28.56a9.961,9.961,0,0,0-7.153,9.714v.111h6.209v-.111a5.079,5.079,0,0,1,1.529-3.7A5.518,5.518,0,0,1,33.006,4.89c2.9,0,5.08,1.869,5.08,4.346,0,2.23-.95,3.833-4.237,7.149L21.784,28.129v4.545H18.143l-5.962-11.83H6.7v11.83Zm0-27.044V15.938h5.877c3.347,0,5.346-1.927,5.346-5.156,0-3.129-2.123-5.151-5.41-5.151Z"></path>
                                      </svg>
                                </div>
                                <div class="col-lg-7 col-8 text-end">
                                    <button class="btn btn-danger width-btn-adjust mb-xxl-1"><img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" class="me-2" width="18" height="18"  id="red_bed" @if(isset($success_array['patient_details']['red_green_bed']['patient_red_green_status']) && $success_array['patient_details']['red_green_bed']['patient_red_green_status'] == 1) style="display:inline;" @else style="display:none;" @endif> Red
                                        Bed</button>
                                    <button class="btn btn-success width-btn-adjust"><img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" id="green_bed"  class="me-2" width="18" height="18" @if(isset($success_array['patient_details']['red_green_bed']['patient_red_green_status']) && $success_array['patient_details']['red_green_bed']['patient_red_green_status'] == 2) style="display:inline;" @else style="display:none;" @endif>Green Bed</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="level-wrapper">
                        <div class="level-button-group" id="levelSection">

                            <button class="btn btn-ccu-level-succcess level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 2) active @endif"  id="level_div_2"  data-level-id="2">Level 1 <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3" id="level_img_2" width="18" height="18"></button>
                            <button class="btn btn-ccu-level-amber level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 3) active @endif"  id="level_div_3"  data-level-id="3">Level 2 <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3 " id="level_img_3" width="18" height="18"></button>
                            <button class="btn btn-ccu-level-danger level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 4) active @endif"  id="level_div_4"  data-level-id="4">Level 3 <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3 " id="level_img_4" width="18" height="18"></button>


                        </div>
                    </div>
                </div>











                <div class="btn-grp-pharmacy">
                    <div class="row mb-1">
                        <div class="col-lg-4 col-md-4 col-4 pe-1 {{ PermissionDeniedDiv('camis_pharmacy_update') }}">
                            <a
                                class="btn btn-darkcyan mb-1 w-100 click_popup_open_ibox_board_round_pharmacy {{ DisabledButtonOnRolePermission('camis_pharmacy_update') }}">Pharmacy <svg
                                    xmlns="http://www.w3.org/2000/svg" width="13"
                                    height="13" viewBox="0 0 22.052 22.059">
                                    <g id="plus-svgrepo-com" transform="translate(0 0)">
                                        <path id="Path_20866" data-name="Path 20866"
                                              d="M8.1,22.059a.732.732,0,0,1-.733-.733V14.742H.783A.732.732,0,0,1,.05,14.01V8.052a.732.732,0,0,1,.732-.732H7.366V.733A.733.733,0,0,1,8.1,0h5.956a.732.732,0,0,1,.733.733V7.317h6.582a.732.732,0,0,1,.733.733v5.958a.732.732,0,0,1-.732.732H14.786v6.585a.732.732,0,0,1-.732.732Zm0-8.782a.732.732,0,0,1,.733.733v6.585H13.32V14.008a.732.732,0,0,1,.732-.732h6.583V8.782H14.055a.733.733,0,0,1-.733-.733V1.465H8.832V8.051a.732.732,0,0,1-.732.732H1.516v4.493Z"
                                              transform="translate(-0.05 0)" fill="#fff" />
                                    </g>
                                </svg></a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4 pe-1 ps-1 {{ PermissionDeniedDiv('camis_antibiotics_update') }}">
                            <button class="btn btn-black mb-1 w-100 patient_pharmacy_antibiotic_iv {{ DisabledButtonOnRolePermission('camis_antibiotics_update') }}" @if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1) data-antibiotic-iv='1' @else data-antibiotic-iv='0' @endif>

                                Antibiotic IV
                                <div class="lh-12">
                                    <span class="date-time-stamp patient_antibiotic_iv_updated_date">
                                        @if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 && !empty($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))
                                            {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="lh-12">
                                    <span class="date-time-stamp patient_antibiotic_iv_updated_timestamp">@if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 && !empty($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))
                                            Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}
                                        @endif
                                    </span>
                                </div>
                            </button>

                        </div>
                        <div class="col-lg-4 col-md-4 col-4 ps-1 {{ PermissionDeniedDiv('camis_antibiotics_update') }}">
                            <button class="btn btn-black mb-1 w-100 patient_pharmacy_antibiotic_oral {{ DisabledButtonOnRolePermission('camis_antibiotics_update') }}" @if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1) data-antibiotic-oral='1' @else data-antibiotic-oral='0' @endif>

                                Antibiotics Oral
                                <div class="lh-12">
                                    <span class="date-time-stamp patient_antibiotic_oral_updated_date text-white">
                                        @if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1 && !empty($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))
                                            {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="lh-12">
                                    <span class="date-time-stamp patient_antibiotic_oral_updated_timestamp">
                                        @if (isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) && $success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1 && !empty($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))
                                            Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}
                                        @endif
                                    </span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row gx-2">
                    <div class="col-lg-12">
                        <div class="title-pharmacy">
                            <h6 class="mb-1">Pharmacy Comment (Latest)</h6>
                        </div>
                                                <textarea class="form-control ibox_board_round_pharmacy_updated_comment_show  @if($success_array['camis_ic_status'] == 'none') custom_height_boardround_page @else custom_height_boardround_page_with_ic @endif" id="ibox_board_round_pharmacy_updated_comment_show"
                                                           readonly>{{ $success_array["pharmacy_latest_comment"] }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="col-xxl-6 ">
    <div class="row gx-2 height-adjust">
        <div class="col-lg-6 col-md-6 mb-1">
            <div class=" {{ PermissionDeniedDiv('camis_task_management_add') }}">
                <input type="text" class="form-control ibox_board_round_patient_task_description_open {{ DisabledButtonOnRolePermission('camis_task_management_add') }}" id="ibox_board_round_patient_task_description_open"
                       placeholder="Type here to add new task or filter tasks below">
            </div>
        </div>
{{--        <div class="col-lg-3 col-md-4 col-6 mb-1 ">--}}
{{--            <button class="btn btn-allebone w-100  {{ DisabledButtonOnRole() }}" >--}}

{{--            </button>--}}

{{--        </div>--}}
{{--        <div class="col-lg-3 col-md-4 col-6 mb-1 {{ PermissionDeniedDiv('camis_doctor_at_night_view') }}">--}}
{{--            <button class="btn btn-allebone w-100 click_popup_open_ibox_board_round_doctors_at_night {{ DisabledButtonOnRolePermission('camis_doctor_at_night_view') }}">--}}
{{--                <img src="{{ asset('asset_v2/Template/icons/night-doctor.svg') }}" class="btn-icon" alt=""--}}
{{--                     width="15"><span>Doctor--}}
{{--                        at--}}
{{--                        Night</span>--}}
{{--            </button>--}}

{{--        </div>--}}
        <div class="col-lg-6 col-md-6 mb-1 @if(CheckDashboardPermission('camis_allowed_to_move_update')) permission_applicable @else  {{ DisabledButtonOnRole() }} @endif">
            <button class="btn btn-allebone w-100 allowed_to_move_color @if(CheckDashboardPermission('camis_allowed_to_move_update')) click_popup_open_ibox_board_round_allowed_to_move @else  {{ DisabledButtonOnRole() }} @endif   @if(isset($success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']) && $success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to'] == 'Do Not Move') bg-btn-red @endif">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                     viewBox="0 0 24.269 24.269" class="btn-icon img-fluid">
                    <g id="bed-single-hotel-svgrepo-com" transform="translate(-1.75 -1.75)">
                        <path id="Path_21440" data-name="Path 21440" d="M6,9h4.837"
                              transform="translate(0.628 1.256)" fill="none" stroke="#000"
                              stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" />
                        <path id="Path_21441" data-name="Path 21441"
                              d="M3,3V24.769m21.769-4.837v4.837m0-4.837H3m21.769,0V16.3a2.419,2.419,0,0,0-2.419-2.419H3"
                              fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2.5" />
                    </g>
                </svg><span class="allowed_to_move_text">@if(isset($success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to'])) {{ isset($success_array['ward_array'][$success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']]) ? $success_array['ward_array'][$success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']] : 'Do Not Move' }}
                 @else Allowed
                    to be
                    Moved? @endif</span>
            </button>
        </div>
    </div>
    <div class="row ibox_board_round_patient_task_content_show gx-2"  id="col-width-adjust">

        @include('Dashboards.Camis.WardSummary.UserTask')
    </div>



    <div class="care-pathway-section" id="care">
        <div class="row gx-2">
            <div class="col-md-12">
                <div class="rectangle-block-1 mb-1">
                    <div class="row ">
                        <div class="col-lg-12">

                            <div class="pathway-history @if(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 1)  bg-green  @endif">
                                <p class="mb-0"> Complex Discharge Team (CDT)</p>
                                @if(isset($success_array['patient_details']['board_round_pathway_requirement']) && $success_array['patient_details']['board_round_pathway_requirement']['planned_discharge_date'] != null)
                                <span>{{ PredefinedYearFormat($success_array['patient_details']['board_round_pathway_requirement']['planned_discharge_date']) }}</span>
                                @endif
                                <div class="">
                                    <button class="btn btn-pathway-history show_pathway_history">Pathway
                                            History</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row gx-2 care-block">


                        <div class="col-md-3 mb-2 mb-lg-0">
                            <div id="cdtButton" class="cdt-btn">
                                <input hidden id="cdt_status"  @if(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) ) value="{{ $success_array['patient_details']['board_round_cdt']['cdt_status'] }}" @endif>


                                @if(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 0)
                                    <button id="cdt_to_review" class="btn btn-primary-grey   bg-amber careRequermentWrap  "> <span id="cdt_text_in_boardround">CDT Referral</span>
                                        <span class="pdna-date cdt_to_review_time @if(!isset($success_array['patient_details']['board_round_cdt']['request_date'])) d-none @endif ">@if(isset($success_array['patient_details']['board_round_cdt']['request_date'])) {{ $success_array['patient_details']['board_round_cdt']['request_by_username'] }} - {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_cdt']['request_date']) }}  @endif</span>
                                    </button>
                                @elseif(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 1)
                                    <button id="cdt_to_review" class="btn btn-primary-grey   careRequermentWrap  bg-complete "> <span id="cdt_text_in_boardround">CDT Referral Accepted</span>
                                        <span class="pdna-date cdt_to_review_time ">@if(isset($success_array['patient_details']['board_round_cdt']['accepted_date'])) {{ $success_array['patient_details']['board_round_cdt']['accepted_by_username'] ?? '' }} - {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_cdt']['accepted_date']) }}  @endif</span>

                                    </button>
                                @elseif(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 2)
                                    <button id="cdt_to_review" class="btn btn-primary-grey   careRequermentWrap   bg-amber "> <span id="cdt_text_in_boardround">To Review</span>
                                        <span class="pdna-date cdt_to_review_time">@if(isset($success_array['patient_details']['board_round_cdt']['to_be_review_date'])) {{ $success_array['patient_details']['board_round_cdt']['reviewed_by_username'] ?? '' }} - {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_cdt']['to_be_review_date']) }}  @endif</span>

                                    </button>
                                @elseif(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 3)
                                    <button id="cdt_to_review" class="btn btn-primary-grey     bg-red   cdt_to_review_offcanvas "> <span id="cdt_text_in_boardround">CDT Referral Rejected</span>
                                        <span class="pdna-date cdt_to_review_time"> @if(isset($success_array['patient_details']['board_round_cdt']['rejected_date'])) {{ $success_array['patient_details']['board_round_cdt']['rejected_by_username'] ?? '' }} - {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_cdt']['rejected_date']) }}  @endif </span>

                                    </button>
                                @elseif(isset($success_array['patient_details']['board_round_cdt']['cdt_status']) && $success_array['patient_details']['board_round_cdt']['cdt_status'] == 4)
                                    <button id="cdt_to_review" class="btn btn-primary-grey     bg-red   cdt_to_review_offcanvas "> <span id="cdt_text_in_boardround">CDT Referral Removed</span>
                                        <span class="pdna-date cdt_to_review_time"> @if(isset($success_array['patient_details']['board_round_cdt']['removed_at'])) {{ $success_array['patient_details']['board_round_cdt']['removed_by_username'] ?? '' }} - {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_cdt']['removed_at']) }}  @endif </span>

                                    </button>
                                @else
                                    <button id="cdt_to_review" class="btn btn-primary-grey       cdt_to_review "> <span id="cdt_text_in_boardround">CDT Referral</span>
                                        <span class="pdna-date cdt_to_review_time d-none"></span>


                                    </button>
                                @endif

                            </div>
                        </div>




                        <div class="col-md-3 mb-2 mb-lg-0 careRequermentWrap">
                            <div class="skyblue-box">
                                <div class="label-box d-flex align-items-center justify-content-between mb-2">
                                    <label for="dtoc_service_boardround" class="form-label mb-0 fs-12">Authority</label>
                                    @if(isset($success_array['patient_details']['board_round_pathway_requirement']) && isset($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) )
                                    <span class="date-field">{{ PredefinedDateFormatWithoutDayName($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <input type="text" class="form-control" id="dtoc_service_boardround"
                                           placeholder="{{ $success_array['patient_details']['board_round_pathway_requirement']['dtoc_service_text'] ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 mb-lg-0 careRequermentWrap">
                            <div class="skyblue-box">
                                <div class="label-box d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label mb-0 fs-12">Service</label>
                                    @if(isset($success_array['patient_details']['board_round_pathway_requirement']) && isset($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) )
                                        <span class="date-field">{{ PredefinedDateFormatWithoutDayName($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <input type="text" class="form-control" value="{{ $success_array['patient_details']['board_round_pathway_requirement']['service_by_pathway_text'] ?? '' }}"  readonly >
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 mb-2 mb-lg-0 {{ PermissionDeniedDiv('camis_pathway_agreed_update') }}">
                            <div class="path_way_selectbox skyblue-box  @if(isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)  @else careRequermentWrap @endif">
                                <div class="label-box mb-2">
                                    <label class="form-label mb-0 fs-12">Pathway</label>
                                    @if(isset($success_array['patient_details']['board_round_pathway_requirement']) && isset($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) )
                                        <span class="date-field">{{ PredefinedDateFormatWithoutDayName($success_array['patient_details']['board_round_pathway_requirement']['updated_at']) }}</span>
                                    @endif

                                </div>
                                <div class="{{ DisabledButtonOnRolePermission('camis_pathway_agreed_update') }}">
                                    <select class="form-select w-100 ibox_pathway_data_update" id="ibox_pathway_data_update" @if(isset($success_array['patient_details']['board_round_pathway_requirement']['dtoc_pathway_id'])) disabled="disabled" @endif
                                                aria-label="Default select example" @if(isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)  @else disabled @endif>
                                        <option value="">Select Pathway</option>
                                        @foreach($success_array['dtoc_path_way_drop'] as $pathway_list)
                                            <option value="{{ $pathway_list->id }}" @if(isset($success_array['patient_details']['board_round_pathway_requirement']['dtoc_pathway_id']) && $success_array['patient_details']['board_round_pathway_requirement']['dtoc_pathway_id'] == $pathway_list->id) selected @endif @if(isset($success_array['patient_details']['board_round_pathway_requirement']['dtoc_pathway_id'])) disabled="disabled" @endif>{{ $pathway_list->dtoc_pathway_text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="discharge-tracker-comments">
        <div class="rectangle-block-1 mb-1">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center rectangle-block-2">
                        <p class="mb-0">Discharge Tracker Comments</p>
                        <button class="btn btn-viewall w-auto click_open_camis_patinet_dtoc_comments">
                            View All
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="comments-box">
                        @if(count($success_array['patient_details']['board_round_dtoc_comments'])>0)
                            <ul>
                                @foreach($success_array['patient_details']['board_round_dtoc_comments'] as $comment)
                                    <li @if(isset($comment['priority']) && $comment['priority'] == 1) class="bg-priority-task" @endif>{{ $comment['comments']}}-{{ PredefinedDateFormatFor24Hour($comment['date']) }}</li>
                                @endforeach
                            </ul>
                        @else

                            <div  style="text-align: center; width: 100%; position:relative; top: 50%">
                                {{ NotFoundMessage() }}

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-2 ">
        <div class="col-md-6 mb-1">
            <div class="rectangle-block-1 ">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between rectangle-block-2">
                            <p class="mb-0">Potential/Definite (P/D)Discharge</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="dischargeSection" class="row p-2 {{ PermissionDeniedDiv('camis_potential_definite_update') }}">
                            <div class="col-lg-6 col-md-6 pe-md-0 grp-btns text-center">
                                <button id="potentialToday" data-pd-option-value='1' data-pd-option-date='{{ $success_array['today']->format('Y-m-d') }}' data-pd-option-type='1' class="btn  w-100 mb-1 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(1, $success_array['today']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Potential
                                    Today<img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" id="potential_today_active" class="ms-3" width="18" height="18" ></button>
                                <button id="potentialTommorow" data-pd-option-value='1' data-pd-option-date='{{ $success_array['tomorrow']->format('Y-m-d') }}' data-pd-option-type='1' class="btn  w-100 mb-1 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(1, $success_array['tomorrow']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Potential {{ $success_array['tomorrow']->format('l') }}
                                    <img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" id="potential_tommorow_active" alt="" class="ms-3" width="18" height="18"></button>
                                <button id="potentialDayAfterTomorow" data-pd-option-value='1' data-pd-option-date='{{ $success_array['dayAfterTomorrow']->format('Y-m-d') }}' data-pd-option-type='1' class="btn  w-100 mb-1 mb-md-0 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(1, $success_array['dayAfterTomorrow']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Potential
                                    {{ $success_array['dayAfterTomorrow']->format('l') }}<img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" id="potential_dayafter_tommorow_active" alt="" class="ms-3" width="18" height="18">
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 grp-btns ps-md-1 text-center">
                                <button id="definiteToday" data-pd-option-value='2' data-pd-option-date='{{ $success_array['today']->format('Y-m-d') }}' data-pd-option-type='2' class="btn w-100 mb-1 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(2, $success_array['today']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Definite
                                    Today<img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" id="definite_today_active" alt=""  class="ms-3" width="18" height="18"></button>
                                <button id="definiteTommorow" data-pd-option-value='2' data-pd-option-date='{{ $success_array['tomorrow']->format('Y-m-d') }}' data-pd-option-type='2' class="btn w-100 mb-1 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(2, $success_array['tomorrow']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Definite
                                    {{ $success_array['tomorrow']->format('l') }}<img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" id="definite_tommorow_active" alt="" class="ms-3" width="18" height="18">
                                </button>
                                <button id="definiteDayAfterTomorow" data-pd-option-value='2' data-pd-option-date='{{ $success_array['dayAfterTomorrow']->format('Y-m-d') }}' data-pd-option-type='2' class="btn w-100 mb-1 mb-md-0 {{ DisabledButtonOnRolePermission('camis_potential_definite_update') }} click_popup_open_ibox_board_round_potential_definite @if (isset($success_array['patient_details']['potential_definite']) && GetPotentialDefiniteDischarge(2, $success_array['dayAfterTomorrow']->format('Y-m-d'), $success_array['patient_details']['camis_patient_id'])) active @endif">Definite
                                    {{ $success_array['dayAfterTomorrow']->format('l') }}<img src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" id="definite_dayafter_tommorow_active" alt="" class="ms-3" width="18" height="18">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 discharge-plan-block mb-1 {{ PermissionDeniedDiv('camis_discharge_planning_update') }}">
            <div class="rectangle-block-1 {{ DisabledButtonOnRolePermission('camis_discharge_planning_update') }}">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between rectangle-block-2">
                            <p class="mb-0">Discharge Planning</p>
                        </div>
                    </div>
                </div>
                <div class="discharge-planner">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2 col-2 ">
                            <h6 class="mb-0">EDS</h6>
                        </div>
                        <div class="col-lg-10 col-md-10 col-10">
                            <div id="ednSection" class="d-flex justify-content-end">
                                <button data-edn-option-value='1'  id="ednYes" class="grp-btns-bg  btn me-2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 1) active @endif">
                                    <img src="{{ asset('asset_v2/Template') }}/icons/tick-circle-black.svg" alt=""
                                         class="edn_1 "  id="yesIcon" width="22" height="22"></button>
                                <button  data-edn-option-value='2' id="ednNo" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 2) active @endif">
                                    <img src="{{ asset('asset_v2/Template') }}/icons/close-black-round.svg" alt=""
                                         class="edn_2 " id="noIcon" width="22" height="22"></button>
                                <button data-edn-option-value='3' id="ednNa" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 3) active @endif">
                                    <img  class="edn_3 " id="naIcon" src="{{ asset('asset_v2/Template') }}/icons/NA-black.svg" alt=""
                                          width="22" height="22"></button>
                            </div>
                        </div>

                    </div>
                    <div class="planner-borderline"></div>
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2 col-2 ">
                            <h6 class="mb-0">TTO</h6>
                        </div>
                        <div class="col-lg-10 col-md-10 col-10">
                            <div class="d-flex justify-content-end">
                                <div id="ttoSection" class="d-flex justify-content-end">
                                    <button data-tto-option-value='1' id="ttoYes" class="grp-btns-bg  btn me-2 camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 1) active @endif">
                                        <img src="{{ asset('asset_v2/Template') }}/icons/tick-circle-black.svg" alt=""
                                             class="tto_1 " id="yesIcon" width="22" height="22"></button>
                                    <button data-tto-option-value='2' id="ttoNo" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 2) active @endif">
                                        <img src="{{ asset('asset_v2/Template') }}/icons/close-black-round.svg" alt=""
                                             class="tto_2 " id="noIcon" width="22" height="22"></button>
                                    <button data-tto-option-value='3' id="ttoNa" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 3) active @endif">
                                        <img src="{{ asset('asset_v2/Template') }}/icons/NA-black.svg" alt="" id="naIcon1"
                                             class="tto_3 " id="naIcon"  width="22" height="22"></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col-md-2 discharge-lounge mb-1 @if(CheckSpecificPermission('camis_dl_handover_update') && ((!isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status'])) || (isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status']) && $success_array['patient_details']['patient_discharge_lounge_hand_over']['status'] != 1))) discharge_lounge_handover @endif {{ PermissionDeniedDiv('camis_dl_handover_update') }}" id="dl_handover">--}}

{{--            @if(!isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status']))--}}
{{--                <button class="btn btn-discharge-lounge {{ DisabledButtonOnRolePermission('camis_dl_handover_update') }}">Discharge Lounge Handover</button>--}}
{{--            @elseif(isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status']) && $success_array['patient_details']['patient_discharge_lounge_hand_over']['status'] == 0)--}}
{{--                <button class="btn btn-discharge-lounge bg-amber-btn {{ DisabledButtonOnRolePermission('camis_dl_handover_update') }}">Discharge Lounge Handover Pedning</button>--}}
{{--            @elseif(isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status']) && $success_array['patient_details']['patient_discharge_lounge_hand_over']['status'] == 1)--}}
{{--                <button class="btn btn-discharge-lounge bg-success-btn {{ DisabledButtonOnRolePermission('camis_dl_handover_update') }}">Discharge Lounge Handover Approved</button>--}}
{{--            @elseif(isset($success_array['patient_details']['patient_discharge_lounge_hand_over']['status']) && $success_array['patient_details']['patient_discharge_lounge_hand_over']['status'] == 2)--}}
{{--                <button class="btn btn-discharge-lounge bg-danger-btn {{ DisabledButtonOnRolePermission('camis_dl_handover_update') }}">Discharge Lounge Handover Rejected</button>--}}
{{--            @endif--}}
{{--        </div>--}}

    </div>
</div>
</div>
@if(!request()->has('stranded_patient'))
<div class="footer-buttons">
    <div class="row g-2 ibox_modal_footer_button_class_backup justify-content-center ">
        <div class="col-lg-3 col-6 ">
            <button class="btn btn-allebone w-100 button_ward_summary_boardround_prev_patient"><img src="{{ asset('asset_v2/Template') }}/icons/previous.svg" alt=""
                                                                                                    class="btn-icon"><span>PREVIOUS PATIENT</span>
            </button>
        </div>

        <div class="col-lg-3 col-6 ">
            <button class="btn btn-allebone w-100 button_ward_summary_boardround_next_patient"><img src="{{ asset('asset_v2/Template') }}/icons/next-right.svg" alt=""
                                                                                                    class="btn-icon" width="20" height="20"><span>NEXT
                                    PATIENT</span>
            </button>
        </div>
        <div class="locked_area col-lg-3 col-6 {{ PermissionDeniedDiv('camis_history_modal_view') }}">
            <button  class="btn btn-allebone w-100 button_ward_summary_boardround_show_history {{ DisabledButtonOnRolePermission('camis_history_modal_view') }}"><img
                    src="{{ asset('asset_v2/Template') }}/icons/eye.svg" alt="" class="btn-icon"><span> SHOW HISTORY</span>
            </button>
        </div>
        <div class="col-lg-3 col-6">
            <button class="btn btn-allebone w-100" id="board_round_cancel" onclick="CloseBoardRound('{{ strtolower($success_array['patient_details']['ibox_ward_short_name']) }}')"><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg" alt=""
                                                                                                                                                                 class="btn-icon" width="14" height="14"><span>CLOSE</span> </button>
        </div>
    </div>

</div>
@endif
