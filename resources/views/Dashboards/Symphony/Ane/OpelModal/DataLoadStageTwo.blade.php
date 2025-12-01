<div class="row ">
    <div class="col-lg-12 ">
        <div class="card-sitrep  ems-time-row">
            <div class="card-sitrep-modal">
                <div class="d-none d-md-block">
                    <div class="row g-2 mb-2">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">Number Of Patients</div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">Triage</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" step="1" min="0" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="ed_thermo_meter[triage][patient]" value="0" id="triage_patient" placeholder=""
                            aria-label="default input example">
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">First Assessment
                                Resus</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="text" name="ed_thermo_meter[first_assesment_resus][patient]" id="first_assesment_resus_patient" placeholder=""
                            aria-label="default input example" value="{{ $safety_thermometer_view['first_assessment_resus'] }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">First Assessment
                                Majors</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" name="ed_thermo_meter[first_assesment_majors][patient]" placeholder="" id="first_assesment_majors_patient"
                            aria-label="default input example"  value="{{ is_numeric($safety_thermometer_view['first_assessment_majors']) ? $safety_thermometer_view['first_assessment_majors'] : '' }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">First Assessment
                                Paeds</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" name="ed_thermo_meter[first_assesment_peads][patient]" id="first_assesment_peads_patient" placeholder=""
                            aria-label="default input example"  value="{{ is_numeric($safety_thermometer_view['first_assessment_paeds']) ? $safety_thermometer_view['first_assessment_paeds'] : '' }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">Medical Review</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" name="ed_thermo_meter[medical_review][patient]" id="medical_review_patient" placeholder=""
                            aria-label="default input example"  value="{{ is_numeric($safety_thermometer_view['medical_review']) ? $safety_thermometer_view['medical_review'] : '' }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">Surgical Review</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" step="1" min="0" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')"  name="ed_thermo_meter[surgical_review][patient]" id="surgical_review_patient" placeholder=""
                            aria-label="default input example"  value="{{ is_numeric($safety_thermometer_view['surgical_review']) ? $safety_thermometer_view['surgical_review'] : '' }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">Orthopaedic Review</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" step="1" min="0" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="ed_thermo_meter[orthopaedic_review][patient]" id="orthopaedic_review_patient" placeholder=""
                            aria-label="default input example"  value="{{ is_numeric($safety_thermometer_view['orthopaedic_review']) ? $safety_thermometer_view['orthopaedic_review'] : '' }}" readonly>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0">Other Speciality
                                Review</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" step="1" min="0" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="0"  name="ed_thermo_meter[other_speciality_review][patient]" id="other_speciality_review_patient" placeholder=""
                            aria-label="default input example">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-8">
                        <div class="">
                            <label for="" class="form-label mb-0"> UTC</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control patient_input" type="number" step="1" min="0" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="ed_thermo_meter[gp_review][patient]" id="gp_review_patient" placeholder=""
                            aria-label="default input example" value="{{ is_numeric($safety_thermometer_view['utc']) ? $safety_thermometer_view['utc'] : '' }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
