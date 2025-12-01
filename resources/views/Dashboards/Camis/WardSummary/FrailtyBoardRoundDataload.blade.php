
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

<input type="hidden" id="camis_patient_current_ward" value="{{ strtolower($success_array['patient_details']['camis_patient_ward']) }}">

<input type="hidden" id="old_antibiotic_iv_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) : '' }}">
<input type="hidden" id="old_antibiotic_iv_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}" @else value="" @endif>
<input type="hidden" id="old_antibiotic_oral_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) : '' }}">
<input type="hidden" id="old_antibiotic_oral_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}" @else value="" @endif>
<input type="hidden" name="is_next_popup_need_to_open" id='is_next_popup_need_to_open' value="0" />

<div class="col-lg-12">
    <div class="row gx-2 align-items-center">

        <div class="locked_area col-lg-2 col-md-6 order-1 order-lg-0 mb-1 {{ PermissionDeniedDiv('camis_next_of_kin_view') }}">
            <div class="btn-col click_popup_open_ibox_board_round_nok {{ DisabledButtonOnRolePermission('camis_next_of_kin_view') }}">
                <button class="btn btn-allebone w-100 "><svg xmlns="http://www.w3.org/2000/svg" width="17.002" height="18" viewBox="0 0 17.002 22.745" class="btn-icon">
                        <path id="Union_20" data-name="Union 20" d="M5.486,22.745H4.418a2,2,0,0,1-2-2V19.191H1.7a1.705,1.705,0,0,1-1.7-1.7V14.082A4.262,4.262,0,0,1,4.257,9.825h2.2a3.39,3.39,0,0,1,1.333.271V9.814a3,3,0,0,1,3-3H14a3,3,0,0,1,3,3V16.19a3.005,3.005,0,0,1-2.609,2.975v1.579a2,2,0,0,1-2,2H11.328l-.374-3.972A1.65,1.65,0,0,0,9.38,17.059H7.5a1.65,1.65,0,0,0-1.574,1.714l-.439,3.972h0Zm1.269-8.112a1.731,1.731,0,0,0,1.651,1.8,1.8,1.8,0,0,0,0-3.6A1.731,1.731,0,0,0,6.755,14.633ZM1.727,5.842A2.957,2.957,0,1,1,4.684,8.8,2.957,2.957,0,0,1,1.727,5.842ZM9.634,2.957A2.957,2.957,0,1,1,12.59,5.914,2.957,2.957,0,0,1,9.634,2.957Z"></path>
                    </svg><span>Next of
                        Kin</span>
                </button>
            </div>
        </div>



        <div class="col-lg-8 order-0 order-lg-1 mb-1">
            <div class="btn-col ">
                <button class="btn btn-allebone-center w-100">
                    <div
                        class="d-flex align-items-center justify-content-md-between flex-md-row flex-column">
                        <div>
                            <span>{{ $success_array['patient_details']['patient_ward_bed_info'] }}</span>
                        </div>
                        <div>
                            <span>{{ $success_array['patient_details']['patient_name_age'] }}</span>
                        </div>
                        <div>



                            <span>LOS {{ !empty($success_array['patient_details']['camis_patient_ward_start_date']) ? NumberOfHoursBetweenTwoDates($success_array['patient_details']['camis_patient_ward_start_date'], CurrentDateOnFormat()) : NumberOfHoursBetweenTwoDates($success_array['patient_details']['camis_patient_admission_date_time'], CurrentDateOnFormat()) }} Hours On This Ward</span>
                        </div>
                    </div>

                </button>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 order-2 order-lg-2 mb-1">
            <div class="btn-col ">
                <a class="btn btn-allebone w-100" id="board_round_close" href="{{ route('ward.frailty') }}"><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg"
                    class="btn-icon" alt="" width="14"><span>Close</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row gx-2">
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
                                        <tr class="bg-white ">
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
                                            <td class="{{ DisabledButtonOnRolePermission('camis_movement_history_view') }}">{{ !empty($success_array['patient_details']['camis_patient_ward_stay_number']) ? $success_array['patient_details']['camis_patient_ward_stay_number'] : 0 }} Moves</td>
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
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="row gx-2 height-adjust">
                <div class="col-lg-6 mb-1">
                    <div class=" {{ PermissionDeniedDiv('camis_task_management_add') }}">
                        <input type="text" class="form-control ibox_board_round_patient_task_description_open {{ DisabledButtonOnRolePermission('camis_task_management_add') }}" id="ibox_board_round_patient_task_description_open"
                               placeholder="Type here to add new task or filter tasks below">
                    </div>
                </div>
            </div>
            <div class="row ibox_board_round_patient_task_content_show gx-2">
                @include('Dashboards.Camis.WardSummary.UserTask')
            </div>
            <div class="discharge-tracker-comments">
                <div class="rectangle-block-1 mb-1">
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center rectangle-block-2">
                                <p class="mb-0">Patients Moving History</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 ">

                                @if(count($success_array['movement_data']) > 0)
                                    <div class="comments-box">
                                        <ul>
                                            @foreach ($success_array['movement_data'] as $movement)
                                                <li>{{ $movement }} </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                @else
                                    <div style=" display: flex
                                    ;
                                        align-items: center;
                                        justify-content: center;
                                        min-height: 117px;">{{ NotFoundMessage() }}</div>
                                
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-buttons">
        <div class="row gx-2 ">
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
                <button class="btn btn-allebone w-100" id="board_round_cancel" onclick="location.href='{{ route('ward.frailty') }}';" ><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg" alt=""
                                                                                                                                                                     class="btn-icon" width="14" height="14"><span>CLOSE</span> </button>
            </div>
        </div>
    </div>
</div>
