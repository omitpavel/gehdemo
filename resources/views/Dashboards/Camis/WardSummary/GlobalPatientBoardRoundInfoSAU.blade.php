@if(Route::currentRouteName() != 'site.stranded_patients')
<style>
    .form-control:disabled, .form-control[readonly]{
        background-color: #fff;
    }
    .level-wrapper button {

        font-size: 11px;
    }
</style>
@endif
<input type="hidden" name="ibox_board_round_popup_opened_patient_flag_name" id="ibox_board_round_popup_opened_patient_flag_name" class="ibox_board_round_popup_opened_patient_flag_name" value="" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_id_prev" id='ward_summary_boardround_modal_popup_camis_patient_id_prev' value="{{ $success_array['prev_patient'] }}" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_id_next" id='ward_summary_boardround_modal_popup_camis_patient_id_next' value="{{ $success_array['next_patient'] }}" />
<input type="hidden" name="ward_summary_boardround_modal_popup_camis_patient_pass_number" id='ward_summary_boardround_modal_popup_camis_patient_pass_number' value="{{ $success_array['patient_details']['camis_patient_pas_number'] }}" />

<input type="hidden" id='pd_discharge_date' value="{{ isset($success_array['patient_details']['potential_definite']['potential_definite_date']) ? date('Y-m-d', strtotime($success_array['patient_details']['potential_definite']['potential_definite_date'])) : '' }}" />
<input type="hidden" id='pd_discharge_type' value="{{ $success_array['patient_details']['potential_definite']['type'] ?? 0 }}" />

<input type="hidden" id="current_edn_status" value="{{ $success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] ?? 0 }}">
<input type="hidden" id="current_tto_status" value="{{ $success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] ?? 0 }}">



<input type="hidden" id="old_antibiotic_iv_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) : '' }}">
<input type="hidden" id="old_antibiotic_iv_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}" @else value="" @endif>
<input type="hidden" id="old_antibiotic_oral_time" value="{{ isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) ? PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) : '' }}">
<input type="hidden" id="old_antibiotic_oral_time_since" @if(isset($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))  value="Since {{ PatientLos($success_array['patient_details']['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}" @else value="" @endif>
<input type="hidden" name="is_next_popup_need_to_open" id='is_next_popup_need_to_open' value="0" />
@if(Route::currentRouteName() == 'site.stranded_patients')
<div>
    <button class="btn bg-lock mb-2 w-100 modal-locked content_display_none" id="lock_all_image"><img src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="" width="20" class="me-3">
        <span class="locked_user_name_to_show">Locked By
        <span class="locked_by_name"></span></span></button>
