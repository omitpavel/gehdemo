
<ul class="nav nav-tabs"  id="dltab" role="tablist">
    <li class="mb-2">
        <a class="tab-custom-btn active" data-bs-toggle="tab" href="#tab1">
            <div class="tab-active">TAB 01</div>
        </a>
    </li>
    <li class="mb-2 @if($success_array['handover_data'] == null) permission_restricted @endif dl_tab_2">
        <a class="tab-custom-btn" data-bs-toggle="tab" href="#tab2">
            <div class="tab-active">TAB 02</div>
        </a>
    </li>
    <li class="mb-2 @if($success_array['handover_data'] == null) permission_restricted @endif dl_tab_3">
        <a class="tab-custom-btn" data-bs-toggle="tab" href="#tab3">
            <div class="tab-active">TAB 03</div>
        </a>
    </li>
    <li class="mb-2 @if($success_array['handover_data'] == null) permission_restricted @endif dl_tab_4">
        <a class="tab-custom-btn" data-bs-toggle="tab" href="#tab4">
            <div class="tab-active">TAB 04</div>
        </a>
    </li>
</ul>
<div class="tab-content" id="tabcontent" >
    <div id="tab1" class="tab-pane active  discharge_lounge_tab_1_data">
        <div class="card-discharge-handover mb-2">
            <div class="form-content">
                <div class="row gx-2 mb-2">
                    <div class="col-12">
                        <div class="text-blue">
                            <h5 class="mb-0">PATIENT’S DISCHARGE CHECK LIST -
                                <span>(Ext.360/4408)</span>
                            </h5>
                        </div>
                        @if($success_array['handover_data'] != null && $success_array['handover_data']['status'] == 2)
                            <div class="text-reject-reason">
                                <label for="" class="form-label"><b>Reject Reason :</b> @if($success_array['handover_data']['reject_reason'] != '') {{$success_array['handover_data']['reject_reason']}} @else N/A @endif</label>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Patient Name</label>
                    </div>
                    <div class="col-lg-3 col-md-9 mb-2">
                        <input type="text" class="form-control" id="" aria-describedby=""
                            placeholder="{{ $success_array['patient_data']->camis_patient_name }}" disabled>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">NHS Number</label>
                    </div>
                    <div class="col-lg-3 col-md-9 mb-2">
                        <input type="text" class="form-control" id="" aria-describedby=""
                            placeholder="{{ $success_array['patient_data']->camis_patient_pas_number }}" disabled>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Date of Birth</label>
                    </div>
                    <div class="col-lg-3 col-md-9 mb-2">
                        <input type="text" class="form-control" id="" aria-describedby=""
                            placeholder="{{ $success_array['patient_data']['camis_patient_date_of_birth'] ? PredefinedDobDateAlone($success_array['patient_data']['camis_patient_date_of_birth']) : '' }}" disabled>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Date</label>
                    </div>
                    <div class="col-lg-3 col-md-9 mb-2">
                        <input type="text" class="form-control" id="" aria-describedby=""
                            placeholder="12-Jan-2021" disabled>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Hospital Number</label>
                    </div>
                    <div class="col-lg-3 col-md-9">
                        <input type="text" class="form-control" id="" aria-describedby=""
                            placeholder="{{ $success_array['patient_data']->camis_patient_nhs_number }}" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-discharge-handover">
            <div class="header-content">
                <h6 class="mb-0">PATIENT’S HISTORY</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Reason for Admission</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" aria-describedby="" id="dl_admitting_reason"
                            placeholder="" value="{{ $success_array['patient_admit_reason'] }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">PMH</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_pmh" aria-describedby=""
                            value="{{ $success_array['handover_data']->pmh ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">DNCPAR</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_dncpar" aria-describedby=""
                        value="{{ $success_array['handover_data']->dncpar ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Allergy</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_allergy" aria-describedby=""
                        value="{{ $success_array['handover_data']->allergy ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">EWS Score</label>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-2">
                        <input type="text" class="form-control" id="dl_ews" aria-describedby=""
                        value="{{ $success_array['patient_data']['PatientVitalPacInfo']['totalews'] ?? '--' }}" readonly>
                    </div>
                    <div class="col-lg-1 col-md-1 mb-2 text-center">
                        <label for="" class="form-label">2</label>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-2">
                        <input type="text" class="form-control" id="dl_ews2" aria-describedby=""
                        value="{{ $success_array['handover_data']->ews ?? '' }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-2">
                        <label for="" class="form-label">Type of Mask</label>
                    </div>
                    <div class="col-lg-2 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_type_of_mask" aria-describedby=""
                        value="{{ $success_array['handover_data']->type_of_mask ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Learning Disability</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_learning_disability" aria-describedby=""
                        value="{{ $success_array['handover_data']->learning_disability ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Safeguarding Issues</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_safeguarding_issues" aria-describedby=""
                        value="{{ $success_array['handover_data']->safeguarding_issues ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Critical Medication</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_critical_medication" aria-describedby=""
                        value="{{ $success_array['handover_data']->critical_medication ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Mobility</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_mobility" aria-describedby=""
                        value="{{ $success_array['handover_data']->mobility ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Diet</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_diet" aria-describedby=""
                        value="{{ $success_array['patient_diet'] }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Pressure Ulcer</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="dl_pressure_ulcer" aria-describedby=""
                        value="{{ $success_array['handover_data']->pressure_ulcer ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <label for="" class="form-label">Continence</label>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <input type="text" class="form-control" id="dl_continence" aria-describedby=""
                            value="{{ $success_array['patient_continence'] }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" class="tab-pane fade">
        <div class="card-discharge-handover">
            <div class="header-content">
                <h6 class="mb-0">DESTINATION</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-4 mb-2">
                        <label for="" class="form-label">Contact number of carers</label>
                    </div>
                    <div class="col-lg-9 col-md-8 mb-2">
                        <input type="text" class="form-control" id="dl_contact_number_of_carers" aria-describedby=""
                        value="{{ $success_array['handover_data']->contact_number_of_carers ?? '' }}">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-2 offset-lg-3">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="care_home_other_setting" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->care_home_other_setting == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="care_home_other_setting">
                                Care home/other setting
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-2">
                        <label for="" class="form-label">Cut off time</label>
                    </div>
                    <div class="col-lg-3 col-md-5 mb-2">
                        <input type="text" class="form-control" id="dl_cut_of_time" aria-describedby=""
                        value="{{ $success_array['handover_data']->cut_off_time ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-4 mb-2">
                        <label for="" class="form-label">Name of care home</label>
                    </div>
                    <div class="col-lg-9 col-md-8 mb-2">
                        <input type="text" class="form-control" id="dl_name_of_care_home" aria-describedby=""
                        value="{{ $success_array['handover_data']->name_of_care_home ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-4 mb-2">
                        <label for="" class="form-label">Contact number of care home</label>
                    </div>
                    <div class="col-lg-9 col-md-8 mb-2">
                        <input type="text" class="form-control" id="dl_number_of_care_home" aria-describedby=""
                        value="{{ $success_array['handover_data']->contact_number_of_care_home ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label for="" class="form-label">Next of Kin aware</label>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <input type="text" class="form-control" id="dl_next_to_kin_aware" aria-describedby=""
                        value="{{ $success_array['handover_data']->next_of_kin_aware ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tab3" class="tab-pane fade">
        <div class="card-discharge-handover">
            <div class="header-content">
                <h6 class="mb-0 text-start">ELECTRONICS DISCHARGE SUMMARY LETTER (EDN)</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" value="1"
                                id="edn_status_completed" name="edn_status" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->edn_status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="edn_status_completed">
                                Completed
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" value="0"
                                id="edn_status_to_be_completed" name="edn_status" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->edn_status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="edn_status_to_be_completed">
                                To be Completed
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-content rounded-0">
                <h6 class="mb-0 text-start">MEDICATIONS</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="medication_status" value="0"
                                id="medication_no" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->medication_status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="medication_no">
                                No
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="medication_status" value="1"
                                id="medication_with_patient" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->medication_status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="medication_with_patient">
                                With Patient
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="medication_status" value="2"
                                id="medication_pharmacy" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->medication_status == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="medication_pharmacy">
                                Pharmacy
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="medication_status" value="3"
                                id="medication_awaiting_confirmation" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->medication_status == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="medication_awaiting_confirmation">
                                Awaiting Authorization
                            </label>
                        </div>
                    </div>
                    <h6 class="mt-2">TTO's</h6>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="tto_awaiting_authorization" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->tto_awaiting_authorization == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tto_awaiting_authorization">
                                Awaiting Authorization
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-content rounded-0">
                <h6 class="mb-0 text-start">REFERRAL</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="referral_status" value="0"
                                id="referral_catheter_online_nhft" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->referral_status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="referral_catheter_online_nhft">
                                Catheter online NHFT
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="referral_status" value="1"
                                id="referral_district_nurse" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->referral_status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="referral_district_nurse">
                                District Nurse
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="radio" name="referral_status" value="2"
                                id="referral_not_aaplicable" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->referral_status == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="referral_not_aaplicable">
                                Not Applicable
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tab4" class="tab-pane fade">
        <div class="card-discharge-handover">
            <div class="header-content">
                <h6 class="mb-0">DESTINATION</h6>
            </div>
            <div class="form-content">
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="family_to_collect" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->family_to_collect == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="family_to_collect">
                                Family to collect
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="family_at_home" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->family_at_home == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="family_at_home">
                                Family at home
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="key_safe" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->key_safe == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="key_safe">
                                KEY SAFE
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="patient_has_a_key" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->patient_has_a_key == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="patient_has_a_key">
                                Patient has a KEY
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Contact Number</label>
                    </div>
                    <div class="col-lg-9 col-md-6 mb-2">
                        <input type="text" class="form-control" id="contact_number" aria-describedby=""
                        value="{{ $success_array['handover_data']->contact_number ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="hospital_ambulance" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->hospital_ambulance == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hospital_ambulance">
                                Hospital Ambulance
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="booked" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->booked == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="booked">
                                Booked
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="job_reference" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->job_reference == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="job_reference">
                                Job Reference
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-2">
                        <input type="text" class="form-control" id="to_be_booked" aria-describedby=""
                        value="{{ $success_array['handover_data']->to_be_booked ?? '' }}">
                    </div>
                    <div class="col-lg-2 col-md-2 mb-2">
                        <label for="to_be_booked" class="form-label">To be booked</label>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="private_crew" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->private_crew == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="private_crew">
                                Private Crew - from Volunteer (If Denise is not around, please do
                                not
                                use the private crew)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-content rounded-0">
                <h6 class="mb-0 text-start">EQUIPMENT</h6>
            </div>
            <div class="form-content">
                <h6 class="text-blue mb-3">Equipment to take home</h6>
                <div class="row row-cols-md-5 row-cols-1 gx-2 mb-md-2 align-items-center">
                    <div class="col mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="zimer_frame" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->zimer_frame == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="zimer_frame">
                                Zimer frame
                            </label>
                        </div>
                    </div>
                    <div class="col mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="stick" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->stick == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="stick">
                                Stick
                            </label>
                        </div>
                    </div>
                    <div class="col mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="commode" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->commode == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="commode">
                                Commode
                            </label>
                        </div>
                    </div>
                    <div class="col mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="bed_pan" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->bed_pan == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="bed_pan">
                                Bed Pan
                            </label>
                        </div>
                    </div>
                    <div class="col mb-2 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input p-2 me-2 mt-0" type="checkbox" value=""
                                id="equipment_not_applicable" {{ !empty($success_array['handover_data']) && $success_array['handover_data']->equipment_not_applicable == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="equipment_not_applicable">
                                Not Applicable
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row gx-2 align-items-center">
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="name_of_ward" class="form-label">Name of the ward</label>
                    </div>
                    <div class="col-lg-9 col-md-9 mb-2">
                        <input type="text" class="form-control" id="name_of_ward" value="{{ $success_array['patient_ward'] }}" aria-describedby=""
                            >
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="name_of_staff_nurse" class="form-label">Name of the Staff Nurse</label>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-2">
                        <input type="text" class="form-control" id="name_of_staff_nurse" aria-describedby=""
                        value="{{ $success_array['handover_data']->name_of_staff_nurse ?? '' }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-3 mb-2 text-md-center">
                        <label for="" class="form-label">Time</label>
                    </div>
                    <div class="col-lg-2 col-md-2 col-9 mb-2">
                        <input type="text" class="form-control clockpicker_nurse" id="nurse_time" aria-describedby=""
                        value="{{ $success_array['handover_data']->nurse_time ?? '' }}">
                    </div>
                    <div class="col-lg-3 col-md-3 mb-2">
                        <label for="" class="form-label">Handover appointed by</label>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-2">
                        <input type="text" class="form-control" id="handover_appointed_by" aria-describedby=""
                        value="{{ $success_array['handover_data']->handover_appointed_by ?? '' }}" >
                    </div>
                    <div class="col-lg-1 col-md-1 col-3 mb-2 text-md-center ">
                        <label for="" class="form-label">Time</label>
                    </div>
                    <div class="col-lg-2 col-md-2 col-9 mb-2">
                        <input type="text" class="form-control clockpicker_handover" id="handover_time" aria-describedby=""
                        value="{{ $success_array['handover_data']->handover_time ?? '' }}" >
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <label for="" class="form-label">Additional Note</label>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <textarea class="form-control" id="dl_note"
                            rows="3">{{ $success_array['handover_data']->note ?? ''  }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
