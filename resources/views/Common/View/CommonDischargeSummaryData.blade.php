
@if($patient_array != null)
    <input type="hidden" value="{{ @$patient_array->camis_patient_id }}" class="discharged_patients_print_id" id="discharged_patients_print_id">
    <div class="card-dischage-summary" >
        <div class="row">
            <div class="col-lg-4 col-md-4 pe-md-1">
                <div class="mb-2">
                    <label  class="form-label">Hospital
                        Number</label>
                    <input type="text" readonly value="{{ @$patient_array->camis_patient_pas_number }} " class="form-control" id="hos_number" placeholder="">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 pe-md-1 ps-md-1">
                <div class="mb-2">
                    <label  class="form-label">NHS
                        Number</label>
                    <input type="text" readonly value="{{ @$patient_array->camis_patient_nhs_number }}" class="form-control" id="nhs_number" placeholder="">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 ps-md-1">
                <div class="mb-2">
                    <label  class="form-label">Name</label>
                    <input type="text" readonly value="{{ @$patient_array->camis_patient_name }}" class="form-control" id="name" placeholder="">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 pe-md-1">
                <div class="mb-2">
                    <label  class="form-label">Admitted
                        Date</label>
                    <input type="text" class="form-control" readonly @if(isset($patient_array->camis_patient_admission_date_time)) value="{{ PredefinedYearFormat($patient_array->camis_patient_admission_date_time) }}" @endif id="admission_date_time" placeholder="1st Jul 2023 22:48">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 pe-md-1 ps-md-1">
                <div class="mb-2">
                    <label  class="form-label">Discharge
                        Date</label>
                    <input type="text" readonly @if(isset($patient_array->camis_patient_discharge_date_time)) value="{{ PredefinedYearFormat($patient_array->camis_patient_discharge_date_time) }}" @endif class="form-control" id="disharge_date_time" placeholder="2nd Jul 2023 01:25">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 ps-md-1">
                <div class="mb-2">
                    <label  class="form-label">LOS</label>
                    <input type="text" readonly @if(isset($patient_array->camis_patient_admission_date_time) && isset($patient_array->camis_patient_discharge_date_time)) value="{{ NumberOfDays($patient_array->camis_patient_admission_date_time, $patient_array->camis_patient_discharge_date_time) }} {{ NumberOfDays($patient_array->camis_patient_admission_date_time, $patient_array->camis_patient_discharge_date_time) > 1 ? 'Days' : 'Day' }}" @endif class="form-control" id="num_days" placeholder="1">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Admitted
                        Reason</label>
                    <p class="comment-area">
                        {{ @$patient_array->BoardRoundAdmittingReason->patient_admitting_reason }}
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Past Medical History</label>
                    <p class="comment-area">
                        {{ @$patient_array->BoardRoundPastMedicalHistory->patient_past_medical_history }}
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Social History</label>
                    <p class="comment-area">
                        {{ @$patient_array->BoardRoundSocialHistory->patient_social_history }}
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Patient Goal</label>
                    <p class="comment-area">{{ @$patient_array->BoardRoundPatientGoal->patient_patient_goal }}</p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="rectangle-block-1 mb-2">
                    <div class="blue-rectangle-block ">
                        <h6 class="mb-0">TASK COMPLETED</h6>
                    </div>
                    <div>
                        <table class="breachReasonTable responsiveTable table-completed-tasks">
                            <thead>
                            <tr class="position-relative">
                                <th class="text-center">#</th>
                                <th>Tasks</th>
                                <th>Created Date</th>
                                <th>Completed Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($patient_array->BoardRoundPatientTasks))
                                @forelse($patient_array->BoardRoundPatientTasks as $task)
                                    <tr>
                                        <td class="pivoted text-center">
                                            <div class="tdBefore">#</div>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Tasks</div>
                                            {{ $task->task_description }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Created Date</div>
                                            {{ PredefinedYearFormat($task->created_at) }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Completed Date</div>
                                            {{ PredefinedYearFormat($task->updated_at) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-records-row">
                                        <td class="pivoted no-records-cell w-100" colspan="4" >
                                            <div class="tdBefore"></div>
                                            {{ NotFoundMessage() }}
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr class="no-records-row">
                                    <td class="pivoted no-records-cell w-100" colspan="4" >
                                        <div class="tdBefore"></div>
                                        {{ NotFoundMessage() }}
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rectangle-block-1 mb-2">
                    <div class="blue-rectangle-block ">
                        <h6 class="mb-0">FLAG</h6>
                    </div>
                    <div class="row p-3">
                        <div class="col-lg-12 text-center">
                            <div class="flags-section">
                                @if(isset($patient_array->PatientWiseFlags))
                                    @forelse($patient_array->PatientWiseFlags as $flag)
                                        <div class="flag-group">
                                            {!! GetBedFlagImages($flag->patient_flag_name) !!}
                                            <span> {{ GetFlagName($flag->patient_flag_name) }}</span>
                                        </div>
                                    @empty
                                        <div class="w-100">
                                            <div class="custom_not_found">
                                                No Flag Found!
                                            </div>
                                        </div>


                                    @endforelse
                                @else
                                    <div class="w-100">
                                        <div class="custom_not_found">
                                            No Flag Found!
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12">
                <div class="rectangle-block-1 mb-2">
                    <div class="blue-rectangle-block ">
                        <h6 class="mb-0">PHARMACY</h6>
                    </div>
                    <div class="row g-2 p-2">
                        <div class="col-lg-4 col-md-4 ">
                            <button class="btn btn-discharge-grey mb-1 w-100">
                                @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 1)
                                    <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                        width="20">
                                @endif
                                DRUG HISTORY
                                PARTIAL</button>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <button class="btn btn-discharge-grey mb-1 w-100">
                                @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 2)
                                    <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                        width="20">
                                @endif
                                DRUG HISTORY
                                FULL</button>
                        </div>
                        <div class="col-lg-4 col-md-4 ">
                            <button class="btn btn-discharge-grey mb-1 w-100">
                                @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 3)
                                    <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                        width="20">
                                @endif
                                MEDICATION IN
                                DRAFT TO BE
                                REVIEWED</button>
                        </div>
                        <div
                            class="col-xl-4 col-lg-5 col-md-5 text-center offset-md-1 offset-lg-1
                                                offset-xl-2">
                            <button class="btn btn-discharge-grey mb-1 w-100 mt-md-1">
                                @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_iv_status == 1)
                                    <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                        width="20">
                                @endif
                                ANTIBIOTICS  IV
                                <span class="ms-3">
                                {{ PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_iv_date)  }}
                                </span>
                            </button>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-5  text-center">
                            <button
                                class="btn btn-discharge-grey mb-1 w-100 mt-md-1">
                                @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_oral_status == 1)
                                    <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                        width="20">
                                @endif
                                ANTIBIOTICS
                                ORAL<span class="ms-3"> {{ PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_oral_date)  }}
                            </span>
                            </button>
                        </div>


                        <div class="col-12 order-md-5 order-5">
                            <div class="">
                                <label class="form-label">Pharmacy Comment</label>
                                <p class="comment-area">
                                    {{ optional($patient_array->BoardRoundPharmacyData)->pharmacy_latest_comment }}
                                </p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="rectangle-block-1 mb-2">
                    <div class="blue-rectangle-block ">
                        <h6 class="mb-0">HANDOVER</h6>
                    </div>
                    <div class="row gx-2 p-2">
                        <div class="col-lg-4 col-md-4">
                            <div class="mb-2">
                                <input class="form-control" type="text" readonly placeholder="Consultant : Dr Aleksandar Aleksic" value="Consultant : {{ $patient_array->camis_consultant_name }}" aria-label="default input example">
                            </div>
                            <div class="mb-2">
                                <input class="form-control" type="text" readonly value="EDD: {{ $patient_array->camis_consultant_name }}" placeholder="EDD:" aria-label="default input example">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 pe-md-1">
                                    <div class="mb-2">
                                        <input class="form-control" type="text" readonly value="Medfit: {{ $patient_array->BoardRoundMedicallyFitData ? ( $patient_array->BoardRoundMedicallyFitData->patient_medically_fit_status == 1? "yes" : 'No'): '' }}" placeholder="Medfit: No" aria-label="default input example">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 ps-md-1">
                                    <div class="mb-2">
                                        <input class="form-control" type="text" readonly value="OBS : {{ $patient_array->PatientHandOver ?$patient_array->PatientHandOver->ibox_handover_obs_varience: '' }}" placeholder="OBS :" aria-label="default input example">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <input class="form-control" type="text" readonly value="Variances : {{ $patient_array->PatientHandOver ?$patient_array->PatientHandOver->ibox_handover_varience_store: '' }}" placeholder="Variances :" aria-label="default input example">
                            </div>
                            <div class="d-flex justify-content-start mb-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input p-2 " disabled style="opacity: 1;" {{ @$patient_array->PatientHandOver->ibox_handover_pain_analgesia == 0 ? '':'checked' }} type="checkbox" value="" id="">
                                    <label class="form-check-label ms-2 pt-1" style="opacity: 1;">Pain / Analgesia</label>
                                </div>
                                <div class=' padding-zero  ' style='padding: 2px 0 0 35px;'>
                                    @if(@$patient_array->PatientHandOver->ibox_handover_pain_analgesia == 1)
                                        Please refer to EPMA
                                    @endif</div>
                            </div>
                            <div class="rectangle-block-1 mb-1 keep-moving">
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                            <label for="" class="form-label mb-0">
                                                K - KEEP MOVING</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="checkbox-card p-2">
                                            <div class="mb-2">
                                                <label for="exampleFormControlInput1" class="form-label">Mobility</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_mobility:'' }}" placeholder="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="exampleFormControlInput1" class="form-label">Equipment</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_equipment:'' }}" placeholder="">
                                            </div>
                                            <div class="mb-2 mb-md-0">
                                                <label for="exampleFormControlInput1" class="form-label">Assistance
                                                    Needed</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_assistance_needed:'' }}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        @php

                            $s_surface_varience_array = [];
                            $s_surface_varience_array = explode(',', $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_s_surface:'');

                        @endphp

                        <div class="col-lg-4 col-md-4">
                            <div class="bg-ash">
                                <div class="rectangle-block-1 mb-1">
                                    <div class="row ">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                <label for="" class="form-label mb-0">
                                                    S - SURFACE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="checkbox-card p-2">

                                                @for ($x = 0; $x < 5; $x++)
                                                    <div @if($x < 4) class="mb-2" @endif>
                                                        <input class="form-control" readonly value="@if(isset($s_surface_varience_array[$x])){{ $s_surface_varience_array[$x] }}@endif" type="text" placeholder="" aria-label="default input example">
                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rectangle-block-1 mb-1 continence">
                                    <div class="row ">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                <label for="" class="form-label mb-0">
                                                    I - CONTINENCE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="checkbox-card p-2">
                                                <div class="">
                                                    <input class="form-control" type="text" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_i_continence : "" }}" placeholder="" aria-label="default input example">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="rectangle-block-1 mb-1">
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                            <label for="" class="form-label mb-0">
                                                S - SKIN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="checkbox-card p-2">
                                            <div class="mb-2">
                                                <label for="exampleFormControlInput1" class="form-label">Repositioning
                                                    Routine</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1"  readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_repositioning_routine:'' }}" placeholder="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="exampleFormControlInput1" class="form-label">Skin
                                                    Conditioning</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_skin_conditioning :'' }}" placeholder="">
                                            </div>
                                            <div class="">
                                                <label for="exampleFormControlInput1" class="form-label">Dressings</label>
                                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_dressings:'' }}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle-block-1 mb-1 nutrition">
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                            <label for="" class="form-label mb-0">
                                                N - NUTRITION</label>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $s_surface_varience_array = [];
                                    $s_surface_varience_array = explode(',', $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_n_nutrition : "");

                                @endphp
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="checkbox-card p-2">
                                            <div class="row">
                                                @for ($x = 0; $x < 9; $x++)
                                                    <div class="col-lg-6 col-md-6 pe-md-1">
                                                        <div class="mb-2">
                                                            <input class="form-control" readonly value="@if(isset($s_surface_varience_array[$x])){{ $s_surface_varience_array[$x] }}@endif" type="text" placeholder="" aria-label="default input example">
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="">
                                <label class="form-label">N - Nutrition Special Diet Comment</label>
                                <p class="comment-area"> {{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_special_diet_comment : "" }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="">
                                <label class="form-label">Comment</label>
                                <p class="comment-area">
                                    {{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_comment : "" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rectangle-block-1">
                    <div class="blue-rectangle-block ">
                        <h6 class="mb-0">COMPLEX DISCHARGE TEAM (CDT)</h6>
                    </div>
                    <div class="row g-2 p-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label  class="form-label">Pathway</label>
                                <input type="text" class="form-control" readonly  value=" {{ $patient_array->BoardRoundPathwayRequirement?$patient_array->BoardRoundPathwayRequirement->DtocPathway->dtoc_pathway_text : '' }} " placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Services</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->service_by_pathway_text) ) value="{{ $patient_array->BoardRoundPathwayRequirement->service_by_pathway_text  }}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Reason Code</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly  @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->dtoc_authority_text))  value="{{ $patient_array->BoardRoundPathwayRequirement->dtoc_authority_text  }}" @endif placeholder="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-2">
                                <label  class="form-label">Current Status</label>
                                <input type="text" class="form-control" readonly @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->DtocStatus->dtoc_current_status_text)) value="{{ $patient_array->BoardRoundPathwayRequirement->DtocStatus->dtoc_current_status_text }}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label  class="form-label">Authority</label>
                                <input type="text" class="form-control" readonly  @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->dtoc_service_text))  value="{{ $patient_array->BoardRoundPathwayRequirement->dtoc_service_text  }}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Confirmed Discharge
                                    Date</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly  @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->planned_discharge_date))  value="{{ PredefinedDateFormatForPlannedDichargedDate($patient_array->BoardRoundPathwayRequirement->planned_discharge_date)  }}" @endif placeholder="">
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-2">
                                <label  class="form-label">Comments</label>
                                <div class="card-col-grp">
                                    <div class="row gx-1">
                                        @forelse($patient_array->BoardRoundDtocComments as $comments)
                                            <div class="col-12">
                                                <span class="comment">{{ $comments->join_comments  }}</span>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center">
                                                <span class="comment">No Records Found</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@else

    <div class="col-md-12  custom_not_found" >
        {{ NotFoundMessage() }}
    </div>

@endif