</div>
@endif
<div class="col-lg-12">
    <div class="row gx-2 align-items-center" style="pointer-events: none">
        <div class="col-lg-12 mb-1">
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
    </div>
    <div class="row gx-2">
        <div class="col-xxl-6">
            <div class="row gx-2">
                <div class="col-lg-6">
                    <div class="mb-1 mb-xxl-0">
                        <div class="card-medical-reports ">
                            <div class="header-reports">
                                <p class="header-texarea mb-0">
                                    Admitting Reason
                                </p>
                                <span class="update-time ">
                                        @isset($success_array['patient_details']['board_round_admitting_reason']['updated_at'])
                                        Last Updated :
                                        {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_admitting_reason']['updated_at']) }}
                                    @endisset
                                    </span>
                            </div>
                            <div class="reports-content">
                                    <span> @isset($success_array['patient_details']['board_round_admitting_reason']['patient_admitting_reason'])
                                            {{ $success_array['patient_details']['board_round_admitting_reason']['patient_admitting_reason'] }}
                                        @endisset </span>
                            </div>
                        </div>

                        <div class="card-medical-reports">
                            <div class="header-reports">
                                <p class="header-texarea mb-0">Past Medical History
                                </p>
                                <span class="update-time ">
                                       @isset($success_array['patient_details']['board_round_past_medical_history']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_past_medical_history']['updated_at'])}} @endisset
                                    </span>
                            </div>
                            <div class="reports-content">
                                    <span> @isset($success_array['patient_details']['board_round_past_medical_history']['patient_past_medical_history']) {{$success_array['patient_details']['board_round_past_medical_history']['patient_past_medical_history']}} @endisset </span>
                            </div>
                        </div>
                        <div class="card-medical-reports">
                            <div class="header-reports">
                                <p class="header-texarea mb-0">
                                    Social History
                                </p>
                                <span class="update-time ">
                                        @isset($success_array['patient_details']['board_round_social_history']['updated_at'])
                                        Last Updated :
                                        {{ PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_social_history']['updated_at']) }}
                                    @endisset </span>
                            </div>
                            <div class="reports-content">
                                    <span> @isset($success_array['patient_details']['board_round_social_history']['patient_social_history'])
                                            {{ $success_array['patient_details']['board_round_social_history']['patient_social_history'] }}
                                        @endisset </span>
                            </div>
                        </div>
                        <div class="card-medical-reports">
                            <div class="header-reports">
                                <p class="header-texarea mb-0">
                                   Patient Goal
                                </p>
                                <span class="update-time ">
                                      @isset($success_array['patient_details']['board_round_patient_goal']['updated_at']) Last Updated : {{PredefinedDateFormatFor24Hour($success_array['patient_details']['board_round_patient_goal']['updated_at'])}} @endisset
                                     </span>
                            </div>
                            <div class="reports-content">
                                    <span>@isset($success_array['patient_details']['board_round_patient_goal']['patient_patient_goal']) {{$success_array['patient_details']['board_round_patient_goal']['patient_patient_goal']}} @endisset </span>
                            </div>
                        </div>

                        <div class="">
                            <div class="card-table">
                                <div>
                                    <table class="table-allebone">
                                        <tbody>
                                        <tr class="bg-white">
                                            <td class=" border-end">
                                                Hospital Number
                                            </td>
                                            <td class="">
                                                {{ $success_array['patient_details']['camis_patient_pas_number'] }}
                                            </td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <td class="border-end">
                                                Consultant</td>
                                            <td>{{ $success_array['patient_details']['camis_consultant_name'] }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white">
                                            <td class="border-end">
                                                Speciality</td>
                                            <td>{{ $success_array['patient_details']['camis_consultant_code_description'] . ' (' . $success_array['patient_details']['camis_consultant_specialty'] . ')' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <td class="border-end">Admission Type</td>
                                            <td class="position-relative"> @if(isset($success_array['patient_details']['ip_admission_type_description'])) {{  ucwords($success_array['patient_details']['ip_admission_type_description']) }}   @endif  </td>
                                        </tr>
                                        <tr class="bg-white">
                                            <td class="border-end">
                                                EDD</td>
                                            <td>
                                                @if (
                                                    !isset(
                                                        $success_array['patient_details']['board_round_estimated_discharge_date']['patient_estimated_discharge_date']))
                                                    <button
                                                        name="board_round_edd_button click_popup_open_ibox_board_round_edd "
                                                        class="btn btn-edd w-100">
                                                        CLICK TO
                                                        ENTER EDD
                                                    </button>
                                                @else
                                                    <button name=""
                                                            class="btn btn-edd w-100 click_popup_open_ibox_board_round_edd ">
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
                                        <tr class="bg-white">
                                            <td class=" border-end">
                                                Ward Movement
                                            </td>
                                            <td class="">
                                                {{ $success_array['patient_details']['camis_patient_ward_stay_number'] }} Moves
                                            </td>
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


                    <div class="ward-icons-wrapper">
                        @foreach ($success_array['show_flag_list'] as $flags)
                            <div class="card-hex-icons mb-1 {{ DisabledButtonOnRolePermission('camis_flag_update') }}">
                                <div class="icon-wrap">
                                    <div class="d-flex align-items-start">
                                        @foreach($flags['flag_list'] as $flag)
                                            <div class="icon-col @if(!in_array($flag['patient_flag_stored_name'], ['ibox_patient_flag_covid_19', 'ibox_patient_flag_assisted_ventilation', 'ibox_patient_flag_pathology', 'ibox_patient_flag_radiology'])) cursor_pointer ibox_board_round_patient_flag_list_assign @endif ibox_board_round_patient_flag_active_{{ $flag['patient_flag_stored_name'] }} @if(CheckSpecificBedFlagsExitsOnArray($success_array['patient_details']['patient_wise_flags'], $flag['patient_flag_stored_name'])) flag_active @else flag_inactive @endif"  data-patient-flag-show-name="{{ $flag['patient_flag_name'] }}" data-patient-flag-stored-name="{{ $flag['patient_flag_stored_name'] }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $flag['patient_flag_name'] }}">
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
                        <div class="col-12 mb-1">
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
                                <div class="row gx-2 align-items-center w-100">
                                    <div class="col-4 ">
                                        <h6 class="mb-0">Medically Fit</h6>
                                    </div>
                                    <div class="col-8 gx-0 text-end" id="medfitSection">
                                        <button name=""
                                                class="btn btn-medfit-no @if (
                                    (isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) &&
                                        $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 0) ||
                                        !isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'])) active @else '' @endif">NO</button>
                                        <button class="btn btn-medfit-yes @if (isset($success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status']) &&
                                    $success_array['patient_details']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) active @else '' @endif"
                                                data-bs-toggle="offcanvas" data-bs-target="#medicallyFit" aria-controls="offcanvasRight">
                                            YES
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="reason-reside">
                                <div class="rectangle-block-1">
                                    <div class="row gx-2 align-items-center w-100">
                                        <div class="col-md-4">
                                            <div class="reason-reside-header">
                                                <p class="mb-0">Reason to Reside</p>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-boxes">
                                                @if(isset($success_array['patient_details']['board_round_reason_to_reside']) && isset($success_array['patient_details']['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category']))

                                                    <a class="btn mb-0 ">{{str_replace('.', ',',str_replace('_', ' ', ucwords($success_array['patient_details']['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value_category'])))}}
                                                    </a>
                                                @else
                                                    <a class="btn mb-0 ">No Reason To Reside</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="level-wrapper">
                        <div class="level-button-group" id="levelSection">
                            <button class="btn btn-ccu-level-succcess level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 2) active @endif"  id="level_div_2"  data-level-id="2">Level 1<img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3" id="level_img_2" width="18" height="18"></button>
                            <button class="btn btn-ccu-level-amber level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 3) active @endif"  id="level_div_3"  data-level-id="3">Level 2<img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3 " id="level_img_3" width="18" height="18"></button>
                            <button class="btn btn-ccu-level-danger level_status_update @if(isset($success_array['patient_details']['board_round_level']['updated_at']) && $success_array['patient_details']['board_round_level']['level'] == 4) active @endif"  id="level_div_4"  data-level-id="4">Level 3<img src="{{ asset('asset_v2/Template/icons/tick-circle.svg')}}" alt="" class="ms-3 " id="level_img_4" width="18" height="18"></button>
                        </div>
                    </div>
                    <div class="btn-grp-pharmacy">
                        <div class="row mb-1">
                            <div class="col-lg-4 col-md-4 col-4 pe-1">
                                <a data-bs-toggle="modal" data-bs-target="#pharmacy"
                                   class="btn btn-darkcyan mb-1 w-100 click_popup_open_ibox_board_round_pharmacy">Pharmacy <svg
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
                        <div class="col-12">
                            <div class="title-pharmacy">
                                <h6 class="mb-1">Pharmacy Comment (Latest)</h6>
                            </div>
                                                      <textarea class="form-control ibox_board_round_pharmacy_updated_comment_show " id="ibox_board_round_pharmacy_updated_comment_show"
                                                                rows  readonly>{{ @$success_array["pharmacy_latest_comment"] }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-xxl-6">
        <div class="row gx-2 height-adjust">
            <div class="col-lg-6 offset-lg-6 mb-1">
                <div class="btn-col">
                    <button class="btn btn-allebone w-100 @if(isset($success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']) && $success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to'] == 'Do Not Move') bg-btn-red @endif"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24.269 24.269" class="btn-icon img-fluid">
                            <g id="bed-single-hotel-svgrepo-com" transform="translate(-1.75 -1.75)">
                                <path id="Path_21440" data-name="Path 21440" d="M6,9h4.837" transform="translate(0.628 1.256)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                                <path id="Path_21441" data-name="Path 21441" d="M3,3V24.769m21.769-4.837v4.837m0-4.837H3m21.769,0V16.3a2.419,2.419,0,0,0-2.419-2.419H3" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                            </g>
                        </svg><span>
                            @if(isset($success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to'])) {{ isset($success_array['ward_array'][$success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']]) ? $success_array['ward_array'][$success_array['patient_details']['allowed_to_move']['patient_allowed_to_be_moved_to']] : 'Do Not Move' }}

                            @else
                                Allowed
                                to be
                                Moved?
                            @endif
                                </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row gx-2">

            <div class="col-lg-6 col-md-6 col-assign-task mb-1">
                <div class="bg-task">
                    <label class="form-label mb-0">Task to be Completed</label>
                </div>
                <div class="card-task">
                    <div class="list-group">
                        @if (count($success_array['task_to_be_completed']) > 0)
                            @foreach ($success_array['task_to_be_completed'] as $row)
                                <li data-patient-task-id="{{ $row['id'] }}" class="list-group-item list-group-item-action cursor_pointer  @if(isset($row['patient_task_show_string_class']) && !empty($row['patient_task_show_string_class'])) {{ ltrim($row['patient_task_show_string_class'], '#') }}_task  @else {{ $loop->index % 2 === 0 ? '' : 'bg-silver' }} @endif ibox_boardround_popup_patient_task_to_be_completed_show_list ibox_boardround_popup_patient_task_show">
                                    @if ($row['task_priority'] == 1) ! @endif {{ $row['patient_task_show_string'] }}
                                </li>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-6">
                <div class="bg-task">
                    <label class="form-label mb-0">Completed Task</label>
                </div>
                <div class="card-task mb-1">
                    <div class="list-group">


                        @if (count($success_array['task_completed']) > 0)
                            @foreach ($success_array['task_completed'] as $row)
                                <li class="list-group-item list-group-item-action ibox_boardround_popup_patient_task_completed_show_list cursor_pointer task_comment_id {{ $loop->index % 2 === 0 ? '' : 'bg-silver' }}"  data-task-id="{{ $row['id'] }}">
                                    {{ isset($row['patient_task_show_string']) ? $row['patient_task_show_string'] : $row['task_description'] }} <div class="comment-icon task_comment_id" data-task-id="{{ $row['id'] }}">
                                    </div>
                                </li>
                            @endforeach
                        @endif


                    </div>
                </div>
            </div>
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
                                        <label  class="form-label mb-0 fs-12">Service</label>
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
                                    <div class="label-box d-flex align-items-center justify-content-between mb-2">
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
                            <button class="btn btn-viewall w-auto">
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

        <div class="row gx-2 {{ PermissionDeniedDiv('camis_discharge_planning_update') }}">
            <div class="col-12 discharge-plan-block mb-1 {{ DisabledButtonOnRolePermission('camis_discharge_planning_update') }}">
                <div class="rectangle-block-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between rectangle-block-2">
                                <p class="mb-0">Discharge Planner</p>
                            </div>
                        </div>
                    </div>
                    <div class="discharge-planner">
                        <div class="row g-1 align-items-center">
                            <div class="col-md-5">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 col-md-2 col-2 ">
                                        <h6 class="mb-0">EDS</h6>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-10">
                                        <div id="ednSection" class="d-flex justify-content-end">
                                            <button data-edn-option-value='1'  id="ednYes" class="grp-btns-bg active  btn me-2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 1) active @endif">
                                                <img src="{{ asset('asset_v2/Template/icons/tick-circle-black.svg') }}" alt="" id="yesIcon1" width="22" height="22"></button>
                                            <button data-edn-option-value='2' id="ednNo" class="grp-btns-bg btn me-2 2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 2) active @endif">
                                                <img src="{{ asset('asset_v2/Template//icons/close-black-round.svg') }}" alt="" id="closeIcon1" width="22" height="22"></button>
                                            <button data-edn-option-value='3' id="ednNa" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_edn_status @if(!isset($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status']))  @elseif($success_array['patient_details']['board_round_edn']['discharge_planning_edn_status'] == 3) active @endif">
                                                <img src="{{ asset('asset_v2/Template//icons/NA-black.svg') }}" alt="" id="naIcon1" width="22" height="22"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="planner-borderline"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 col-md-2 col-2 ">
                                        <h6 class="mb-0">TTO</h6>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-10">
                                        <div class="d-flex justify-content-end">
                                            <div id="ttoSection" class="d-flex justify-content-end">
                                                <button data-tto-option-value='1' id="ttoYes" class="grp-btns-bg btn me-2  camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 1) active @endif">
                                                    <img src="{{ asset('asset_v2/Template/icons/tick-circle-black.svg') }}" alt="" id="yesIcon2" width="22" height="22"></button>
                                                <button data-tto-option-value='2' id="ttoNo" class="grp-btns-bg btn me-2 camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 2) active @endif">
                                                    <img src="{{ asset('asset_v2/Template/icons/close-black-round.svg') }}" alt="" id="closeIcon2" width="22" height="22"></button>
                                                <button data-tto-option-value='3' id="ttoNa" class="grp-btns-bg btn me-2  camis_patient_ward_summary_boardround_save_tto_status @if(!isset($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status']))  @elseif($success_array['patient_details']['board_round_tto']['discharge_planning_tto_status'] == 3) active @endif">
                                                    <img src="{{ asset('asset_v2/Template/icons/NA-black.svg') }}" alt="" id="naIcon2" width="22" height="22"></button>
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





