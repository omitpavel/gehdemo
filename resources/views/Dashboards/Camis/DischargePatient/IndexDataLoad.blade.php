<div class="col-lg-12">
    <div class="sticky-toprow" id="stickyToprow">
        <div class="row gx-2 fixed-height align-items-center">
            <div class="col-xl-2 col-lg-3 col-md-3 mb-2">
                {!! AllWardListDropdown('ward_id') !!}
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 mb-2">
                <input type="text" id="date_picker" class="form-control" placeholder="Select date"
                    value="@if (!empty(request()->date)) {{ \Carbon\Carbon::parse(request()->date)->format('Y-m-d') }} @endif" />
            </div>

            <div class="col-xl-1 col-lg-1 col-md-1 mb-2">
                <div class="text-center">
                    <h6 class="mb-0">OR</h6>
                </div>
            </div>

            <div class="col-xl-3 col-lg-5 col-md-5 mb-2">
                <div class="d-flex justify-content-between ">
                    <input class="form-control" name="search_input" id="search_input" type="text"
                        placeholder="Search" aria-label="default input example" value="{{ request()->search_input }}">
                    <button type="button" class="btn btn-dark ms-2" onclick="SearchFunction();"><i class="bi bi-search"></i></button>

                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 mb-2">
                <button onclick="ResetData();" type="button" class="btn btn-export w-100 "><img
                        src="{{ asset('asset_v2/Template') }}/icons/reset.svg" alt="" width="16"
                        class="me-3 cursor_pointer">Reset Search</button>
            </div>
            <div class="col-xl-2 col-lg-7 col-md-6 col-8 mb-2">
                <div class="bg-patients-count">
                    <h6>Total Patients</h6>
                    <h5>{{ $success_array['discharges_from_cdt_count'] }}</h5>
                </div>
            </div>
            <div
                class="col-xl-1 col-lg-2 col-md-3 col-4 mb-2 {{ PermissionDeniedDiv('discharged_dashboard_export_dashboard_view') }}">
                <button type="button"
                    class="btn btn-export w-100 {{ DisabledButtonOnRolePermission('discharged_dashboard_export_dashboard_view') != 'permission_restricted' &&
                    $success_array['discharges_from_cdt_count'] > 0
                        ? ' export_patient_list'
                        : 'disabled' }}  {{ DisabledButtonOnRolePermission('discharged_dashboard_export_dashboard_view') }}"><img
                        src="{{ asset('asset_v2/Template') }}/icons/export.svg" alt="" width="16"
                        class="me-3 cursor_pointer">Export</button>
            </div>

        </div>
    </div>

    @if (count($success_array['patient_details']) > 0)

        <div class="discharge-summary-wrapper">

            <div class="card-discharges discharge-details">
                @foreach ($success_array['patient_details'] as $ward_name => $patient_list)
                    <div class="ward-patients-wrapper">
                        <div class="name-header">
                            <span>{{ $ward_name }}</span>
                        </div>

                        <div class="custom-card">

                            <table class="responsiveTable table-custom">

                                @foreach ($patient_list as $patient)
                                    @php

                                        $admission = Carbon\Carbon::parse(
                                            $patient['camis_patient_admission_date_time'],
                                        );
                                        $discharge = Carbon\Carbon::parse(
                                            $patient['camis_patient_discharge_date_time'],
                                        );

                                        $discharge_hour = $discharge->hour;
                                        $days_diff = $admission->diffInDays($discharge);
                                    @endphp
                                    <tbody class="table-patient-tbody">
                                        <tr class="table-patient-row-1">
                                            <td class="pivoted ">
                                                <div class="tdBefore">Patient ID</div>
                                                <span>{{ $patient['camis_patient_id'] }}</span>
                                            </td>
                                            <td class="pivoted ">
                                                <div class="tdBefore">Name</div>
                                                {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}

                                            </td>
                                            <td class="pivoted ">
                                                <div class="tdBefore">Hospital Number</div>
                                                <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">LOS (Days)</div>
                                                <span>{{ $days_diff }} Days(@if ($days_diff >= 21)
                                                        LOS 21+
                                                    @else
                                                        Less than 21 Days
                                                    @endif)</span>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Admitted Date</div>
                                                <span>
                                                    {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}</span>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Discharge Date</div>
                                                <span>
                                                    {{ PredefinedDateFormatFor24Hour($patient['camis_patient_discharge_date_time']) }}

                                                </span>
                                            </td>

                                            <td class="pivoted">
                                                <div class="tdBefore">Discharge From</div>
                                                <span>
                                                    {{ $success_array['all_wards'][$patient['camis_patient_ward']] ?? '--' }}
                                                </span>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Discharge Destination</div>
                                                <span>
                                                    {{ !empty($patient['camis_patient_discharge_destination']) ? $patient['camis_patient_discharge_destination'] : '--' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-patient-row-2">
                                            <td class="pivoted ">
                                                <div class="note-grp">
                                                    <div class="tdBefore">Other Notes</div>
                                                    <button class="btn btn-assign-task"
                                                        onclick="PatientInfo('{{ $patient['camis_patient_id'] }}');">Ibox
                                                        Discharge
                                                        Summary</button>
                                                </div>
                                                <textarea
                                                    class="form-control click_open_other_comment_offcanvas cursor-pointer insert_comment_id_{{ $patient['camis_patient_id'] }}"
                                                    id="insert_comment_id_{{ $patient['camis_patient_id'] }}" data-patient-id="{{ $patient['camis_patient_id'] }}"
                                                    readonly>{{ $patient['other_notes']['discharge_comment'] ?? '' }}</textarea>
                                            </td>


                                            <td class="pivoted {{ isset($patient['discharge_assigned_data']['id']) ? 'class_show_green' : 'class_show_red ' }}"
                                                id="discharge_data_{{ $patient['camis_patient_id'] }}">
                                                <div class="tdBefore">Discharge Pathway</div>
                                                <div class="w-100">
                                                    <select
                                                        class="form-select w-100 patient_dt_select_drop patient_dt_select_drop_{{ $patient['camis_patient_id'] }}"
                                                        aria-label="Default select example"
                                                        style="max-width: 150px; !importnat;"
                                                        data-camis-patient-id="{{ $patient['camis_patient_id'] }}"
                                                        data-admit-time="{{ $patient['camis_patient_admission_date_time'] }}"
                                                        data-discharge-time="{{ $patient['camis_patient_discharge_date_time'] }}">
                                                        <option value="">Select Discharge Pathway
                                                        </option>
                                                        @foreach ($success_array['discharge_tracker_dropdown'] as $reason)
                                                            <option value="{{ $reason->discharge_drop_id }}"
                                                                @if (isset($patient['discharge_assigned_data']['id']) &&
                                                                        $patient['discharge_assigned_data']['dt_drop_id'] == $reason->discharge_drop_id) selected @endif>
                                                                {{ $reason->discharge_drop_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>

                        </div>


                    </div>
                @endforeach
            </div>

        </div>
    @else
        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
    @endif

</div>


<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1025 && windowWidth < 1200) {
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var
                    noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '95px';
            }
        }
    } else if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '185px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function(header) {
                    header.style.top = '185px';
                })
            }
        }
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '45px';
            }
        }
    }
</script>
