<div id="breach_reason_update_success_message" class="col-xs-12 col-md-12"> </div>
{!! Form::hidden('breach_reason_popup_current_attendence_id', $success_array['breach_record_array']['attendance_id'], ['id' => 'breach_reason_popup_current_attendence_id']) !!}
<div class="col-md-12  padding-zero">
    <div class="row gx-2 mb-1">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12  mb-1">
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="pas_number_modal">
                        PAS Number
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('pas_number_modal', $success_array['breach_record_array']['pas_number'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'pas_number_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="reg_date_modal">
                        Reg Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('reg_date_modal', $success_array['breach_record_array']['registration_date'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'reg_date_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label">
                        Time From Reg To Triage
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['time_from_reg_to_triage_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['time_from_reg_to_triage'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label">
                        Time From Reg To ED Dr
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['time_from_reg_to_ed_doctor_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['time_from_reg_to_ed_doctor'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;">{{ $success_array['breach_record_array']['time_from_reg_to_ed_doctor_right'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label">
                        Time From Reg To Referral
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['time_from_reg_to_referal_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['time_from_reg_to_referal'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;">{{ $success_array['breach_record_array']['time_from_reg_to_referal_right'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label">
                        Time From Referral To Specialty Dr
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['time_from_referral_to_speciality_doctor_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['time_from_referral_to_speciality_doctor'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;">{{ $success_array['breach_record_array']['time_from_referral_to_speciality_doctor_right'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" >
                        Time In Dept Over 4 Hours
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['time_in_department_over_four_hour_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['time_in_department_over_four_hour'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" >
                        Patients In ED Department
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['patients_ed_department_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['patients_ed_department'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;">{{ $success_array['breach_record_array']['patients_ed_department_right'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6  col-sm-12">
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="pat_name_modal">
                        Name
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('pat_name_modal', $success_array['breach_record_array']['patient_name'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'pat_name_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="arrival_mode_modal">
                        Arrival Mode
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('arrival_mode_modal', $success_array['breach_record_array']['arrival_mode'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'arrival_mode_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="tri_date_modal">
                        Triage Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('tri_date_modal', $success_array['breach_record_array']['triage_date_time'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'tri_date_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="seen_date_modal">
                        Seen By ED Dr Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('seen_date_modal', $success_array['breach_record_array']['seen_by_ed_doctor_date'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'seen_date_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="referral_date_time_modal">
                        Referral Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('referral_date_time_modal', $success_array['breach_record_array']['referal_date_time'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'referral_date_time_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="clinical_refferal_date_modal">
                        Speciality Dr Seen Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('clinical_refferal_date_modal', $success_array['breach_record_array']['speciality_doctor_seen_date_time'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'clinical_refferal_date_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="departure_date_modal">
                        Departure Date
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('departure_date_modal', $success_array['breach_record_array']['departure_date'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'departure_date_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label">
                        Patients Waiting Bed
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    <div class="form-control disabled-div-show {{ $success_array['breach_record_array']['patients_waiting_bed_colour'] }}">
                        <span class='breach-reason-text-inside-span'>{{ $success_array['breach_record_array']['patients_waiting_bed'] }}</span>
                        <span class='breach-reason-text-inside-span' style="float: right;">{{ $success_array['breach_record_array']['patients_waiting_bed_right'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="ed_ea_number_modal">
                        Attendance ID
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('ed_ea_number_modal', $success_array['breach_record_array']['attendance_id'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'ed_ea_number_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="speciality_modal">
                        Assigned Speciality
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('speciality_modal', $success_array['breach_record_array']['speciality'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'speciality_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="triage_category_modal">
                        Triage Category
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('triage_category_modal', $success_array['breach_record_array']['triage_category'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'triage_category_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="seen_ae_by_modal">
                        Seen By ED Dr
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('seen_ae_by_modal', $success_array['breach_record_array']['seen_by_ed_doctor'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'seen_ae_by_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="time_to_dta_modal">
                        Time From DTA To Admitted
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('time_to_dta_modal', $success_array['breach_record_array']['time_from_dta_to_admitted'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'time_to_dta_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="clinical_reffereal_value_modal">
                        Speciality Dr
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('clinical_reffereal_value_modal', $success_array['breach_record_array']['speciality_doctor_description'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'clinical_reffereal_value_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="time_in_depart_modal">
                        Time In Department
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('time_in_depart_modal', $success_array['breach_record_array']['time_in_department'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'time_in_depart_modal']) !!}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="department_modal">
                        Department
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('department_modal', $success_array['breach_record_array']['attendence_type'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'department_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="first_location_modal">
                        First Location
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('first_location_modal', $success_array['breach_record_array']['first_location'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'first_location_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="processing_complaint_modal">
                        Processing Complaint
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('first_location_modal', $success_array['breach_record_array']['processing_complaint'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'processing_complaint_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="final_location_modal">
                        Final Location
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('final_location_modal', $success_array['breach_record_array']['final_location'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'final_location_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="dta_date_time_modal">
                        DTA Date / Time
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('dta_date_time_modal', $success_array['breach_record_array']['dta_date_time'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'dta_date_time_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="discharge_outcome_desc_modal">
                        Discharge Outcome
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('discharge_outcome_desc_modal', $success_array['breach_record_array']['discharge_outcome'], ['class' => 'form-control ', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'discharge_outcome_desc_modal']) !!}
                </div>
            </div>
            <div class="col-md-12 padding-zero mb-2">
                <div class="col-xs-12 col-md-12 padding-zero">
                    <label class="form-label" for="dta_discharged_ward_modal">
                        Ward
                    </label>
                </div>
                <div class="col-xs-12 col-md-12 padding-zero">
                    {!! Form::text('dta_discharged_ward_modal', $success_array['breach_record_array']['ward'], ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'dta_discharged_ward_modal']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 " style='margin-top:10px;margin-bottom:15px;'>
        <input type="hidden" name="attendence_id" id="attendence_id" value="">
        <div class="col-md-12  padding-zero">
            <div class="col-xs-12 col-md-12 padding-zero" id="breach_reason_automated">
                <label class="form-label" for="breach_reason_update_id_to_store_field">
                    Breach Reason Automated
                </label>
            </div>
            <div id="breach_form_reason_value" style="float: left; width: 100%;">
                {!! Form::select('breach_reason_update_id_to_store_field', ['' => 'Select Breach Reason'] + $success_array['breach_reason'], $success_array['breach_record_array']['breach_reason_id'], ['class' => 'form-control', 'id' => 'breach_reason_update_id_to_store_field']) !!}
            </div>
            <div id="breach_unlock_reason" style="width: 5%; float: left"> </div>
        </div>
    </div>


    <div class="col-md-12 " style='margin-top:10px;margin-bottom:15px;'>
        &nbsp;
    </div>
</div>
