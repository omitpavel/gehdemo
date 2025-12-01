<input type="hidden" id="date" value="{{ request()->get('date') }}">
<div class="col-lg-12">
    <div class="row g-2 discharge-row">
        <div class="col-lg-2 col-md-4">
            <div>
                <input class="form-control" type="text" placeholder="Search" value="{{ request()->get('search_text') }}"
                    aria-label="default input example" id="daterangepicker">
            </div>
        </div>

        <div class="col-lg-2 col-md-4">
            <div>
                <select class="form-select w-100" aria-label="Default select example" id="time">
                    <option value="" @if (request()->get('time') == '') selected @endif>All</option>
                    <option value="1" @if (request()->get('time') == 1) selected @endif>All Patients Discharged
                        Before 5PM</option>
                    <option value="2" @if (request()->get('time') == 2) selected @endif>All Patients Discharged
                        Between 5.01PM and 11.59PM</option>
                    <option value="3" @if (request()->get('time') == 3) selected @endif>LOS 21 + Patients
                        Discharged Before 5PM</option>
                    <option value="4" @if (request()->get('time') == 4) selected @endif>LOS 21 + Patients
                        Discharged Between 5.01PM and 11.59PM</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            {!! AllWardListDropdown() !!}
        </div>
        <div class="col-xxl-3 col-lg-2 col-md-5">
            <div class="d-flex justify-content-between ">
                <input class="form-control discharges_custom_search" type="text" placeholder="Search"
                    value="{{ request()->get('search_text') }}" aria-label="default input example" id="search_text">
                <button type="button" class="btn btn-dark ms-2" id="submit_search_text"><i
                        class="bi bi-search "></i></button>

            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="bg-patients-count">
                <h6>Total Patients</h6>
                <h5>{{ $success_array['discharges_from_cdt_count'] }}</h5>
            </div>
        </div>
        <div
            class="col-xxl-1 col-lg-2 col-md-3 @if ($success_array['discharges_from_cdt_count'] > 0) export_patient_list @else board_round_done @endif">
            <button class="btn btn-export w-100"> <i
                    class="bi bi-box-arrow-in-right pe-2 text-black"></i>Export</button>
        </div>
    </div>

    @if (count($success_array['patient_list']) > 0)
        <div class="card-discharges discharge-details">
            @foreach ($success_array['patient_list'] as $ward_name => $patient_list)
                <div class="ward-patients-wrapper">
                    <div class="name-header">
                        <span>{{ $ward_name }}</span>
                    </div>

                    <div class="custom-card">
                        <table class="responsiveTable table-custom">
                            @foreach ($patient_list as $patient)
                                @php

                                    $admission = Carbon\Carbon::parse($patient['camis_patient_admission_date_time']);
                                    $discharge = Carbon\Carbon::parse($patient['camis_patient_discharge_date_time']);

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
    @else
        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
    @endif
</div>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

        @if (!empty(request()->get('date')))
            var start = moment('{{ request()->get('date') }}', 'YYYY-MM-DD');
        @else
            var start = moment().endOf('day');
        @endif

        function cb(start) {
            $('#daterangepicker').val(start.format('MMMM D, YYYY'));
            $('#date').val(start.format('YYYY-MM-DD'));
            $('#submit_search_text').click();
        }


        $('#daterangepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: start,
            minDate: moment().subtract(365, 'days').endOf('day'),
            maxDate: moment().endOf('day'),
            locale: {
                format: 'ddd MMMM D, YYYY'
            }
        }, cb);



    });
</script>
