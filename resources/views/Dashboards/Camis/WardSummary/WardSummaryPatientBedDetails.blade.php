
@if (count($success_array['ward_patient_list_array']) > 0)
    @foreach ($success_array['ward_patient_list_array'] as $key => $pat_list_array)
        <div class="side-room " >
            <div class="row ps-35 " id="spl-cols" >

                <div class="wrapper-head" >
                    <div @if(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 1) class="header-left bay-closed" title="Bay Closed" @elseif(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 2) class="header-left bay-restricted" title="Bay Restricted" @else class="header-left" title="Bay Open" @endif>{{ $key }}</div>
                </div>
                @if (count($pat_list_array) > 0)
                        @foreach ($pat_list_array as $pat_data)
                            @if ($pat_data['camis_patient_id'] != '')
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-12 mb-2  @if(CheckSpecificPermission('camis_boardround_view')) cursor_pointer ward_summary_patient_boardround_modal_popup_click @endif " @if(!CheckSpecificPermission('camis_boardround_view')) onclick="CommonLoginModalPopupOpenOnRequest();" @endif data-board-round-camis-patient-id="{{ $pat_data['camis_patient_id'] }}">
                                    <div class="medical-details-card ">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8 pe-0 ps-0">
                                                <div class="ward-header-row ">
                                                        <div class="header-col-1 bg-blue-bed-no"  data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="{{ $pat_data['ibox_bed_actual_name'] }}">
                                                            <h6 class="mb-0 text-center">{{ $pat_data['ibox_bed_no'] }}</h6>
                                                        </div>
                                                        @if(isset($pat_data['allowed_to_move']['patient_allowed_to_be_moved_to']) && $pat_data['allowed_to_move']['patient_allowed_to_be_moved_to'] == 'Do Not Move')
                                                            <div class="header-col-1 bg-red">
                                                                <img src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="Bed Lock"  data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="Do Not Move">
                                                            </div>
                                                        @endif
                                                        @if(in_array($success_array['ward_url'], ['rltamu01', 'rltamu02']))
                                                            <div class="@if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_not_for_resus')) header-col-3 @else header-col-5 @endif  @if($pat_data['ibox_patient_admit_date_los_value'] >= 21) bed_black_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 5 && $pat_data['ibox_patient_admit_date_los_value'] < 21) bed_red_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 3 && $pat_data['ibox_patient_admit_date_los_value'] < 5) bed_amber_background @else bg-dark-blue @endif">
                                                                <span>LOS  {{ $pat_data['ibox_patient_admit_date_los_value'] }} Days </span>
                                                            </div>
                                                        @else
                                                            <div class="@if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_not_for_resus')) header-col-3 @else header-col-5 @endif  @if($pat_data['ibox_patient_admit_date_los_value'] >= 21) bed_black_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 7) bed_red_background @else bg-dark-blue @endif">
                                                                <span>LOS @if($success_array['ward_url'] == 'rltsauip') {{ $pat_data['ibox_patient_admit_date_los_value_hour'] }} Hours @else {{ $pat_data['ibox_patient_admit_date_los_value'] }} Days @endif</span>
                                                            </div>
                                                        @endif
                                                        @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_not_for_resus'))
                                                            <div class="header-col-2 bg-yellow" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="DNACPR">
                                                                <span>DNACPR</span>
                                                            </div>
                                                        @endif


                                                </div>
                                                <div class="card-medical">
                                                    <div class="patient-data-table">

                                                        <div class="patient-data">
                                                            <div class="gender-icon">
                                                                @if (strtolower($pat_data['camis_patient_sex']) == 'male')
                                                                    <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Male">
                                                                @elseif(strtolower($pat_data['camis_patient_sex']) == 'female')
                                                                    <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Female">
                                                                @endif
                                                            </div>
                                                            <div class="name">
                                                                <span class="patient_name_hide_on_request @if ($pat_data['ibox_patient_surname_count'] > 1) SurNameRepeat @endif">{{ $pat_data['ibox_patient_hide_name'] }}</span>
                                                                <span class="content_display_none patient_name_show_on_request @if ($pat_data['ibox_patient_surname_count'] > 1) SurNameRepeat @endif"> {{ $pat_data['camis_patient_name'] }}</span>
                                                                <span class="pass-id">({{ $pat_data['camis_patient_pas_number'] }})</span>
                                                            </div>
                                                        </div>
                                                        <div class="edd-data">
                                                            <div class="label-edd  @if($success_array['ward_url'] == 'rltsauip') d-none @endif">
                                                                <span>EDD</span>
                                                            </div>
                                                            <div class="value-edd  @if($success_array['ward_url'] == 'rltsauip') d-none @endif">
                                                                @if(isset($pat_data['board_round_estimated_discharge_date']))
                                                                    <span class="fw-bold @if(\Carbon\Carbon::parse($pat_data['board_round_estimated_discharge_date']['patient_estimated_discharge_date'])->isPast()) text-danger @else text-success @endif">{{ PredefinedDateFormatForEDD($pat_data['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) }}</span>
                                                                @else
                                                                    <span class="fw-bold text-danger">No EDD Set</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="medfit-data">
                                                            <div class="label-medfit">
                                                                <span>Med Fit</span>
                                                            </div>
                                                            <div class="value-medfit">
                                                                @if(isset($pat_data['board_round_medically_fit_data']['patient_medically_fit_status']))
                                                                    @if($pat_data['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                                        <span class="fw-bold text-success">Yes</span>
                                                                    @else
                                                                        <span class="fw-bold text-danger">No</span>
                                                                    @endif
                                                                @else
                                                                    <span class="fw-bold text-danger">No</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="doctor-data" >
                                                            <div class="name @if(strtolower($pat_data['ibox_ward_short_name']) == 'talb' && $pat_data['camis_consultant_code_group'] == 'Haematology') TALB_Haematology_consultant_color @elseif(strtolower($pat_data['ibox_ward_short_name']) == 'talb' && $pat_data['camis_consultant_code_group'] == 'Oncology') TALB_Oncology_consultant_color @endif ">
                                                                <span @if(!empty($pat_data['camis_consultant_code_description']))  data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $pat_data['camis_consultant_code_description'] }}" @endif>{{  limitText($pat_data['camis_consultant_name'], 28)  }}</span>
                                                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $pat_data['camis_consultant_code_description'] }} ({{ $pat_data['camis_consultant_specialty'] }})" >{{  limitText($pat_data['camis_consultant_code_description'], 21)  }} ({{  limitText($pat_data['camis_consultant_specialty'], 6)  }})</span>

                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="medical-bottom-count">
                                                        <div class="row gx-1 align-items-center">

                                                            <div class="col-3">
                                                                {!! GetEwsData($pat_data['patient_vital_pac_info']['totalews'] ?? null, 30) !!}

                                                                <span class="vitals">EWS</span>
                                                            </div>

                                                                <div class="col-6" >
                                                                    @if(isset($pat_data['allowed_to_move']['patient_allowed_to_be_moved_to']))
                                                                        @if($pat_data['allowed_to_move']['patient_allowed_to_be_moved_to'] != 'Do Not Move')
                                                                            <div data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="Allowed To Move To {{ $success_array['ward_array'][$pat_data['allowed_to_move']['patient_allowed_to_be_moved_to']] }}" @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_outlier')) class="ward-move" @else class="outlier-box" @endif>
                                                                                <span class="bg-outlier-wards">&gt; {{ $success_array['ward_array'][$pat_data['allowed_to_move']['patient_allowed_to_be_moved_to']] }}</span>
                                                                            </div>
                                                                        @else
                                                                            <div @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_outlier')) class="ward-move" @else class="outlier-box" @endif>
                                                                                <span class="bg-not-move" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="Do Not Move">Do Not Move</span>
                                                                            </div>
                                                                        @endif
                                                                    @endif

                                                                        @if($outlier = CheckSpecificBedFlagsExitsOnArrayWithData($pat_data['flags'], 'ibox_patient_flag_outlier', 'flag_outlier_value'))
                                                                        <div class="outlier-box">
                                                                            <span class="bg-outlier-wards" data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="OUTLIER : {{ $outlier }}"> @if($outlier == 'Other') OUTLIER: OTHER @else OUTLIER: {{ substr(strtoupper($outlier), 0, 4) }} @endif </span>
                                                                        </div>
                                                                        @endif
                                                                </div>



                                                                <div class="col-3" >
                                                                    @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_ambo') && CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_frailty'))
                                                                    <div class="ambo-section" >
                                                                        @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_ambo'))
                                                                            <span class="bg-green" data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="AMBO"> AMBO </span>

                                                                        @endif
                                                                    </div>

                                                                    <div class="jef-section" >
                                                                        @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_frailty'))
                                                                            <span class="bg-blue-wards" data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="Frailty"> JEF </span>

                                                                        @endif
                                                                    </div>
                                                                    @elseif(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_ambo'))
                                                                        <div class="ambo-section" >
                                                                        </div>
                                                                        <div class="jef-section" >
                                                                            @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_ambo'))
                                                                                <span class="bg-green" data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom" title="AMBO"> AMBO </span>

                                                                            @endif
                                                                        </div>
                                                                        @elseif(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_frailty'))
                                                                        <div class="ambo-section" >
                                                                        </div>
                                                                        <div class="jef-section" >
                                                                            @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_frailty'))
                                                                            <span class="bg-blue-wards" data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom" title="Frailty"> JEF </span>

                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>



                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4 ps-0 pe-0 bg-col-grey">
                                                <div class="bg-blue">
                                                    <div class="row w-100">
                                                        <div class="col-12 p-0">
                                                            <div class="task-row">

                                                                @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_ptwr'))
                                                                <div class="task-col-1 bg-green" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="PTWR Patients">
                                                                    <span>PTWR</span>
                                                                </div>

                                                                @endif
                                                                {{-- @if (count($pat_data['ptwr_data']) < 1)
                                                                    <div class="task-col-1 @if (strtotime($pat_data['camis_patient_ward_start_date']) <= strtotime("-12 hours")) bg-red @else bg-green @endif" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="PTWR Patients">
                                                                        <span>PTWR</span>
                                                                    </div>
                                                                @endif --}}
                                                                @if(CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_infection_risk'))

                                                                        @php
                                                                            $primary_flag = $pat_data['infection_risks'] ?? [];

                                                                            $primary_flag = array_filter($primary_flag, function ($flag) {
                                                                                return $flag['is_primary'] == 1;
                                                                            });

                                                                            $primary_flag = isset($primary_flag[0]) ? $primary_flag[0] : [];

                                                                        @endphp
                                                                        @if(isset($primary_flag['infection_type']) && isset($primary_flag['infection_name']))
                                                                            <div class="task-col-1">
                                                                                @if($primary_flag['infection_type'] == 'CANSTAYINBAY' || $primary_flag['infection_type'] == 'RESOLVED')
                                                                                    <div class="green-circle" data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom" title="Infection Risk - {{ $primary_flag['infection_name'] }} ({{ucwords(strtolower($primary_flag['infection_type'] === 'CANSTAYINBAY' ? 'CAN STAY IN BAY' : $primary_flag['infection_type']))}})">
                                                                                        <span>IC</span>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="red-circle" data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom" title="Infection Risk - {{ $primary_flag['infection_name'] }} ({{ucwords(strtolower($primary_flag['infection_type']))}})">
                                                                                        <span>IC</span>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                @endif
                                                                @if(isset($pat_data['red_green_bed']) && count($pat_data['red_green_bed']) > 0)
                                                                    <div class="task-col-1" @if(isset($pat_data['red_green_bed']['red_green_reason']['red_text_value']) && $pat_data['red_green_bed']['patient_red_green_status'] == 1) data-bs-toggle="tooltip" data-bs-placement="top" title="{{$pat_data['red_green_bed']['red_green_reason']['red_text_value']}}" @endif>
                                                                        @if($pat_data['red_green_bed']['patient_red_green_status'] == 1)

                                                                            <div class="red-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Red Bed">
                                                                                <span>{{ floor(abs(time() - strtotime($pat_data['red_green_bed']['updated_at'])) / (60 * 60 * 24)) }}</span>
                                                                            </div>

                                                                        @else
                                                                            <div class="green-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Green Bed">
                                                                                <span>{{ floor(abs(time() - strtotime($pat_data['red_green_bed']['updated_at'])) / (60 * 60 * 24)) }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-0 pt-1 w-100">
                                                    <div class="ward-icons">

                                                        @if (CheckSpecificBedFlagsExitsOnArray($pat_data['flags'], 'ibox_patient_flag_off_the_ward'))
                                                            @if (GetSpecificBedFlagsExtraDetailsFromArray($pat_data['flags'], 'ibox_patient_flag_off_the_ward')['patient_flag_off_the_ward_selected_data'] != 'Surgary')
                                                                <div class="off-ward-icon">
                                                                    <img src="{{ asset('asset_v2/Template/icons/ward_icons/off_the_ward.png') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Off The Ward" alt="" style='width:55px !important' >
                                                                </div>
                                                            @else
                                                                <div class="off-ward-text">
                                                                    <span>OFF THE <br> WARD</span>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <table class="ward-flags">
                                                                <tbody>
                                                                    <tr>
                                                                        @php
                                                                            if(isset($pat_data['patient_vital_pac_info']['alert_value']) && in_array($pat_data['patient_vital_pac_info']['alert_value'], ['Stage 1', 'Stage 2','Stage 3', 'Stage DNR'])){
                                                                                array_push($pat_data['patient_wise_flags'], ['patient_flag_status_value' => 1, 'patient_flag_name' => 'aki_flag_'.str_replace(' ', '_', $pat_data['patient_vital_pac_info']['alert_value']), 'patient_flag_extra_details' => json_encode(array())]);
                                                                                $success_array['show_on_ward_summary_status_check']['aki_flag_'.str_replace(' ', '_', $pat_data['patient_vital_pac_info']['alert_value'])] = 'AKI';
                                                                            }
                                                                            $flag_list_show_array = PatientWiseFlagsUrlForWardSummaryGetAllFlags($pat_data['patient_wise_flags'], $success_array['show_on_ward_summary_status_check'], 9);

                                                                        @endphp
                                                                        @php $x_inc = 0; @endphp
                                                                        @foreach ($flag_list_show_array as $key => $flag)
                                                                            <td>{!! GetWardSummaryBedFlagImages($flag) !!}</td>
                                                                            @if ($x_inc % 3 == 2)
                                                                    </tr>
                                                                    <tr>
                                                        @endif
                                                        @php $x_inc++; @endphp
                            @endforeach

                            </tr>
                            </tbody>
                            </table>
                        @endif
                                                    </div>

                                                    <div class="flags-row">
                                                        <table class="table-status-flags">
                                                            <tr>
                                                                @if(isset($pat_data['board_round_edn']['discharge_planning_edn_status']) && in_array($pat_data['board_round_edn']['discharge_planning_edn_status'], [1, 2]))
                                                                    <td data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" @if($pat_data['board_round_edn']['discharge_planning_edn_status'] == 1) title="EDS Required - Completed" @elseif($pat_data['board_round_edn']['discharge_planning_edn_status'] == 2) title="EDS Required - Not Completed" @else  title="EDN Status Not Applicable" @endif>
                                                                        <div @if($pat_data['board_round_edn']['discharge_planning_edn_status'] == 1) class="bg-eds-yes" @elseif($pat_data['board_round_edn']['discharge_planning_edn_status'] == 2) class="bg-eds-no" @else class="bg-edn-na" @endif>EDS</div>
                                                                    </td>
                                                                @endif
                                                                @if(isset($pat_data['board_round_tto']['discharge_planning_tto_status']) && in_array($pat_data['board_round_tto']['discharge_planning_tto_status'], [1, 2]))
                                                                    <td data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" @if($pat_data['board_round_tto']['discharge_planning_tto_status'] == 1) title="TTO Required - Completed" @elseif($pat_data['board_round_tto']['discharge_planning_tto_status'] == 2) title="TTO Required - Not Completed" @else  title="TTO Status Not Applicable" @endif>
                                                                        <div @if($pat_data['board_round_tto']['discharge_planning_tto_status'] == 1) class="bg-tto-yes" @elseif($pat_data['board_round_tto']['discharge_planning_tto_status'] == 2) class="bg-tto-no" @else class="bg-tto-na" @endif>TTO</div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @if(isset($pat_data['potential_definite']['potential_definite_date']) && isset($pat_data['potential_definite']['type']))
                                                                @php
                                                                    $pd_date = \Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date']);
                                                                    $today = \Carbon\Carbon::today();
                                                                    $tomorrow = \Carbon\Carbon::tomorrow();
                                                                @endphp

                                                                @if(in_array($pat_data['potential_definite']['type'], [1]))
                                                                    <tr data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        @if(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->isToday())
                                                                            title="Potential Discharges Today"
                                                                        @else
                                                                            title="Potential Discharges On {{ PredefinedDateFormatForPD(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->format('Y-m-d')) }}"
                                                                        @endif>

                                                                            <td colspan="2" class="pb-0 pt-0">
                                                                                <div class="dark-gradient-danger">? HOME @if(!\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->isToday())-{{ strtoupper(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->format('D')) }} @endif</div>
                                                                            </td>
                                                                    </tr>
                                                                @else
                                                                    <tr data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        @if(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->isToday())
                                                                            title="Definite Discharges Today"
                                                                        @else
                                                                            title="Definite Discharges On {{ PredefinedDateFormatForPD(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->format('Y-m-d')) }}"
                                                                        @endif>

                                                                            <td colspan="2" class="pb-0 pt-0">
                                                                                <div class="dark-gradient-danger">HOME @if(!\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->isToday())-{{ strtoupper(\Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date'])->format('D')) }} @endif</div>
                                                                            </td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-12 mb-2">
                                    <div class="medical-details-card">
                                        <div class="row">
                                            <div
                                                class="col-xl-12 col-lg-12 col-md-12 col-12  @if(isset($pat_data['ibox_bed_status']['status']) && $pat_data['ibox_bed_status']['status'] == 0 || $pat_data['ibox_bed_status_camis'] == 'open')  bg-bed-empty @else bg-bed-closed @endif justify-content-start ps-1">
                                                <h6 class="mb-0 text-center">{{ $pat_data['ibox_bed_no'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="card-medical">
                                            <div class="closed-message">
                                                <span id="ward_close_status_{{ $pat_data['ibox_ward_bed_id'] }}">
                                                    @if(isset($pat_data['ibox_bed_status']['status']))
                                                        @if($pat_data['ibox_bed_status']['status'] == 0)
                                                            Bed Open: Empty
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 1)
                                                            Bed Closed
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 2)
                                                            Bed Restricted
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 3)
                                                            Bed Out Of Service
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 4)
                                                            Bed Reserved @if(!empty($pat_data['ibox_bed_status']['reserved_for'])) For {{ $pat_data['ibox_bed_status']['reserved_for'] }}<br>({{ $pat_data['ibox_bed_status']['patient_name'] }}) @endif
                                                        @endif
                                                    @else

                                                    @if ($pat_data['ibox_bed_status_camis'] == 'open') Bed Open: Empty @else Bed Closed: {{ ucfirst(strtolower($pat_data['ibox_bed_status_camis'])) }} @endif

                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif
