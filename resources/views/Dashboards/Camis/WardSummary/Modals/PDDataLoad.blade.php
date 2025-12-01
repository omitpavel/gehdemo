@if (count($success_array['patient_list']) > 0)

    <div class="potential_document_details_insert" id="potential_document_details_insert">
        @foreach ($success_array['patient_list'] as $potential_discharge_patients)
            <div class="card-patient-details mb-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="name-header">
                            <h6 class="mb-0">{{ $potential_discharge_patients['camis_patient_name'] }}</h6>
                        </div>
                    </div>
                    <div class="patient-details">
                        <div class="row g-2">
                            <div class="col-xxl-8">
                                <div class="discharge-patient-details">
                                    <div class="row gx-0">
                                        <div class="col-md-6 border-handover-end">
                                            <ul>
                                                <li class="label-primary">Age</li>
                                                <li>: {{ $potential_discharge_patients['camis_patient_age'] }} (DOB {{ $potential_discharge_patients['camis_patient_date_of_birth'] }})</li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary">PassID</li>
                                                <li>: {{ $potential_discharge_patients['camis_patient_nhs_number'] }} </li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary">Bed & Bay</li>
                                                <li>: {{ $potential_discharge_patients['ibox_actual_bed_full_name'] }} </li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary">LOS</li>
                                                <li>: {{ PatientLos($potential_discharge_patients['camis_patient_admission_date_time']) }} Total With {{ PatientLos($potential_discharge_patients['camis_patient_ward_start_date']) }} On This Ward</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li class="label-primary">Consultant</li>
                                                <li>: {{ $potential_discharge_patients['camis_consultant_name'] }}
                                                </li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary">Med Fit</li>
                                                <li>: @if (!empty($potential_discharge_patients['board_round_medically_fit_data']))
                                                        Yes
                                                    @else
                                                        @if (isset($potential_discharge_patients['board_round_medically_fit_data']))
                                                            @if ($potential_discharge_patients['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        @else
                                                            No
                                                        @endif
                                                    @endif
                                                </li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary">EDD</li>
                                                <li>: @if (isset($potential_discharge_patients['board_round_estimated_discharge_date']))
                                                        {{ IboxEstimatedDischargeDateShowBoardround($potential_discharge_patients['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) }}
                                                    @else
                                                        No EDD Set
                                                    @endif
                                                </li>
                                            </ul>
                                            <ul>
                                                <li class="label-primary"></li>
                                                <li> </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-md-1 col-4">
                                <div class="pac-count-box">
                                    <h6 class="fw-bold">Vital PAC</h6>
                                    <div class="position-relative">
                                        @if (isset($potential_discharge_patients['patient_vital_pac_info']))
                                            @if (count($potential_discharge_patients['patient_vital_pac_info']) > 0)
                                                @php
                                                    $ews = $potential_discharge_patients['patient_vital_pac_info']['totalews'] ?? '--';
                                                @endphp

                                                @if ($potential_discharge_patients['patient_vital_pac_info']['totalews'] < 6)
                                                    <svg width="45" height="45" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <g id="Shape / Triangle">
                                                                <path id="Vector"
                                                                    d="M4.37891 15.1999C3.46947 16.775 3.01489 17.5634 3.08281 18.2097C3.14206 18.7734 3.43792 19.2851 3.89648 19.6182C4.42204 20.0001 5.3309 20.0001 7.14853 20.0001H16.8515C18.6691 20.0001 19.5778 20.0001 20.1034 19.6182C20.5619 19.2851 20.8579 18.7734 20.9172 18.2097C20.9851 17.5634 20.5307 16.775 19.6212 15.1999L14.7715 6.79986C13.8621 5.22468 13.4071 4.43722 12.8135 4.17291C12.2957 3.94236 11.704 3.94236 11.1862 4.17291C10.5928 4.43711 10.1381 5.22458 9.22946 6.79845L4.37891 15.1999Z"
                                                                    stroke="{{ $ews >= 5 ? '#ff2e2e' : '#000000' }}" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                @else
                                                    <svg width="45" height="45" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <g id="Shape / Triangle">
                                                                <path id="Vector"
                                                                    d="M4.37891 15.1999C3.46947 16.775 3.01489 17.5634 3.08281 18.2097C3.14206 18.7734 3.43792 19.2851 3.89648 19.6182C4.42204 20.0001 5.3309 20.0001 7.14853 20.0001H16.8515C18.6691 20.0001 19.5778 20.0001 20.1034 19.6182C20.5619 19.2851 20.8579 18.7734 20.9172 18.2097C20.9851 17.5634 20.5307 16.775 19.6212 15.1999L14.7715 6.79986C13.8621 5.22468 13.4071 4.43722 12.8135 4.17291C12.2957 3.94236 11.704 3.94236 11.1862 4.17291C10.5928 4.43711 10.1381 5.22458 9.22946 6.79845L4.37891 15.1999Z"
                                                                    stroke="#ff2624" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                @endif
                                                <span class="pac-triangle-text">{{ $ews >= 5 ? $ews : $ews }}</span>
                                            @endif
                                        @else
                                            <svg width="45" height="45" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="Shape / Triangle">
                                                        <path id="Vector"
                                                            d="M4.37891 15.1999C3.46947 16.775 3.01489 17.5634 3.08281 18.2097C3.14206 18.7734 3.43792 19.2851 3.89648 19.6182C4.42204 20.0001 5.3309 20.0001 7.14853 20.0001H16.8515C18.6691 20.0001 19.5778 20.0001 20.1034 19.6182C20.5619 19.2851 20.8579 18.7734 20.9172 18.2097C20.9851 17.5634 20.5307 16.775 19.6212 15.1999L14.7715 6.79986C13.8621 5.22468 13.4071 4.43722 12.8135 4.17291C12.2957 3.94236 11.704 3.94236 11.1862 4.17291C10.5928 4.43711 10.1381 5.22458 9.22946 6.79845L4.37891 15.1999Z"
                                                            stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="pac-triangle-text">--</span>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold mt-2">EWS</h6>

                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-11 col-8 text-md-end">
                                <div class="handover-icons-wrapper">
                                    @php
                                        $flag_list_show_array = PatientWiseFlagsUrlForWardSummaryGetAllFlags($potential_discharge_patients['patient_wise_flags'], $success_array['show_on_ward_summary_status_check_all'], 9);
                                    @endphp
                                    @foreach ($flag_list_show_array as $key => $flag)
                                        <div class="flag-group">
                                            {!! GetWardSummaryBedFlagImages($flag) !!}
                                            <span>{{ GetFlagName($flag) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 reason-section">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div class="col-12">
                                            <label class="form-label">Admitting
                                                Reason</label>
                                            <p class="reason" style="min-height: 80px;">
                                                {{ isset($potential_discharge_patients['board_round_admitting_reason']) ? $potential_discharge_patients['board_round_admitting_reason']['patient_admitting_reason'] : '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-12">
                                            <label class="form-label">Social
                                                History</label>
                                            <p class="reason" style="min-height: 80px;">
                                                {{ isset($potential_discharge_patients['board_round_social_history']) ? $potential_discharge_patients['board_round_social_history']['patient_social_history'] : '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-12">
                                            <div class="row gx-2">
                                                <div class="col-3">
                                                    <label class="form-label">Pharmacy</label>
                                                </div>
                                                <div class="col-9 text-end">

                                                    @if (isset($potential_discharge_patients['board_round_pharmacy_data']) && count($potential_discharge_patients['board_round_pharmacy_data']) > 0)
                                                        <label for="" class="form-label">
                                                            @if ($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_drug_history'] == 1)
                                                                Drug History Partial
                                                            @elseif($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_drug_history'] == 2)
                                                                Drug History Full
                                                            @elseif($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_drug_history'] == 3)
                                                                Drug History Reviewed
                                                                @endif @if ($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 || $potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                @if(in_array($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_drug_history'], [1, 2, 3])) - @endif Antibiotics: @if ($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 && $potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                        IV & ORAL
                                                                    @elseif($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1)
                                                                        IV
                                                                    @elseif($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                        ORAL
                                                                    @endif
                                                                @endif
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="reason" style="min-height: 80px;">
                                                {{ isset($potential_discharge_patients['board_round_pharmacy_data']['pharmacy_latest_comment']) ? $potential_discharge_patients['board_round_pharmacy_data']['pharmacy_latest_comment'] : '' }}
                                            </p>
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
    <script>
        $(document).ready(function() {
            $('#potential_definite_print').removeClass('disabled');
            @if($success_array['type'] == 'definite')
                if (!$('#potential_definite_print').hasClass('print_definite_discharges')) {

                    $('#potential_definite_print').addClass('print_definite_discharges');
                }
             @else
                if (!$('#potential_definite_print').hasClass('print_potential_discharges')) {

                    $('#potential_definite_print').addClass('print_potential_discharges');
                }
            @endif

        });

    </script>
@else
    <div class="No_record_css">
        {{ NotFoundMessage() }}
    </div>

    <script>
        $(document).ready(function() {
            $('#potential_definite_print').removeClass('print_potential_discharges');
            $('#potential_definite_print').addClass('disabled');
        });

    </script>
@endif
