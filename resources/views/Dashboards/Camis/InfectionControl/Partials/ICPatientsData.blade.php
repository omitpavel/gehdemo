<div class="col-lg-12">
    <div class="row gx-2 fs-13 ic-filters">
        <div class="col-xxl-3 col-lg-4 col-md-6  mb-2  ">

            <select class="form-select w-100" name="room_type" id="room_type" aria-label="Default select example">
                <<option value="">Both</option>
                    <option value="siderooms" @if (isset($success_array['room_type']) && $success_array['room_type'] == 'siderooms') selected @endif>Side Rooms</option>
                    <option value="others" @if (isset($success_array['room_type']) && $success_array['room_type'] == 'others') selected @endif>Others</option>
            </select>

        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 mb-2 ">

            <select class="form-select w-100" class="infection_reason" id="infection_reason"
                aria-label="Default select example">
                <option value="">Select Risk Reason</option>
                @if (isset($success_array['infection_reason_list_arr']) && count($success_array['infection_reason_list_arr']) > 0)
                    @foreach ($success_array['infection_reason_list_arr'] as $id => $ic_reason)
                        <option value="{{ $id }}" @if ($success_array['infection_reason_id'] == $id) selected @endif>
                            {{ $ic_reason }}</option>
                    @endforeach
                @endif
            </select>

        </div>
        <div class="col-xxl-2 col-lg-4 col-md-4 mb-2 ">
            <div id="reverseFilterButton">
                <button
                    class="btn btn-reverse-barrier reverse_barrier_filter @if (isset($success_array['reverse_barrier']) && $success_array['reverse_barrier'] == 1) active @endif"><img
                        src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" width="18"
                        height="18">Reverse Barrier<h5 class="fw-bold mb-0">
                        {{ $success_array['total_reverse_barrier'] }}</h5>
                </button>
            </div>

        </div>
        <div class="col-xxl-2 col-lg-6 col-md-4 mb-2">
            <div class="patients-count-box">
                <div class="d-flex align-items-center justify-content-between">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        fill="none">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12a7 7 0 0 1 7-7m-7 7H2m3 0c0 1.933.784 3.683 2.05 4.95L4.5 19.5M12 5V2m0 3c1.933 0 3.683.784 4.95 2.05L19.5 4.5M12 2h2m-2 0h-2M2 12v-2m0 2v2m17.5-9.5L18 3m1.5 1.5L21 6M4.5 4.5 6 3M4.5 4.5 3 6m1.5-1.5L7 7M4.5 19.5 6 21m-1.5-1.5L3 18m13 1h.001M9 10.5A1.5 1.5 0 0 1 10.5 9m5.501 7L16 13m6 3a6 6 0 1 1-12 0 6 6 0 0 1 12 0z">
                            </path>
                        </g>
                    </svg>
                    <h6 class="mb-0">Covid Positive</h6>
                    <h5 class="fw-bold mb-0">{{ $success_array['infected_patients'] }}</h5>
                </div>

            </div>
        </div>
        <div class="col-xxl-2 col-lg-6 col-md-4 mb-2">
            <div class="patients-count-box">
                <div class="d-flex align-items-center justify-content-between">
                    <svg width="20px" height="20px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="invisible_box" data-name="invisible box">
                                    <rect width="48" height="48" fill="none"></rect>
                                </g>
                                <g id="Layer_4" data-name="Layer 4">
                                    <g>
                                        <circle cx="35" cy="22" r="6"></circle>
                                        <path
                                            d="M45.2,33.3a17.4,17.4,0,0,0-20.4,0,1.6,1.6,0,0,0-.8,1.4v5.8A1.6,1.6,0,0,0,25.6,42H44.4A1.6,1.6,0,0,0,46,40.5V34.7A1.6,1.6,0,0,0,45.2,33.3Z">
                                        </path>
                                        <path
                                            d="M26,9H22V4H6V9H2V40a2,2,0,0,0,2,2H20V34.7A5.6,5.6,0,0,1,22.5,30,24.3,24.3,0,0,1,26,28ZM13,34H9V30h4Zm0-6H9V24h4Zm0-6H9V18h4Zm1-6a1,1,0,0,1-1-1V13H11a1,1,0,0,1,0-2h2V9a1,1,0,0,1,2,0v2h2a1,1,0,0,1,0,2H15v2A1,1,0,0,1,14,16Zm5,18H15V30h4Zm0-6H15V24h4Zm0-6H15V18h4Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <h6 class="mb-0">Normal Patients</h6>
                    <h5 class="fw-bold mb-0">30</h5>
                </div>

            </div>
        </div>
    </div>
    @if (isset($success_array['ic_patient_list_arr_all']) && count($success_array['ic_patient_list_arr_all']) > 0)
        @foreach ($success_array['ic_patient_list_arr_all'] as $ward_key => $ward_data)
            @if (count($ward_data) > 0)
                <div class="card-ic-patients mb-lg-2">
                    <div class="name-header">
                        <span>{{ $ward_key }}</span>
                    </div>
                    <table class="breachReasonTable responsiveTable table-infection-control">
                        <thead>
                            <tr class="position-relative">
                                <th>Bay & Bed</th>
                                <th>Name</th>
                                <th>PAS Number</th>
                                <th>Consultant</th>
                                <th>Primary Risk</th>
                                <th>Other Risk</th>
                                <th>LOS</th>
                                <th>Admitted Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ward_data as $patient_data)
                                @php
                                    // No "use" statement here
                                    $flagsRaw = $patient_data['infection_risks'] ?? [];

                                    $primary = array_values(ArrayFilter($flagsRaw, function ($item) {
                                        if ($item['is_primary'] == 1) {
                                            return true;
                                        }
                                    }));

                                    $primaryLabel = null;
                                    if (isset($primary['0'])) {
                                        $type = $primary['0']['infection_type'] ?? '';
                                        $type = $type === 'CANSTAYINBAY' ? 'CAN STAY IN BAY' : $type;
                                        $primaryLabel =
                                            ($primary['0']['infection_name'] ?? '') . ' - ' . ucwords(strtolower($type));
                                    }

                                    $nextReviewDateRaw = $primary['0']['next_review_date'] ?? null;


                                    $others_flag = array_values(
                                        array_map(
                                            function ($item) {
                                                $type = isset($item['infection_type']) ? $item['infection_type'] : '';
                                                $type = $type === 'CANSTAYINBAY' ? 'CAN STAY IN BAY' : $type;
                                                $infection_text = isset($item['infection_name'])
                                                    ? $item['infection_name']
                                                    : '';
                                                return $infection_text . ' - ' . ucwords(strtolower($type));
                                            },
                                            array_filter($flagsRaw, function ($item) {
                                                return ($item['is_primary'] == 0);
                                            }),
                                        ),
                                    );
                                @endphp


                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Bay & Bed</div>
                                        {{ $patient_data['ibox_actual_bed_full_name'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Name</div>
                                        {!! CamisPatientGender($patient_data['camis_patient_sex'], $patient_data['camis_patient_name']) !!}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">PAS Number</div>
                                        {{ $patient_data['camis_patient_pas_number'] }}
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">Consultant</div>
                                        {{ $patient_data['camis_consultant_name'] }}
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">Primary Risk</div>
                                        @if ($primaryLabel)
                                            <div>{{ $primaryLabel }}</div>

                                            @if ($nextReviewDateRaw)
                                                <small>
                                                    Next review:
                                                    {{ PredefinedDateFormatForPD($nextReviewDateRaw) }}

                                                </small>
                                            @else
                                                <small><em>No next review date</em></small>
                                            @endif
                                        @else
                                            --
                                        @endif
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">Other Risk</div>
                                        {{ is_array($others_flag) && count($others_flag) > 0 ? implode(', ', $others_flag) : '' }}
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">LOS</div>
                                        {{ NumberOfDaysBetweenTwoDates($patient_data['camis_patient_admission_date'], date('Y-m-d')) }}
                                        Days
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Admitted Date</div>
                                        {{ PredefinedDateFormatFor24Hour($patient_data['camis_patient_admission_date_time']) }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Action</div>
                                        <div class="reverse-barrier-block">
                                            <button
                                                class="btn btn-reverse-barrier click_assign_reverse_barrier @if (isset($patient_data['reverse_barrier']['reverse_barrier_status']) &&
                                                        $patient_data['reverse_barrier']['reverse_barrier_status'] == 1) active @endif"
                                                data-patient-id="{{ $patient_data['camis_patient_id'] }}">
                                                Reverse Barrier
                                                <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}"
                                                    alt="" class="ms-2" width="18" height="18">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @endif
        @endforeach
    @else
        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
    @endif

</div>
