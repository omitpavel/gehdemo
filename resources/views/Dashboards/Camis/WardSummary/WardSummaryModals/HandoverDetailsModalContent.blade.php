<div class="row g-2">
    <div class="col-xxl-7">
        <input type="hidden" id="ward_id" value="{{ $success_array['patient_details']->ibox_ward_id }}">

        <div class="handover-patient-details">
            <h6 class="patient-name">{{ $success_array['patient_details']->camis_patient_name }} ( {{ $success_array['patient_details']->camis_patient_pas_number }}) - {{ $success_array['patient_details']->ibox_actual_bed_full_name }}</h6>
            <div class="row gx-0">
                <div class="col-md-6 border-handover-end">
                    <ul>
                        <li class="label-primary">Age</li>
                        <li>:  {{ $success_array['patient_details']->camis_patient_age }}  (DOB: {{ $success_array['patient_details']->camis_patient_date_of_birth }})
                        </li>
                    </ul>
                    <ul>
                        <li class="label-primary">Consultant</li>
                        <li>: {{ $success_array['patient_details']->camis_consultant_name }}
                        </li>
                    </ul>
                    <ul>
                        <li class="label-primary">LOS</li>
                        <li>: {{ PatientLos($success_array['patient_details']->camis_patient_admission_date_time) }} Total With {{ PatientLos($success_array['patient_details']->camis_patient_ward_start_date) }} On This Ward</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li class="label-primary">Med Fit</li>
                        <li>: {{ $success_array['patient_details']->BoardRoundMedicallyFitData ? $success_array['patient_details']->BoardRoundMedicallyFitData->patient_medically_fit_status == 1? 'Yes' : 'No' : 'No' }} </li>
                    </ul>
                    <ul>
                        <li class="label-primary">EDD</li>
                        <li>: {{ $success_array['patient_details']['BoardRoundEstimatedDischargeDate'] ? PredefinedDateFormatForEDD($success_array['patient_details']['BoardRoundEstimatedDischargeDate']->patient_estimated_discharge_date) : 'No EDD Set' }}</li>
                    </ul>
                    <ul></ul>
                </div>
                <div class="col-12">
                    <ul>
                        <li class="label-primary">Red/Green</li>
                        <li>: @if(isset($success_array['patient_details']->RedGreenBed->patient_red_green_status) && $success_array['patient_details']->RedGreenBed->patient_red_green_status == 1)
                            @php
                                $red_bed = json_decode($success_array['patient_details']->RedGreenBed->patient_red_green_status_reason_code, true);
                                $pending_red_bed_task = array_keys(array_filter($red_bed, function($value) {
                                    return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
                                }));
                            @endphp
                            Red ( @foreach ($pending_red_bed_task as $pending_red_task)
                            {{ $success_array['red_bed_reason_list'][$pending_red_task]}} @if(!$loop->last) , @endif
                            @endforeach )
                            @elseif(isset($success_array['patient_details']->RedGreenBed->patient_red_green_status) && $success_array['patient_details']->RedGreenBed->patient_red_green_status == 2)
                                Green
                            @else -- @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-1 col-md-1 col-4">
        <div class="pac-count-box">
            <h6 class="fw-bold">Vital PAC</h6>
            <div class="position-relative">
                    @if(isset($success_array['patient_details']['PatientVitalPacInfo']->totalews))    {!! GetEwsDataHandover($success_array['patient_details']['PatientVitalPacInfo']->totalews, 45) !!}  @else {!! GetEwsDataHandover('', 45) !!}  @endif

            </div>
            <h6 class="fw-bold mt-2">EWS</h6>

        </div>
    </div>
    <div class="col-xxl-4 col-md-11 col-8 text-md-end">
        <div class="handover-icons-wrapper">
            @foreach($success_array['patient_details']->PatientWiseFlags as $flag)
                <div class="flag-group">
                    {!! GetBedFlagImages($flag->patient_flag_name) !!}
                    <span>{{ GetFlagName($flag->patient_flag_name) }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-12 reason-section">
        <div class="row row-cols-xxl-5 row-cols-1 gx-2">
            <div class="col">
                <div class="">
                    <label for="exampleFormControlTextarea1" class="form-label">Admitting
                        Reason</label>
                    <p class="reason">
                        {{ $success_array['patient_details']['BoardRoundAdmittingReason'] ? $success_array['patient_details']['BoardRoundAdmittingReason']->patient_admitting_reason : '' }}
                </p></div>
            </div>
            <div class="col">
                <div class="">
                    <label for="exampleFormControlTextarea1" class="form-label">Past Medical
                        History</label>
                    <p class="reason">
                        {{ $success_array['patient_details']['BoardRoundPastMedicalHistory'] ? $success_array['patient_details']['BoardRoundPastMedicalHistory']->patient_past_medical_history : '' }}
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <label for="exampleFormControlTextarea1" class="form-label">Social
                        History</label>
                    <p class="reason">
                        {{ $success_array['patient_details']['BoardRoundSocialHistory'] ? $success_array['patient_details']['BoardRoundSocialHistory']->patient_social_history : '' }}
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <label for="exampleFormControlTextarea1" class="form-label">Patient
                        Goal</label>
                    <p class="reason">
                        {{ $success_array['patient_details']['BoardRoundPatientGoal'] ? $success_array['patient_details']['BoardRoundPatientGoal']->patient_patient_goal : '' }}
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="pharmacy-content">
                    <div class="row gx-2">
                        <div class="col-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Pharmacy</label>
                        </div>
                        <div class="col-9 text-end">
                            @if(isset($success_array['patient_details']['BoardRoundPharmacyData']))
                                <label  class="form-label">
                                    @if(@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history == 1)
                                        Drug History Partial
                                    @elseif(@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history == 2)
                                        Drug History Full
                                    @elseif(@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history == 3)
                                        Drug History Reviewed
                                    @elseif(@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history == 4)
                                        PHARMACIST SCREENED
                                    @endif

                                        @if(isset($success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history) &&  in_array($success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_drug_history, [1, 2, 3, 4]))

                                            @if(
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status == 1 &&
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status == 1
                                            )
                                                -
                                            @elseif(
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status == 1 &&
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status != 1
                                            )
                                                -
                                            @elseif(
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status != 1 &&
                                                @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status == 1
                                            )
                                                -
                                            @endif

                                        @endif

                                    @if((@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status == 1) && (@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status == 1) ) Antibiotics: IV  & ORAL @elseif((@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status == 1) && (@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status != 1)) Antibiotic :IV @elseif((@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_iv_status != 1) && (@$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_antibiotic_oral_status == 1)) Antibiotic :ORAL @endif
                                </label>
                                @endif
                        </div>
                    </div>
                    <p class="reason">
                        {{ @$success_array['patient_details']['BoardRoundPharmacyData']->pharmacy_latest_comment }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<hr>
<div class="row gx-1 mb-2">
    <div class="col-xxl-3">
        <label  class="form-label">Obs</label>
        <div class="">
            <select class="form-select w-100 bg-grey" id="obs_varience"  aria-label="Default select example">
                <option value="">Please Select  </option>
                <option {{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_obs_varience == '15 Mins' ? 'selected' :'' : '' }} value="15 Mins">15 Mins</option>
                <option {{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_obs_varience == '30 Mins' ? 'selected' :'' : '' }} value="30 Mins">30 Mins</option>
                <option {{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_obs_varience == 'Hourly' ? 'selected' :'' : '' }} value="Hourly">Hourly</option>
                <option {{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_obs_varience == '2 Hourly' ? 'selected' :'' : '' }} value="2 Hourly">2 Hourly</option>
                <option {{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_obs_varience == '4 Hourly' ? 'selected' :'' : '' }} value="4 Hourly">4 Hourly</option>

            </select>
        </div>
        <div class="">
            <div class="variance-textarea">
                <label  class="form-label">Variances</label>
                <textarea class="form-control bg-grey"  id="varience_store" rows="3">{{ $success_array['patient_details']['PatientHandOver'] ? $success_array['patient_details']['PatientHandOver']->ibox_handover_varience_store: '' }}</textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input p-2 bg-grey mt-0"  {{ @$success_array['patient_details']['PatientHandOver']->ibox_handover_pain_analgesia == 0 ? '':'checked' }} type="checkbox" id="handover_pain_analgesia"
                       name="handover_pain_analgesia" onclick="CheckboxPainAnalgesia();" value="1">
                <label class="form-check-label ms-2" for="handover_pain_analgesia">
                    Pain / Analgesia :
                </label>
                <label class="paoranaWrap" id="refer_to_epma" @if(@$success_array['patient_details']['PatientHandOver']->ibox_handover_pain_analgesia == 0) style="display: none;" @endif>Please refer to EPMA</label>
            </div>

        </div>
    </div>

    @php

        $s_surface_varience_array = [];
        $s_surface_varience_array = explode(',', $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_s_surface:'');


    @endphp
    <div class="col-xxl-9">
        <div class="row gx-1">
            <div class="col-lg-3 col-md-6">
                <div class="bg-purple">
                    <h6 class="mb-0">S-Surface </h6>
                    <input type="hidden" id="s_surface_value" value="{{ implode(',',$s_surface_varience_array) }}">
                </div>
                <div class="row g-1">
                    <div class="col-lg-6 col-md-6 col-6 ">
                        <input type="checkbox" style="display: none;"   {{ in_array('Room Mattress', $s_surface_varience_array) ? 'checked' : '' }} value="Room Mattress" id="room_mattress" name="s_surface[]">
                        <button for="room_mattress"  id="room_mattress_label" onclick="CheckedLabeld('s_surface', 'room_mattress');" class=" btn btn-handover {{ in_array('Room Mattress', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area" >
                                    <img class="tick_icon {{ in_array('Room Mattress', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Room Mattress', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Room Mattress
                                </div>
                            </div>

                         </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <input type="checkbox" style="display: none;"  {{ in_array('Repose Wedge', $s_surface_varience_array) ? 'checked' : '' }} value="Repose Wedge" id="respose_wedge" name="s_surface[]">
                        <button for="respose_wedge" id="respose_wedge_label" onclick="CheckedLabeld('s_surface', 'respose_wedge');" class=" btn btn-handover {{ in_array('Repose Wedge', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div  class="icon-area">
                                    <img class="tick_icon {{ in_array('Repose Wedge', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Repose Wedge', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Repose Wedge
                                </div>
                            </div>

                            </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <input type="checkbox" style="display: none;"  {{ in_array('Repose Troughs', $s_surface_varience_array) ? 'checked' : '' }} value="Repose Troughs" id="repose_troughs" name="s_surface[]">
                        <button for="repose_troughs" id="repose_troughs_label" onclick="CheckedLabeld('s_surface', 'repose_troughs');" class=" btn btn-handover {{ in_array('Repose Troughs', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div  class="icon-area">
                                    <img class="tick_icon {{ in_array('Repose Troughs', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Repose Troughs', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Repose Troughs
                                </div>
                            </div>

                            </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 ">
                        <input type="checkbox" style="display: none;"  {{ in_array('Air Mattress', $s_surface_varience_array) ? 'checked' : '' }} value="Air Mattress" id="air_mattress" name="s_surface[]">
                        <button for="air_mattress" id="air_mattress_label" onclick="CheckedLabeld('s_surface', 'air_mattress');" class=" btn btn-handover {{ in_array('Air Mattress', $s_surface_varience_array) ? 'handover_check' : '' }}" >
                            <div class="button-wrapper">
                                <div class="icon-area" >
                                    <img class="tick_icon {{ in_array('Air Mattress', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Air Mattress', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Air Mattress
                                </div>
                            </div>

                            </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 mb-1">
                        <input type="checkbox" style="display: none;"  {{ in_array('Chair Cushion', $s_surface_varience_array) ? 'checked' : '' }} value="Chair Cushion" id="chair_cushion" name="s_surface[]">
                        <button for="chair_cushion" id="chair_cushion_label" onclick="CheckedLabeld('s_surface', 'chair_cushion');" class=" btn btn-handover {{ in_array('Chair Cushion', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area">
                                    <img class="tick_icon {{ in_array('Chair Cushion', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Chair Cushion', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }}  src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Chair Cushion
                                </div>
                            </div>

                            </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 ">
                <div class="bg-darkblue">
                    <h6 class="mb-0">S-Skin</h6>
                </div>
                <div class="mb-1">
                    <label class="form-label mb-0">Repositioning
                        Routine</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_repositioning_routine:'' }}" class="h-36 form-control bg-grey"
                            id="repositioning_routine" placeholder="">
                </div>
                <div class="mb-1">
                    <label class="form-label mb-0">Skin
                        Conditioning</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_skin_conditioning :'' }}" class="h-36 form-control bg-grey"
                            id="skin_conditioning" placeholder="">
                </div>
                <div class="mb-1">
                    <label
                            class="form-label mb-0">Dressings</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_dressings:'' }}" class="h-36 form-control bg-grey"
                            id="dressing" placeholder="">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="bg-purple">
                    <h6 class="mb-0">K-Keep Moving</h6>
                </div>
                <div class="mb-1">
                    <label
                            class="form-label mb-0">Mobility</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_mobility:'' }}" class="h-36 form-control bg-grey"
                            id="mobility" placeholder="">
                </div>
                <div class="mb-1">
                    <label
                            class="form-label mb-0">Equipment</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_equipment:'' }}" class="h-36 form-control bg-grey"
                            id="equipment" placeholder="">
                </div>
                <div class="mb-1">
                    <label class="form-label mb-0">Assistance
                        Needed</label>
                    <input type="text" value="{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_assistance_needed:'' }}" class="h-36 form-control bg-grey"
                            id="assistance_needed" placeholder="">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="bg-darkblue">
                    <h6 class="mb-0">I-Continence</h6>
                </div>
                <div>
                    <select class="form-select w-100 bg-grey mb-1" id="i_continence" name="hand_over_i_continence"
                            aria-label="Default select example">
                        <option value="">Please Select
                        </option>
                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Urine' ? 'selected' : '' : "" }} value="Urine">Urine</option>

                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Double incontinent' ? 'selected' : '' : "" }} value="Double incontinent">Double incontinent</option>
                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Pads required' ? 'selected' : '' : "" }} value="Pads required">Pads required</option>
                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Catheterised' ? 'selected' : '' : "" }} value="Catheterised">Catheterised</option>
                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Continent' ? 'selected' : '' : "" }} value="Continent">Continent</option>
                        <option {{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_i_continence == 'Faecal Incontinent' ? 'selected' : '' : "" }} value="Faecal Incontinent">Faecal Incontinent</option>
                    </select>
                </div>
            </div>
            @php
                $s_surface_varience_array = [];
                $s_surface_varience_array = explode(',', $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_n_nutrition : "");

            @endphp
            <div class="col-lg-3 col-md-6">
                <div class="bg-purple">
                    <h6 class="mb-0">N-Nutrition</h6>
                    <input type="hidden" id="n_nutation_value" value="{{ implode(',',$s_surface_varience_array) }}">
                </div>
                <div class="row g-1">
                    <div class="col-lg-5 col-md-5 col-5">
                        <input type="checkbox" style="display: none;"  {{ in_array('Special Diet', $s_surface_varience_array) ? 'checked=true' : '' }} value="Special Diet" id="special_diet" name="n_nutrition[]">
                        <button for="special_diet" id="special_diet_label" onclick="CheckedLabeld('n_nutrition', 'special_diet');" class="btn btn-handover {{ in_array('Special Diet', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area  " >
                                    <img class="tick_icon {{ in_array('Special Diet', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Special Diet', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }}  src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"
                                        alt="">

                                </div>
                                <div class="button-text">
                                    Special Diet
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-7 col-md-7 col-7">
                        <input type="checkbox" style="display: none;"  {{ in_array('Food Fluid Chart', $s_surface_varience_array) ? 'checked' : '' }} value="Food Fluid Chart" id="food_fluid_chart" name="n_nutrition[]">
                        <button for="food_fluid_chart" id="food_fluid_chart_label" onclick="CheckedLabeld('n_nutrition', 'food_fluid_chart');" class="btn btn-handover {{ in_array('Food Fluid Chart', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area " >
                                    <img class="tick_icon {{ in_array('Food Fluid Chart', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Food Fluid Chart', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"
                                        alt="">

                                </div>
                                <div class="button-text">
                                    Food
                                    Fluid Chart
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-5 col-md-5 col-5 ">
                        <input type="checkbox" style="display: none;" {{ in_array('Dietition', $s_surface_varience_array) ? 'checked' : '' }} value="Dietition" id="dietition" name="n_nutrition[]">
                        <button for="dietition"  id="dietition_label" onclick="CheckedLabeld('n_nutrition' ,'dietition');"   class=" btn btn-handover me-1 {{ in_array('Dietition', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area " >
                                    <img class="tick_icon  {{ in_array('Dietition', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Dietition', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Dietition
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-lg-7 col-md-7 col-7 ">
                        <input type="checkbox" style="display: none;"  {{ in_array('Fluid Restrictions', $s_surface_varience_array) ? 'checked' : '' }} value="Fluid Restrictions" id="fluid_restrictions" name="n_nutrition[]">
                        <button for="fluid_restrictions"  id="fluid_restrictions_label"  onclick="CheckedLabeld('n_nutrition', 'fluid_restrictions');"  class=" btn btn-handover {{ in_array('Fluid Restrictions', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area ">
                                    <img class="tick_icon {{ in_array('Fluid Restrictions', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Fluid Restrictions', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }}  src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Fluid Restrictions
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-5 col-md-5 col-5">
                        <input type="checkbox" style="display: none;"  {{ in_array('SALT', $s_surface_varience_array) ? 'checked' : '' }} value="SALT" id="salt" name="n_nutrition[]">
                        <button for="salt" id="salt_label"  onclick="CheckedLabeld('n_nutrition' ,'salt');" class=" btn btn-handover me-1 {{ in_array('SALT', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area" >
                                    <img class="tick_icon {{ in_array('SALT', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('SALT', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    SALT
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-lg-7 col-md-7 col-7 ">
                        <input type="checkbox" style="display: none;"  {{ in_array('Assisted Feeding', $s_surface_varience_array) ? 'checked' : '' }} value="Assisted Feeding" id="assisted_feeding" name="n_nutrition[]">
                        <button for="assisted_feeding" id="assisted_feeding_label" onclick="CheckedLabeld('n_nutrition', 'assisted_feeding');" class=" btn btn-handover {{ in_array('Assisted Feeding', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area">
                                    <img class="tick_icon {{ in_array('Assisted Feeding', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Assisted Feeding', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }}  src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Assisted Feeding
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-5 col-md-5 col-5">
                        <input type="checkbox" style="display: none;"  {{ in_array('Diabetes', $s_surface_varience_array) ? 'checked' : '' }} value="Diabetes" id="diabetes" name="n_nutrition[]">
                        <button for="diabetes" id="diabetes_label" onclick="CheckedLabeld('n_nutrition' ,'diabetes');"
                                class=" btn btn-handover me-1 {{ in_array('Diabetes', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area">
                                    <img  class="tick_icon {{ in_array('Diabetes', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Diabetes', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Diabetes
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-7 col-md-7 col-7">
                        <input type="checkbox" style="display: none;"  {{ in_array('Nil by Mouth', $s_surface_varience_array) ? 'checked' : '' }} value="Nil by Mouth" id="nil_by_mouth" name="n_nutrition[]">
                        <button for="nil_by_mouth"  id="nil_by_mouth_label" onclick="CheckedLabeld('n_nutrition' ,'nil_by_mouth');" class="h-36 h-36 justify-content-around  btn btn-handover {{ in_array('Nil by Mouth', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area" >
                                    <img class="tick_icon {{ in_array('Nil by Mouth', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Nil by Mouth', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Nil by Mouth
                                </div>
                            </div>


                        </button>
                    </div>
                    <div class="col-lg-5 col-md-5 col-5">
                        <input type="checkbox" style="display: none;"  {{ in_array('Normal', $s_surface_varience_array) ? 'checked' : '' }} value="Normal" id="normal" name="n_nutrition[]">
                        <button for="normal"  id="normal_label"  onclick="CheckedLabeld('n_nutrition' ,'normal');"
                                class="h-36  btn btn-handover me-1 {{ in_array('Normal', $s_surface_varience_array) ? 'handover_check' : '' }}">
                            <div class="button-wrapper">
                                <div class="icon-area" >
                                    <img class="tick_icon {{ in_array('Normal', $s_surface_varience_array) ? 'green_tick_active' : '' }}" {{ in_array('Normal', $s_surface_varience_array) ? 'style=display:block' : 'style=display:none' }} src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                </div>
                                <div class="button-text">
                                    Normal
                                </div>
                            </div>

                        </button>
                    </div>
                    <div class="col-lg-7 col-md-7 col-7">
                    </div>
                    <div class="col-12" style="{{ in_array('Special Diet', $s_surface_varience_array) ? 'display:block' : 'display:none' }}" id="handover_diet_comment">
                        <div class="nutrition-comment">
                            <textarea class=" form-control bg-grey" id="hand_over_special_diet_comment">{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_special_diet_comment : "" }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row  gx-2">

    <div class="col-xl-9 mb-2">
        <div class="task-comments-section">
            <div class="header-task">
                <h6>Task to be Completed</h6>
            </div>
            <div class="completed-tasks">
                @forelse($success_array['patient_details']->BoardRoundPatientTasks as $key => $task)
                    @if($key % 2 == 0)
                        <div class="row align-items-center gx-0">
                            @endif

                            <div class="col-md-6">
                                <div class="cell">
                                    <h6 class="comment-number">{{ $loop->iteration }}</h6>
                                    <p class="comment">
                                        @if($task->task_priority == 1) ! @endif
                                        @if($task->task_category != 0) {{ @$task->PatientTaskCategory->task_category_name }} - @endif
                                        @if($task->task_category == 6) {{ @$task->task_dp_status_order_value }} @endif
                                        {{ @$task->task_description }} - {{ PredefinedDateFormatFor24Hour($task->task_updated_at) }} - {{ @$task->PatientTaskGroup->task_group_name }}
                                    </p>
                                </div>
                            </div>

                            @if($key % 2 != 0 || $loop->last)
                        </div>
                    @endif

                @empty
                    <div style="position: relative;top: 50%; text-align: center;">
                        {{ NotFoundMessage() }}
                    </div>
                @endforelse
            </div>

        </div>
    </div>
    <div class="col-xl-3 mb-2">
        <div class="">
            <div class="card-comment-grp">
                <h6>Comment</h6>
                <textarea class="form-control "  rows="6" id="ibox_handover_comment">{{ $success_array['patient_details']->PatientHandOver?$success_array['patient_details']->PatientHandOver->ibox_handover_comment : "" }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="row g-2 handover-group">
    <input type="hidden" id="total_handover_count" value="{{  $success_array['total_handover'] }}">
    <div class="col-lg-3 col-md-6">
        <button class="btn btn-grey {{ $success_array['previous_patient'] != null ? '' :'inactive' }} "  @if( $success_array['previous_patient'] != null) onclick="PreviousPatient('{{$success_array['patient_details']->ibox_ward_id }}','{{  $success_array['previous_patient'] }}'); " @endif>
            <img src="{{ asset('asset_v2/Template/icons/previous.svg') }}" alt="" width="15"
                    height="15" class="btn-icon"><span>PREVIOUS  PATIENT</span>
        </button>
    </div>
    <div class="col-lg-3 col-md-6">
        <button class="btn btn-grey" onclick="SaveHandOverDetails('{{ $success_array['patient_details']->camis_patient_id }}','{{ $success_array['next_patient'] != null ? 'save_and_next' :'save' }}');">
            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" width="15" height="15"
                    class="btn-icon"> <span>SAVE CHANGES {{ $success_array['next_patient'] != null ? ' - NEXT PATIENT' :'' }} </span>
        </button>
    </div>
    <div class="col-lg-2 col-md-4">
        <button class="btn btn-grey" onclick="ShowHandoverFilterPopUp('{{ $success_array['patient_details']->ibox_ward_id }}','{{ $success_array['patient_details']->camis_patient_id }}');">
            <img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" width="18" height="18"
                    class="btn-icon">
            <span>PRINT</span>
        </button>
    </div>
    <div class="col-lg-2 col-md-4">
        <button class="btn btn-grey"  data-bs-dismiss="modal" aria-label="Close" onclick="CloseOffcanvas('handoverModal');">
            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="12" height="12"
                    class="btn-icon"><span>CLOSE</span>
        </button>
    </div>
    <div class="col-lg-2 col-md-4">
        <button class="btn btn-grey {{ $success_array['next_patient'] != null ? '' :'inactive' }} " @if($success_array['next_patient'] != null) onclick="NextPatient('{{$success_array['patient_details']->ibox_ward_id }}','{{ $success_array['next_patient'] }}');" @endif>
            <img src="{{ asset('asset_v2/Template/icons/next-right.svg') }}" alt="" width="15"
                    height="15" class="btn-icon"><span>NEXT
                                        PATIENT</span>
        </button>
    </div>
</div>
<h6 class="mb-1 mt-2">NAVIGATION</h6>
<div class="row row-cols-lg-5 row-cols-md-3 row-cols-1" id="navigation">
    @foreach($success_array['bed_navigation'] as $bed)
                <div class="col ">
                    <div class="row align-items-center border-right">
                        <div class="col-12">
                            <div class="text-center">
                                <ul class="leftside-head">
                                    @if($bed->ibox_bed_group_name != 'Bay')
                                    <li> {{ $bed->ibox_bed_group_name }}</li>
                                    @else
                                        <li> {{ $bed->ibox_bed_group_name }}  {{  $bed->ibox_bed_group_number }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="handover-rightside">
                                <div class="row handover-rightside-list" style="--bs-gutter-x:0 !important;">
                                    @foreach($success_array['bed_navigation_no'] as $bed_no)
                                        @if(($bed->ibox_bed_group_name == $bed_no['ibox_bed_group_name'] ) && ($bed->ibox_bed_group_number == $bed_no['ibox_bed_group_number']))
                                            <div class="col-3 bed_no bg-grey {{ $bed_no['camis_patient_id'] ? :'inactive' }}" @if($bed_no['camis_patient_id']) onclick="GetPatientByBedNo('{{ $success_array['patient_details']->ibox_ward_id }}','{{ $bed_no['ibox_bed_group_name'] }}','{{ $bed_no['ibox_bed_group_number'] }}','{{ $bed_no['ibox_bed_no'] }}');" @endif>
                                                @if(in_array($bed_no['camis_patient_id'], $success_array['patients_data']) )

                                                <div class="tick-icon">
                                                    <img src="{{ asset('asset_v2/Template/icons/green-circle-mark.svg') }}"/>

                                                </div>
                                                @endif
                                                {{ $bed_no['ibox_bed_no'] }}
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

    @endforeach
<script>
    $(document).ready(function () {
        var total_handover_count = $("#total_handover_count").val();
        $('#handover_count').html(total_handover_count);

    });
</script>
</div>
