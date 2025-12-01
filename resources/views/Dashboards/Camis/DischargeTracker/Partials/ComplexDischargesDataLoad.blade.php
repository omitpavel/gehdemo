<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2">
                        <a class="tab-custom-btn click_dtoc_search_reset ">
                            <div class="tab-active">CDT Patients</div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn click_discharges_from_cdt active" data-bs-toggle="tab"
                            href="#dischargeFromCdt">
                            <div class="tab-active">Discharge From CDT</div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn click_discharges_from_ed_referral">
                            <div class="tab-active">ED Referral</div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <div id="cdtPatients" class="tab-pane active">



                    <div class="discharges-cdt-wrapper">
                        <div class="row g-2 discharge-row">


                            <div class="col-lg-2 col-md-4">
                                <div class="card-date">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Select Discharged Date">
                                            <div class="cyan-circle text-center me-2">
                                                <i class="bi bi-calendar3 "></i>
                                            </div>
                                            <div class="date-box w-90">
                                                <input type="hidden" id="complex_date"
                                                    value="{{ request()->get('complex_date') }}">
                                                <input type="text" name="datepicker" id="complex_daterangepicker"
                                                    placeholder="{{ request()->filled('complex_date') ? PredefinedYearFormat(request()->complex_date) : 'Select Date' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-4">
                                <div>
                                    <select class="form-select w-100" aria-label="Default select example"
                                        id="complex_time">
                                        <option value="" @if (request()->get('complex_time') == '') selected @endif>All
                                        </option>
                                        <option value="1" @if (request()->get('complex_time') == 1) selected @endif>All
                                            Patients Discharged Before 5PM</option>
                                        <option value="2" @if (request()->get('complex_time') == 2) selected @endif>All
                                            Patients Discharged Between 5.01PM and 11.59PM</option>
                                        <option value="3" @if (request()->get('complex_time') == 3) selected @endif>LOS 21
                                            + Patients Discharged Before 5PM</option>
                                        <option value="4" @if (request()->get('complex_time') == 4) selected @endif>LOS 21
                                            + Patients Discharged Between 5.01PM and 11.59PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                {!! AllWardListDropdown('ward_id_cdt') !!}
                            </div>
                            <div class="col-xxl-3 col-lg-2 col-md-5">
                                <div class="d-flex justify-content-between ">
                                    <input class="form-control discharges_custom_search" type="text"
                                        placeholder="Search" value="{{ request()->get('complex_search_text') }}"
                                        aria-label="default input example" id="complex_search_text">
                                    <button type="button" class="btn btn-dark ms-2" id="complex_submit_search_text"><i
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
                                class="col-xxl-1 col-lg-2 col-md-3 @if (count($success_array['patient_list']) > 0) export_patient_list @else board_round_done @endif">
                                <button class="btn btn-export w-100"> <i
                                        class="bi bi-box-arrow-in-right pe-2 text-black"></i>Export</button>
                            </div>
                        </div>

                        @if (count($success_array['patient_list']) > 0)
                            <div class="card-discharges discharge-details">
                                @foreach ($success_array['patient_list'] as $ward_name => $patient_list)
                                    <div class="ward-patients-wrapper">
                                        <div class="custom-card">

                                            <div class="name-header">
                                                <span>{{ $ward_name }}</span>
                                            </div>
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
                                                                <span> {{ PredefinedDateFormatFor24Hour($patient['camis_patient_discharge_date_time']) }} </span>
                                                            </td>

                                                            <td class="pivoted">
                                                                <div class="tdBefore">Discharged From</div>
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
                                                                            <option
                                                                                value="{{ $reason->discharge_drop_id }}"
                                                                                @if (isset($patient['discharge_assigned_data']['id']) &&
                                                                                        $patient['discharge_assigned_data']['dt_drop_id'] == $reason->discharge_drop_id) selected @endif>
                                                                                {{ $reason->discharge_drop_name }}
                                                                            </option>
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
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="today_discharges_value" value="{{ $success_array['discharges_today'] }}">
<script>
    function safeStyle(id, prop, value) {
        const el = document.getElementById(id);
        if (el) el.style[prop] = value;
    }

    var windowWidth = window.innerWidth;
    if (windowWidth > 1400) {
        if (
            document.getElementById("marquee-content") &&
            document.getElementsByClassName(".bg-sticky") &&
            document.getElementsByClassName(".sticky-header")
        ) {
            safeStyle("stickyToprow", "top", "85px");
            safeStyle("medfitRow", "top", "145px");

            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "206px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "206px";
                });
            }
        } else {
            safeStyle("stickyToprow", "top", "60px");
            safeStyle("medfitRow", "top", "120px");
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "180px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "180px";
                });
            }
        }
        if (document.getElementById("medfitRow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "53px";
            }
        }
    } else if (windowWidth > 1026 && windowWidth < 1399) {
        if (document.getElementById("marquee-content")) {
            safeStyle("stickyToprow", "top", "85px");
            safeStyle("medfitRow", "top", "146px");
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "258px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "258px";
                });
            }
        }
        if (document.getElementById("medfitRow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "103px";
            }
        }
    }
</script>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

        @if (!empty(request()->get('complex_date')))
            var start = moment('{{ request()->get('complex_date') }}', 'YYYY-MM-DD');
        @else
            var start = moment().endOf('day');
        @endif

        function cb(start) {
            $('#complex_daterangepicker').val(start.format('MMMM D, YYYY'));
            $('#complex_date').val(start.format('YYYY-MM-DD'));
            $('#complex_submit_search_text').click();
        }


        $('#complex_daterangepicker').daterangepicker({
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
